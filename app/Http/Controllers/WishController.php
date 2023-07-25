<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wish;
use App\Models\Requester;
use App\Models\Status;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
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
use App\Notifications\WishInProgressNotification;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class WishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:wish-read|wish-create|wish-update|wish-delete', ['only' => ['index','store', 'show']]);
        $this->middleware('permission:wish-create', ['only' => ['create','store']]);
        $this->middleware('permission:wish-update', ['only' => ['edit','update']]);
        $this->middleware('permission:wish-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $user = Auth::user();
        $roles = Role::all();
        if($user->hasRole('Admin')) {
            $wishes = Wish::all();
            return view('wishes.index', ['wishes' => $wishes])->with(['user' => $user]);
        } else {
            $wishes = Wish::where('created_by', $user->id)->get();
            return view('wishes.index', ['wishes' => $wishes])->with(['user' => $user]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
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
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $validateData = $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'organization' => 'required',
            'requester_id' => 'required',
            'filename' => 'file|mimes:pdf|max:4096',
        ]);
        // jika ada file
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

            // berkas disimpan ke dalam folder storage
            $filenameWithExt = $request->file('filename')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('filename')->getClientOriginalExtension();
            $newFilename = $filename . '_' . date('YmdHis') . '.' . $extension;
            $path = $request->file('filename')->storeAs('filename', $newFilename);
            $wish->filename = $newFilename;
            
            // berkas disimpan ke dalam folder public
            /* $filenameWithExt = $request->file('filename')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('filename')->getClientOriginalExtension();
            $newFilename = $filename . '_' . date('YmdHis') . '.' . $extension;
            $path = $request->file('filename')->move('filename', $newFilename);
            $wish->filename = $newFilename; */

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
        // kirim notifikasi bahwa data berhasil diinput
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
    public function show($id): View
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
    public function edit($id): View
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
    public function update(Request $request, $id): RedirectResponse
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

            // berkas disimpan ke dalam folder storage
            /* $filenameWithExt = $request->file('filename')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('filename')->getClientOriginalExtension();
            $newFilename = $filename . '_' . 'updated' . '_' . date('YmdHis') . '.' . $extension;
            Storage::delete('filename/' . $wish->filename);
            $path = $request->file('filename')->storeAs('filename', $newFilename);
            $wish->filename = $newFilename; */

            // berkas disimpan ke dalam folder public
            $filenameWithExt = $request->file('filename')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('filename')->getClientOriginalExtension();
            $newFilename = $filename . '_' . 'updated' . '_' . date('YmdHis') . '.' . $extension;
            File::delete('filename/' . $wish->filename);
            $path = $request->file('filename')->move('filename', $newFilename);
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
            ->with('success_message', 'Data Permohonan Kerjasama berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $wish = Wish::find($id);
        // hapus berkas di folder public atau storage, guna mengurangi sampah pada server
        // Storage::delete('filename/' . $wish->filename);
        File::delete('filename/' . $wish->filename);
        if ($wish) $wish->delete();
        return redirect()->route('wishes.index')
            ->with('success_message', 'Daftar Permohonan Kerjasama berhasil dihapus!');
    }

    // set status permohonan kerjasama menjadi in progress
    public function nextstep2($id)
    {
        $user = Auth::user();
        $wish = Wish::find($id);
        $wish->update([
            'status_id' => '2',
        ]);
        // ambil id created_by dari tabel permohonan kerjasama
        $idpengguna = User::select('users.*')->join('wishes', 'wishes.created_by', '=', 'users.id')->where('wishes.id', '=', $id)->get();
        // kirim notifikasi bahwa data permohonan telah diupdate ke admin dan user
        Notification::send($user, new WishInProgressNotification($wish->name));
        // Notification::send($idpengguna, new WishInProgressNotification($wish->name));
        return redirect()->route('wishes.index')
            ->with('success_message', 'Status Permohonan Kerjasama berhasil diupdate!');
    }

    // set status permohonan kerjasama menjadi disetujui
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
        // Notification::send($idpengguna, new WishSuccessToUserNotification($wish->name));
        return redirect()->route('wishes.index')
            ->with('success_message', 'Status Permohonan Kerjasama berhasil disetujui!');
    }

    // set status permohonan kerjasama menjadi pending
    public function wishcancelled($id)
    {
        $user = Auth::user();
        $wish = Wish::find($id);
        $wish->update([
            'status_id' => '1',
        ]);
        // ambil id created_by dari tabel permohonan kerjasama
        $idpengguna = User::select('users.*')->join('wishes', 'wishes.created_by', '=', 'users.id')->where('wishes.id', '=', $id)->get();
        // kirim notifikasi bahwa data permohonan dibatalkan atau ditolak ke admin dan user
        Notification::send($user, new WishRejectedNotification($wish->name));
        // Notification::send($idpengguna, new WishRejectedToUserNotification($wish->name));
        return redirect()->route('wishes.index')
            ->with('success_message', 'Status Permohonan Kerjasama berhasil dibatalkan!');
    }
}
