<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHighlightId extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('horses', function (Blueprint $table) {
            $table->unsignedInteger('highlight_id')->nullable();
        });

        Schema::table('profile', function (Blueprint $table) {
            $table->unsignedInteger('highlight_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
    }
}
