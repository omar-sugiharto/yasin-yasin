<?php

namespace App\Http\Controllers;

use App\SiteInfo;
use App\Testimonial;
use App\CpSection;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cp = CpSection::allConverted();
        $infos = SiteInfo::allConverted();
        $testimonials = Testimonial::all();
        $rate = Testimonial::calcRate();
        return view('testimoni', compact('testimonials', 'rate', 'cp', 'infos'));
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
        Testimonial::create([
            'user_id' => auth()->id,
            'message' => $request->message,
            'rating' => $request->rating,
        ]);

        return redirect('testimoni')->with('message', "Terima kasih telah memberikan testimoni tehadap pelayanan kami. Sepatah dua patah kata dari Anda akan sangat berarti bagi pelayanan kami ke depannya.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function edit(Testimonial $testimonial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimonial $testimonial)
    {
        //
    }
}
