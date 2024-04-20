<?php

namespace App\Http\Controllers;

use App\Image;
use App\Report;
use App\ReportAttachment;
use App\Schedule;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ReportController extends Controller
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

        $reports = Report::all();
        $total['waiting'] = User::getTotalWaitingDocument();
        $total['booked'] = Schedule::getTotalBooked();

        return view('admin.report.index', compact('reports', 'total'));
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
        $report = Report::create([
            'subject' => $request->subject,
            'content' => $request->content,
            'user_id' => auth()->user()->id
        ]);

        if (NULL !== $request->file('attachments')) {
            $files = $request->file('attachments');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $filename = pathinfo($filename, PATHINFO_FILENAME);
                $extension = ".".$file->getClientOriginalExtension();

                $attachment = ReportAttachment::create([
                    'name' => $filename,
                    'ext' => $extension,
                    'report_id' => $report->id
                ]);

                $file->move("attachments/", $attachment->id."｜".$attachment->name.$attachment->ext);
            }
        }

        return redirect('admin/reports')->with('message', 'Laporan dengan judul "'.$report->subject.'" berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (auth()->guest() || auth()->user()->role != "admin") {
            return redirect('/login');
        }

        $report = Report::findOrFail($id);
        $total['waiting'] = User::getTotalWaitingDocument();
        $total['booked'] = Schedule::getTotalBooked();

        return view('admin.report.show', compact('report', 'total'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
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
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $report->update([
            'subject' => $request->subject,
            'content' => $request->content,
            'user_id' => auth()->user()->id
        ]);

        return redirect('admin/reports/'.$report->id)->with('message', 'Laporan dengan judul "'.$report->subject.'" berhasil disunting.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        $attachments = ReportAttachment::findByReportId($report->id);
        foreach ($attachments as $attachment) {
            File::delete(public_path('attachments/'.$attachment->id."｜".$attachment->name.$attachment->ext));
            $attachment->delete();
        }
        $subject = $report->subject;
        $report->delete();
        return redirect('admin/reports')->with('message','Laporan "'.$subject.'" berhasil dihapus beserta dengan lampirannya.');
    }

    /**
     * Store an image to server
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $file = $request->file('upload');

            //get filename with extension
            $filenamewithextension = $file->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = ".".$file->getClientOriginalExtension();

            //update database
            $image = Image::create([
                'name' => $filename,
                'ext' => $extension,
                'user_id' => auth()->user()->id
            ]);

            //filename to store
            $filenametostore = $image->name."｜".$image->id.$image->ext;

            //Upload File
            $file->move("images/user_upload/", $filenametostore);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/user_upload/'.$filenametostore);
            $msg = 'Gambar berhasil diunggah.';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }

    /**
     * Delete specified attachments from report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReportAttachment  $reportAttachment
     * @return \Illuminate\Http\Response
     */
    public function delete(ReportAttachment $reportAttachment)
    {
        $report_id = $reportAttachment->report_id;
        File::delete(public_path('attachments/'.$reportAttachment->id."｜".$reportAttachment->name.$reportAttachment->ext));
        $reportAttachment->delete();

        return redirect('admin/reports/'.$report_id)->with('messageAttachment', 'Lampiran yang dipilih berhasil dihapus.');
    }

    /**
     * Add attachment for report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request, Report $report)
    {
        if (NULL !== $request->file('attachments')) {
            $files = $request->file('attachments');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $filename = pathinfo($filename, PATHINFO_FILENAME);
                $extension = ".".$file->getClientOriginalExtension();

                $attachment = ReportAttachment::create([
                    'name' => $filename,
                    'ext' => $extension,
                    'report_id' => $report->id
                ]);

                $file->move("attachments/", $attachment->id."｜".$attachment->name.$attachment->ext);
            }
        }

        return redirect('admin/reports/'.$report->id)->with('messageAttachment', 'Berhasil menambahkan lampiran baru.');
    }


}
