<?php

namespace App\Mail;

use App\Models\Issue\CommentModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;

    /**
     * Create a new message instance.
     *
     * @param CommentModel $comment
     */
    public function __construct(CommentModel $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject = $this->comment->issue->project->email_subject;
        return $this->view('emails.comment-mail')
            ->with('layout', $this->comment->issue->project->email_layout);
    }
}
