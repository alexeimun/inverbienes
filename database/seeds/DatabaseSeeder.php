<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $this->migrateColorsAndRaces();
        //$this->migrateLocation(new \Rhemo\Models\Profile);
        //$this->migrateLocation(new \Rhemo\Models\Prize);
        //$this->migrateLocation(new \Rhemo\Models\Horse);
        //$this->migrateLocation(new \Rhemo\Models\Calendar);
        //\Rhemo\Models\User::whereAccountType(0)->update(['email_checked' => 1]);
    }

    private function migrateColorsAndRaces() {
        DB::table('horse_colors')->insert([
            ['name' => 'Alazan'],
            ['name' => 'Bayo'],
            ['name' => 'Castaño'],
            ['name' => 'Isabelino'],
            ['name' => 'Moro'],
            ['name' => 'Negro'],
            ['name' => 'Cervuno'],
            ['name' => 'Naranjuelo'],
            ['name' => 'Pavo'],
            ['name' => 'Zaino']
        ]);

        DB::table('horse_races')->insert([
            ['name' => 'Criollo colombiano',],
            ['name' => 'Pura sangre inglés',],
            ['name' => 'Ibérico',],
            ['name' => 'Polos',],
            ['name' => 'Cruces',],
            ['name' => 'Hannoveriano',],
            ['name' => 'Appaloosa',],
            ['name' => 'Pony',],
            ['name' => 'Criollo argentino',],
            ['name' => 'Azteca',],
            ['name' => 'Hunter',],
            ['name' => 'Andaluz',],
            ['name' => 'Percheron',],
            ['name' => 'Belga',],
            ['name' => 'Berberisco',],
            ['name' => 'Standardbred',],
            ['name' => 'Paso peruano',],
            ['name' => 'American paint',],
            ['name' => 'Akhal-teke',],
            ['name' => 'Asnales',],
            ['name' => 'Mulares',],
            ['name' => 'Chileno',],
            ['name' => 'Lipizzano',],
            ['name' => 'Lusitano',],
            ['name' => 'Exmoor',],
            ['name' => 'Bavaro',],
            ['name' => 'Falabella',],
            ['name' => 'Boloñes',],
            ['name' => 'Frison',],
            ['name' => 'Morgan',],
            ['name' => 'Mustang',],
            ['name' => 'Silla francés',],
            ['name' => 'Tennessee',],
            ['name' => 'Pinto',],
            ['name' => 'Clydesdale',],
            ['name' => 'Trakehner',],
            ['name' => 'Cuarto de milla Americano',],
            ['name' => 'Gypsy vanner',],
            ['name' => 'Árabe']
        ]);
    }

    private function migrateLocation($Model) {
        foreach ($Model::cursor() as $_model) {
            $country = $this->getCountry($_model->country_id);
            if($country && !$_model->location) {
                $_city = $this->getCity($_model->city_id);
                $_state = $this->getStates($_model->state_id);
                $state = $_state ? $_state . ', ' : '';
                $city = $_city ? $_city . ', ' : '';
                $_model->location = $city . $state . $country;
                $_model->save();
            }
        }
    }

    private function getCity($id) {
        return DB::table('cities')->where('id', $id)->value('name');
    }

    private function getCountry($id) {
        return DB::table('countries')->where('id', $id)->value('name');
    }

    private function getStates($id) {
        return DB::table('states')->where('id', $id)->value('name');
    }
}
