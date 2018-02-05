<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownloadDetailTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('download_details1',function (Blueprint $table){
            $table->unsignedInteger('download_id');
            $table->unsignedInteger('subject_id');
            $table->foreign('download_id')->references('id')->on('downloads')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('download_details2',function (Blueprint $table){
            $table->unsignedInteger('download_id');
            $table->unsignedInteger('faculty_id');
            $table->unsignedInteger('semester', 2);
            $table->foreign('download_id')->references('id')->on('downloads')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('download_details1');
         Schema::dropIfExists('download_details2');
    }
}
