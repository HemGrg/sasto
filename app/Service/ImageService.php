<?php

namespace App\Service;

use Illuminate\Support\Facades\Storage;
use Image;

class ImageService
{
    public function swapImage($oldImage, $newImage)
    {
        if ($newImage) {
            info('deleting old image');
            $this->unlinkImage($oldImage);
            return $this->storeImage($newImage);
        }

        return $oldImage;
    }

    public function storeImage($image)
    {
        //get filename with extension
        $filenamewithextension = $image->getClientOriginalName();

        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

        //get file extension
        $extension = $image->getClientOriginalExtension();

        //filename to store
        $filenametostore = uniqid() . '.' . $extension;

        // Save to storage
        $imagePath = Storage::putFileAs($this->getStorageBasePath(), $image, $filenametostore);

        logger('Saved New Image');
        info($imagePath);

        return $imagePath;
    }

    public function unlinkImage($image)
    {
        if (Storage::exists($image)) {
            logger('Deleting older image ' . $image);
            Storage::delete($image);
        }
        return true;
    }

    public function getStorageBasePath()
    {
        return config('constants.image_directory') . DIRECTORY_SEPARATOR . date('Y') . DIRECTORY_SEPARATOR . date('M');
    }

    // public function generateThumbsName($fileName, $sizeKey = 'thumb')
    // {
    //     $fileArray = pathinfo($fileName);
    //     return $fileArray['dirname'] . '/' . $fileArray['filename'] . '-' . $sizeKey . '.' . $fileArray['extension'];
    // }

    /**
     * Create a thumbnail of specified size
     *
     * @param string $path path of thumbnail
     * @param int $width
     * @param int $height
     */
    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        $img->save($path);
    }
}
