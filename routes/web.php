<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::prefix(config('tallcraftui.route_prefix'))->group(function () {
    // Authenticated Web Routes
    Route::middleware(['web', 'auth'])->group(function () {
        Route::post('/upload', function (Request $request) {
            $file = $request->file('file');
            $path = $file->store($request->folder, $request->disk);

            return response()->json([
                'location' => Storage::disk($request->disk)->url($path),
            ]);
        })->name('tallcraftui.upload');
    });
});
