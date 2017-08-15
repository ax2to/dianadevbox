<?php

namespace App\Http\Controllers;

use App\Models\IssueModel;
use App\Models\WorkLogModel;
use Illuminate\Http\Request;

class WorkLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workLogs = WorkLogModel::where('in_progress', false)->get();

        return view('work-logs.index', compact('workLogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('work-logs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $workLog = new WorkLogModel();
        $workLog->issue_id = $request->issue_id;
        $workLog->user_id = \Auth::id();
        $workLog->worked = $workLog->convertString2DateInterval($request->worked);
        $workLog->date = $request->date;
        $workLog->description = $request->description;
        $workLog->save();

        return redirect()->route('work-logs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param WorkLogModel $workLog
     * @return \Illuminate\Http\Response
     */
    public function show(WorkLogModel $workLog)
    {
        return view('work-logs.show', compact('workLog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param WorkLogModel $workLog
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkLogModel $workLog)
    {
        return view('work-logs.edit', compact('workLog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param WorkLogModel $workLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkLogModel $workLog)
    {
        $workLog->issue_id = $request->issue_id;
        $workLog->worked = $workLog->convertString2DateInterval($request->worked);
        $workLog->date = $request->date;
        $workLog->description = $request->description;
        $workLog->save();

        return redirect()->route('work-logs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function timesheet()
    {
        $days_of_month = date('t');
        $issues = IssueModel::all();
        return view('work-logs.timesheet', compact('days_of_month', 'issues'));
    }
}
