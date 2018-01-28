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

Route::prefix('manage')->middleware('role:superadministrator|administrator|editor|author|contributor')->group( function(){
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
