<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class UserCompanyInstitution extends Authenticatable{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'users_company_institution';
    protected $guard = 'user-company-institution';

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'company_institution_id',
        'deleted_state',

    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function companyInstitution() {
        return $this->belongsTo(CompanyInstitution::class);
    }
}
