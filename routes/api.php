<?php

use App\Models\Blogs;
use App\Models\Service;
use App\Models\Programs;
use App\Models\Setting;
use Illuminate\Http\Request;
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
    $blogs = Blogs::active();
    foreach ($blogs as $blog) {
        $blog->thumbnail = url('/images/blogs/') . $blog->thumbnail;
        $blog->description = strip_tags($blog->description);
    }
    return $blogs;
});

Route::get('posts/{id}', function($id) {
   return (new App\Models\Blogs)->getActiveWithSlug($id);
});

/* Services */
Route::get('services', function() {
    return Service::active();
   // return Service::activePagination();
});

Route::get('services/{id}', function($id) {
    return (new App\Models\Service)->getActiveWithSlug($id);
});

/* Programs */
Route::get('programs', function() {
    return Programs::active();
    //  return Programs::activePagination();
});

Route::get('programs/{id}', function($id) {
    return (new App\Models\Programs)->getActiveWithSlug($id);

});

/* Sliders */
Route::get('slider', function() {
    return Setting::where('key', '=', 'slider_images')->first()->value;
});

/* Contact */
Route::middleware('throttle:1,3')->post('contact', function(Request $request) {

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
Route::middleware('throttle:1,3')->post('order', function(Request $request) {

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