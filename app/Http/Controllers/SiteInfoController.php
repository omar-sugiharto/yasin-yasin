<?php

namespace App\Http\Controllers;

use App\Document;
use App\Schedule;
use App\SiteInfo;
use App\User;
use Illuminate\Http\Request;

class SiteInfoController extends Controller
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

        $infos = SiteInfo::allConverted();
        $total['waiting'] = User::getTotalWaitingDocument();
        $total['booked'] = Schedule::getTotalBooked();

        return view('admin.info', compact('infos', 'total'));
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
        $keys = array_keys($request->infos);
        for ($i=0; $i < count($request->infos); $i++) {
            $infoDB = SiteInfo::search($keys[$i]);
            $infoDB->update(["value" => $request->infos[$keys[$i]]]);
        }

        return redirect('admin/infos')->with('message','Data kontak berhasil diubah.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SiteInfo  $info
     * @return \Illuminate\Http\Response
     */
    public function show(SiteInfo $info)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SiteInfo  $info
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteInfo $info)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SiteInfo  $info
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SiteInfo $info)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SiteInfo  $info
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteInfo $info)
    {
        //
    }
}
