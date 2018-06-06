<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;
use Artisan;
use App\Tenant;
use Session;
use DB;
//use Illuminate\Support\Facades\Artisan;
class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenants = Tenant::withTrashed()->paginate(10);
        return view('manage.tenants.index', ['tenants' => $tenants] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage.tenants.create');
    }

    /*
        for enable disable softDelete
    */

    public function softDelete($id)
    {
        $tenant = Tenant::withTrashed()->findOrFail($id);
        if($tenant->trashed()) 
            $tenant->restore();
        else
        {
            $tenant->delete();
            Session::flash('success', $tenant->name.' soft deleted successfully');
        }
        return back();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tenant = Tenant::withTrashed()->findOrFail($id);
        $table_array=[];
        $tables = DB::select('SHOW TABLES LIKE "'.$tenant->identifier.'_%"');
            foreach ($tables as $table) 
            {
                foreach ($table as $value)
                    array_push($table_array, $value);
            }
        return view('manage.tenants.show', [ 'tenant' => $tenant,
                                            'table_array' => $table_array]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tenant = Tenant::withTrashed()->findOrFail($id);
        return view('manage.tenants.show', [ 'tenant' => $tenant ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        /* force deleting is needed because of
        $tenant=Tenant::withTrashed()->findOrFail($id);
        if( $tenant->forceDelete() )
        {
            Session::flash('success', 'file  was successfully deleted');
            return redirect()->route('tenants.index');
        }
        else
            return back()->withErrors(' delete failed due to unknown error '); 
        */
    }

    //migrating required tables for newly registered tenant 

    public function migrateTables1(Request $request)   
    {
        $tenant = Tenant::findOrFail($request->id);
        $ten = $tenant->identifier;
        
        $db_name = config('database.connections.mysql.database');
        $table_array=[];

        if($request->ajax())   
        { 
            if($request->action == 'migrate')
            {   /*
                //config(['database.connections.mysql.prefix' => session('tenant').'_']);
                Artisan::call('migrate', [
                    '--path' => 'database/migrations/new_tenant_migrations'
                ]);
                */
                 //  start laratrust tablesg
                
                if (!Schema::hasTable($ten.'_roles')) 
                {
                    Schema::connection('mysql')->create($ten.'_roles', function(Blueprint $table)
                    {
                        $table->increments('id');
                        $table->string('name')->unique();
                        $table->string('display_name')->nullable();
                        $table->string('description')->nullable();
                        $table->timestamps();
                    });
                }

                if (!Schema::hasTable($ten.'_permissions')) 
                {
                    Schema::connection('mysql')->create($ten.'_permissions', function(Blueprint $table)
                    {
                        // Create table for storing permissions
                        $table->increments('id');
                        $table->string('name')->unique();
                        $table->string('display_name')->nullable();
                        $table->string('description')->nullable();
                        $table->timestamps();
               
                    });
                }
                
                if (!Schema::hasTable($ten.'_role_user')) 
                {
                    Schema::connection('mysql')->create($ten.'_role_user', function(Blueprint $table ) use($ten)
                    {
                     // Create table for associating roles to users and teams (Many To Many Polymorphic)
                        $table->integer('role_id')->unsigned();
                        $table->integer('user_id')->unsigned();
                        $table->string('user_type');

                        $table->foreign('role_id')->references('id')->on($ten.'_roles')
                           ->onDelete('cascade')->onUpdate('cascade');

                        $table->primary(['user_id', 'role_id', 'user_type']);
                    });
                }

                 if (!Schema::hasTable($ten.'_permission_user')) 
                {
                    Schema::connection('mysql')->create($ten.'_permission_user', function(Blueprint $table) use($ten)
                    {
                    // Create table for associating permissions to users (Many To Many Polymorphic)
                        $table->integer('permission_id')->unsigned();
                        $table->integer('user_id')->unsigned();
                        $table->string('user_type');

                        $table->foreign('permission_id')->references('id')->on($ten.'_permissions')
                            ->onUpdate('cascade')->onDelete('cascade');

                        $table->primary(['user_id', 'permission_id', 'user_type']);
                    });
                }

                if (!Schema::hasTable($ten.'_permission_'.$ten.'_role')) 
                {
                // Create table for associating permissions to roles (Many-to-Many)
                    Schema::create($ten.'_permission_'.$ten.'_role', function (Blueprint $table) use($ten) {
                        $table->unsignedInteger('permission_id');
                        $table->unsignedInteger('role_id');

                        $table->foreign('permission_id')->references('id')->on($ten.'_permissions')
                            ->onDelete('cascade')->onUpdate('cascade');
                        $table->foreign('role_id')->references('id')->on($ten.'_roles')
                            ->onDelete('cascade')->onUpdate('cascade');

                        $table->primary(['permission_id', 'role_id']);
                    });
                }
                
                
                 //   End of laratrust tables
                

               //tenant faculties table    
                if (!Schema::hasTable($ten.'_faculties')) 
                {
                    Schema::connection('mysql')->create($ten.'_faculties', function(Blueprint $table)
                    {    
                
                        $table->increments('id');
                        $table->string('name')->unique();
                        $table->string('display_name');
                        $table->timestamps();
                    });
                }

                ////tenant subjects table
                if (!Schema::hasTable($ten.'_subjects')) 
                {
                    Schema::connection('mysql')->create($ten.'_subjects', function(Blueprint $table)
                    { 
                        $table->increments('id');
                        $table->string('name')->unique();
                        $table->boolean('project');
                        $table->timestamps();
                    });  
                }   

                //tenant faculty subject table    
                if (!Schema::hasTable($ten.'_faculty_'.$ten.'_subject')) 
                {
                    Schema::connection('mysql')->create($ten.'_faculty_'.$ten.'_subject', function(Blueprint $table )  use($ten)
                    {
                        $table->increments('id');
                        $table->integer('faculty_id')->unsigned();
                        $table->integer('subject_id')->unsigned();
                        $table->integer('semester')->unsigned();

                        $table->foreign('faculty_id')->references('id')->on($ten.'_faculties')
                              ->onUpdate('cascade')->onDelete('cascade'); 
                        $table->foreign('subject_id')->references('id')->on($ten.'_subjects')
                              ->onDelete('cascade')->onUpdate('cascade');  
                    });  
                }      

                 //tenant download_categories table   
                if (!Schema::hasTable($ten.'_download_categories')) 
                {
                    Schema::connection('mysql')->create($ten.'_download_categories', function(Blueprint $table)
                    {
                        $table->increments('id');
                        $table->string('name')->unique();
                        $table->string('category_type');
                        $table->unsignedTinyInteger('max_no_of_files');
                    });
                }

                 //tenant downloads table   
                if (!Schema::hasTable($ten.'_downloads')) 
                {
                    Schema::connection('mysql')->create($ten.'_downloads', function(Blueprint $table ) use($ten)
                    {
                        $table->increments('id');
                        $table->string('title');

                        
                          //  dont forget to make unsignedInteger on foreignkey of 'id',
                        
                        $table->unsignedInteger('category_id');
                        $table->unsignedInteger('uploader_id');
                        $table->unsignedInteger('subject_id')->nullable();
                        $table->unsignedInteger('faculty_id')->nullable();
                        $table->integer('semester')->length(2)->unsigned()->nullable();
                        $table->text('description');
                        $table->dateTime('published_at')->nullable();
                        $table->timestamps();

                        $table->foreign('category_id')->references('id')->on($ten.'_download_categories')->onUpdate('cascade')
                                                ->onDelete('cascade');
                        $table->foreign('uploader_id')->references('id')->on('users')
                              ->onUpdate('cascade')->onDelete('cascade');
                        $table->foreign('subject_id')->references('id')->on($ten.'_subjects')->onDelete('cascade')->onUpdate('cascade');
                        $table->foreign('faculty_id')->references('id')->on($ten.'_faculties')->onDelete('cascade')->onUpdate('cascade');
                    });  
                }

                if (!Schema::hasTable($ten.'_download_files')) 
                {
                    Schema::connection('mysql')->create($ten.'_download_files', function(Blueprint $table) use($ten)
                    {
                        $table->unsignedInteger('download_id');
                        $table->string('original_filename');
                          $table->string('display_name');
                        $table->string('filepath')->unique();
                        
                        $table->foreign('download_id')->references('id')->on($ten.'_downloads')->onDelete('cascade')->onUpdate('cascade');
                    });  
                }

                //tenant projects table  download_categories  
                if (!Schema::hasTable($ten.'_projects')) 
                {
                    Schema::connection('mysql')->create($ten.'_projects', function(Blueprint $table) use($ten)
                    {
                        $table->increments('id');
                        $table->string('name');
                        $table->string('original_filename');
                        $table->string('filepath')->unique();
                        $table->string('url_link')->unique();
                        $table->text('abstract');
                        
                         //dont forget to make unsignedInteger on foreignkey of 'id',
                        
                        $table->unsignedInteger('subject_id');
                        $table->unsignedInteger('uploader_id');

                        $table->dateTime('published_at')->nullable();
                        $table->timestamps();

                        $table->foreign('subject_id')->references('id')->on($ten.'_subjects')->onUpdate('cascade')->onDelete('cascade');
                        
                        $table->foreign('uploader_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
                    });  
                }

                 //tenant project members table   
                if (!Schema::hasTable($ten.'_project_members')) 
                {
                    Schema::connection('mysql')->create($ten.'_project_members', function(Blueprint $table) use($ten)
                    {
                        $table->increments('id');
                        $table->unsignedInteger('project_id');
                        $table->string('roll_no', 15);
                        $table->string('name');
                        $table->foreign('project_id')->references('id')->on($ten.'_projects')->onUpdate('cascade')->onDelete('cascade'); 
                        $table->unique(['project_id','roll_no']);
                                   
                    });  
                }

                //tenant tags table    
                if (!Schema::hasTable($ten.'_tags')) 
                {
                    Schema::connection('mysql')->create($ten.'_tags', function(Blueprint $table)
                    {
                        $table->increments('id');
                        $table->string('name')->unique();
                        $table->unsignedInteger('created_by');
                        $table->timestamps();
                    });  
                }

                 //tenant taggables table   
                if (!Schema::hasTable($ten.'_taggables')) 
                {
                    Schema::connection('mysql')->create($ten.'_taggables', function(Blueprint $table) use($ten)
                    {
                        $table->unsignedInteger('tag_id');
                        $table->unsignedInteger('taggable_id');
                        $table->string('taggable_type');
                        //primary is not needed but its a good practice
                        $table->primary(['tag_id','taggable_id','taggable_type']);
                        $table->foreign('tag_id')->references('id')->on($ten.'_tags')->onDelete('cascade')->onUpdate('cascade');   
                    });  
                }

                //tenant images table    
                if (!Schema::hasTable($ten.'_images')) 
                {
                    Schema::connection('mysql')->create($ten.'_images', function(Blueprint $table)
                    {
                        $table->increments('id');
                        $table->string('filepath')->unique();
                        $table->unsignedInteger('imagable_id');
                        $table->string('imagable_type');
                        $table->timestamps();

                        $table->index(['imagable_id','imagable_type']);    
                    });  
                }

                //tenant download files table    
                
            } 
            else if($request->action == 'drop')
            {
                Schema::connection('mysql')->dropIfExists( $ten.'_images');
                Schema::connection('mysql')->dropIfExists( $ten.'_taggables');
                Schema::connection('mysql')->dropIfExists( $ten.'_tags');
                Schema::connection('mysql')->dropIfExists( $ten.'_project_members');
                Schema::connection('mysql')->dropIfExists( $ten.'_projects');
                Schema::connection('mysql')->dropIfExists( $ten.'_download_files');
                Schema::connection('mysql')->dropIfExists( $ten.'_downloads');
                Schema::connection('mysql')->dropIfExists( $ten.'_download_categories');
                Schema::connection('mysql')->dropIfExists( $ten.'_faculty_'.$ten.'_subject');
                Schema::connection('mysql')->dropIfExists( $ten.'_subjects');
                Schema::connection('mysql')->dropIfExists( $ten.'_faculties');
                Schema::connection('mysql')->dropIfExists( $ten.'_permission_'.$ten.'_role');
                Schema::connection('mysql')->dropIfExists( $ten.'_permission_user');
                Schema::connection('mysql')->dropIfExists( $ten.'_role_user');
                Schema::connection('mysql')->dropIfExists( $ten.'_permissions');
                Schema::connection('mysql')->dropIfExists( $ten.'_roles');
               
            }

            $tables = DB::select('SHOW TABLES LIKE "'.$ten.'_%"');
            foreach ($tables as $table) 
            {
                foreach ($table as $value)
                    array_push($table_array, $value);
            }

            return json_encode($table_array);
        }        

        
                
    }
}
