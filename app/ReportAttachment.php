<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportAttachment extends Model
{
    protected $fillable = [
    	'name', 'ext', 'report_id'
    ];

    public function report()
    {
        return $this->belongsTo('App\Report');
    }

    public static function findByReportId($report_id)
    {
    	return ReportAttachment::where('report_id', $report_id)->get();
    }
}
