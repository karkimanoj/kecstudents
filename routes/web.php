<?php

Route::middleware('auth')->group(function(){
	/*
		pages routes	
	*/
		//download routes
		Route::get('/downloads/{category_id}', 'Page\DownloadController@Index')->name('downloads.home');

	Route::get('/ajaxCall', 'Page\DownloadController@ajaxCall')->name('page.downloads.ajaxCall');

	//ajax route for displaying projects as per subjects and tags and for sort too
		Route::get('/projects/{category}/{cat_id}', 'Page\ProjectController@Index')->name('projects.home');
		Route::get('/projects/ajaxIndex', 'Page\ProjectController@ajaxIndex')->name('projects.ajaxIndex');
		
		
});

Route::prefix('user')->middleware('auth')->group(function(){
		/*
			user routes
		*/
		Route::resource('/projects', 'User\ProjectController', ['as'=>'user']);
		
		Route::resource('/downloads', 'User\DownloadController', ['as'=>'user']);

});



Route::prefix('manage')->middleware('role:superadministrator|administrator')->group( function(){

	/*
		manage (admin) routes
	*/
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
