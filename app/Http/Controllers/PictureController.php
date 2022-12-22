<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Picture;
use Illuminate\Support\Facades\Storage;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pictures = Picture::all();
        return view('pictures.index', [
            'pictures' => $pictures
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pictures.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $picture = new Picture();
        $picture->name = $validateData['name'];
        $picture->detail = $validateData['detail'];
        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $newFilename = $filename.'_'.date('YmdHis').'.'.$extension;
            $path = $request->file('image')->storeAs('gambar', $newFilename);
        } else {
            $newFilename = 'black-screen.jpg';
        }
        $picture->image = $newFilename;
        $picture->save();
        
        return redirect()->route('pictures.index')
            ->with('success_message', 'Data Gambar berhasil ditambahkan!');
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
        $picture = Picture::find($id);
        return view('pictures.edit', ['picture' => $picture]);
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
            'detail' => 'required',
        ]);
        
        $picture = Picture::find($id);
        if($request->hasFile('image')){
            $request->validate([
              'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $newFilename = $filename.'_'.'updated'.'_'.date('YmdHis').'.'.$extension;
            Storage::delete('gambar/'. $picture->image);
            $path = $request->file('image')->storeAs('gambar', $newFilename);
            $picture->image = $newFilename;
        }
        $picture->name = $request->name;
        $picture->detail = $request->detail;
        $picture->save();

        $validateData = $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'image' => 'image|max:2048',
        ]);
    
        return redirect()->route('pictures.index')
                        ->with('success_message','Data Gambar berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $picture = Picture::find($id);
        Storage::delete('gambar/'. $picture->image);
        if ($picture) $picture->delete();
        return redirect()->route('pictures.index')
            ->with('success_message', 'Daftar Gambar berhasil dihapus!');
    }
}
