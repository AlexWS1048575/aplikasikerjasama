<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wish;
use App\Models\Requester;
use App\Models\Status;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WishNotification;
use App\Notifications\WishUpdateNotification;
use App\Notifications\WishStatusNotification;

class WishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        // jika user yang login role adalah admin
        if ($user->role_id == '1') {
            $wishes = Wish::all();
            return view('wishes.index', [
                'wishes' => $wishes
            ])->with([
                'user' => $user,
            ]);
        // selain role admin
        } else {
            // jika salah satu data user tidak lengkap
            if ((!$user->affiliation) || (!$user->phone)) {
                // redirect ke halaman unauthorized, dimana user wajibkan mengisi data terlebih dahulu untuk mengakses data
                return view('401');
            // jika semua data user lengkap
            } else {
                $wishes = Wish::where('created_by', $user->id)->get();
                return view('wishes.index', [
                    'wishes' => $wishes
                ])->with([
                    'user' => $user,
                ]);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $requesters = Requester::all();
        return view('wishes.create', compact('requesters'))->with(['user' => $user]);
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
        $validateData = $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'organization' => 'required',
            'requester_id' => 'required',
            'filename' => 'file|mimes:pdf|max:4096',
        ]);

        // jika punya berkas
        if ($request->hasFile('filename')) {
            $wish = new Wish();
            $wish->name = $validateData['name'];
            $wish->detail = $validateData['detail'];
            $wish->phone = $request->phone;
            $wish->pic = $request->pic;
            $wish->organization = $validateData['organization'];
            $wish->requester_id = $validateData['requester_id'];
            $wish->created_by = $user->id;
            $wish->updated_by = $user->id;
            $filenameWithExt = $request->file('filename')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('filename')->getClientOriginalExtension();
            $newFilename = $filename.'_'.date('YmdHis').'.'.$extension;
            $path = $request->file('filename')->storeAs('wishes', $newFilename);
            $wish->filename = $newFilename;
            $wish->save();
        // jika tidak punya berkas
        } else {
            $wish = new Wish();
            $wish->name = $validateData['name'];
            $wish->detail = $validateData['detail'];
            $wish->phone = $request->phone;
            $wish->pic = $request->pic;
            $wish->organization = $validateData['organization'];
            $wish->requester_id = $validateData['requester_id'];
            $wish->created_by = $user->id;
            $wish->updated_by = $user->id;
            $wish->save();
        }
        Notification::send($user, new WishNotification($request->name));
        
        return redirect()->route('wishes.index')
            ->with('success_message', 'Data Permohonan Kerjasama berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wish = Wish::find($id);
        $requesters = Requester::all();
        $statuses = Status::all();
        $user = Auth::user();
        return view('wishes.show', ['wish' => $wish], compact('requesters', 'statuses'))->with(['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $wish = Wish::find($id);
        $requesters = Requester::all();
        $statuses = Status::all();
        $user = Auth::user();
        return view('wishes.edit', ['wish' => $wish], compact('requesters', 'statuses'))->with(['user' => $user]);
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
        $validateData = $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'organization' => 'required',
            'requester_id' => 'required',
            'status_id' => 'required',
            'filename' => 'file|mimes:pdf|max:4096',
        ]);
        $wish = Wish::find($id);
        // jika ada berkas yang mau diganti
        if ($request->hasFile('filename')) {
            $wish->name = $validateData['name'];
            $wish->detail = $validateData['detail'];
            $wish->phone = $request->phone;
            $wish->pic = $request->pic;
            $wish->organization = $validateData['organization'];
            $wish->requester_id = $validateData['requester_id'];
            $wish->status_id = $request->status_id;
            $wish->updated_by = $user->id;
            $filenameWithExt = $request->file('filename')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('filename')->getClientOriginalExtension();
            $newFilename = $filename.'_'.'updated'.'_'.date('YmdHis').'.'.$extension;
            Storage::delete('wishes/'.$wish->filename);
            $path = $request->file('filename')->storeAs('wishes', $newFilename);
            $wish->filename = $newFilename;
            $wish->save();
        // jika tidak ada berkas
        } else {
            $wish->name = $validateData['name'];
            $wish->detail = $validateData['detail'];
            $wish->phone = $request->phone;
            $wish->pic = $request->pic;
            $wish->organization = $validateData['organization'];
            $wish->requester_id = $validateData['requester_id'];
            $wish->status_id = $request->status_id;
            $wish->updated_by = $user->id;
            $wish->save();
        }
        Notification::send($user, new WishUpdateNotification($request->name));

        return redirect()->route('wishes.index')
                        ->with('success_message','Data Permohonan Kerjasama berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wish = Wish::find($id);
        Storage::delete('wishes/'. $wish->filename);
        if ($wish) $wish->delete();
        return redirect()->route('wishes.index')
            ->with('success_message', 'Daftar Permohonan Kerjasama berhasil dihapus!');
    }

    // set status kerjasama menjadi setuju
    public function wishcometrue($id) {
        $user = Auth::user();
        $wish = Wish::find($id);
        $created_by = DB::table("wishes")
                ->leftJoin("users", function($join){
                    $join->on("wishes.created_by", "=", "users.id");
                })
                ->select("wishes.created_by")
                ->where("wishes.id", "=", $id)
                ->get();
        $wish->update([
            'status_id' => '3',
        ]);
        Notification::send($created_by, new WishStatusNotification($wish->name));
        return redirect()->route('wishes.index')
            ->with('success_message', 'Status Permohonan Kerjasama berhasil disetujui!');
    }

    // set status kerjasama menjadi needs revision (perlu revisi)
    public function wishcancelled($id) {
        $user = Auth::user();
        $wish = Wish::find($id);
        $wish->update([
            'status_id' => '2',
        ]);
        return redirect()->route('wishes.index')
            ->with('success_message', 'Status Permohonan Kerjasama berhasil dibatalkan!');
    }
}
