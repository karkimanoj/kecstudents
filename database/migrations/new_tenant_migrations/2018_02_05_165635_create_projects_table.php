<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.jjj
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('original_filename');
            $table->string('filepath')->unique();
            $table->string('url_link')->unique();
            $table->text('abstract');
            /*
                dont forget to make unsignedInteger on foreignkey of 'id',
            */
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('uploader_id');

            $table->dateTime('published_at')->nullable();
            $table->timestamps();

            $table->foreign('subject_id')->references('id')->on('subjects')->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('uploader_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
             

        });
        


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
