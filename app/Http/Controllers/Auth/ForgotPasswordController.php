<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\CpSection;
use App\Mail\SendPasswordReset;
use App\Http\Controllers\Controller;
use App\SiteInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    public function index(Request $request)
    {
        $cp = CpSection::allConverted();
        $infos = SiteInfo::allConverted();
        if (!isset($request->token)) {
            return view('auth.forgot', compact('cp', 'infos'));
        }
        else {
            $token = $request->token;
            if (User::isTokenResetPasswordValid($token)) {
                return view('auth.forgot', compact('cp', 'infos', 'token'));
            }
            else {
                return redirect('forgot')->with('message', 'Token Anda tidak valid.');
            }
        }
    }

    public function sendEmail(Request $request)
    {
        $cp = CpSection::allConverted();
        $infos = SiteInfo::allConverted();

        if (!isset($request->email)) {
            $error = "Harap isi bidang ini.";
            return view('auth.forgot', compact('error', 'cp', 'infos'));
        }

        $email = $request->email;

        if (strpos($email, "@") === false) {
            $error = "Email tidak valid.";
            return view('auth.forgot', compact('error', 'email', 'cp', 'infos'));
        }

        if (!(User::isRegistered($email))) {
            $error = "Email belum terdaftar.";
            return view('auth.forgot', compact('error', 'email', 'cp', 'infos'));
        }

        $token = User::generateRandomToken(255, false);
        User::insertTokenForgotPassword($email, $token);

        Mail::to($email)->send(new SendPasswordReset($token));

        return redirect('forgot')->with('message', 'Kami telah mengirimi Anda email terkait pengaturan ulang kata sandi Anda, harap buka email Anda segera.');
    }

    public function resetPassword(Request $request)
    {
        $messages = [
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal memuat 6 karakter.',
            'password.confirmed' => 'Kata sandi tidak sesuai.',
        ];

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], $messages);

        if ($validator->fails()) {
            return redirect('forgot')->withErrors($validator)->with('token', $request->token);
        }

        $user = User::searchUserByToken($request->token);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        User::removeTokenResetPassword($request->token);

        return redirect('forgot')->with('message', 'Kata sandi berhasil diatur ulang, silakan masuk.');
    }
}
