<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectHasMembersModel extends Pivot
{
    protected $table = 'projects_has_members';
    protected $foreignKey = 'project_id';
    protected $relatedKey = 'user_id';
}
