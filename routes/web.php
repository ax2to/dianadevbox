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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'ProjectController@index')->name('projects.index');

    Route::post('users/{user}/change-password', 'UserController@changePassword')->name('users.change-password');
    Route::resource('users', 'UserController');
    Route::resource('projects', 'ProjectController');

    Route::get('issues/{issue}/change-status/{status}/{resolution?}', 'IssueController@changeStatus')->name('issues.change-status');
    Route::get('issues/{issue}/derive-to/{user}', 'IssueController@deriveTo')->name('issues.derive-to');
    Route::resource('issues', 'IssueController');

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
    $now = \Carbon\Carbon::now();
    $now->tz = new DateTimeZone('America/Lima');
    $now->day = 15;
    dump($now);
    $logs = \App\Models\WorkLogModel::whereDate('created_at', $now)->get();
    foreach ($logs as $log) {
        dump($log->created_at);
    }
});