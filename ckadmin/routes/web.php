<?php

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

// Route::get('/', function () {
// 	return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/home', 'HomeController@index')->name('home');


// password reset route

// Route::post('password/email/');
// Route::post('password/reset/');

Route::resource('articles', 'ArticleController');
Route::get('Upload-Profile-Pic', 'ArticleController@profilepic')->name('add-profilepic.page');
Route::post('Save-Profile-Pic/{id}', 'ArticleController@saveProfilePic')->name('save-profilepic.page');

Route::get('userRegister', 'ArticleController@userCreate')->name('user.page');
Route::get('user-list', 'ArticleController@userList')->name('user.list');
Route::delete('user/{id}', 'ArticleController@userdelete')->name('user.destroy');

Route::post('user-register', 'ArticleController@register')->name('user.register');
Route::resource('infograph', 'InfographController');
Route::resource('quiz', 'QuizTopicController');

ROute::get('succper', 'ArticleController@getscore');

Route::resource('ckprofile', 'CkProfileController');
Route::get('contact-message', 'CkProfileController@message')->name('contact-message');
Route::delete('delete-message/{id}', 'CkProfileController@destroyMessage')->name('delete-message');


//start for template all page , it should be remove for production
Route::get('pages/{name}', 'HomeController@pages')->name('template');