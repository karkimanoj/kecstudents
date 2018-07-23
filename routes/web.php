<?php

Route::middleware('subdomain', 'auth')->group(function(){
	/*
	  pages routes	
	*/
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

		//all posts  routes 	
		Route::get('/posts/create', 'User\PostController@create')->name('user.posts.create');	

		Route::get('/posts', 'User\PostController@index')->name('user.posts.index');
		Route::get('/posts/{slug}', 'User\PostController@show')->name('user.posts.show');
		
		Route::post('/posts', 'User\PostController@store')->name('user.posts.store');
		Route::get('/posts/{slug}/edit', 'User\PostController@edit')->name('user.posts.edit');
		Route::put('/posts/{slug}', 'User\PostController@update')->name('user.posts.update');
		Route::delete('/posts/{slug}', 'User\PostController@destroy')->name('user.posts.destroy');

		Route::resource('/events', 'User\EventController', ['as'=>'user']);
		//event ajax routes
		Route::get('/eventsAction', 'User\EventController@interest_and_join')->name('user.events.action');	

		Route::get('/eventFeed', 'User\EventController@eventFeed')->name('user.events.feed');
		Route::get('/eventList', 'User\EventController@eventList')->name('user.events.eventList');

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

