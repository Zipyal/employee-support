<?php

namespace App\Http\Controllers;

use App\Models\UploadImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait UploadImageTrait
{
    protected string $imagesDir = 'img/upload';

    /**
     * @param Request $request
     * @param string $modelClass
     * @param string|int $modelId
     * @return void
     */
    protected function uploadImages(Request $request, string $modelClass, $modelId): void
    {
        foreach ($request->file('images') ?? [] as $file) {
            $filename = $file->getClientOriginalName();
            $filename = preg_replace('/\s+/', '_', trim($filename));

            $dir = $this->imagesDir;
            $dirAbsolute = public_path($dir);
            $filepath = rtrim($dir, '/') . '/' . $filename;

            try {
                $file->move($dirAbsolute, $filename);
            } catch (\Throwable $e) {
                abort($e->getCode(), $e->getMessage());
            }

            UploadImage::query()->create([
                'image_filepath' => $filepath,
                'imageable_type' => $modelClass,
                'imageable_id' => $modelId,
            ]);
        }
    }
}
