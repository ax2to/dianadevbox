<?php

namespace App;

use App\Models\RoleModel;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int role_id
 */
class User extends Authenticatable
{
    use Notifiable;
    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastName', 'timezone', 'email', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->lastName;
    }

    public function role()
    {
        return $this->belongsTo(RoleModel::class);
    }

    public function getIsAdminAttribute()
    {
        return User::ROLE_ADMIN == $this->role_id;
    }

    public function tzDateTime(Carbon $date)
    {
        return $date->tz($this->timezone)->format('Y-m-d H:i');
    }
}
