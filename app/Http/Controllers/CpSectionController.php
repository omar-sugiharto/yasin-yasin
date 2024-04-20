<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\CpSection;
use App\Document;
use App\Schedule;
use App\User;
use Illuminate\Http\Request;

class CpSectionController extends Controller
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

        $cp = CpSection::orderBy('pos')->get();
        $total['waiting'] = User::getTotalWaitingDocument();
        $total['booked'] = Schedule::getTotalBooked();
        return view('admin.cp.index', compact('cp', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->guest() || auth()->user()->role != "admin") {
            return redirect('/login');
        }

        $total['waiting'] = User::getTotalWaitingDocument();
        $total['booked'] = Schedule::getTotalBooked();
        return view('admin.cp.create', compact('total'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!isset($request->title)) {
            return redirect()->back()->withInput()->with('error', "Judul wajib diisi!");
        }

        $slug = Str::slug($request->title);

        $no = 0;
        while (CpSection::getBySlug($slug) !== NULL) {
            $no++;
            $slug = Str::slug($request->title).'-'.$no;
        }

        $pos = CpSection::latest()->orderBy('pos', 'desc')->first()->pos + 1;

        $cp = CpSection::create([
            'title'   => $request->title,
            'content' => $request->content,
            'slug'    => $slug,
            'pos'     => $pos,
            'user_id' => auth()->user()->id
        ]);

        return redirect('admin/cp/'.$slug)->with('message', $cp->title.' perusahaan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CpSection  $cpSection
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        if (auth()->guest() || auth()->user()->role != "admin") {
            return redirect('/login');
        }

        $cp = CpSection::getBySlug($slug);

        if ($cp == NULL) {
            abort(404);
        }

        $total['waiting'] = User::getTotalWaitingDocument();
        $total['booked'] = Schedule::getTotalBooked();

        if ($slug == "about" || $slug == "vimision") {
            return view('admin.cp.'.$slug, compact('cp', 'total'));
        }
        else {
            return view('admin.cp.cp', compact('cp', 'total'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CpSection  $cpSection
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CpSection  $cpSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $cp = CpSection::getBySlug($slug);

        if ($slug == 'vimision') {
            $cp[0]->update([
                'content' => $request->vision,
                'user_id' => auth()->user()->id
            ]);
            $cp[1]->update([
                'content' => $request->mission,
                'user_id' => auth()->user()->id
            ]);

            $title = "Visi & Misi";
        }
        else {
            if ($slug == 'tentang') {
                $cp->update([
                    'content' => $request->content,
                    'user_id' => auth()->user()->id
                ]);
            }
            else {
                $slug = Str::slug($request->title);

                $no = 0;
                while (CpSection::getBySlug($slug) !== NULL) {
                    $no++;
                    $slug = Str::slug($request->title).'-'.$no;
                }

                $cp->update([
                    'title'   => $request->title,
                    'content' => $request->content,
                    'slug'    => $slug,
                    'user_id' => auth()->user()->id
                ]);
            }
            $title = $cp->title;
        }

        return redirect('admin/cp/'.$slug)->with('message', $title.' perusahaan berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CpSection  $cpSection
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $cp = CpSection::getBySlug($slug);
        $title = $cp->title;
        $cp->delete();
        return redirect()->back()->with('message', $title.' perusahaan berhasil dihapus.');
    }

    public function up($cp)
    {
        $cp = CpSection::getBySlug($cp);
        $current = $cp->pos;

        $up = CpSection::where('pos', ($current - 1))->get()->first();
        $cp->update(['pos' => $current - 1]);
        $up->update(['pos' => ($up->pos + 1)]);

        return redirect()->back()->with('message', "Berhasil menaikkan {$cp->title}.");
    }

    public function down($cp)
    {
        $cp = CpSection::getBySlug($cp);
        $current = $cp->pos;

        $down = CpSection::where('pos', $current + 1)->get()->first();
        $cp->update(['pos' => $current + 1]);
        $down->update(['pos' => ($down->pos - 1)]);

        return redirect()->back()->with('message', "Berhasil menurunkan {$cp->title}.");
    }
}
