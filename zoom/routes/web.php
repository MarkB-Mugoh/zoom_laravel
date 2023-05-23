<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZoomController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/view', function () {
    return view('meetings');
});





Route::group(['prefix' => 'zoom'], function () {
    // Route::get('/view', [App\Http\Controllers\ZoomController::class, 'view_blade']);

    Route::post('/schedule-meeting', [App\Http\Controllers\ZoomController::class, 'scheduleMeeting']);

    Route::post('/create', [App\Http\Controllers\ZoomController::class, 'create'])->name('zoom.create');
    Route::patch('/update/{id}', [App\Http\Controllers\ZoomController::class, 'update'])->name('zoom.update');
    Route::get('/get/{id}', [App\Http\Controllers\ZoomController::class, 'get'])->name('zoom.get');
    Route::delete('/delete/{id}', [App\Http\Controllers\ZoomController::class, 'delete'])->name('zoom.delete');
});



