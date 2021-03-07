<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use Illuminate\Http\Request;

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

Route::get('/', function (Request $request) {
	$PostsController = new PostsController;
	$page = $request->input('page') ?: 1;
	$posts = $PostsController->get_posts($page);
	$pages = ceil(($PostsController->get_posts_count() / 10));

	Session::put('forum.page', $page);

	return view('home')->withPosts($posts)->withPage($page)->withPages($pages);
})->name('home');

Route::view('register', 'register')->name('register');
Route::post('registerUser', 'App\Http\Controllers\AuthController@register_user');

Route::view('login', 'login')->name('login');
Route::post('loginUser', 'App\Http\Controllers\AuthController@login');

Route::get('thread/{page}', function ($link) {
	$PostsController = new PostsController;
	$post = $PostsController->get_single_post($link);

	return view('thread')->with('post', $post);
});

Route::post('thread/{page}', 'App\Http\Controllers\ReplyController@create');

Route::group(['middleware' => 'user.authenticated'], function () {
	Route::view('post', 'post')->name('post');
});

Route::group(['middleware' => ['user.authenticated', 'throttle:posts']], function () {
	Route::post('createPost', 'App\Http\Controllers\PostsController@create')->name('posts.create');
});

Route::fallback(function () {
	return redirect()->route('home');
});
