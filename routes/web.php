<?php

use Developermithu\Tallcraftui\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

if (config('tallcraftui.upload.enabled')) {
    Route::prefix(config('tallcraftui.route_prefix'))
        ->middleware(config('tallcraftui.upload.middleware'))
        ->group(function () {
            Route::post('/upload', UploadController::class)->name('tallcraftui.upload');
        });
}
