<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\ProjectModel;
use App\User;
use Auth;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = ProjectModel::where('company_id', Auth::user()->company_id)->get();

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project = new ProjectModel();
        $project->company_id = Auth::user()->company_id;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->save();

        flash(sprintf('The project, %s, was created successfully.', $project->name))->success();

        return redirect()->route('projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param ProjectModel $project
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectModel $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ProjectModel $project
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectModel $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectRequest $request
     * @param ProjectModel $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, ProjectModel $project)
    {
        $project->fill($request->validated());
        $project->save();

        flash(sprintf('The project, %s, was updated successfully.', $project->name))->success();

        return redirect()->route('projects.index');
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

    public function addMember(ProjectModel $project, User $user)
    {
        $project->members()->toggle($user);

        flash(sprintf('The user, %s, was added successfully.', $user->fullName));

        return redirect()->route('projects.show', $project);
    }
}
