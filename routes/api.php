<?php

use App\Models\Blogs;
use App\Models\Service;
use App\Models\Programs;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Mail\Contact;
use App\Mail\Order;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* POSTS */
Route::get('posts', function() {
    $posts = Blogs::active();
    foreach ($posts as $blog) {
        if (!$blog->thumbnail) {
            $blog->thumbnail = url('/images/blogs/image-placeholder.png') ;
        } else
        $blog->thumbnail = url('/images/blogs/'. $blog->thumbnail) ;
        $blog->description = strip_tags($blog->description);
    }
    return $posts;
});

Route::get('posts/{id}', function($id) {
    $post = (new App\Models\Blogs)->getActiveWithSlug($id);
    if (!$post->thumbnail) {
        $post->thumbnail = url('/images/blogs/image-placeholder.png') ;
    } else
        $post->thumbnail = url('/images/blogs/'. $post->thumbnail) ;
    return $post;
});

/* Services */
Route::get('services', function() {
    $posts = DB::table('services')->select('name AS title', 'image AS thumbnail', 'slug','description', 'content')->where('status', 1)->get();
    foreach ($posts as $service) {
        if (!$service->thumbnail) {
            $service->thumbnail = url('/images/blogs/image-placeholder.png') ;
        } else
            $service->thumbnail = url('/storage/uploads/images/services/'. $service->thumbnail) ;
        $service->description = strip_tags($service->description);
    }
    return $posts;
   // return Service::activePagination();
});

Route::get('services/{slug}', function($slug) {
    $post = Service::select('name AS title', 'image AS thumbnail', 'slug','description', 'content')->where('status', 1)->where('slug' , $slug)->first();
    if (!$post->thumbnail) {
        $post->thumbnail = url('/images/blogs/image-placeholder.png') ;
    } else
        $post->thumbnail = url('/storage/uploads/images/services/'. $post->thumbnail) ;

    return $post;
});

/* Programs */
Route::get('programs', function() {
    $posts = DB::table('programs')->select('title','slug', 'thumbnail', 'description', 'content', 'units as programmEle', 'duration')->where('status', 1)->get();
    foreach ($posts as $program) {
        if (!$program->thumbnail) {
            $program->thumbnail = url('/images/blogs/image-placeholder.png') ;
        } else
            $program->thumbnail = url('/images/programs/'. $program->thumbnail) ;
        $program->description = strip_tags($program->description);
    }
    return $posts;
    //  return Programs::activePagination();
});

Route::get('programs/{slug}', function($slug) {
//    $post = DB::table('programs')->select('title','slug', 'thumbnail', 'description', 'content', 'units as programmEle', 'duration')->where('status', 1)->where('slug', $slug)->get();
    $post = (new App\Models\Programs)->getActiveWithSlug($slug);
    if (!$post->thumbnail) {
        $post->thumbnail = url('/images/blogs/image-placeholder.png') ;
    } else
        $post->thumbnail = url('/images/programs/'. $post->thumbnail) ;
    return $post;

});

/* Sliders */
Route::get('slider', function() {
    $slider = [];
    $images = json_decode(Setting::where('key', '=', 'slider_images')->first()->value);
    foreach($images as $image) {
        $slider[] = url( "images/settings/" . $image );
    }
    return json_encode($slider,JSON_UNESCAPED_SLASHES);
});

Route::get('settings', function () {
    $settings_req = Setting::all();
    $settings['whatsapp'] = $settings_req[1]->value;
    $settings['email'] = $settings_req[2]->value;
    $settings['twitter'] = $settings_req[3]->value;
    return $settings;
});

/* Contact */
Route::middleware('throttle:1,4')->post('contact', function(Request $request) {

    $validator = Validator::make($request->all(), [
		'name' => 'required|max:255',
		'entity' => 'required|max:255',
		'number' => 'required|max:50',
		'email' => 'required|max:255|email',
		'subject' => 'required|max:500',
	]);

	if ($validator->fails()) {
		return response()->json(['error' => $validator->messages()], 200);
	}

	$to = Setting::where('key', '=', 'email')->first()->value;

	Mail::to($to)->send(new Contact($request->all()));

	return response()->json(['response' => "sent"], 200);

});

/* Order  */
Route::middleware('throttle:1,4')->post('order', function(Request $request) {

    $validator = Validator::make($request->all(), [
		'name' => 'required|max:255',
		'entity' => 'required|max:255',
		'number' => 'required|max:50',
		'email' => 'required|max:255|email',
		'service' => 'required|max:255',
		'subject' => 'required|max:500',
	]);

	if ($validator->fails()) {
		return response()->json(['error' => $validator->messages()], 200);
	}

	$to = Setting::where('key', '=', 'email')->first()->value;

	Mail::to($to)->send(new Order($request->all()));

	return response()->json(['response' => "sent"], 200);

});
