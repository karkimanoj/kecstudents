<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvent1MembersTable extends Migration
{
    /**
     * Run the migrations.
     *g
     * @return void
     */
    public function up()
    {
        Schema::create('event1_members', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('event1_id');
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['event1_id', 'user_id']);
            $table->foreign('event1_id')->references('id')->on('event1s')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event1_members');
    }
}
