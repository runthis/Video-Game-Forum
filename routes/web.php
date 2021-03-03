<?php

use Illuminate\Support\Facades\Route;

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
	return view('home');
});

Route::view('register', 'register');
Route::view('login', 'login')->name('login');
Route::view('post', 'post');

Route::post('registerUser', 'App\Http\Controllers\AuthController@register_user');
Route::post('loginUser', 'App\Http\Controllers\AuthController@login');

Route::group(['middleware' => 'user.authenticated'], function () {
	Route::post('createPost', 'App\Http\Controllers\PostsController@create')->name('posts.create');
});
