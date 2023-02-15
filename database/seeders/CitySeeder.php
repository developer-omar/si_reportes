<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        City::create([
            'name' => 'La Paz'
        ]);
        City::create([
            'name' => 'Cochabamba'
        ]);
        City::create([
            'name' => 'Santa Cruz'
        ]);
        City::create([
            'name' => 'Tarija'
        ]);
        City::create([
            'name' => 'Potosi'
        ]);
        City::create([
            'name' => 'Oruro'
        ]);
        City::create([
            'name' => 'Trinidad'
        ]);
        City::create([
            'name' => 'Cobija'
        ]);
        City::create([
            'name' => 'Sucre'
        ]);
    }
}
