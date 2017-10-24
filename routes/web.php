<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\DB;

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'ProjectController@index')->name('projects.index');

    Route::post('users/{user}/change-password', 'UserController@changePassword')->name('users.change-password');
    Route::resource('users', 'UserController');

    Route::get('projects/{project}/add-member/{user}', 'ProjectController@addMember')->name('projects.add-member');
    Route::resource('projects', 'ProjectController');

    Route::resource('goals', 'GoalController');
    Route::post('goals/{goal}/add', 'GoalController@add')->name('goals.add');


    Route::get('issues/{issue}/change-status/{status}/{resolution?}', 'IssueController@changeStatus')->name('issues.change-status');
    Route::get('issues/{issue}/derive-to/{user}', 'IssueController@deriveTo')->name('issues.derive-to');
    Route::resource('issues', 'IssueController');

    Route::resource('tickets', 'TicketController');

    Route::get('work-logs/timesheet', 'WorkLogController@timesheet')->name('work-logs.timesheet');
    Route::resource('work-logs', 'WorkLogController');


    Route::group(['namespace' => 'Issue', 'prefix' => 'issues', 'as' => 'issues.'], function () {
        Route::post('{issue}/attachments/store', 'AttachmentController@store')->name('attachments.store');
    });

    Route::group(['namespace' => 'Issue', 'prefix' => 'issues', 'as' => 'issues.'], function () {
        Route::post('{issue}/comments/store', 'CommentController@store')->name('comments.store');
    });
});

Route::get('testing', function () {
    $rows = DB::table('data.data_tmp')->skip(11653)->take(2500)->get();
    foreach ($rows as $row) {
        // contact
        $contact = new \App\Models\ContactModel();
        $contact->company = $row->col7;
        $contact->name = $row->col1;
        $contact->lastname = $row->col2;
        $contact->country = $row->col3;
        $contact->email1 = $row->col4;
        $contact->phone1 = $row->col9;
        $contact->phone2 = $row->col10;
        $contact->address = $row->col18;
        $contact->city = $row->col22;
        $contact->save();


        // issue
        $data1 = '';
        if ($row->col7 != '') {
            $data1 .= $row->col7;
        } else {
            $data1 = 'lead';
        }

        $data2 = '';
        foreach ($row as $string) {
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
        $issue->status_id = 6;
        $issue->assign_to = 1;
        $issue->reported_by = 1;
        $issue->resolution_id = 8;
        $issue->contact_id = $contact->id;
        $issue->save();
    }
});