<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
    	'subject', 'content', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function reportAttachments()
    {
        return $this->hasMany('App\ReportAttachment');
    }

}
