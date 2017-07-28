@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('projects.index') }}">Projects</a></li>
                    <li><a href="{{ route('issues.index') }}">Issues</a></li>
                    <li class="active">WorkLogs</li>
                </ol>
            </div>
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
                                <th>WorkLog</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Issue</th>
                                <th>Project</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($workLogs as $workLog)
                                <tr>
                                    <td>{{ $workLog->id }}</td>
                                    <td>{{ $workLog->worked2string }}</td>
                                    <td>{{ $workLog->description }}</td>
                                    <td>{{ $workLog->date }}</td>
                                    <td>{{ $workLog->issue->id }}</td>
                                    <td>{{ $workLog->issue->project->name }}</td>
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
