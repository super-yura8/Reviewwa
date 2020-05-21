<?php

namespace App\Http\Controllers;

use App\Model\File;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('layouts.mainPage');
    }

    public function showReviewEditor()
    {
        return view('layouts.addReview');
    }

    public function uploadImg(Request $request)
    {
        $file = $request->file('upload');
        $path = 'storage/'.$file->store('reviewsImg','public');
        $fileName = $file->hashName();
        File::create(['file_path' => $path, 'origin_file_name' => $file->getClientOriginalName(), 'hash_file_name' => $fileName, 'user_id' => auth()->id()]);
        return response()->json(['uploaded' => 1, 'fileName' => $fileName, 'url' => $path]);
    }
}
