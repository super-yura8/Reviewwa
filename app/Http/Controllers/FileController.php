<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImgRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Model\File;

class FileController extends Controller
{
    public function uploadImg(ImgRequest $request)
    {
        $file = $request->file('upload');
        $resize = Image::make($file)->resize(668, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg');
        $fileName = $file->hashName();
        Storage::disk('public')->put('reviewsImg/' . $fileName, $resize->__toString());
        File::create(['file_path' => 'storage/reviewsImg/' . $fileName,
            'origin_file_name' => $file->getClientOriginalName(),
            'hash_file_name' => $fileName,
            'user_id' => auth()->id()]);
        return response()->json(['uploaded' => 1, 'fileName' => $fileName, 'url' => 'storage/reviewsImg/' . $fileName]);
    }
}
