<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downloads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('original_filename');
            $table->string('filepath')->unique();
            /*
                dont forget to make unsignedInteger on foreignkey of 'id',
            */
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('uploader_id');
            $table->text('description');
            $table->dateTime('published_at')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('download_categories')->onUpdate('cascade')
                                    ->onDelete('cascade');
            
            $table->foreign('uploader_id')->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('cascade');;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('downloads');
    }
}
