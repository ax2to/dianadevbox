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
        <section class="row">
            <div class="col-md-8">
                <form>
                    Filters:
                    <label>Project</label>
                    {{ Form::projects('project_id', null, ['all' => true]) }}
                    <label>Status</label>
                    {{ Form::issueStatus('status', null, ['all' => true]) }}
                    <label>Resolution</label>
                    {{ Form::issueResolutions('resolution', null, ['all' => true]) }}
                    <label>Assigned To</label>
                    {{ Form::users('assign_to', null, ['all' => true]) }}
                    <button>Apply</button>
                </form>
            </div>
            <div class="col-md-4">b</div>
        </section>
        <div class="panel panel-default">
            <div class="panel-heading">Issues</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-responsive table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Project</th>
                                <th>Summary</th>
                                <th>Type</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Resolution</th>
                                <th>Reported By</th>
                                <th>Assigned To</th>
                                <th>Created At</th>
                                <th>Updated At</th>
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
                                    <td>{{ $issue->reported->fullName }}</td>
                                    <td>{{ $issue->assign->fullName }}</td>
                                    <td>{{ $issue->created_at->format('d/m/y H:i') }}</td>
                                    <td>{{ $issue->updated_at->format('d/m/y H:i') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
