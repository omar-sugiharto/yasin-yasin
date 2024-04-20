<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	"user_id", "message", "rating"
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function getRandom($total = 5)
    {
    	$testi = [];

    	$testimonials = Testimonial::all();

    	$numbers = range(0, count($testimonials) - 1);
		shuffle($numbers);
		$random = array_slice($numbers, 0, $total);

    	foreach ($random as $value) {
    		$testi[] = $testimonials[$value];
    	}

    	return $testi;
    }

    public static function calcRate()
    {
        $testimonials = Testimonial::all();
        $rate = 0;
        foreach ($testimonials as $testimonial) {
            $rate += $testimonial->rating;
        }
        return number_format($rate /= count($testimonials), 1);
    }
}
