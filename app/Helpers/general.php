<?php

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\File;
define('WEBSITE_NAME', 'وصلة');
define('LOGO_FILE_NAME', 'logo.png');
define('FAVICON_FILE_NAME', 'logo.png');
define('MADE_BY', 'مؤسسة التفكير الإبداعي لتقنية المعلومات');
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
        } else if ($name === 'image-placeholder.png') {
            return true;
        } else {
            return false;
        }
        return true;
    } catch (\Exception $ex) {
        return false;
    }
}