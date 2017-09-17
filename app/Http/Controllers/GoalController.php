<?php

namespace App\Http\Controllers;

use App\Forms\GoalForm;
use App\Http\Requests\GoalRequest;
use App\Models\GoalModel;
use App\Models\IssueModel;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goals = GoalModel::paginate();

        return view('goals.index', compact('goals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = new GoalForm(route('goals.store'));

        return view('goals.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GoalRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(GoalRequest $request)
    {
        $goal = new GoalModel();
        $goal->fill($request->validated());
        $goal->save();

        flash(sprintf('The goal, %s, was created successfully.', $goal->name))->success();

        return redirect()->route('goals.index');
    }

    /**
     * Display the specified resource.
     *
     * @param GoalModel $goal
     * @return \Illuminate\Http\Response
     * @internal param GoalModel $goalModel
     */
    public function show(GoalModel $goal)
    {
        $issues = IssueModel::all()->pluck('fullName', 'id')->toArray();

        return view('goals.show', compact('goal', 'issues'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param GoalModel $goal
     * @return \Illuminate\Http\Response
     * @internal param GoalModel $goalModel
     */
    public function edit(GoalModel $goal)
    {
        $form = new GoalForm(route('goals.update', $goal), 'PUT');
        $form->setModel($goal);

        return view('goals.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GoalRequest|Request $request
     * @param  \App\Models\GoalModel $goal
     * @return \Illuminate\Http\Response
     */
    public function update(GoalRequest $request, GoalModel $goal)
    {
        $goal->fill($request->validated());
        $goal->save();

        flash(sprintf('The goal, %s, was updated successfully.', $goal->name))->success();

        return redirect()->route('goals.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GoalModel $goal
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoalModel $goal)
    {
        //
    }

    public function add(GoalModel $goal)
    {
        $issue = IssueModel::findOrFail(request('issue_id'));
        $goal->issues()->save($issue);

        return redirect()->route('goals.show', $goal);
    }
}
