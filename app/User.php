<?php

namespace App;

use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'address', 'photo_ext', 'role', 'document_status', 'document_notes'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public function getId()
    {
        return $this->id;
    }

    public function documents()
    {
        return $this->hasMany('App\Document');
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    public function companyProfiles()
    {
        return $this->hasMany('App\CpSection');
    }

    public function schedules()
    {
        return $this->hasMany('App\Schedule');
    }

    public function testimonials()
    {
        return $this->hasMany('App\Testimonial');
    }

    public function reports()
    {
        return $this->hasMany('App\Report');
    }

    public static function allClient()
    {
        return User::where('role', 'client')->orderBy('name')->get();
    }

    public static function isEmailUnique($email, $now = "")
    {
        $email = User::where('email', $email)->get();
        if (count($email) > 0) {
            if ($now == "") {
                return false;
            }
            else {
                if ($email[0]->email == $now) {
                    return true;
                }
                else {
                    return false;
                }
            }
        }
        else {
            return true;
        }
    }

    public static function generateRandomToken($length = 6, $withSymbol = true)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($withSymbol == true) {
            $characters .= "~!@#$%^&*()_+[]{},.<>?";
        }
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function isRegistered($email)
    {
        $email = User::where('email', $email)->get();
        return (count($email) > 0) ? true : false;
    }

    public static function insertTokenForgotPassword($email, $token)
    {
        $now = date("Y-m-d H:i:s", time());
        DB::table('password_resets')->where('email', $email)->delete();
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => $now,
        ]);
    }

    public static function isTokenResetPasswordValid($token)
    {
        $now = date("Y-m-d H:i:s", time());
        $oneHourBefore = date("Y-m-d H:i:s", strtotime($now . " -1 hour"));

        $data = DB::table('password_resets')->where('token', $token)->whereBetween('created_at', [$oneHourBefore, $now])->get();
        return (count($data) > 0) ? true : false;
    }

    public static function searchUserByToken($token)
    {
        $email = DB::table('password_resets')->where('token', $token)->get();
        $email = $email[0]->email;
        $user = User::where('email', $email)->get();
        return $user[0];
    }

    public static function removeTokenResetPassword($token)
    {
        DB::table('password_resets')->where('token', $token)->delete();
    }

    public static function getTotalWaitingDocument()
    {
        return count(User::where('document_status', 'waiting')->get());
    }
}
