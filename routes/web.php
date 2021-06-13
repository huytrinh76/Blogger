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

Route::get('/','App\Http\Controllers\HomeController@index')->name('home');
Route::get('posts','App\Http\Controllers\PostController@index')->name('post.index');
Route::get('post/{slug}','App\Http\Controllers\PostController@details')->name('post.details');
Route::get('category/{slug}','App\Http\Controllers\PostController@postByCategory')->name('category.posts');
Route::get('tag/{slug}','App\Http\Controllers\PostController@postByTag')->name('tags.post');

Route::get('profile/{username}','App\Http\Controllers\AuthorController@profile')->name('author.profile');

Route::post('subscriber','App\Http\Controllers\SubscriberController@store')->name('subscriber.store');

Auth::routes();

Route::get('search','App\Http\Controllers\SearchController@search')->name('search');

Route::group(['middleware'=>['auth']], function(){
    Route::post('favorite/{post}/add','App\Http\Controllers\FavoriteController@add')->name('post.favorite');
    Route::post('comment/{post}','App\Http\Controllers\CommentController@store')->name('comment.store');
});


Route::group(['as'=>'admin.','prefix'=>'admin','middleware'=>['auth','admin']], function(){
    Route::get('dashboard','App\Http\Controllers\Admin\DashboardController@index')->name('dashboard');
    Route::get('settings','App\Http\Controllers\Admin\SettingsController@index')->name('settings');
    Route::put('profile-update','App\Http\Controllers\Admin\SettingsController@updateProfile')->name('profile.update');
    Route::put('password-update','App\Http\Controllers\Admin\SettingsController@updatePassword')->name('password.update');
    Route::resource('tag','App\Http\Controllers\Admin\TagController');
    Route::resource('category','App\Http\Controllers\Admin\CategoryController');
    Route::resource('post','App\Http\Controllers\Admin\PostController');

    Route::get('pending/post','App\Http\Controllers\Admin\PostController@pending')->name('post.pending');
    Route::put('post/{id}/approve','App\Http\Controllers\Admin\PostController@approve')->name('post.approve');

    Route::get('authors','App\Http\Controllers\Admin\AuthorController@index')->name('author.index');
    Route::delete('authors/{id}','App\Http\Controllers\Admin\AuthorController@destroy')->name('author.destroy');

    Route::get('favorite','App\Http\Controllers\Admin\FavoriteController@index')->name('favorite.index'); 
    Route::get('comments','App\Http\Controllers\Admin\CommentController@index')->name('comment.index');
    Route::delete('comments/{id}','App\Http\Controllers\Admin\CommentController@destroy')->name('comment.destroy');
    Route::get('subscriber','App\Http\Controllers\Admin\SubscriberController@index')->name('subscriber.index');
    Route::delete('subscriber/{subscriber}','App\Http\Controllers\Admin\SubscriberController@destroy')->name('subscriber.destroy');
});


Route::group(['as'=>'author.','prefix'=>'author','middleware'=>['auth','author']], function(){
    Route::get('dashboard','App\Http\Controllers\Author\DashboardController@index')->name('dashboard');

    Route::get('comments','App\Http\Controllers\Author\CommentController@index')->name('comment.index');
    Route::match(['get','delete'],'comments/{id}','App\Http\Controllers\Author\CommentController@destroy')->name('comment.destroy');

    Route::get('settings','App\Http\Controllers\Author\SettingsController@index')->name('settings');
    Route::put('profile-update','App\Http\Controllers\Author\SettingsController@updateProfile')->name('profile.update');
    Route::put('password-update','App\Http\Controllers\Author\SettingsController@updatePassword')->name('password.update');
    Route::resource('post','App\Http\Controllers\Author\PostController');

    Route::get('favorite','App\Http\Controllers\Author\FavoriteController@index')->name('favorite.index'); 
});


View::composer('layouts.frontend.partials.footer',function($view){
    $categories = App\Models\Category::all();
    $view->with('categories',$categories);
});