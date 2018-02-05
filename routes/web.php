<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|group(['prefix'=>'manage'],
*/

Route::middleware('role:superadministrator|administrator|teacher|student|staff')->group(function(){
	Route::resource('/downloads', 'Download\DownloadController');
});

Route::get('/manage/downloads/publish', 'Download\DownloadController@publish');

Route::prefix('manage')->middleware('role:superadministrator|administrator')->group( function(){


		Route::resource('/downloads', 'Download\DownloadController');

		Route::get('/downloads/category', 'Download\DownloadCategoryController@index')->name('download_categories.index');
		Route::post('/downloads/category', 'Download\DownloadCategoryController@store')->name('download_categories.store');

		Route::resource('/subjects', 'SubjectController');

		Route::resource('/faculties', 'FacultyController');

		Route::resource('/roles', 'RoleController', ['except'=>'destroy']);

		Route::resource('/permissions', 'PermissionController', ['except'=>'destroy']);

		Route::resource('/users', 'UserController');

		Route::get('/', 'ManageController@index');

		Route::get('/dashboard',  ['as'=>'manage.dashboard', 'uses'=>'ManageController@dashboard']);
});

Route::get('/', function () {
    return view('welcome');
});
	
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
