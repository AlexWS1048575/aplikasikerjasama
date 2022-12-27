<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Corporation;
use App\Models\Status;
use App\Models\Type;
use App\Models\CorporationType;
use App\Models\DurationType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CorporationNotification;
use App\Notifications\CorporationUpdateNotification;
use App\Notifications\CorporationSuccessNotification;
use App\Notifications\CorporationNeedRevisionNotification;
use PDF;
use App\Imports\CorporationImport;
use App\Exports\CorporationExport;
use Maatwebsite\Excel\Facades\Excel;

class CorporationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $corporations = Corporation::all();
        $user = Auth::user();
        // jika user yang login role adalah admin
        if ($user->role_id == '1') {
            $corporations = Corporation::all();
            return view('corporations.index', [
                'corporations' => $corporations
            ])->with([
                'user' => $user,
            ]);
        // selain role admin
        } else {
            return view('404');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = Status::all();
        $types = Type::all();
        $corporationtypes = CorporationType::all();
        $durationtypes = DurationType::all();
        $corporations = Corporation::all();
        $user = Auth::user();
        // jika user yang login role adalah admin
        if ($user->role_id == '1') {
            return view('corporations.create', compact('statuses', 'types', 'corporationtypes', 'durationtypes'))->with(['user' => $user]);
        // selain role admin
        } else {
            return view('404');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'document_no' => 'required',
            'assignment_date' => 'required',
            'summary' => 'required',
            'duration' => 'required',
            'type_id' => 'required',
            'corporationtype_id' => 'required',
            'durationtype_id' => 'required',
            'attachment' => 'file|mimes:pdf|max:4096',
        ]);
        // jika ada file
        if ($request->hasFile('attachment')) {
            $filenameWithExt = $request->file('attachment')->getClientOriginalName();
            $attachment = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('attachment')->getClientOriginalExtension();
            $newFilename = $attachment.'_'.date('YmdHis').'.'.$extension;
            $path = $request->file('attachment')->storeAs('attachment', $newFilename);
            Corporation::create([
                'name' => $request->name,
                'title' => $request->title,
                'phonenumber' => $request->phonenumber,
                'document_no' => $request->document_no,
                'assignment_date' => $request->assignment_date,
                'summary' => $request->summary,
                'pic' => $request->pic,
                'duration' => $request->duration,
                'type_id' => $request->type_id,
                'corporationtype_id' => $request->corporationtype_id,
                'durationtype_id' => $request->durationtype_id,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'attachment' => $newFilename,
            ]);
        // jika tidak ada file
        } else {
            Corporation::create([
                'name' => $request->name,
                'title' => $request->title,
                'phonenumber' => $request->phonenumber,
                'document_no' => $request->document_no,
                'assignment_date' => $request->assignment_date,
                'summary' => $request->summary,
                'pic' => $request->pic,
                'duration' => $request->duration,
                'type_id' => $request->type_id,
                'corporationtype_id' => $request->corporationtype_id,
                'durationtype_id' => $request->durationtype_id,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }
        // kirim notifikasi bahwa data berhasil diinput
        Notification::send($user, new CorporationNotification($request->name));
        return redirect()->route('corporations.index')
            ->with('success_message', 'Data Kerjasama berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $statuses = Status::all();
        $types = Type::all();
        $corporationtypes = CorporationType::all();
        $durationtypes = DurationType::all();
        $corporation = Corporation::find($id);
        $user = Auth::user();
        // jika user yang login role adalah admin
        if ($user->role_id == '1') {
            return view('corporations.show', ['corporation' => $corporation], compact('statuses', 'types', 'corporationtypes', 'durationtypes'))->with(['user' => $user]);
        // selain role admin
        } else {
            return view('404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $statuses = Status::all();
        $types = Type::all();
        $corporationtypes = CorporationType::all();
        $durationtypes = DurationType::all();
        $corporation = Corporation::find($id);
        $user = Auth::user();
        // jika user yang login role adalah admin
        if ($user->role_id == '1') {
            return view('corporations.edit', ['corporation' => $corporation], compact('statuses', 'types', 'corporationtypes', 'durationtypes'))->with(['user' => $user]);
        // selain role admin
        } else {
            return view('404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'document_no' => 'required',
            'assignment_date' => 'required',
            'summary' => 'required',
            'duration' => 'required',
            'status_id' => 'required',
            'type_id' => 'required',
            'corporationtype_id' => 'required',
            'durationtype_id' => 'required',
            'attachment' => 'file|mimes:pdf|max:4096',
        ]);

        $corporation = Corporation::find($id);
        // jika ada berkas yang mau diganti
        if ($request->hasFile('attachment')) {
            $corporation->name = $request->name;
            $corporation->title = $request->title;
            $corporation->phonenumber = $request->phonenumber;
            $corporation->document_no = $request->document_no;
            $corporation->assignment_date = $request->assignment_date;
            $corporation->summary = $request->summary;
            $corporation->pic = $request->pic;
            $corporation->duration = $request->duration;
            $corporation->status_id = $request->status_id;
            $corporation->type_id = $request->type_id;
            $corporation->corporationtype_id = $request->corporationtype_id;
            $corporation->durationtype_id = $request->durationtype_id;
            $corporation->updated_by = $user->id;
            $filenameWithExt = $request->file('attachment')->getClientOriginalName();
            $attachment = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('attachment')->getClientOriginalExtension();
            $newFilename = $attachment.'_'.'updated'.'_'.date('YmdHis').'.'.$extension;
            Storage::delete('attachment/'.$corporation->attachment); // hapus berkas lama guna mengurangi sampah pada project, dan berkas di folder public/storage juga diganti
            $path = $request->file('attachment')->storeAs('attachment', $newFilename);
            $corporation->attachment = $newFilename;
            $corporation->save();
        // jika tidak ada berkas
        } else {
            $corporation->name = $request->name;
            $corporation->title = $request->title;
            $corporation->phonenumber = $request->phonenumber;
            $corporation->document_no = $request->document_no;
            $corporation->assignment_date = $request->assignment_date;
            $corporation->summary = $request->summary;
            $corporation->pic = $request->pic;
            $corporation->duration = $request->duration;
            $corporation->status_id = $request->status_id;
            $corporation->type_id = $request->type_id;
            $corporation->corporationtype_id = $request->corporationtype_id;
            $corporation->durationtype_id = $request->durationtype_id;
            $corporation->updated_by = $user->id;
            $corporation->save();
        }
        // kirim notifikasi bahwa data berhasil diupdate
        Notification::send($user, new CorporationUpdateNotification($request->name));
        return redirect()->route('corporations.index')
            ->with('success_message', 'Data Kerjasama berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $corporation = Corporation::find($id);
        Storage::delete('attachment/'. $corporation->attachment); // hapus berkas yang diupload guna mengurangi sampah pada project
        if ($corporation) $corporation->delete();
        return redirect()->route('corporations.index')
            ->with('success_message', 'Data Kerjasama berhasil dihapus!');
    }

    // cetak pdf
    public function downloadpdf() {
        $corporations = Corporation::get();
  
        // ambil semua data dari database
        $data = [
            'title' => 'Data PDF Kerja Sama',
            'corporations' => $corporations,
        ]; 
        // tanggal download pdf adalah tanggal hari ini
        $date = date('YmdHis');

        // load view PDF
        $pdf = PDF::loadView('corporations.pdf', $data)->setPaper('a4', 'landscape');
        // cetak pdf dengan metode download
        return $pdf->download($date.'_'.'updated.pdf');
        // return $pdf;
    }

    // ekspor ke excel
    public function exportexcel() {
        // tanggal ekspor diambil dari tanggal hari ini
        $date = date('YmdHis');
        // ekspor ke excel
        return Excel::download(new CorporationExport, $date.'_'.'updated.xlsx');
    }

    // lihat halaman import
    public function viewimport() {
        return view('corporations.import');
    }

    // impor data dari excel
    public function importexcel(Request $request) {
        // cek apakah file berupa excel atau tidak, jika tidak atau lebih dari 4 MB akan muncul pesan error
        $validatedData = $request->validate([
            'file' => 'required|mimes:xls,xlsx|max:4096',
         ]);
        Excel::import(new CorporationImport, $request->file('file'));
        return redirect('corporations')->with('success_message', 'Daftar Kerjasama berhasil diimport!');
    }

    // set status kerjasama menjadi setuju
    public function setasapproved($id) {
        $user = Auth::user();
        $corporation = Corporation::find($id);
        $corporation->update([
            'status_id' => '3',
        ]);
        // kirim notifikasi bahwa status kerjasama telah disetujui
        Notification::send($user, new CorporationSuccessNotification($corporation->name));
        return redirect()->route('corporations.index')
            ->with('success_message', 'Status Kerjasama berhasil disetujui!');
    }

    // set status kerjasama menjadi needs revision (perlu revisi)
    public function setasrevisions($id) {
        $user = Auth::user();
        $corporation = Corporation::find($id);
        $corporation->update([
            'status_id' => '2',
        ]);
        // kirim notifikasi bahwa status kerjasama perlu direvisi
        Notification::send($user, new CorporationNeedRevisionNotification($corporation->name));
        return redirect()->route('corporations.index')
            ->with('success_message', 'Status Kerjasama berhasil dibatalkan!');
    }
}
