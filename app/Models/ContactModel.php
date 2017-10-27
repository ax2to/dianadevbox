<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactModel extends Model
{
    use SoftDeletes;

    protected $table = 'contacts';

    protected $fillable = ['company', 'name', 'lastname', 'email1', 'email2', 'phone1', 'phone2'];
}
