<?php

Route::middleware('subdomain', 'auth')->group(function(){
	/*
	  pages routes	
	*/
		//event routes	  
	  	Route::get('/events/{type}', 'Page\EventController@Index')->name('events.home');


		//download routes
		Route::get('/downloads/{category_id}', 'Page\DownloadController@Index')->name('downloads.home');
		//ajx download route
		Route::get('/ajaxCall', 'Page\DownloadController@ajaxCall')->name('page.downloads.ajaxCall');

	
		Route::get('/projects/{category}/{cat_id}', 'Page\ProjectController@Index')->name('projects.home');
		//ajax route for displaying projects as per subjects and tags and for sort too
		Route::get('/projects/ajaxIndex', 'Page\ProjectController@ajaxIndex')->name('projects.ajaxIndex');
		
		
});

Route::prefix('user')->middleware('subdomain')->group(function(){
		/*
			user routes
		*/

		Route::resource('/events', 'User\EventController', ['as'=>'user']);
		//event ajax routes
		Route::get('/eventsAction', 'User\EventController@interest_and_join')->name('user.events.action');	

		Route::get('/eventFeed', 'User\EventController@eventFeed')->name('user.events.feed');
		Route::get('/eventList', 'User\EventController@eventList')->name('user.events.eventList');

		Route::resource('/projects', 'User\ProjectController', ['as'=>'user']);
		
		Route::resource('/downloads', 'User\DownloadController', ['as'=>'user']);

		


});



//tenant routes -only available to superadministrator
Route::prefix('manage')->middleware('subdomain','role:superadministrator')->group( function(){

	Route::resource('/tenants', 'Admin\TenantController');
	Route::get('/tenants/softDelete/{id}', 'Admin\TenantController@softDelete')->name('tenants.softDelete');

	//ajax route for migrating tables according to newly registered tenants   
	Route::get('/migrateTables1', 'Admin\TenantController@migrateTables1');
});

Route::prefix('manage')->middleware('subdomain','role:superadministrator|administrator')->group( function(){

	/*
		manage (admin) routes
	*/
		//Route::get('/test11', 'ManageController@index');
		//Route::get('/test', 'Project\ProjectController@test');

		//Route::resource('/events', 'Admin\EventController');	
		Route::resource('/events', 'Admin\EventController');
		//ajax call for softdeleting event
		Route::get('/eventsSoftDelete', 'Admin\EventController@ajaxSoftDelete')->name('events.softDelete');

		Route::get('/tags', 'Admin\TagController@index')->name('tags.index');
		Route::delete('/tags/{id}', 'Admin\TagController@destroy')->name('tags.destroy');

		Route::resource('/projects', 'Admin\ProjectController');
		Route::get('/projects/publish', 'Admin\ProjectController@publish');
		
		
		Route::resource('/downloads', 'Admin\DownloadController');
		Route::get('/downloads/publish', 'Admin\DownloadController@publish');

		Route::get('/downloads/category', 'Admin\DownloadCategoryController@index')->name('download_categories.index');
		Route::post('/downloads/category', 'Admin\DownloadCategoryController@store')->name('download_categories.store');

		Route::resource('/subjects', 'Admin\SubjectController');

		Route::resource('/faculties', 'Admin\FacultyController');

		Route::resource('/roles', 'Admin\RoleController', ['except'=>'destroy']);

		Route::resource('/permissions', 'Admin\PermissionController', ['except'=>'destroy']);

		Route::resource('/users', 'Admin\UserController');

		Route::get('/', 'Admin\ManageController@index');

		Route::get('/dashboard',  ['as'=>'manage.dashboard', 'uses'=>'Admin\ManageController@dashboard']);
});




        
 

Route::group([ 'middleware' => ['subdomain']
    ], function(){
    	
	Auth::routes();
	Route::get('/subdomainTest', 'HomeController@subdomain');

	Route::get('/', 'HomeController@index');
	Route::get('/home', 'HomeController@index')->name('home');

});

