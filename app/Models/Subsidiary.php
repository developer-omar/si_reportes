<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsidiary extends Model {
    use HasFactory;

    protected $table = "subsidiaries";

    public function companyInstitution() {
        return $this->belongsTo(CompanyInstitution::class);
    }

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function reports() {
        return $this->hasMany(Report::class);
    }
}
