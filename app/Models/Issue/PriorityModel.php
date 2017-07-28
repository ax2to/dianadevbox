<?php

namespace App\Models\Issue;

use Illuminate\Database\Eloquent\Model;

class PriorityModel extends Model
{
    const DEFAULT = 3;
    protected $table = 'issue_priorities';
}
