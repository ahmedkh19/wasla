<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\ProgramsController;
use App\Http\Controllers\SettingController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth::routes();
Auth::routes();
Route::group(['namespace' => '', 'prefix' => 'admin' , 'middleware' => ['auth']], function () {
    Route::get('/', [StaterkitController::class, 'home'])->name('home');
    Route::get('home', [StaterkitController::class, 'home'])->name('home');

    /* Route Services */
    Route::resource('services', ServicesController::class, ['only'=> ['index', 'update', 'create','store', 'edit']]);
    Route::get('services/delete/{id}', [ServicesController::class , 'destroy'])->name('services.destroy');
    Route::get('services/ajax', [ServicesController::class, 'ajax'])->name('services-ajax');

    /* Route Blogs */
    Route::resource('blogs', BlogsController::class, ['only'=> ['index', 'update', 'create','store', 'edit']]);
    Route::get('blogs/delete/{id}', [BlogsController::class , 'destroy'])->name('blogs.destroy');
    Route::get('blogs/ajax', [BlogsController::class, 'ajax'])->name('blogs-ajax');

    /* Route Programs */
    Route::resource('programs', ProgramsController::class, ['only'=> ['index', 'update', 'create','store', 'edit']]);
    Route::get('programs/delete/{id}', [ProgramsController::class , 'destroy'])->name('programs.destroy');
    Route::get('programs/ajax', [ProgramsController::class, 'ajax'])->name('programs-ajax');

    /* Route Programs */
    // Show //
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    // Update //
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    // Delete slider images //
    Route::delete('settings', [SettingController::class, 'destroy'])->name('settings.destroy');

});
