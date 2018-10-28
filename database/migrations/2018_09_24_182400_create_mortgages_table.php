<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMortgagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('mortgages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('debtor_id');
            $table->unsignedInteger('creditor_id');
            $table->unsignedInteger('immovable_id');
            $table->integer('consecutive')->nullable();
            $table->date('start_date')->nullable();
            $table->date('final_date')->nullable();
            $table->enum('type', ['Abierta', 'Cerrada'])->nullable();
            $table->enum('state', ['Vigente', 'Demandado', 'Cancelado'])->default('Vigente')->nullable();
            $table->integer('capital')->nullable();
            $table->integer('initial_balance')->nullable();
            $table->integer('adjustment')->nullable();
            $table->integer('commission')->nullable();
            $table->integer('interest')->nullable();
            $table->integer('mortgage_percent')->nullable();
            $table->integer('fee_admin')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('mortgages');
    }

}
