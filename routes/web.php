<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;

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
	$PostsController = new PostsController;
	$posts = [
		'sticky' => $PostsController->get_posts(true),
		'normal' => $PostsController->get_posts(false)
	];

	return view('home')->with('posts', $posts);
});

Route::view('register', 'register')->name('register');
Route::view('login', 'login')->name('login');

Route::post('registerUser', 'App\Http\Controllers\AuthController@register_user');
Route::post('loginUser', 'App\Http\Controllers\AuthController@login');

Route::group(['middleware' => 'user.authenticated'], function () {
	Route::view('post', 'post')->name('post');
	Route::post('createPost', 'App\Http\Controllers\PostsController@create')->name('posts.create');
});
