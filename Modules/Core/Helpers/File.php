<?php

namespace Modules\Core\Helpers;

//use Shetabit\Shopit\Modules\Core\Helpers\File as BaseFile;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class File
{

    /**
     * Upload an image with specific width and height.
     *
     * @param UploadedFile $image
     * @param string $dir
     * @param int $width
     * @param int $height
     * @param string $disk
     * @return string|boolean
     */
    public static function imageUpload($image, $dir, $width = null, $height = null, $disk = 'public')
    {
        try {
            $basePath = $dir.'/';
            $img = null;
            $path = null;
            if ($width && $height) {
                $path = $image->hashName($dir);
                $img = Image::make($image);
                $img->fit($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                    //$constraint->upsize();
                });
            }
            $image = ($img == null) ? $image : (string) $img->encode();
            $realPath = ($path == null) ? $basePath : $path;
            $src = ($path == null) ? $basePath.'/'.$image->hashName() : $path;
            Storage::disk($disk)->put($realPath, $image);

            return $src;
        } catch (Exception $e) {
            Log::error('Failed image upload: ' . var_export($e->getTrace()));
        }

        return false;
    }

    /**
     * Upload a file.
     *
     * @param UploadedFile $file
     * @param string $dir
     * @param null $disk
     * @return bool
     */
    public static function fileUpload($file, $dir, $disk = null)
    {
        try {
            if ($disk) {
                $path = $file->store($dir, $disk);
            } else {
                $path = $file->store($dir);
            }
            return $path;
        } catch (Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
        }

        return false;
    }

    /**
     * Delete permanently a file from disk.
     *
     * @param string $path
     * @param string $disk
     * @return array
     */
    public static function delete($path, $disk = 'public')
    {
        $output = [
            'success' => false,
            'message' => 'File not exists'
        ];

        if (Storage::disk($disk)->exists($path)) {
            try {

                Storage::disk($disk)->delete($path);

                $output = [
                    'success' => true
                ];

            } catch (Exception $e) {

                $output = [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
            }
        }

        return $output;
    }

    /**
     * Insert an image as image watermark.
     *
     * @param string $image
     * @param string $watermark
     * @param string $position
     */
    public static function insertWatermark($image, $watermark, $position = 'bottom-right')
    {
        $img = Image::make($image);
        $width = $img->width();
        $height = $img->height();
        $watermarkWidth = ($width / 100) * 20;
        $watermarkHeight = ($height / 100) * 20;
        $watermarkImg = Image::make($watermark);
        $resizedWatermark = $watermarkImg->resize($watermarkWidth, $watermarkHeight);
        $img->insert($resizedWatermark, $position, 10, 10);
        $img->save($image);
    }

    /**
     * Base64 file upload.
     *
     * @param string $base64Image
     * @param string $dir
     * @param string $disk
     * @return string
     */
    public static function base64Upload($base64Image, $dir, $disk = 'public')
    {
        @list($type, $file_data) = explode(';', $base64Image);
        @list(, $file_data) = explode(',', $file_data);
        $extension = explode('/', $type)[1];
        $imageName = time() . '.' . $extension;
        $path = "$dir/{$imageName}";
        Storage::disk($disk)->put($path, base64_decode($file_data));

        return $path;
    }
}
