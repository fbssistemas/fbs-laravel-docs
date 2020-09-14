<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ImagesController extends Controller
{
    public function index()
    {
        $files = Storage::files('public/images');
        $directories = Storage::directories('public/images');

        return response()->json([
            'directories' => $directories,
            'files' => $files
        ]);
    }

    public function uploadImages(Request $request)
    {
        $file = $request->file('file');
        $name = $file->getClientOriginalName();
        $extension = $file->extension();

        $url = Storage::url(Storage::put('public/images', $file));

        return response()->json(['url' => URL::to('/') . $url]);
    }

    public function uploadDocs()
    {
    }
}
