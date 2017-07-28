<?php

namespace App\Models\Issue;

use Illuminate\Database\Eloquent\Model;

class StatusModel extends Model
{
    const DEFAULT = 1;
    protected $table = 'issue_status';
}
