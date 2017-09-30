<?php

namespace App\Http\Controllers;

use App\Forms\IssueForm;
use App\Http\Requests\Issue\CreateRequest;
use App\Http\Requests\Issue\UpdateRequest;
use App\Models\IssueModel;
use App\Models\WorkLogModel;
use App\User;
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
        $issues = IssueModel::where('company_id', Auth::user()->company_id)->allowedProjects();
        $issues = $this->applyFilter($issues, 'project_id');
        $issues = $this->applyFilter($issues, 'priority_id');
        $issues = $this->applyFilter($issues, 'status_id');
        $issues = $this->applyFilter($issues, 'resolution_id', 8);
        $issues = $this->applyFilter($issues, 'assign_to');
        $issues = $this->applyFilter($issues, 'reported_by');

        $search = request('search', null);
        if (request()->has('search')) {
            $issues->where('summary', 'Like', '%' . request('search') . '%');
        }

        $issues = $issues->leftJoin('issue_priorities', 'priority_id', '=', 'issue_priorities.id')
            ->select('issues.*')
            ->orderBy('issue_priorities.order', 'desc')
            ->paginate();
        return view('issues.index', compact('issues', 'search'));
    }

    public function applyFilter($model, $filter, $default = 'all')
    {
        if (request($filter, $default) != 'all') {
            $model->where($filter, request($filter, $default));
        }
        return $model;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = new IssueForm(route('issues.store'));

        return view('issues.create', compact('form'));
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
        $issue->company_id = Auth::user()->company_id;
        $issue->reported_by = Auth::id();
        $issue->save();

        flash(sprintf('The issue, %s, was created successfully.', $issue->summary))->success();

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

    public function changeStatus(IssueModel $issue, $status_id, $resolution_id = 8)
    {
        $issue->status_id = $status_id;
        $issue->save();

        //TODO move to events
        $workLog = new WorkLogModel();
        $workLog->stopLog();

        if ($status_id == 3) {
            $workLog->startLog($issue);
        }

        if ($status_id == 5 || $status_id == 2) {
            $issue->resolution_id = $resolution_id;
            $issue->save();
        }

        return redirect()->route('issues.show', $issue);
    }

    public function deriveTo(IssueModel $issue, User $user)
    {
        $issue->assign_to = $user->id;
        $issue->save();

        return redirect()->route('issues.show', $issue);
    }
}
