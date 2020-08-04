<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImgRequest;
use App\Models\Avatars;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Model\File;

class FileController extends Controller
{
    const IMG_PATH = 'reviewsImg/';
    const AVATAR_PATH = 'avatarImg/';
    public function uploadImg(ImgRequest $request)
    {
        $file = $request->file('upload');
        $resize = Image::make($file)->resize(668, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg');
        $fileName = $file->hashName();

        $file = File::create(['file_path' => 'storage/' . self::IMG_PATH . $fileName,
            'origin_file_name' => $file->getClientOriginalName(),
            'hash_file_name' => $fileName,
            'user_id' => auth()->id()]);
        if ($file instanceof File) {
            Storage::disk('public')->put(self::IMG_PATH . $fileName, $resize->__toString());
            return response()->json(['uploaded' => 1, 'fileName' => $fileName, 'url' => 'storage/' . self::IMG_PATH . $fileName]);
        }
    }

    public function uploadUserAvatarImg(ImgRequest $request)
    {
        $file = $request->file('upload');

        $resizeBig = Image::make($file)->resize(610, 610, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg');

        $resizeSmall = Image::make($file)->resize(64, 64, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg');

        $imgBig = Image::canvas(255, 255)->insert($resizeBig, 'center')->stream();
        $imgSmall = Image::canvas(32, 32)->insert($resizeSmall, 'center')->stream();

        $imgBigName = 'b' . $file->hashName();
        $imgSmallName = 's' . $file->hashName();

        $avatars = Avatars::create([
            'avatar_big' => 'storage/' . self::AVATAR_PATH . $imgBigName,
            'avatar_small' => 'storage/' . self::AVATAR_PATH . $imgSmallName]);
        if ($avatars instanceof Avatars) {
            Storage::disk('public')->put(self::AVATAR_PATH . $imgBigName, $imgBig->__toString());
            Storage::disk('public')->put(self::AVATAR_PATH . $imgSmallName, $imgSmall->__toString());
            if (auth()->user()->avatars->first() instanceof Avatars) {
                auth()->user()->avatars()->updateExistingPivot(
                    auth()->user()->avatars->first()->id,
                    ['avatars_id' => $avatars->id]
                );
            } else {
                auth()->user()->avatars()->attach($avatars->id);
            }
        } else {
            abort(404);
        }
    }
}
