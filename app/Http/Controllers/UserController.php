<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = User::all();
        // return view('users.index', [
        //     'users' => $users
        // ]);

        $users = User::all();
        $pengguna = Auth::user();
        if ($pengguna->role_id == '1') {
            return view('users.index', [
                'users' => $users
            ])->with([
                'pengguna' => $pengguna,
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
        $pengguna = Auth::user();
        if ($pengguna->role_id == '1') {
            return view('users.create');
        } else {
            return view('404');
        }
        
        // return view('users.create');
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ]);
        $array = $request->only([
            'name', 'email', 'password'
        ]);
        $array['password'] = bcrypt($array['password']);
        $user = User::create($array);
        return redirect()->route('users.index')
            ->with('success_message', 'Data User berhasil ditambahkan!');
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
        // $user = User::find($id);
        // if (!$user) return redirect()->route('users.index')
        //     ->with('error_message', 'User dengan id'.$id.' tidak ditemukan!');
        //     return view('users.edit', [
        //         'user' => $user
        // ]);
        $user = User::find($id);
        $roles = Role::all();
        $pengguna = Auth::user();
        if (($pengguna->role_id == '1') && ($user->id > '2')) {
            if (!$user) return redirect()->route('users.index')
                ->with('error_message', 'User dengan id '.$id.' tidak ditemukan!');
                return view('users.edit', ['user' => $user], compact('roles'));
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
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'sometimes|nullable|confirmed',
            'role_id' => 'required'
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        if ($request->password) $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('users.index')
            ->with('success_message', 'Data User berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        if ($id == $request->user()->id) return redirect()->route('users.index')
            ->with('error_message', 'Anda tidak dapat menghapus diri sendiri!');
        if ($user) $user->delete();
        return redirect()->route('users.index')
            ->with('success_message', 'Data User berhasil dihapus!');
    }
}
