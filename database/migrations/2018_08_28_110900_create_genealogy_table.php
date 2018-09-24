<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGenealogyTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('genealogy', function (Blueprint $table) {
            $table->integer('registry');
            $table->string('name', 100);
            $table->string('registry_type', 2)->nullable();
            $table->string('genre', 1)->nullable();
            $table->string('father_name', 100)->nullable();
            $table->integer('father_registry')->nullable();
            $table->string('mother_name', 100)->nullable();
            $table->integer('mother_registry')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('genealogy');
    }

}
