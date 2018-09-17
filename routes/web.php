<?php

Route::middleware('subdomain', 'auth')->group(function(){
	/*
	  pages routes	
	*/
	  	//notice routes

	  	Route::get('/notices', 'Page\NoticeController@index')->name('notices.home');
	  	Route::get('/notices/{id}', 'Page\NoticeController@show')->name('notice.show');
		//post routes
	  	Route::get('/posts', 'Page\PostController@Index')->name('posts.home');
	  	Route::get('/posts/ajaxIndex', 'Page\PostController@ajaxIndex')->name('posts.ajaxIndex');
		//download routes
		Route::get('/downloads/{category_id}', 'Page\DownloadController@Index')->name('downloads.home');
		//ajx download route
		Route::get('/ajaxCall', 'Page\DownloadController@ajaxCall')->name('page.downloads.ajaxCall');

	
		Route::get('/projects/{category}/{cat_id}', 'Page\ProjectController@Index')->name('projects.home');
		//ajax route for displaying projects as per subjects and tags and for sort too
		Route::get('/projects/ajaxIndex', 'Page\ProjectController@ajaxIndex')->name('projects.ajaxIndex');
		
		
});

Route::prefix('user')->middleware('subdomain', 'auth', 'role:teacher|staff|student')->group(function(){
		/*
			user routes
		*/

		//notification routes
		Route::get('/readNotification', 'User\notificationController@markAllAsRead')->name('notification.markAll');	
		Route::get('/readNotification/{id}', 'User\notificationController@markAsRead')->name('notification.markOne');
		Route::get('/notifications', 'User\notificationController@index')->name('notifications.index');
		//all posts  routes 	
		Route::get('/posts/create', 'User\PostController@create')->name('user.posts.create');	

		Route::get('/posts', 'User\PostController@index')->name('user.posts.index');
		Route::get('/posts/{slug}', 'User\PostController@show')->name('user.posts.show');
		
		Route::post('/posts', 'User\PostController@store')->name('user.posts.store');
		Route::get('/posts/{slug}/edit', 'User\PostController@edit')->name('user.posts.edit');
		Route::put('/posts/{slug}', 'User\PostController@update')->name('user.posts.update');
		Route::delete('/posts/{slug}', 'User\PostController@destroy')->name('user.posts.destroy');

		//event ajax routes
		Route::get('/notifyComment', 'User\CommentController@notifyComment')->name('user.comments.notifyComment');
		Route::get('/eventsAction', 'User\EventController@interest_and_join')->name('user.events.action');		
		//end ofevent ajax routes
		Route::resource('/events', 'User\EventController', ['as'=>'user']);
		

		Route::get('/eventFeed', 'User\EventController@eventFeed')->name('user.events.feed');
		Route::get('/eventList', 'User\EventController@eventList')->name('user.events.eventList');

		Route::post('/projects/{project}/confirmMember', 'User\ProjectController@confirmMember')->name('user.projects.confirmMember');
		Route::resource('/projects', 'User\ProjectController', ['as'=>'user']);
		
		Route::resource('/downloads', 'User\DownloadController', ['as'=>'user']);

		


});



//tenant routes -only available to tennt admin
Route::middleware('TenantAdmin')->group( function(){
	
	//tenants contoller
	Route::post('/tenants/addSuperAdmin', 'Admin\TenantController@addSuperAdmin')->name('tenants.addSuperAdmin');
	Route::resource('/tenants', 'Admin\TenantController');
	Route::get('/tenants/softDelete/{id}', 'Admin\TenantController@softDelete')->name('tenants.softDelete');

	//ajax route for migrating tables according to newly registered tenants   
	Route::get('/migrateTables1', 'Admin\TenantController@migrateTables1');

	//tenant admin login and logout controller
	Route::get('adminLogin', 'Auth\TenantAdminLoginController@showLoginForm')->name('tenantadmin.login');
	Route::post('/adminLogin', 'Auth\TenantAdminLoginController@login')->name('tenantadmin.login.submit');
	Route::post('/adminLogout', 'Auth\TenantAdminLoginController@tenantAdminLogout')->name('tenantadmin.logout');

	//tenant admin controller
	Route::resource('/tenantAdmin', 'Admin\TenantAdminController');
	
});


Route::prefix('manage')->middleware('subdomain','role:superadministrator|administrator')->group( function(){

	/*
		manage (admin) routes
	*/
		//Route::get('/test11', 'ManageController@index');
		//Route::get('/test', 'Project\ProjectController@test');
		Route::get('/collegePeoples/index/{type}', 'Admin\CollegePeopleController@index')->name('collegePeoples.index');
		Route::get('/collegePeoples/create', 'Admin\CollegePeopleController@create')->name('collegePeoples.create');	
		
		Route::get('/collegePeoples/{id}/{type}', 'Admin\CollegePeopleController@show')->name('collegePeoples.show');
		Route::post('/collegePeoples', 'Admin\CollegePeopleController@store')->name('collegePeoples.store');
		Route::get('/collegePeoples/{id}/edit/{type}', 'Admin\CollegePeopleController@edit')->name('collegePeoples.edit');
		Route::put('/collegePeoples/{id}', 'Admin\CollegePeopleController@update')->name('collegePeoples.update');
		Route::delete('/collegePeoples/{id}/{type}', 'Admin\CollegePeopleController@destroy')->name('collegePeoples.destroy');
		//Notce resource routes
		Route::resource('/notices', 'Admin\NoticeController');

		//all posts  routes 	
		Route::get('/posts/create', 'Admin\PostController@create')->name('posts.create');	
		Route::get('/posts', 'Admin\PostController@index')->name('posts.index');
		Route::get('/posts/{slug}', 'Admin\PostController@show')->name('posts.show');
		Route::post('/posts', 'Admin\PostController@store')->name('posts.store');
		Route::get('/posts/{slug}/edit', 'Admin\PostController@edit')->name('posts.edit');
		Route::put('/posts/{slug}', 'Admin\PostController@update')->name('posts.update');
		Route::delete('/posts/{slug}', 'Admin\PostController@destroy')->name('posts.destroy');

		//event resource route	
		Route::resource('/events', 'Admin\EventController');
		//ajax call for softdeleting event
		Route::get('/eventsSoftDelete', 'Admin\EventController@ajaxSoftDelete')->name('events.softDelete');

		Route::get('/tags', 'Admin\TagController@index')->name('tags.index');
		Route::delete('/tags/{id}', 'Admin\TagController@destroy')->name('tags.destroy');


		//projects routs
		Route::get('/projects/publish', 'Admin\ProjectController@publish')->name('projects.publish');
		Route::resource('/projects', 'Admin\ProjectController');

		//download routes
		Route::get('/downloads/publish', 'Admin\DownloadController@publish')->name('downloads.publish');
		Route::resource('/downloads', 'Admin\DownloadController');
		

		//download categories controller
		Route::get('/downloadsCategory', 'Admin\DownloadCategoryController@index')->name('download_categories.index');
		Route::post('/downloadsCategory', 'Admin\DownloadCategoryController@store')->name('download_categories.store');

		Route::resource('/subjects', 'Admin\SubjectController');

		Route::resource('/faculties', 'Admin\FacultyController');

		Route::resource('/roles', 'Admin\RoleController', ['except'=>'destroy']);

		Route::resource('/permissions', 'Admin\PermissionController', ['except'=>'destroy']);

		Route::resource('/users', 'Admin\UserController');

		Route::get('/', 'Admin\ManageController@index');
/*
		Route::get('/dashboard',  ['as'=>'manage.dashboard', 'uses'=>'Admin\ManageController@dashboard']);*/
});




        
 

Route::middleware('subdomain')->group( function(){
    	//for first time use after registration
    	Route::get('/registration/passwordChange', function (){
		return view('auth.passwords.registeremail');
		})->name('passwords.firstRegistration');

	Auth::routes();
	Route::get('/subdomainTest', 'HomeController@subdomain');

	Route::get('/', 'HomeController@index');
	Route::get('/home', 'HomeController@index')->name('home');

});

