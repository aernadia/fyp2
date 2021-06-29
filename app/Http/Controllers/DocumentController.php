<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Documents;

class DocumentController extends Controller
{
    
    public function indexUpload()
    {
        $file=Documents::all();
        return view('admin.document.view',compact('file'));
    }

    
    public function createUpload()
    {
        return view('admin.document.create');
    }

   
    public function storeUpload(Request $request)
    {
        $data->save();
        return redirect()->back();
        
    }

  
    public function showUpload($id)
    {
        $data=Documents::find($id);
        return view('admin.document.details',compact('data'));
    }

    
    public function download($file)
    {
       return response()->download('storage/'.$file);
    }
    public function edit($id)
    {
        //
    }

 
}
