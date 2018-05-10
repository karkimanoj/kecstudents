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

		Route::resource('/user/projects', 'User\ProjectController', ['as'=>'user']);

		//ajax route for displaying projects as per subjects and tags and for sort too
		Route::get('/projects/ajaxIndex', 'Page\ProjectController@ajaxIndex')->name('projects.ajaxIndex');
		
		Route::get('/projects/{category}/{cat_id}', 'Page\ProjectController@subjectIndex')->name('projects.home');
		
		//Route::get('/projects/{tagid}/index', 'Page\ProjectController@tagIndex')->name('projects.home2');

		Route::get('/projects/{id}', 'Page\ProjectController@projectShow')->name('projects.view');
});



Route::prefix('manage')->middleware('role:superadministrator|administrator')->group( function(){

		//Route::get('/test11', 'ManageController@index');
		//Route::get('/test', 'Project\ProjectController@test');
		Route::get('/projects/publish', 'Admin\ProjectController@publish');

		Route::get('/tags', 'Admin\TagController@index')->name('tags.index');
		Route::delete('/tags/{id}', 'Admin\TagController@destroy')->name('tags.destroy');

		Route::resource('/projects', 'Admin\ProjectController');

		Route::get('/downloads/category', 'Admin\DownloadCategoryController@index')->name('download_categories.index');
		Route::post('/downloads/category', 'Admin\DownloadCategoryController@store')->name('download_categories.store');
		
		Route::get('/downloads/publish', 'Admin\DownloadController@publish');

		Route::resource('/downloads', 'Admin\DownloadController');


		Route::resource('/subjects', 'Admin\SubjectController');

		Route::resource('/faculties', 'Admin\FacultyController');

		Route::resource('/roles', 'Admin\RoleController', ['except'=>'destroy']);

		Route::resource('/permissions', 'Admin\PermissionController', ['except'=>'destroy']);

		Route::resource('/users', 'Admin\UserController');

		Route::get('/', 'Admin\ManageController@index');

		Route::get('/dashboard',  ['as'=>'manage.dashboard', 'uses'=>'Admin\ManageController@dashboard']);
});

Route::get('/', 'HomeController@index');
	
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
