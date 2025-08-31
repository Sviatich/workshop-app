<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['success' => false, 'error' => 'Файл не получен.'], 400);
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json(['success' => false, 'error' => 'Файл повреждён.'], 400);
        }

        $validator = Validator::make($request->all(), [
            'file' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,webp,svg,pdf,doc,docx,ppt,pptx,txt,ai,eps,cdr',
                'mimetypes:image/jpeg,image/png,image/webp,image/svg+xml,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,text/plain,application/postscript,application/illustrator,application/vnd.corel-draw,image/x-coreldraw,image/x-cdr,application/x-cdr,application/cdr',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->first('file') ?? 'Недопустимый тип файла.',
            ], 422);
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

