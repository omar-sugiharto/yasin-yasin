<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
		'start', 'end', 'note', 'user_id', 'status', 'step'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function getTotalBooked()
    {
        $start = date('Y-m-d', strtotime('now'))." 00:00:00";
        return count(Schedule::where('status', 'booked')->where('start', '>=', $start)->get());
    }

    public static function findBetween($start, $end)
    {
        return Schedule::whereBetween('start', [$start, $end])->get();
    }

    public static function getEventCalendar()
    {
        $start = date('Y-m', strtotime('-1 month'))."-01";
        return Schedule::where('start', '>=', $start)->get();
    }

    public static function getPastEvents()
    {
        $end = date('Y-m', strtotime('-1 month'))."-01";
        return Schedule::where('end', '<', $end)->get();
    }

    public static function getPastBlankEvents()
    {
        $end = date('Y-m', strtotime('-1 month'))."-01";
        return Schedule::where('end', '<', $end)->where('user_id', NULL)->withTrashed()->get();
    }

    public static function getEventForClient($client)
    {
        $start = date('Y-m', strtotime('-1 month'))."-01";
        $events = Schedule::where('start', '>=', $start)->where('user_id', NULL)->get();

        $booked = Schedule::where('user_id', $client)->get();

        foreach ($booked as $b) {
            $events[] = $b;
        }

        return $events;
    }

    public static function isClashing($datetime, $id = "")
    {
        $start = date('Y-m-d', strtotime($datetime));
        $events = Schedule::findBetween($start, $datetime);

        $checkEvent = ($id != "" ) ? Schedule::findOrFail($id) : "";

        $clash = false;
        foreach ($events as $event) {
            if ($id != "") {
                if ($event->id != $checkEvent->id) {
                    $start = strtotime($event->start);
                    $end = strtotime($event->end);
                    $check = strtotime($datetime);
                    if ($check > $start && $check < $end) {
                        return true;
                    }
                }
            }
            else {
                $start = strtotime($event->start);
                $end = strtotime($event->end);
                $check = strtotime($datetime);
                if ($check > $start && $check < $end) {
                    return true;
                }
            }
        }

        return $clash;
    }
}
