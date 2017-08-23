<?php

namespace App\Models\Issue;

use Illuminate\Database\Eloquent\Model;
use Storage;

/**
 * Class AttachmentModel
 * @package App\Models\Issue
 */
class AttachmentModel extends Model
{
    const PATH_ISSUES = 'issues/attachments';
    /**
     * @var string
     */
    protected $table = 'issue_attachments';

    /**
     * @return mixed
     */
    public function getMime()
    {
        $mime = explode('/', $this->mime);
        return $mime[0];
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return Storage::url(AttachmentModel::PATH_ISSUES . '/' . $this->filename);
        //return asset($this->path . '/' . $this->filename);
    }
}
