<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $sections = [
            'company_institution',
            'subsidiary',
            'report',
            'user_administration',
            'user_company_institution'
        ];
        foreach ($sections as $section) {
            Permission::create([
                'guard_name' => 'user-administration',
                'name' => $section
            ]);
        }
    }
}
