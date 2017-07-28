<?php

namespace App\Models\Issue;

use Illuminate\Database\Eloquent\Model;

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
        return asset($this->path . '/' . $this->filename);
    }
}
