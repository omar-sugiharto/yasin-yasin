<?php

namespace App\Http\Controllers;

use App\SiteInfo;
use App\Document;
use App\Mail\AcceptClientDocuments;
use App\Mail\ClientSendDocuments;
use App\Mail\MessageClientDocuments;
use App\Mail\RejectClientDocuments;
use App\Schedule;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestUrl;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->guest() || auth()->user()->role != "admin") {
            return redirect('/');
        }

        $users = User::allClient();
        $total['waiting'] = User::getTotalWaitingDocument();
        $total['booked'] = Schedule::getTotalBooked();

        return view('admin.document.index', compact('users', 'total'));
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
    public function store(Request $request, User $user = NULL)
    {
        if ($user == NULL) {
            $user = auth()->user();
        }

        $user->update([
            'document_status' => 'waiting',
            'document_notes' => NULL
        ]);

        $file = $request->file('fc_file');

        $loc = md5("kjayasinyasin".md5($request->fc_name).$file->extension());

        $user->documents()->create([
            'name' => $request->fc_name,
            'ext' => $file->extension(),
            'loc' => $loc,
        ]);

        $file->move("client_documents/{$user->id}/", $loc);

        if (!RequestUrl::is('admin/*')) {
            Mail::to(SiteInfo::search('admin_mail', true))->send(new ClientSendDocuments($user->name));
            return redirect("profil#pemberkasan")->with('documentsMessage','Berkas baru, "'.$request->fc_name.'", telah ditambahkan.');
        }

        return redirect("admin/documents/{$user->id}")->with('message','Berkas baru, "'.$request->fc_name.'", telah ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if (auth()->guest() || auth()->user()->role != "admin") {
            return redirect('/');
        }

        $total['waiting'] = User::getTotalWaitingDocument();
        $total['booked'] = Schedule::getTotalBooked();

        return view('admin.document.show', compact('user', 'total'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Document $document)
    {
        $document->update(['name' => $request->fe_name]);

        if (!RequestUrl::is('admin/*')) {
            return redirect("profil#pemberkasan")->with('documentsMessage', "Nama dokumen telah diperbarui.");
        }
        else {
            return redirect()->back()->with('mMessage', "Nama dokumen telah diperbarui.");
        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user = NULL, Document $document)
    {
        if ($user == NULL) {
            $user = auth()->user();
        }

        $name = $document->name;
        $document->delete();
        File::delete(public_path("client_documents/{$user->id}/{$document->loc}"));

        if (!RequestUrl::is('admin/*')) {
            $user->update(['document_status' => 'waiting']);
            Mail::to(SiteInfo::search('admin_mail', true))->send(new ClientSendDocuments($user->name));
            return redirect("profil#pemberkasan")->with('documentsMessage', "Dokumen {$name} telah dihapus.");
        }
        else {
            return redirect()->back()->with('message', "Dokumen {$name} telah dihapus.");
        }
    }

    /**
     * Accept specified client document.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request, User $user)
    {
        $user->update([
            'document_status' => 'accepted',
            'document_notes' => (($request->fa_message == "-") ? NULL : $request->fa_message)
        ]);

        Mail::to($user->email)->send(new AcceptClientDocuments());

        return redirect()->back()->with('message', 'Berkas klien '.$user->name.' berhasil disetujui.');
    }

    /**
     * Reject specified client document.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request, User $user)
    {
        $user->update([
            'document_status' => 'rejected',
            'document_notes' => (($request->fr_message == "-") ? NULL : $request->fr_message)
        ]);

        Mail::to($user->email)->send(new RejectClientDocuments());

        return redirect()->back()->with('message', 'Berkas klien '.$user->name.' berhasil ditolak.');
    }

    /**
     * Reject specified client document.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function message(Request $request, User $user)
    {
        $user->update([
            'document_notes' => $request->fm_message
        ]);

        Mail::to($user->email)->send(new MessageClientDocuments($request->fm_message));

        return redirect()->back()->with('message', 'Pesan perihal berkas klien '.$user->name.' berhasil dikirim.');
    }

}
