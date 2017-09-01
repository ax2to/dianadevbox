<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer company_id
 * @property string name
 * @property string description
 */
class ProjectModel extends Model
{
    protected $table = 'projects';

    protected $fillable = ['name', 'description'];

    public function issues()
    {
        return $this->hasMany(IssueModel::class, 'project_id')
            ->where('company_id', \Auth::user()->company_id);
    }

    public function company()
    {
        return $this->belongsTo(CompanyModel::class);
    }

    public function scopeAllowedForUser($query, User $user)
    {
        $ids = ProjectHasMembersModel::where('user_id', $user->id)->pluck('project_id');
        return $query->whereIn('id', $ids);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'projects_has_members', 'project_id', 'user_id')
            ->using(ProjectHasMembersModel::class);
    }
}
