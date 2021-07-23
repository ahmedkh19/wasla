<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('content.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
       // return $request;
        try {
            DB::beginTransaction();
          //  $images = Setting::where('key', '=', 'slider_images')->first();
            $email = Setting::where('key', '=', 'email')->first();
            $whatsapp = Setting::where('key', '=', 'whatsapp')->first();
            $twitter = Setting::where('key', '=', 'twitter')->first();

           // $images->update(['key' => 'slider_images', 'value' => $request->images]);
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
