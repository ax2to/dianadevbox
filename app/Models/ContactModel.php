<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactModel extends Model
{
    protected $table = 'contacts';

    protected $fillable = ['company', 'name', 'lastname', 'email1', 'email2', 'phone1', 'phone2'];
}
