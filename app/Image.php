<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name', 'ext', 'attachment', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function getImageByUser($user)
    {
    	return Image::where('user_id', $user)->get();
    }

    public static function allAttachment()
    {
        return Image::where('attachment', true)->get();
    }

    public static function allButAttachment()
    {
        return Image::where('attachment', false)->get();
    }

    public static function trash()
    {
        return Image::onlyTrashed()->get();
    }
}
