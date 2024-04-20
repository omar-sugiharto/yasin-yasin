<?php

namespace App\Http\Controllers;

use App\Document;
use Storage;
use App\Image;
use App\Schedule;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->guest() || auth()->user()->role != "admin") {
            return redirect('/login');
        }

        $images = Image::all();
        $total['waiting'] = User::getTotalWaitingDocument();
        $total['booked'] = Schedule::getTotalBooked();

        return view('admin.image', compact('images', 'total'));
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
        $file = $request->file('img');

        $name = str_replace("`", "_", str_replace("'", "_", str_replace("|", "_", str_replace(">", "_", str_replace("<", "_", str_replace("?", "_", str_replace("*", "_", str_replace("\"", "_", str_replace(":", "_", str_replace("/", "_", str_replace("\\", "_", $request->name)))))))))));
        $ext = ".".$file->getClientOriginalExtension();

        $image = Image::create([
            'name' => $name,
            'ext' => $ext,
            'user_id' => auth()->user()->id
        ]);

        $file->move("images/user_upload/", $image->name."｜".$image->id.$image->ext);

        return redirect('admin/images')->with('message','Gambar baru, "'.$image->name.$image->ext.'", telah ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name = str_replace("`", "_", str_replace("'", "_", str_replace("|", "_", str_replace(">", "_", str_replace("<", "_", str_replace("?", "_", str_replace("*", "_", str_replace("\"", "_", str_replace(":", "_", str_replace("/", "_", str_replace("\\", "_", $request->name)))))))))));
        $image = Image::findOrFail($id);
        $before = $image->name;
        $image->update(["name" => $name]);
        Storage::move('images/user_upload/'.$before."｜".$image->id.$image->ext, 'images/user_upload/'.$name."｜".$image->id.$image->ext);
        return redirect('admin/images')->with('message','Nama gambar berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $name = $image->name;
        $ext = $image->ext;
        $image->delete();
        return redirect('admin/images')->with('message','Gambar "'.$name.$ext.'" berhasil dibuang ke tempat sampah.');
    }

    /**
     * Display trashed listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        if (auth()->user()->role == "admin") {
            $trash = Image::trash();
            $total['waiting'] = User::getTotalWaitingDocument();
            $total['booked'] = Schedule::getTotalBooked();

            return view('admin.trash', compact('trash', 'total'));
        }
        else {
            return redirect('/');
        }
    }

    /**
     * Vanish the specified resource from trash.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function vanish($id)
    {
        $image = Image::withTrashed()->findOrFail($id);
        $name = $image->name;
        $ext = $image->ext;

        File::delete(public_path('images/user_upload/'.$name."｜".$image->id.$image->ext));

        $image->forceDelete();
        return redirect('admin/images/trash')->with('message','Gambar "'.$name.$ext.'" berhasil dihapus secara permanen.');
    }

    /**
     * Restore the specified resource from trash.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $image = Image::withTrashed()->findOrFail($id);
        $name = $image->name;
        $ext = $image->ext;
        $image->restore();
        return redirect('admin/images/trash')->with('message','Gambar "'.$name.$ext.'" berhasil dikembalikan ke galeri.');
    }
}
