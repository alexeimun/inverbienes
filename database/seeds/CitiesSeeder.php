<?php

use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('cities')->insert(CitiesFeed::feed());
    }
}
