<?php

use App\Mail\CommentMail;
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

Route::get('/status', function (Request $request) {
    $status = \App\Models\Issue\StatusModel::where('workflow_id', 2)->get();
    $data = [];
    foreach ($status as $s) {
        $issues = \App\Models\IssueModel::where('type_id', 5)->where('status_id', $s->id);
        $data[] = ['id' => $s->id, 'name' => $s->name, 'count' => $issues->count()];
    }
    return $data;
});

Route::get('/tickets/{id?}', function (Request $request, $id = 6) {
    $issues = \App\Models\IssueModel::where('type_id', 5)->where('status_id', $id)
        ->with(['status', 'contact'])
        ->paginate(20);

    return $issues;
});

Route::post('/ticket/{issue}/status/{status}', function (\App\Models\IssueModel $issue, $status) {
    $issue->status_id = $status;
    $issue->save();

    return $issue;
});

Route::post('/contacts/{contact}', function (Request $request, \App\Models\ContactModel $contact) {
    $contact->fill($request->all());
    $contact->save();

    return $contact;
});

Route::get('/ticket/{ticket}/comments', function ($ticket) {
    $comments = \App\Models\Issue\CommentModel::with('user')
        ->where('issue_id', $ticket)
        ->paginate();

    return $comments;
});

Route::post('/ticket/{ticket}/comment', function (Request $request) {
    $comment = new \App\Models\Issue\CommentModel();
    $comment->fill($request->all());
    $comment->save();

    if ($request->get('email')) {
        $issue = \App\Models\IssueModel::find($request->get('issue_id'));
        $contact = \App\Models\ContactModel::find($issue->contact_id);
        if ($contact->email1 != '') {
            Mail::to($contact->email1)->send(new CommentMail($comment));
        }
        if ($contact->email2 != '') {
            Mail::to($contact->email2)->send(new CommentMail($comment));
        }
    }

    return $comment;
});