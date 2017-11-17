<?php

namespace App\Models\Issue;

use App\Models\IssueModel;
use App\User;
use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    protected $table = 'issue_comments';
    protected $fillable = ['issue_id', 'user_id', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function issue()
    {
        return $this->belongsTo(IssueModel::class);
    }
}
