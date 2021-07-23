<?php

use App\Models\Blogs;
use App\Models\Service;
use App\Models\Programs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
   // return Blogs::activePagination();
    return Blogs::active();
});

Route::get('posts/{id}', function($id) {
    if (Blogs::find($id))
    return Blogs::getActive($id);
    else
        return false;
});

/* Services */
Route::get('services', function() {
    return Service::active();
   // return Service::activePagination();
});

Route::get('services/{id}', function($id) {
    if (Service::find($id))
        return Service::getActive($id);
    else
        return false;
});

/* Programs */
Route::get('programs', function() {
    return Programs::active();
    //  return Programs::activePagination();
});

Route::get('programs/{id}', function($id) {
    if (Programs::find($id))
        return Programs::getActive($id);
    else
        return false;
});