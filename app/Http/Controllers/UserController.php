<?php

namespace App\Http\Controllers;

use Storage;
use App\User;
use App\CpSection;
use App\Document;
use Illuminate\Http\Request;
use App\Mail\NewRegisteredAdmin;
use App\Mail\NewRegisteredClientFromAdmin;
use App\Schedule;
use App\SiteInfo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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

        $users = User::all();
        $total['waiting'] = User::getTotalWaitingDocument();
        $total['booked'] = Schedule::getTotalBooked();

        return view('admin.user', compact('users', 'total'));
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
        $valid = true;
        $messages = [];

        if (!isset($request->name) || !isset($request->email) || !isset($request->phone)) {
            $valid = false;
            $messages[] = "Semua bidang wajib diisi.";
        }

        if (isset($request->email)) {
            if (strpos($request->email, "@") === false) {
                $valid = false;
                $messages[] = "Email yang dimasukkan tidak valid.";
            }
            if (!(User::isEmailUnique($request->email))) {
                $valid = false;
                $messages[] = "Email yang dimasukkan sudah terdaftar.";
            }
        }

        if (!$valid) {
            return redirect('admin/users')->with('error', $messages);
        }
        else {
            $pass = User::generateRandomToken();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($pass),
                'address' => $request->address,
                'role' => $request->role
            ]);

            $user->contacts()->create([
                'name' => "Telepon",
                'value' => $request->phone
            ]);

            if ($request->role == "admin") {
                Mail::to($request->email)->send(new NewRegisteredAdmin($user, $pass));
            }
            else {
                Mail::to($request->email)->send(new NewRegisteredClientFromAdmin($user, $pass));
            }

            return redirect('admin/users')->with('messages', "Pengguna baru telah dibuat.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (isset($request->password)) {
            $valid = true;
            $messages = [];

            if (!isset($request->password) || !isset($request->password_confirmation)) {
                $valid = false;
                $messages[] = "Semua bidang wajib diisi.";
            }
            else {
                if (strlen($request->password) < 6) {
                    $valid = false;
                    $messages[] = "Kata sandi minimal memuat 6 karakter.";
                }
                if ($request->password != $request->password_confirmation) {
                    $valid = false;
                    $messages[] = "Kata sandi tidak sama.";
                }
            }

            if (!$valid) {
                return redirect('admin/users')->with('error', $messages);
            }
            else {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);

                return redirect('admin/users')->with('message', "Kata sandi pengguna telah diatur ulang.");
            }
        }
        else {
            $valid = true;
            $messages = [];

            if (!isset($request->name) || !isset($request->email) || !isset($request->phone)) {
                $valid = false;
                $messages[] = "Semua bidang wajib diisi.";
            }

            if (isset($request->email)) {
                if (strpos($request->email, "@") === false) {
                    $valid = false;
                    $messages[] = "Email yang dimasukkan tidak valid.";
                }
                if (!(User::isEmailUnique($request->email, $user->email))) {
                    $valid = false;
                    $messages[] = "Email yang dimasukkan sudah terdaftar.";
                }
            }

            if (!$valid) {
                return redirect('admin/users')->with('error', $messages);
            }
            else {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'address' => $request->address,
                    'role' => $request->role
                ]);

                return redirect('admin/users')->with('message', "Detail pengguna telah berhasil diubah.");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect('admin/users')->with('message','Pengguna telah dihapus.');
    }

    /**
     * Display the profile of loged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        if (auth()->guest()) {
            return redirect('/login');
        }

        $cp = CpSection::allConverted();
        $infos = SiteInfo::allConverted();

        return view('profile', compact('cp', 'infos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function homeUpdate(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);

        if (isset($request->img)) {
            File::delete(public_path('images/user_photo/'.$user->id.$user->photo_ext));

            $file = $request->file('img');
            $ext = ".".$file->getClientOriginalExtension();

            $user->update([
                'photo_ext' => $ext
            ]);

            $file->move("images/user_photo/", $user->id.$user->photo_ext);
            return redirect('profil')->with('photoMessage','Foto atau logo perusahaan baru berhasil diterapkan.');
        }
        else if(isset($request->remove_photo)) {
            File::delete(public_path('images/user_photo/'.$user->id.$user->photo_ext));

            $user->update([
                'photo_ext' => NULL
            ]);

            return redirect('profil')->with('photoMessage', 'Foto atau logo perusahaan Anda berhasil dihapus.');
        }
        else if (isset($request->new_password)) {
            $messages = [
                'new_password.required' => 'Kata sandi baru wajib diisi.',
                'new_password.min' => 'Kata sandi baru minimal memuat 6 karakter.',
                'new_password.confirmed' => 'Kata sandi baru tidak sama.',
            ];

            $validator = Validator::make($request->all(), [
                'new_password' => ['required', 'string', 'min:6', 'confirmed'],
            ], $messages);

            $passValid = Hash::check($request->current_password, auth()->user()->password);

            if ($validator->fails() || $passValid == false) {
                if ($passValid == false) {
                    $validator->getMessageBag()->add('current_password', 'Kata sandi tidak sesuai.');
                }
                return redirect('profil')->withErrors($validator)->withInput();
            }

            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            return redirect('profil')->with('passwordMessage', 'Kata sandi Anda berhasil diatur ulang.');
        }
        else {
            $messages = [
                'name.required' => 'Nama wajib diisi.',
                'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
                'email.required' => 'Alamat email wajib diisi.',
                'email.email' => 'Alamat email tidak valid.',
                'email.max' => 'Alamat email tidak boleh lebih dari 255 karakter.',
                'password.required' => 'Kata sandi wajib diisi.',
                'phone.max' => 'Nomor telepon tidak boleh lebih dari 255 karakter.',
            ];

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required'],
            ], $messages);

            $emailValid = User::isEmailUnique($request->email, auth()->user()->email);
            $passValid = Hash::check($request->password, auth()->user()->password);

            if ($validator->fails() || $emailValid == false || $passValid == false) {
                if ($emailValid == false) {
                    $validator->getMessageBag()->add('email', 'Alamat email ini sudah terdaftar.');
                }
                if ($passValid == false) {
                    $validator->getMessageBag()->add('password', 'Kata sandi tidak sesuai.');
                }
                return redirect('profil')->withErrors($validator)->withInput();
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
            ]);

            return redirect('profil')->with('profileMessage', 'Detail profil Anda berhasil diubah.');
        }
    }
}
