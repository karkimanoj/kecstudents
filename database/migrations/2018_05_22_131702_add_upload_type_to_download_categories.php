<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUploadTypeToDownloadCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('download_categories', function (Blueprint $table) {
            $table->unsignedTinyInteger('max_no_of_files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('download_categories', function (Blueprint $table) {
            $table->dropColumn('max_no_of_files');
        });
    }
}
