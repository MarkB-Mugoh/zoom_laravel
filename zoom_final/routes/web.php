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




Route::get('/users', 'App\Http\Controllers\ZoomController@index')->name('meetings.index');
Route::post('/meetings', 'App\Http\Controllers\ZoomController@create')->name('meetings.create');




// Route::get('/create-meeting', [ZoomController::class, 'createMeeting'])->name('zoom.createMeeting');
// Route::get('meetings', 'App\Http\Controllers\ZoomController@index')->name('meetings.index');
// Route::get('start-meeting/{meeting}', 'App\Http\Controllers\ZoomController@start_meeting')->name('meeting.start');
// Route::get('join-meeting/{meeting}', 'App\Http\Controllers\ZoomController@join_meeting')->name('meeting.join');
// Route::get('leave-meeting', 'App\Http\Controllers\ZoomController@leave_meeting')->name('meeting.leave');
// Route::get('create-new-meeting', 'App\Http\Controllers\ZoomController@create')->name('meeting.create');
// Route::post('create-new-meeting', 'App\Http\Controllers\ZoomController@store')->name('meeting.store');
// Route::delete('delete-meeting/{meeting}', 'App\Http\Controllers\ZoomController@destroy')->name('meeting.destroy');




