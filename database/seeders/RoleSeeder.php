<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $administrator = Role::create([
            'guard_name' => 'user-administration',
            'name' => 'Administrador'
        ]);
        $user = Role::create([
            'guard_name' => 'user-administration',
            'name' => 'Usuario'
        ]);
        $client = Role::create([
            'guard_name' => 'user-company-institution',
            'name' => 'Cliente'
        ]);
    }
}
