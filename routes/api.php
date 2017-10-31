<?php

use App\Mail\CommentMail;
use App\Models\ContactModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/pipeline', function (Request $request) {
    $status = \App\Models\Issue\StatusModel::where('workflow_id', 2)->get();
    $data = [];
    foreach ($status as $s) {
        $issues = \App\Models\IssueModel::where('type_id', 5)
            ->where('status_id', $s->id);
        if ($request->user_id != 'all') {
            $issues->where('assign_to', $request->user_id);
        }
        $data[] = ['id' => $s->id, 'name' => $s->name, 'count' => $issues->count()];
    }
    return $data;
});

Route::get('/tickets', function (Request $request) {
    $issues = \App\Models\IssueModel::where('type_id', 5)
        ->where('status_id', $request->status)
        ->with(['status', 'contact'])
        ->orderBy('id', 'desc');

    if ($request->user_id != 'all') {
        $issues->where('assign_to', $request->user_id);
    }

    return $issues->limit(200)->get();
});

Route::post('/ticket/{issue}/status/{status}', function (\App\Models\IssueModel $issue, $status) {
    $issue->status_id = $status;
    $issue->save();

    return $issue;
});

Route::get('/ticket/{issue}', function (\App\Models\IssueModel $issue) {
    return $issue;
});

Route::get('/ticket/{ticket}/comments', function ($ticket) {
    $comments = \App\Models\Issue\CommentModel::with('user')
        ->where('issue_id', $ticket)
        ->limit(20)
        ->get();

    return $comments;
});

Route::post('/ticket/{ticket}/comment', function (Request $request) {
    $comment = new \App\Models\Issue\CommentModel();
    $comment->fill($request->all());
    $comment->save();

    if ($request->get('email')) {
        $issue = \App\Models\IssueModel::find($request->get('issue_id'));
        $contact = ContactModel::find($issue->contact_id);
        if ($contact->email1 != '') {
            Mail::to($contact->email1)->send(new CommentMail($comment));
            $comment->message .= '<div class="email-sent">Email sent to: ' . $contact->email1 . '</div>';
            $comment->save();
        }
        if ($contact->email2 != '') {
            Mail::to($contact->email2)->send(new CommentMail($comment));


            $comment->message .= '<div class="email-sent">Email sent to: ' . $contact->email2 . '</div>';
            $comment->save();
        }
    }

    return $comment;
});

Route::post('/ticket/create', function (Request $request) {
    // contact
    $contact = new ContactModel();
    $contact->company = $request->company;
    $contact->name = $request->name;
    $contact->lastname = $request->lastname;
    $contact->country = $request->country;
    $contact->email1 = $request->email1;
    $contact->email2 = $request->email2;
    $contact->phone1 = $request->phone1;
    $contact->phone2 = $request->phone2;
    $contact->address = $request->address;
    $contact->city = $request->city;
    $contact->source = $request->source;
    $contact->save();

    // issue
    $data1 = '';
    if ($request->company != '') {
        $data1 .= $request->company;
    } else {
        $data1 = 'new ticket';
    }

    $data2 = '';
    foreach ($request->all() as $string) {
        if (!is_null($string) && $string != '') {
            $data2 .= $string . '<br>';
        }
    }

    $issue = new \App\Models\IssueModel();
    $issue->company_id = 1;
    $issue->project_id = 4;
    $issue->type_id = 5;
    $issue->summary = $data1;
    $issue->description = $data2;
    $issue->priority_id = 3;
    $issue->status_id = $request->pipeline;
    $issue->assign_to = $request->get('user_id', 1);
    $issue->reported_by = 1;
    $issue->resolution_id = 8;
    $issue->contact_id = $contact->id;
    $issue->save();

    return $issue;
});

Route::get('/contact/{contact}', function (ContactModel $contact) {
    return $contact;
});

Route::post('contact/{contact}/update', function (ContactModel $contact, Request $request) {
    $contact->setAttribute($request->field, $request->value);
    $contact->save();

    return $contact;
});

Route::post('/contacts/{contact}', function (Request $request, ContactModel $contact) {
    $contact->fill($request->all());
    $contact->save();

    return $contact;
});