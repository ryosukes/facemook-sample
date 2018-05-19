<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();

            $table->index('user_id');
            $table->index('tag_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags');

            $table->unique(['user_id', 'tag_id'], 'unique_for_user_id_tag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_tags');
    }
}
