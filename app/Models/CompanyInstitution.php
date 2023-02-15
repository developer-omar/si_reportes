<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInstitution extends Model {
    use HasFactory;

    protected $table = "companies_institutions";

    public function subsidiaries() {
        return $this->hasMany(Subsidiary::class);
    }

    public function usersCompanyInstitution() {
        return $this->hasMany(UserCompanyInstitution::class);
    }
}
