<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class UserAdministration extends Authenticatable{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'users_administration';
    protected $guard_name = 'user-administration';

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'deleted_state',
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function reports() {
        return $this->hasMany(Report::class);
    }
}
