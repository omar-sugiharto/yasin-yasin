<?php

namespace App\Http\Controllers;

use App\User;
use App\SiteInfo;
use App\Schedule;
use App\CpSection;
use App\Document;
use App\Helpers\Sirius;
use App\Mail\DoneAppointment;
use App\Mail\BookAppointment;
use App\Mail\BookedAppointment;
use App\Mail\CanceledAppointment;
use App\Mail\ConfirmedAppointment;
use App\Mail\BookConfirmedAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;



class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->guest() || auth()->user()->role != "admin") {
            return redirect('/login');
        }

        $clients = User::allClient();
        $events = Schedule::getEventCalendar();
        $pastEvents = Schedule::getPastEvents();
        $total['waiting'] = User::getTotalWaitingDocument();
        $total['booked'] = Schedule::getTotalBooked();

        return view('admin.calendar', compact('events', 'clients', 'pastEvents', 'total'));
    }

    /**
     * Display a listing of the resource for client.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        if (auth()->guest()) {
            return redirect('/login');
        }

        $cp = CpSection::allConverted();
        $infos = SiteInfo::allConverted();
        $events = Schedule::getEventForClient(auth()->user()->id);
        return view('calendar', compact('events', 'cp', 'infos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = Schedule::create([
            'start' => $request->start,
            'end' => $request->end,
            'step' => "document_check"
        ]);
        return redirect('admin/schedules')->with('message', 'Jadwal kosong pada hari '.Sirius::toIdLongDateDay($event->start).' hingga '.Sirius::toIdLongDateDay($event->end).' telah dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = Schedule::findOrFail($id);
        if ($event->user_id == NULL) {
            if (isset($request->fill)) {
                $event->update([
                    'user_id' => $request->client,
                    'note' => $request->note,
                    'step' => "document_check"
                ]);

                if ($request->fill == 'client') {
                    Mail::to(auth()->user()->email)->send(new BookAppointment($event));
                    Mail::to(SiteInfo::search('booked_appointment_mail', true))->send(new BookedAppointment($event));
                    $event->update(['status' => "booked"]);
                    return redirect('kalender')->with('message','Permintaan jadwal audit pada hari '.Sirius::toIdLongDateDay($event->start).' hingga '.Sirius::toIdLongDateDay($event->end).' telah dikirim.');
                }
                else {
                    $status = $request->status;
                    $event->update(['status' => $status, 'step' => 'document_check']);
                    if ($status == "confirmed") {
                        Mail::to($event->user->email)->send(new BookConfirmedAppointment($event));
                        Mail::to(SiteInfo::search('booked_appointment_mail', true))->send(new BookedAppointment($event));
                        $status = "Terkonfirmasi";
                    }
                    else if ($status == "done") {
                        $status = "Selesai";
                    }
                    else if ($status == "canceled") {
                        $status = "Dibatalkan";
                    }
                    else if ($status == "booked") {
                        Mail::to($event->user->email)->send(new BookAppointment($event));
                        Mail::to(SiteInfo::search('booked_appointment_mail', true))->send(new BookedAppointment($event));
                        $status = "Menunggu Konfirmasi";
                    }
                    return redirect('admin/schedules')->with('message','Jadwal dengan '.$event->user->name.' pada hari '.Sirius::toIdLongDateDay($event->start).' hingga '.Sirius::toIdLongDateDay($event->start).' telah dibuat dengan status "'.$status.'".');
                }
            }
            else {
                $event->update([
                    'start' => $request->start,
                    'end' => $request->end,
                ]);
                return redirect('admin/schedules')->with('message','Tanggal jadwal kosong berhasil diubah.');
            }
        }
        else {
            $status = $request->status;
            $step = $request->step ?? 'document_check';
            if ($status == "blank") {
                $event->update([
                    'user_id' => NULL,
                    'note' => NULL,
                    'status' => 'blank'
                ]);
                return redirect('admin/schedules')->with('message','Pada hari '.Sirius::toIdLongDateDay($event->start).' hingga '.Sirius::toIdLongDateDay($event->end).' telah berhasil dikosongkan.');
            }
            else {
                $user = $event->user->name;
                $event->update(['status' => $status, 'step' => $step]);
                $added_message = "";

                if ($status == "confirmed") {
                    $status = "dikonfirmasi";
                    Mail::to($event->user->email)->send(new ConfirmedAppointment($event));
                    $updated_data['step'] = $step;
                    $added_message = " dengan tahap ";
                    if ($step == "document_check") {
                        $added_message .= "Pengecekan Berkas";
                    }
                    else {
                        $added_message .= "Audit";
                    }
                }
                else if ($status == "done") {
                    $status = "diselesaikan";
                    Mail::to($event->user->email)->send(new DoneAppointment($event));
                }
                else if ($status == "canceled") {
                    $status = "dibatalkan";
                    Mail::to($event->user->email)->send(new CanceledAppointment($event));
                }
                else if ($status == "booked") {
                    $status = 'dibuah menjadi "Menunggu Konfirmasi"';
                }

                return redirect('admin/schedules')->with('message','Status jadwal dengan '.$user.' pada hari '.Sirius::toIdLongDateDay($event->start).' hingga '.Sirius::toIdLongDateDay($event->end).' telah '.$status.$added_message.'.');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();
        return redirect('admin/schedules')->with('message', "Berhasil menghapus jadwal.");
    }

    /**
     * Remove multiple the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function multipledestroy(Request $request)
    {
        $filled = false;
        $events = Schedule::findBetween($request->start, $request->end);
        foreach ($events as $event) {
            if ($event->user_id == NULL) {
                $event->delete();
            }
            else {
                $filled = true;
            }
        }

        $filledText = "";
        if ($filled) {
            $filledText = ' <span class="badge badge-danger">Jadwal yang telah diisi tidak akan dihapus.</span>';
        }
        return redirect('admin/schedules')->with('message', "Berhasil menghapus banyak jadwal sekaligus.".$filledText);
    }

    /**
     * Clean storage from blank past events.
     *
     * @return \Illuminate\Http\Response
     */
    public function clean()
    {
        $events = Schedule::getPastBlankEvents();
        foreach ($events as $event) {
            $event->forceDelete();
        }
        return redirect('admin/schedules')->with('message', "Jadwal lampau yang kosong berhasil dihapus secara permanen.");
    }
}
