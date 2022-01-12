<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('content.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'slider_images.*' => 'mimes:jpg,jpeg,png',
        ]);

        try {
            DB::beginTransaction();
          	$images = Setting::where('key', '=', 'slider_images')->first();
            $email = Setting::where('key', '=', 'email')->first();
            $whatsapp = Setting::where('key', '=', 'whatsapp')->first();
            $twitter = Setting::where('key', '=', 'twitter')->first();

		    $the_images = array();

			// edit images
			if (isset($request->keep_images)):
				foreach($request->keep_images as $old_image):
					if (in_array($old_image,json_decode($images->value))):
						$the_images[] = $old_image;
					endif;
				endforeach;
			endif;

			// save images
			if (isset($request->slider_images)):
				foreach($request->slider_images as $image):
					$image_name = uniqid() . '-' . $image->getClientOriginalName();
					$image->move(public_path('images/settings/'), $image_name);
				    $the_images[] = $image_name;
				endforeach;
			endif;
			
			// delete images
			if (isset($images->value) && !empty(json_decode($images->value))):
				foreach(json_decode($images->value) as $db_image):
					if (!in_array($db_image,$the_images)):
						File::delete(public_path('images/settings/') . $db_image);
					endif;
				endforeach;
			endif;

           	$images->update(['key' => 'slider_images', 'value' => json_encode($the_images, JSON_UNESCAPED_UNICODE)]);
            $email->update(['key' => 'email', 'value' => $request->email]);
            $whatsapp->update(['key' => 'whatsapp', 'value' => $request->whatsapp]);
            $twitter->update(['key' => 'twitter', 'value' => $request->twitter]);
            DB::commit();
            return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'لقد حدث خطأ، رجاء أعد المحاولة لاحقا : '. $ex]);

        }
    }
}
