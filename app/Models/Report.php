<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model {
    use HasFactory;

    protected $table = "reports";

    public function subsidiary() {
        return $this->belongsTo(Subsidiary::class);
    }

    public function equipmentStatus() {
        return $this->belongsTo(EquipmentStatus::class);
    }

    public function userAdministration() {
        return $this->belongsTo(UserAdministration::class);
    }
}
