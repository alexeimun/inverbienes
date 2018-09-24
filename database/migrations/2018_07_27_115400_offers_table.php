<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class OffersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->unsignedTinyInteger('priority')->default(0);
            $table->unsignedBigInteger('media_id')->nullable();
            $table->string('title')->nullable();
            $table->string('author', 100)->nullable();
            $table->text('body')->nullable();
            $table->string('link')->nullable();
            $table->enum('category', [
                'Nutrición', 'Herrería', 'Talabartería', 'Veterinaria', 'Pesebrera',
                'Reproductores', 'Transporte', 'Asociaciones', 'Insumos', 'Otros'
            ]);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('offers');
    }

}
