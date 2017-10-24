<?php

namespace App\Models;

use App\DateInterval;
use App\DateTime;
use App\Models\Issue\AttachmentModel;
use App\Models\Issue\CommentModel;
use App\Models\Issue\PriorityModel;
use App\Models\Issue\ResolutionModel;
use App\Models\Issue\StatusModel;
use App\Models\Issue\TypeModel;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

/**
 * @property int reported_by
 * @property int status_id
 * @property int assign_to
 * @property int resolution_id
 * @property string summary
 */
class IssueModel extends Model
{
    use SoftDeletes;

    protected $table = 'issues';
    protected $fillable = [
        'project_id', 'type_id', 'priority_id',
        'summary', 'description',
        'assign_to', 'estimated'
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
            $interval = new \DateInterval($workLog->worked_interval);
            $dateTime->add($interval);
        }
        $hours = $dateTime->getTimestamp() / 60 / 60;
        return round($hours, 1);
    }

    public function workLogs()
    {
        return $this->hasMany(WorkLogModel::class, 'issue_id');
    }

    public function scopeAllowedProjects($query)
    {
        $projects = ProjectModel::AllowedForUser(Auth::user())->pluck('id');
        return $query->whereIn('project_id', $projects);
    }

    public function getFullNameAttribute()
    {
        return $this->id . ' - ' . $this->summary;
    }

    public function getSpentAttribute()
    {
        $i = new DateInterval(0);

        foreach ($this->workLogs as $workLog) {
            $interval = new \DateInterval($workLog->worked_interval);
            $i->add($interval);
        }
        return $i;
    }

    public function workLogInHours()
    {
        $workLogs = $this->workLogs;
        $dateTime = (new \DateTime())->setTimestamp(0);
        foreach ($workLogs as $workLog) {
            $interval = new \DateInterval($workLog->worked_interval);
            $dateTime->add($interval);
        }
        $hours = $dateTime->getTimestamp() / 60 / 60;
        return round($hours, 1);
    }

    public function getRemainingAttribute()
    {
        $estimated = (new DateTime())->add($this->estimated);
        $spent = (new DateTime())->add($this->spent);

        if ($spent > $estimated) {
            return new DateInterval(0);
        }

        $diff = $estimated->diff($spent);

        $rs = new DateInterval($diff->y, $diff->m, 0, $diff->d, $diff->h, $diff->i, $diff->s);

        return $rs;
    }

    public function getEstimatedAttribute()
    {
        return DateInterval::createFromString($this->attributes['estimated']);
    }

    public function contact()
    {
        return $this->belongsTo(ContactModel::class);
    }
}
