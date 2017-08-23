<?php

namespace App\Http\Controllers\Issue;

use App\Http\Controllers\Controller;
use App\Http\Requests\Issue\Attachment\CreateRequest;
use App\Models\Issue\AttachmentModel;
use App\Models\IssueModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IssueModel $issue
     * @param CreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(IssueModel $issue, CreateRequest $request)
    {
        foreach ($request->attachments as $file) {
            $filename = $issue->id . '-' . str_random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs(AttachmentModel::PATH_ISSUES, $filename);
            Storage::setVisibility($path, 'public');

            $issue->attach($file, $filename);
        }

        return redirect()->route('issues.show', $issue);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
