<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubjectIdFacultyIdSemesterRemoveOriginalFilenameAndFilepathToDownloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('downloads', function (Blueprint $table) {
            $table->unsignedInteger('subject_id')->nullable()->after('uploader_id');
            $table->unsignedInteger('faculty_id')->nullable()->after('uploader_id');
            $table->integer('semester')->length(2)->unsigned()->nullable()->after('uploader_id');

            $table->string('title')->after('id');

            //fks to newly added columns
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('cascade')->onUpdate('cascade');
                   
            // droping columns original_filename filepath
            $table->dropColumn('original_filename');
            $table->dropColumn('filepath');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('downloads', function (Blueprint $table) {
            $table->dropForeign('downloads_subject_id_foreign');
            $table->dropForeign('downloads_faculty_id_foreign');

            $table->dropColumn('subject_id');
            $table->dropColumn('faculty_id');
            $table->dropColumn('semester');

            $table->string('original_filename');
            $table->string('filepath')->unique();
        });
    }
}
