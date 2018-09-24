<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFollowersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('followers', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('profile_id');
            $table->string('profile_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('followers');
    }

}
