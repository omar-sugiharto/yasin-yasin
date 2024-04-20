<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteInfo extends Model
{
    protected $fillable = [
        'name', 'value'
    ];

    public static function search($name, $value = false)
    {
    	$info = SiteInfo::where('name', $name)->get();
    	if ($value == true) {
            return $info[0]->value;
        }
        else {
            return $info[0];
        }
    }

    public static function allConverted()
    {
    	$all = SiteInfo::all();
    	$infos = [];
    	foreach ($all as $info) {
    		$infos[$info->name] = $info->value;
    	}
    	return $infos;
    }
}
