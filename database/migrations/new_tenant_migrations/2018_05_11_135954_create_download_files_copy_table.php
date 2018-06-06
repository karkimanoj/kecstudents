<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownloadFilesCopyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('download_files_copy', function (Blueprint $table) {
          
            $table->unsignedInteger('download_id');
            $table->string('original_filename');
              $table->string('display_name');
            $table->string('filepath')->unique();
            
            $table->foreign('download_id')->references('id')->on('downloads')->onDelete('cascade')->onUpdate('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('download_files_copy');
    }
}
