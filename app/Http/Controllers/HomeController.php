<?php

namespace App\Http\Controllers;

use App\Testimonial;
use App\CpSection;
use App\Document;
use App\Mail\SendMessage;
use App\Schedule;
use App\SiteInfo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Show the homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cp = CpSection::allConverted();
        $sections = CpSection::orderBy('pos')->get();
        $infos = SiteInfo::allConverted();
        $testimonials = Testimonial::getRandom();
        return view('index', compact('sections', 'cp', 'infos', 'testimonials'));
    }

    /**
     * Show the administration dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admin()
    {
        if (auth()->guest() || auth()->user()->role != "admin") {
            return redirect('/login');
        }

        $cp = CpSection::all();
        $total['waiting'] = User::getTotalWaitingDocument();
        $total['booked'] = Schedule::getTotalBooked();

        return view('admin.index', compact('cp', 'total'));
    }

    /**
     * Send email / message to admin.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function send(Request $request)
    {
        $message['name'] = $request->name;
        $message['email'] = $request->email;
        $message['subject'] = $request->subject;
        $message['message'] = $request->message;

        Mail::to(SiteInfo::search('customer_service_mail', true))->send(new SendMessage($message));

        return redirect('/')->with('message', 'Pesan terkirim, balasan akan kami kirim ke email Anda, terima kasih.');
    }
}
