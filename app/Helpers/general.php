<?php

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\File;

define('PAGINATION_COUNT', 15);
define('IMAGES_PATH', '/storage/uploads/images/' );

function uploadImage($folder, $image) {
    try {
        $name = time().'.'.$image->extension();
        $image->move(public_path() . IMAGES_PATH . $folder . '/', $name);
        return $name;
    } catch (\Exception $ex) {
        return false;
    }
}

// Multiple
function uploadImages($folder, $images) {
    foreach($images as $file)
    {
        $name = $file->getClientOriginalName();
        $file->move(public_path() . IMAGES_PATH . $folder . '/', $name);
    }
    return true;
}

// DELETE //

function deleteImage($folder, $name) {
    try {
        if ($name !== 'image-placeholder.png') {
            $image_path = public_path() . IMAGES_PATH . $folder . '/' . $name;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            return true;
        }
        return true;
    } catch (\Exception $ex) {
        return false;
    }
}