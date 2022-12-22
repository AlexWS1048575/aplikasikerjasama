<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrganizationNotification;
use App\Notifications\OrganizationUpdateNotification;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizations = Organization::all();
        // jika user yang login role adalah admin
        $user = Auth::user();
        if ($user -> role_id == '1') {
            return view('organizations.index', [
                'organizations' => $organizations
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
        $user = Auth::user();
        // jika user yang login role adalah admin
        if ($user->role_id == '1') {
            return view('organizations.create')->with(['user' => $user]);
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
            'address' => 'required',
            'headofstate' => 'required',
        ]);
      
        Organization::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'headofstate' => $request->headofstate,
            'pic' => $request->pic,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);
        // kirim notifikasi bahwa data berhasil diinput
        Notification::send($user, new OrganizationNotification($request->name));
        return redirect()->route('organizations.index')
            ->with('success_message', 'Data Organisasi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $organization = Organization::find($id);
        // jika user yang login role adalah admin
        if ($user->role_id == '1') {
            return view('organizations.show', ['organization' => $organization])->with(['user' => $user]);
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
        $user = Auth::user();
        $organization = Organization::find($id);
        // jika user yang login role adalah admin
        if ($user->role_id == '1') {
            return view('organizations.edit', ['organization' => $organization])->with(['user' => $user]);
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
            'address' => 'required',
            'headofstate' => 'required',
        ]);
        $organization = Organization::find($id);
        $organization->name = $request->name;
        $organization->email = $request->email;
        $organization->address = $request->address;
        $organization->phone = $request->phone;
        $organization->headofstate = $request->headofstate;
        $organization->pic = $request->pic;
        $organization->updated_by = $user->id;
        $organization->save();
        // kirim notifikasi bahwa data berhasil diupdate
        Notification::send($user, new OrganizationUpdateNotification($request->name));
        return redirect()->route('organizations.index')
            ->with('success_message', 'Data Organisasi berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organization = Organization::find($id);
        if ($organization) $organization->delete();
        return redirect()->route('organizations.index')
            ->with('success_message', 'Data Organisasi berhasil dihapus!');
    }
}
