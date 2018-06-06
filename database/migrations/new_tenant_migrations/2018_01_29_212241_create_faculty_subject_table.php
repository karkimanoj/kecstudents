<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacultySubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculty_subject', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('faculty_id')->unsigned();
            $table->integer('subject_id')->unsigned();
            $table->integer('semester')->unsigned();

            $table->foreign('faculty_id')->references('id')->on('faculties')
                  ->onUpdate('cascade')->onDelete('cascade'); 
            $table->foreign('subject_id')->references('id')->on('subjects')
                  ->onUpdate('cascade')->onDelete('cascade');       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faculty_subject');
    }
}
