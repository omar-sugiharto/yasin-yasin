<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CpSection extends Model
{
    protected $fillable = [
        'title', 'content', 'pos', 'slug', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function getBySlug($slug)
    {
        if ($slug == 'vimision') {
            return CpSection::where('slug', $slug)->get();
        }
        else {
            return CpSection::where('slug', $slug)->get()->first();
        }
    }

    public static function allConverted()
    {
        $all = CpSection::all();
        $cps = [];
        $vimision = true;
        foreach ($all as $cp) {
            if ($cp->slug == 'vimision') {
                if ($vimision == true) {
                    $cps["vision"] = $cp->content;
                    $vimision = false;
                }
                else {
                    $cps["mission"] = $cp->content;
                }
            }
            else {
                $cps[$cp->slug] = $cp->content;
            }
        }
        return $cps;
    }
}
