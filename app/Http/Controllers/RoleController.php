<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $user = Auth::user();
        if ($user->role_id == '1') {
            return view('roles.index', [
                'roles' => $roles
            ])->with([
                'user' => $user,
            ]);
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
        if ($user->role_id == '1') {
            return view('roles.create');
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
        $request->validate([
            'name' => 'required',
        ]);
      
        Role::create([
            'name' => $request->name,
        ]);
       
        return redirect()->route('roles.index')
            ->with('success_message', 'Data Role berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $user = Auth::user();
        if ($user->role_id == '1') {
            return view('roles.edit', ['role' => $role]);
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
        $request->validate([
            'name' => 'required',
        ]);
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        return redirect()->route('roles.index')
            ->with('success_message', 'Data Role berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        if ($role) $role->delete();
        return redirect()->route('roles.index')
            ->with('success_message', 'Data Role berhasil dihapus!');
    }
}
