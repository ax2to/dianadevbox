<?php

namespace App\Http\Controllers;

use App\Forms\IssueForm;
use App\Http\Requests\Issue\CreateRequest;
use App\Http\Requests\Issue\UpdateRequest;
use App\Models\IssueModel;
use App\Models\WorkLogModel;
use Auth;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $issues = IssueModel::all();

        return view('issues.index', compact('issues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('issues.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $issue = new IssueModel();
        $issue->fill($request->only($issue->getFillable()));
        $issue->reported_by = Auth::id();
        $issue->save();

        return redirect()->route('issues.index');
    }

    /**
     * Display the specified resource.
     *
     * @param IssueModel $issue
     * @return \Illuminate\Http\Response
     */
    public function show(IssueModel $issue)
    {
        return view('issues.show', compact('issue'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param IssueModel $issue
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(IssueModel $issue)
    {
        $form = new IssueForm($this->action = route('issues.update', $issue));
        $form->setModel($issue);

        return view('issues.edit', compact('issue', 'form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param IssueModel $issue
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, IssueModel $issue)
    {
        $issue->fill($request->only($issue->getFillable()));
        $issue->save();

        return redirect()->route('issues.show', $issue);
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

    public function changeStatus(IssueModel $issue, $status_id)
    {
        $issue->status_id = $status_id;
        $issue->save();

        //TODO move to events
        $workLog = new WorkLogModel();
        if ($status_id == 3) {
            $workLog->startLog($issue);
        } else {
            $workLog->stopLog();
        }

        return redirect()->route('issues.show', $issue);
    }
}
