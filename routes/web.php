<?php
use Illuminate\Support\Facades\Mail;
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

Route::get('/', function () {
    return view('hello');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>'auth'], function () {
    Route::resource('/user', 'UsersController');
    Route::get('/user/all-post/{name}', 'UsersController@showPost');
    Route::resource('/stories', 'PostsController');
    Route::resource('/meeting', 'UsersMeetingController');
    Route::post('/meeting/set', 'UsersMeetingController@setMeeting');
});