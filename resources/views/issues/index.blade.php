@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="#">Projects</a></li>
                    <li class="active">Issues</li>
                </ol>
            </div>
        </section>
        @include('flash::message')
        <section class="panel panel-default">
            <div class="panel-heading">
                Issues
                <form class="pull-right">
                    <div class="input-group">
                        <input name="search" class="form-control" placeholder="Search">
                        <div class="input-group-btn">
                            <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="panel-body">
                <section class="row">
                    <div class="col-md-12">
                        <form>
                            <label>Project</label>
                            {{ Form::projects('project_id', request('project_id'), ['all' => true, 'class' => 'select2']) }}
                            <label>Status</label>
                            {{ Form::issueStatus('status_id', request('status_id'), ['all' => true, 'class' => 'select2']) }}
                            <label>Resolution</label>
                            {{ Form::issueResolutions('resolution_id', request('resolution_id', 8), ['all' => true, 'class' => 'select2']) }}
                            <label>Assigned To</label>
                            {{ Form::users('assign_to', request('assign_to'), ['all' => true, 'class' => 'select2']) }}
                            <button class="btn btn-primary">Apply</button>
                        </form>
                    </div>
                </section>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-responsive table-bordered table-striped" style="margin-top: 20px">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Project</th>
                                <th>Summary</th>
                                <th>Type</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Resolution</th>
                                <th>Assigned To</th>
                                <th>Reported By</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($issues as $issue)
                                <tr>
                                    <td>{{ $issue->id }}</td>
                                    <td>{{ $issue->project->name }}</td>
                                    <td><a href="{{ route('issues.show',$issue) }}">{{ $issue->summary }}</a></td>
                                    <td>{{ $issue->type->name }}</td>
                                    <td>{{ $issue->priority->name }}</td>
                                    <td>{{ $issue->status->name }}</td>
                                    <td>{{ $issue->resolution->name ?? 'None' }}</td>
                                    <td>{{ $issue->assign->fullName }}</td>
                                    <td>{{ $issue->reported->fullName }}</td>
                                    <td>{{ Auth::user()->tzDateTime($issue->created_at) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                {{ $issues->appends(request()->all())->links() }}
            </div>
        </section>
    </div>
@endsection
