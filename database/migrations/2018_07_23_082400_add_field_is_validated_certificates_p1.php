<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFieldIsValidatedCertificatesP1 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('horse_certificates', function (Blueprint $table) {
            $table->boolean('is_validated')->default(false)->after('expedition');
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
