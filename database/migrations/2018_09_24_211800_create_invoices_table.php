<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoicesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('mortgage_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->integer('consecutive');
            $table->integer('total');
            $table->integer('capital');
            $table->unsignedSmallInteger('pay_type')->nullable();
            $table->string('bank', 60)->nullable();
            $table->string('check', 60)->nullable();
            $table->date('cancelled_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('invoices');
    }

}
