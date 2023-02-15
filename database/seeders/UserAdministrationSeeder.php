<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAdministration;
use Illuminate\Database\Seeder;

class UserAdministrationSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $userAdministrador = new UserAdministration();
        $userAdministrador->name = 'Omar';
        $userAdministrador->last_name = 'Quispe';
        $userAdministrador->email = 'oquispe@mail.com';
        $userAdministrador->password = bcrypt('Admin123,.');
        $userAdministrador->save();
        $userAdministrador->assignRole('Administrador');
        $userAdministrador->givePermissionTo('company_institution');
        $userAdministrador->givePermissionTo('subsidiary');
        $userAdministrador->givePermissionTo('report');
        $userAdministrador->givePermissionTo('user_administration');
        $userAdministrador->givePermissionTo('user_company_institution');
    }
}
