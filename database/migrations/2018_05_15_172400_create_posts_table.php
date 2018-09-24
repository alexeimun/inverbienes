<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('media_id')->nullable();
            $table->unsignedTinyInteger('state')->nullable();
            $table->string('body', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('posts');
    }

}
