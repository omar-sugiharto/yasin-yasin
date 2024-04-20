<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'user_id', 'name', 'ext', 'loc'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function getDocumentByClientId($id)
    {
        return Document::where('user_id', $id)->first();
    }
}
