<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'Файл не передан.'], 400);
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json(['error' => 'Файл повреждён.'], 400);
        }

        $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('order_files/tmp', $filename, 'public');

        return response()->json([
            'success' => true,
            'file_path' => "/storage/{$path}",
            'filename' => $file->getClientOriginalName(),
        ]);
    }
}
