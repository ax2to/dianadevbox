<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CompanyModel extends Model
{
    protected $table = 'companies';

    public function users()
    {
        return $this->hasMany(User::class, 'company_id');
    }
}
