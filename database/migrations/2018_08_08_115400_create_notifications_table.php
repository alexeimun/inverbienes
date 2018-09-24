<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('event_type')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('detail_id')->nullable();
            $table->string('title', 70)->nullable();
            $table->string('body')->nullable();
            $table->string('person_name')->nullable();
            $table->boolean('seen')->default(false)->nullable();
            $table->unsignedBigInteger('person_image_id')->nullable();
            $table->string('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('notifications');
    }

}
