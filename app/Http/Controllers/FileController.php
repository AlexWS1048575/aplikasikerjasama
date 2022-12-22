<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\File;
  
class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('fileUpload');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'files' => 'required',
            'files.*' => 'mimes:csv,txt,xlx,xls,pdf'
            ]);
        if ($request->hasfile('files')) {
            foreach($request->file('files') as $key => $file)
            {
                $path = $file->store('public/uploads');
                $name = $file->getClientOriginalName();
                $insert[$key]['name'] = $name;
            }
        }
        File::insert($insert);
        return redirect('files-upload')->with('status', 'Multiple File has been uploaded Successfully');
    }
}