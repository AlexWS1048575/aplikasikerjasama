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
use App\Notifications\WishToAdminNotification;
use App\Notifications\WishUpdateNotification;
use App\Notifications\WishUpdateToAdminNotification;
use App\Notifications\WishUpdateToUserNotification;
use App\Notifications\WishSuccessNotification;
use App\Notifications\WishSuccessToUserNotification;
use App\Notifications\WishRejectedNotification;
use App\Notifications\WishRejectedToUserNotification;

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
                // data permohonan diambil dari data user yang input, tidak diambil dari semua data
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
        $newFilename = $filename . '_' . date('YmdHis') . '.' . $extension;
        $path = public_path('wishes-pdf') . '/' . $newFilename;
        $request->file('filename')->move(public_path('wishes-pdf'), $newFilename);
        $wish->filename = $newFilename;
        $wish->save();
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
    
    // send notifications
    if ($user->role_id == 1) {
        // if user is admin
        Notification::send($user, new WishNotification($request->name));
    } else {
        // if user is not admin
        $admin = User::where('role_id', 1)->first();
        Notification::send($user, new WishNotification($request->name));
        Notification::send($admin, new WishToAdminNotification($request->name, $user));
    }

    return redirect()->route('wishes.index')
        ->with('success_message', 'Data Permohonan Kerjasama berhasil ditambahkan!');
}

    // public function store(Request $request)
    // {
    //     $user = Auth::user();
    //     $validateData = $request->validate([
    //         'name' => 'required',
    //         'detail' => 'required',
    //         'organization' => 'required',
    //         'requester_id' => 'required',
    //         'filename' => 'file|mimes:pdf|max:4096',
    //     ]);

    //     // jika punya berkas
    //     if ($request->hasFile('filename')) {
    //         $wish = new Wish();
    //         $wish->name = $validateData['name'];
    //         $wish->detail = $validateData['detail'];
    //         $wish->phone = $request->phone;
    //         $wish->pic = $request->pic;
    //         $wish->organization = $validateData['organization'];
    //         $wish->requester_id = $validateData['requester_id'];
    //         $wish->created_by = $user->id;
    //         $wish->updated_by = $user->id;
    //         $filenameWithExt = $request->file('filename')->getClientOriginalName();
    //         $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    //         $extension = $request->file('filename')->getClientOriginalExtension();
    //         $newFilename = $filename . '_' . date('YmdHis') . '.' . $extension;
    //         // $path = $request->file('filename')->storeAs('wishes', $newFilename);
    //         $path = $request->file('filename')->storeAs('public/wishes-pdf', $newFilename);
    //         $wish->filename = $newFilename;
    //         $wish->save();
    //         // jika tidak punya berkas
    //     } else {
    //         $wish = new Wish();
    //         $wish->name = $validateData['name'];
    //         $wish->detail = $validateData['detail'];
    //         $wish->phone = $request->phone;
    //         $wish->pic = $request->pic;
    //         $wish->organization = $validateData['organization'];
    //         $wish->requester_id = $validateData['requester_id'];
    //         $wish->created_by = $user->id;
    //         $wish->updated_by = $user->id;
    //         $wish->save();
    //     }
    //     // kirim notifikasi bahwa data berhasil diinput, jika user yang login admin
    //     if ($user->role_id == 1) {
    //         Notification::send($user, new WishNotification($request->name));
    //         // selain role admin
    //     } else {
    //         // $iduser adalah user dengan role admin
    //         $iduser = User::where('role_id', '=', '1')->get();
    //         // kirim notifikasi ke user
    //         Notification::send($user, new WishNotification($request->name));
    //         // kirim norifikasi ke admin
    //         Notification::send($iduser, new WishToAdminNotification($request->name, $user));
    //     }

    //     return redirect()->route('wishes.index')
    //         ->with('success_message', 'Data Permohonan Kerjasama berhasil ditambahkan!');
    // }
    // public function store(Request $request)
    // {
    //     $user = Auth::user();
    //     $validateData = $request->validate([
    //         'name' => 'required',
    //         'detail' => 'required',
    //         'organization' => 'required',
    //         'requester_id' => 'required',
    //         'filename' => 'file|mimes:pdf|max:4096',
    //     ]);

    //     // jika punya berkas
    //     if ($request->hasFile('filename')) {
    //         $wish = new Wish();
    //         $wish->name = $validateData['name'];
    //         $wish->detail = $validateData['detail'];
    //         $wish->phone = $request->phone;
    //         $wish->pic = $request->pic;
    //         $wish->organization = $validateData['organization'];
    //         $wish->requester_id = $validateData['requester_id'];
    //         $wish->created_by = $user->id;
    //         $wish->updated_by = $user->id;
    //         $filenameWithExt = $request->file('filename')->getClientOriginalName();
    //         $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    //         $extension = $request->file('filename')->getClientOriginalExtension();
    //         $newFilename = $filename . '_' . date('YmdHis') . '.' . $extension;
    //         $path = $request->file('filename')->storeAs('wishes', $newFilename, 'public');
    //         $wish->filename = $newFilename;
    //         $wish->save();
    //     } else {
    //         $wish = new Wish();
    //         $wish->name = $validateData['name'];
    //         $wish->detail = $validateData['detail'];
    //         $wish->phone = $request->phone;
    //         $wish->pic = $request->pic;
    //         $wish->organization = $validateData['organization'];
    //         $wish->requester_id = $validateData['requester_id'];
    //         $wish->created_by = $user->id;
    //         $wish->updated_by = $user->id;
    //         $wish->save();
    //     }

    //     // kirim notifikasi bahwa data berhasil diinput, jika user yang login admin
    //     if ($user->role_id == 1) {
    //         Notification::send($user, new WishNotification($request->name));
    //     } else {
    //         // $iduser adalah user dengan role admin
    //         $iduser = User::where('role_id', '=', '1')->get();
    //         // kirim notifikasi ke user
    //         Notification::send($user, new WishNotification($request->name));
    //         // kirim norifikasi ke admin
    //         Notification::send($iduser, new WishToAdminNotification($request->name, $user));
    //     }

    //     return redirect()->route('wishes.index')
    //         ->with('success_message', 'Data Permohonan Kerjasama berhasil ditambahkan!');
    // }


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
            $newFilename = $filename . '_' . 'updated' . '_' . date('YmdHis') . '.' . $extension;
            Storage::delete('wishes/' . $wish->filename);
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
        // kirim notifikasi bahwa data berhasil diinput, jika user yang login admin
        if (($user->role_id == '1') && ($wish->created_by == '1')) {
            Notification::send($user, new WishUpdateNotification($request->name));
            // jika admin menginput data user lain
        } else if (($user->role_id == '1') && ($wish->created_by > '1')) {
            // kirim notifikasi ke admin
            Notification::send($user, new WishUpdateNotification($request->name));
            // ambil id created_by dari tabel permohonan kerjasama
            $idpengguna = User::select('users.*')->join('wishes', 'wishes.created_by', '=', 'users.id')->where('wishes.id', '=', $id)->get();
            // kirim notifikasi ke users 
            Notification::send($idpengguna, new WishUpdateToUserNotification($request->name));
            // selain role admin
        } else {
            // $iduser adalah user dengan role admin
            $iduser = User::where('role_id', '=', '1')->get();
            // kirim notifikasi ke user
            Notification::send($user, new WishUpdateNotification($request->name));
            // kirim norifikasi ke admin
            Notification::send($iduser, new WishUpdateToAdminNotification($request->name, $user));
        }

        return redirect()->route('wishes.index')
            ->with('success_message', 'Data Permohonan Kerjasama berhasil diubah!');
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
        Storage::delete('wishes/' . $wish->filename);
        if ($wish) $wish->delete();
        return redirect()->route('wishes.index')
            ->with('success_message', 'Daftar Permohonan Kerjasama berhasil dihapus!');
    }

    // set status permohonan kerjasama menjadi setuju
    public function wishcometrue($id)
    {
        $user = Auth::user();
        $wish = Wish::find($id);
        $wish->update([
            'status_id' => '3',
        ]);
        // ambil id created_by dari tabel permohonan kerjasama
        $idpengguna = User::select('users.*')->join('wishes', 'wishes.created_by', '=', 'users.id')->where('wishes.id', '=', $id)->get();
        // kirim notifikasi bahwa data permohonan telah disetujui ke admin dan user
        Notification::send($user, new WishSuccessNotification($wish->name));
        Notification::send($idpengguna, new WishSuccessToUserNotification($wish->name));
        return redirect()->route('wishes.index')
            ->with('success_message', 'Status Permohonan Kerjasama berhasil disetujui!');
    }

    // set status permohonan kerjasama menjadi needs revision (perlu revisi)
    public function wishcancelled($id)
    {
        $user = Auth::user();
        $wish = Wish::find($id);
        $wish->update([
            'status_id' => '2',
        ]);
        // ambil id created_by dari tabel permohonan kerjasama
        $idpengguna = User::select('users.*')->join('wishes', 'wishes.created_by', '=', 'users.id')->where('wishes.id', '=', $id)->get();
        // kirim notifikasi bahwa data permohonan perlu direvisi ke admin dan user
        Notification::send($user, new WishRejectedNotification($wish->name));
        Notification::send($idpengguna, new WishRejectedToUserNotification($wish->name));
        return redirect()->route('wishes.index')
            ->with('success_message', 'Status Permohonan Kerjasama berhasil dibatalkan!');
    }
}
