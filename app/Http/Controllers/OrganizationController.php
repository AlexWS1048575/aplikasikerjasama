<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrganizationNotification;
use App\Notifications\OrganizationUpdateNotification;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:organization-read|organization-create|organization-update|organization-delete', ['only' => ['index','store', 'show']]);
        $this->middleware('permission:organization-create', ['only' => ['create','store']]);
        $this->middleware('permission:organization-update', ['only' => ['edit','update']]);
        $this->middleware('permission:organization-delete', ['only' => ['destroy']]);
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
        $organizations = Organization::all();
        return view('organizations.index', ['organizations' => $organizations])->with(['user' => $user,]);
        } else {
            $organizations = Organization::where('created_by', $user->id)->get();
            return view('organizations.index', ['organizations' => $organizations])->with(['user' => $user]);
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
        return view('organizations.create')->with(['user' => $user]);
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
    public function show($id): View
    {
        $user = Auth::user();
        $organization = Organization::find($id);
        return view('organizations.show', ['organization' => $organization])->with(['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $user = Auth::user();
        $organization = Organization::find($id);
        return view('organizations.edit', ['organization' => $organization])->with(['user' => $user]);
        
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
    public function destroy($id): RedirectResponse
    {
        $organization = Organization::find($id);
        if ($organization) $organization->delete();
        return redirect()->route('organizations.index')
            ->with('success_message', 'Data Organisasi berhasil dihapus!');
    }
}
