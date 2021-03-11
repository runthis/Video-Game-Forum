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

// Registration
Route::view('register', 'register')->name('register');
Route::post('registerUser', 'App\Http\Controllers\AuthController@register_user');

// Authentication
Route::view('login', 'login')->name('login');
Route::post('loginUser', 'App\Http\Controllers\AuthController@login');

// Viewing a forum post, if it exists
Route::get('thread/{page}', function ($link) {
	$PostsController = new PostsController;
	$post = $PostsController->get_single_post($link);

	// If no posts exists, go home
	if (!$post) {
		return redirect()->route('home');
	}

	return view('thread')->with('post', $post);
});

// Authenticated only requests
Route::group(['middleware' => 'user.authenticated'], function () {
	// Create a new post
	Route::view('post', 'post')->name('post');

	// Edit a post
	Route::post('editPost', 'App\Http\Controllers\PostsController@edit')->name('posts.edit');

	// Edit a reply
	Route::post('editReply', 'App\Http\Controllers\ReplyController@edit')->name('replies.edit');
});

// Throttle post creates and deletes
Route::group(['middleware' => ['user.authenticated', 'throttle:posts']], function () {
	Route::post('createPost', 'App\Http\Controllers\PostsController@create')->name('posts.create');
	Route::post('deletePost', 'App\Http\Controllers\PostsController@delete')->name('posts.delete');
});

// Throttle reply creates
Route::group(['middleware' => ['user.authenticated', 'throttle:replies']], function () {
	Route::post('thread/{page}', 'App\Http\Controllers\ReplyController@create')->name('replies.create');
	Route::post('deleteReply', 'App\Http\Controllers\ReplyController@delete')->name('replies.delete');
});

// Staff actions
Route::group(['middleware' => ['user.authenticated', 'user.staff']], function () {
	Route::post('stickyPost', 'App\Http\Controllers\PostsController@sticky')->name('posts.sticky');
	Route::post('lockPost', 'App\Http\Controllers\PostsController@lock')->name('posts.lock');
});

// When all else fails, go home
Route::fallback(function () {
	return redirect()->route('home');
});
