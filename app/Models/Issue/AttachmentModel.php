<?php

namespace App\Models\Issue;

use Illuminate\Database\Eloquent\Model;
use Storage;

class AttachmentModel extends Model
{
    protected $table = 'issue_attachments';

    public function getMime()
    {
        $mime = explode('/', $this->mime);
        return $mime[0];
    }

    public function getHref()
    {
        return Storage::url('issues/attachments/48-1UO6tMNR.PNG');
        //return asset($this->path . '/' . $this->filename);
    }
}
