<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->call(CitiesSeeder::class);
        $this->call(CompanySeeder::class);

        /**
         * Consecutives
         */
        DB::table('consecutives')->insert([
            'solicitude' => 1,
            'invoice' => 1,
            'daily_block' => 1
        ]);
    }
}
