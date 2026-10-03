<?php

namespace Developermithu\Tallcraftui\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UploadController
{
    public function __invoke(Request $request): JsonResponse
    {
        $config = config('tallcraftui.upload');

        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:'.implode(',', $config['mimes']), 'max:'.$config['max_size']],
            'disk' => ['required', 'string', Rule::in($config['disks'])],
            // Plain folder names only, e.g. "markdown" or "posts/images" (no "..", no leading slash)
            'folder' => ['nullable', 'string', 'max:100', 'regex:/^[A-Za-z0-9_-]+(\/[A-Za-z0-9_-]+)*$/'],
        ]);

        $path = $request->file('file')->store($validated['folder'] ?? '', $validated['disk']);

        abort_if($path === false, 500, 'Unable to store the uploaded file.');

        return response()->json([
            'location' => Storage::disk($validated['disk'])->url($path),
        ]);
    }
}
