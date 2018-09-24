<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('profile_id')->nullable();
            $table->tinyInteger('contact_type')->nullable();
            $table->tinyInteger('horses')->nullable();
            $table->string('contact')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('contacts');
    }

}
