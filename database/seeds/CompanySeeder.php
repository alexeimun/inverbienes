<?php

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('company')->insert([
            'phone' => '5122899',
            'ceo' => 'Rafael Hernandez',
            'address' => 'Cll 50 Nro 48-3 Of 806',
            'nit' => '890934372-2',
            'notary' => 5,
            'email' => 'inverbienes2010@hotmail.com',
            'protocolist_name' => 'JOSE EDUARDO',
            'protocolist_phone' => '2518063'
        ]);
    }
}
