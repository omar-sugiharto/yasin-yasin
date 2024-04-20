<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Schedule;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestUrl;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {

        if (auth()->guest() || auth()->user()->role != "admin") {
            return redirect('/login');
        }

        $total['waiting'] = User::getTotalWaitingDocument();
        $total['booked'] = Schedule::getTotalBooked();

        return view('admin.contact', compact('user', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user = NULL, Request $request)
    {
        $valid = true;

        if (!isset($request->contact_name) || !isset($request->contact_value)) {
            $valid = false;
        }

        if (!$valid) {
            if (RequestUrl::is('admin/*')) {
                return redirect()->back()->with('error', "Semua bidang wajib diisi.");
            }
            else {
                return redirect("profil/#kontak")->with('contactsError', "Semua bidang wajib diisi.");
            }
        }
        else {
            if ($user == NULL) {
                $user = auth()->user();
            }

            $user->contacts()->create([
                'name' => $request->contact_name,
                'value' => $request->contact_value
            ]);

            if (RequestUrl::is('admin/*')) {
                return redirect()->back()->with('message', "Kontak baru telah ditambahkan.");
            }
            else {
                return redirect("profil/#kontak")->with('contactsMessage', "Kontak baru telah ditambahkan.");
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request, Contact $contact)
    {
        $valid = true;

        if (!isset($request->contact_name) || !isset($request->contact_value)) {
            $valid = false;
        }

        if (!$valid) {
            if (RequestUrl::is('admin/*')) {
                return redirect()->back()->with('error', "Semua bidang wajib diisi.");
            }
            else {
                return redirect("profil/#kontak")->with('contactsError', "Semua bidang wajib diisi.");
            }
        }
        else {
            $contact->update([
                'name' => $request->contact_name,
                'value' => $request->contact_value
            ]);

            if (RequestUrl::is('admin/*')) {
                return redirect()->back()->with('message', "Kontak berhasil diperbarui.");
            }
            else {
                return redirect("profil/#kontak")->with('contactsMessage', "Kontak berhasil diperbarui.");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Contact $contact)
    {
        $contact->delete();
        if (RequestUrl::is('admin/*')) {
            return redirect()->back()->with('message', "Kontak berhasil dihapus.");
        }
        else {
            return redirect("profil/#kontak")->with('contactsMessage', "Kontak berhasil dihapus.");
        }
    }
}
