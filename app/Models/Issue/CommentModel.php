<?php

namespace App\Models\Issue;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    protected $table = 'issue_comments';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
