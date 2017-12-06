@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <section class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('projects.index') }}">Projects</a></li>
                    <li><a href="{{ route('projects.show', $goal->project) }}">{{ $goal->project->name }}</a></li>
                    <li class="active">{{ $goal->name }}</li>
                </ol>
            </section>
        </div>
        <div class="row">
            <div class="col-md-8">
                <section class="panel panel-default issue">
                    <div class="panel-heading">{{ $goal->name }}</div>
                    <div class="panel-body">
                        <p>{!! $goal->description !!}</p>
                    </div>
                    <div class="panel-footer text-right">
                        <a href="{{ route('goals.edit', $goal) }}" class="btn btn-primary">Update</a>
                        <a href="#" class="btn btn-danger">Delete</a>
                    </div>
                </section>
                <section class="panel panel-default issue">
                    <div class="panel-heading">Issues</div>
                    <div class="panel-body">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>Issue</th>
                                <th>Status</th>
                                <th>Resolution</th>
                                <th>Asigned To</th>
                                <th>Time Estimated</th>
                                <th>Time Spent</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($goal->issues()->orderBy('summary')->get() as $issue)
                                <tr
                                        @if($issue->resolution_id == 1 || $issue->resolution_id == 2 ) class="success"
                                        @elseif($issue->status_id == 4) class="warning"
                                        @elseif($issue->resolution_id == 5 || $issue->resolution_id == 6) class="danger"
                                        @endif>
                                    <td>{{ link_to_route('issues.show',$issue->summary,[$issue]) }}</td>
                                    <td>{{ $issue->status->name }}</td>
                                    <td>{{ $issue->resolution->name }}</td>
                                    <td>{{ $issue->assign->fullName }}</td>
                                    <td>{{ $issue->estimated }}</td>
                                    <td>{{ $issue->spent }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">
                        {{ Form::open(['url' => route('goals.add',$goal)]) }}
                        <div class="btn-group">
                            {{ Form::select('issue_id', $issues, null, ['class'=>'form-control select2']) }}
                        </div>
                        <button class="btn btn-primary">Add</button>
                        {{ Form::close() }}
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="panel panel-default issue">
                    <div class="panel-heading">Progress</div>
                    <div class="panel-body">
                        <table class="table table-responsive">
                            <tr>
                                <th>Completed</th>
                                <td>{{ $goal->progressCompleted() }} %</td>
                            </tr>
                            <tr>
                                <th>Start Date</th>
                                <td>{{ $goal->start_at }}</td>
                            </tr>
                            <tr>
                                <th>Due Date</th>
                                <td>{{ $goal->end_at }}</td>
                            </tr>
                            <tr>
                                <th>Overall Time Estimated</th>
                                <td>{{ $goal->overallTimeEstimated() }} H</td>
                            </tr>
                            <tr>
                                <th>Overall Time Spent</th>
                                <td>{{ $goal->overallTimeSpent() }} H</td>
                            </tr>
                            <tr>
                                <th>Overall Time Remaining</th>
                                <td>{{ $goal->overallTimeRemaining() }} H</td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel-footer text-right"></div>
                </section>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            $('.panel.issue table').addClass('table');
        });
    </script>
@endpush