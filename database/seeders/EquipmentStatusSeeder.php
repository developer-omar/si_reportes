<?php

namespace Database\Seeders;

use App\Models\EquipmentStatus;
use Illuminate\Database\Seeder;

class EquipmentStatusSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        EquipmentStatus::create([
            'name' => 'Optimo'
        ]);
        EquipmentStatus::create([
            'name' => 'En observacion'
        ]);
        EquipmentStatus::create([
            'name' => 'Con falla'
        ]);
    }
}
