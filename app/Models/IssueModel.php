<?php

namespace App\Models;

use App\Models\Issue\AttachmentModel;
use App\Models\Issue\CommentModel;
use App\Models\Issue\PriorityModel;
use App\Models\Issue\ResolutionModel;
use App\Models\Issue\StatusModel;
use App\Models\Issue\TypeModel;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

/**
 * @property int reported_by
 * @property int status_id
 * @property int assign_to
 * @property int resolution_id
 */
class IssueModel extends Model
{
    protected $table = 'issues';
    protected $fillable = [
        'project_id', 'type_id', 'priority_id',
        'summary', 'description',
        'assign_to'
    ];

    public function project()
    {
        return $this->belongsTo(ProjectModel::class);
    }

    public function priority()
    {
        return $this->belongsTo(PriorityModel::class);
    }

    public function reported()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function type()
    {
        return $this->belongsTo(TypeModel::class);
    }

    public function status()
    {
        return $this->belongsTo(StatusModel::class);
    }

    public function assign()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }

    public function resolution()
    {
        return $this->belongsTo(ResolutionModel::class);
    }

    public function attach(UploadedFile $file, $filename = null)
    {
        $attach = new AttachmentModel();
        $attach->issue_id = $this->id;
        $attach->filename = $filename ?? $file->getFilename();
        $attach->path = AttachmentModel::PATH_ISSUES;
        $attach->size = $file->getSize();
        $attach->mime = $file->getClientMimeType();
        $attach->extension = $file->getClientOriginalExtension();
        $attach->save();

        return $attach;
    }

    public function attachments()
    {
        return $this->hasMany(AttachmentModel::class, 'issue_id');
    }

    public function comments()
    {
        return $this->hasMany(CommentModel::class, 'issue_id');
    }

    public function workLogInHoursByDate($date)
    {
        $workLogs = $this->workLogs()->whereDate('date', '=', date($date))->get();
        $dateTime = (new \DateTime())->setTimestamp(0);
        foreach ($workLogs as $workLog) {
            $interval = new \DateInterval($workLog->worked);
            $dateTime->add($interval);
        }
        $hours = $dateTime->getTimestamp() / 60 / 60;
        return round($hours, 1);
    }

    public function workLogs()
    {
        return $this->hasMany(WorkLogModel::class, 'issue_id');
    }

    public function workLogInHours()
    {
        $workLogs = $this->workLogs;
        $dateTime = (new \DateTime())->setTimestamp(0);
        foreach ($workLogs as $workLog) {
            $interval = new \DateInterval($workLog->worked);
            $dateTime->add($interval);
        }
        $hours = $dateTime->getTimestamp() / 60 / 60;
        return round($hours, 1);
    }
}
