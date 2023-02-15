<?php

namespace Database\Seeders;

use App\Models\CompanyInstitution;
use Illuminate\Database\Seeder;

class CompanyInstitutionSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        CompanyInstitution::create([
            'name' => 'Banco Bisa',
            'photo' => 'http://127.0.0.1:8000/storage/companies_institutions/bisa.png'
        ]);
        CompanyInstitution::create([
            'name' => 'Ministerio de Economia',
            'photo' => 'http://127.0.0.1:8000/storage/companies_institutions/min-economia.png'
        ]);
        CompanyInstitution::create([
            'name' => 'Banco de Desarrollo de América Latina',
            'photo' => 'http://127.0.0.1:8000/storage/companies_institutions/caf.jpg'
        ]);
        CompanyInstitution::create([
            'name' => 'ATC',
            'photo' => 'http://127.0.0.1:8000/storage/companies_institutions/atc.png'
        ]);
    }
}
