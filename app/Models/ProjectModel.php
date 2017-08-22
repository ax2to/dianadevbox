<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectModel extends Model
{
    protected $table = 'projects';

    public function issues()
    {
        return $this->hasMany(IssueModel::class, 'project_id')
            ->where('company_id', \Auth::user()->company_id);
    }
}
