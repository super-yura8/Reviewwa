<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Model\File;

class FileController extends Controller
{
    public function uploadImg(Request $request)
    {
        $file = $request->file('upload');
        $resize = Image::make($file)->resize(668, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg');
        $fileName = $file->hashName();
        Storage::disk('public')->put('reviewImg/' . $fileName, $resize->__toString());
        File::create(['file_path' => 'storage/reviewImg/' . $fileName,
            'origin_file_name' => $file->getClientOriginalName(),
            'hash_file_name' => $fileName,
            'user_id' => 1]); //потом поставить auth()->id()
        return response()->json(['uploaded' => 1, 'fileName' => $fileName, 'url' => 'storage/reviewImg/' . $fileName]);
    }
}
