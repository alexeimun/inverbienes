<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EditFieldRoleProfileP1 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('profile', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('profile', function (Blueprint $table) {
            $table->enum('role', ['Usuario', 'Amante de los caballos',
                'Amazona', 'Montador', 'Criadero', 'Pesebrera', 'Jinete', 'Veterinario'])->default('Usuario');
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
