<?php

namespace App\Http\Controllers;

use App\Image;
use App\CpSection;
use App\Document;
use App\Schedule;
use App\SiteInfo;
use App\User;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $cp = CpSection::allConverted();
        $infos = SiteInfo::allConverted();
        $attachment = Image::allAttachment();

        return view('attachment', compact('cp', 'infos', 'attachment'));
    }

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

        $but = Image::allButAttachment();
        $attachment = Image::allAttachment();
        $total['waiting'] = User::getTotalWaitingDocument();
        $total['booked'] = Schedule::getTotalBooked();

        return view('admin.attachment', compact('but', 'attachment', 'total'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('img');

        $name = str_replace("`", "_", str_replace("'", "_", str_replace("|", "_", str_replace(">", "_", str_replace("<", "_", str_replace("?", "_", str_replace("*", "_", str_replace("\"", "_", str_replace(":", "_", str_replace("/", "_", str_replace("\\", "_", $request->name)))))))))));
        $ext = ".".$file->getClientOriginalExtension();

        $image = Image::create([
            'name' => $name,
            'ext' => $ext,
            'attachment' => true,
            'user_id' => auth()->user()->id
        ]);

        $file->move("images/user_upload/", $image->name."｜".$image->id.$image->ext);

        return redirect('admin/attachments')->with('message','Lampiran baru, "'.$image->name.$image->ext.'", telah ditambahkan. Lampiran ini juga ditambahkan ke dalam Galeri.');
    }

    /**
     * Attach specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image $id
     * @return \Illuminate\Http\Response
     */
    public function attach(Request $request, $id)
    {
        $image = Image::findOrFail($id);
        $image->update(["attachment" => true]);
        return redirect('admin/attachments')->with('message','Lampiran baru, "'.$image->name.$image->ext.'", telah ditambahkan.');
    }

    /**
     * Remove specified attribute attachment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
        if (isset($request->detach)) {
            foreach ($request->detach as $id => $value) {
                $image = Image::findOrFail($id);
                $image->update(["attachment" => false]);
            }
            return redirect('admin/attachments')->with('message','Lampiran yang dipilih telah dihapus dari Lampiran, namun masih bisa ditemukan di Galeri.');
        }
        else{
            return redirect('admin/attachments')->with('message','Tidak ada lampiran yang dipilih.');
        }
    }
}
