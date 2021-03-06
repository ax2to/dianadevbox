@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('projects.index') }}">Projects</a></li>
                    <li><a href="{{ route('issues.index') }}">Issues</a></li>
                    <li><a href="{{ route('work-logs.index') }}">Work Logs</a></li>
                    <li class="active">Timesheet</li>
                </ol>
            </div>
        </section>
        <div class="panel panel-default">
            <div class="panel-heading">Timesheet</div>
            <div class="panel-body">
                <section class="row">
                    <div class="form-group col-md-6">
                        @can('change-user',$timesheet)
                            <form class="form-inline" action="{{ route('work-logs.timesheet',$params) }}">
                                {{ Form::label('user_id','User') }}
                                {{ Form::select('user_id',$users,['user_id'=>Auth::id()]+$params,['class'=>'form-control']) }}
                                <input type="hidden" name="range" value="{{ request('range','week') }}">
                                <input type="hidden" name="mod" value="{{ request('mod',$mod) }}">
                                <button class="btn btn-primary">Go!</button>
                            </form>
                        @endcan
                    </div>
                    <div class="form-group col-md-6 text-right">
                        <div class="btn-group" role="group" aria-label="...">
                            <a href="{{ route('work-logs.timesheet',['mod'=>$mod-1]+$params) }}"
                               type="button" class="btn btn-default">&lt;</a>
                            <a href="{{ route('work-logs.timesheet',['range'=>'day']+$params) }}"
                               type="button" class="btn btn-default">Day</a>
                            <a href="{{ route('work-logs.timesheet',['range'=>'week']+$params) }}"
                               type="button" class="btn btn-default">Week</a>
                            <a href="{{ route('work-logs.timesheet',['range'=>'month']+$params) }}"
                               type="button" class="btn btn-default">Month</a>
                            <a href="{{ route('work-logs.timesheet',['mod'=>$mod+1]+$params) }}"
                               type="button" class="btn btn-default">&gt;</a>
                        </div>
                    </div>
                </section>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-responsive table-bordered table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                @foreach($timesheet->getDays() as $date)
                                    <th class="text-center">{{ $date->day}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Summary</th>
                                <th class="text-center">Hours</th>
                                @foreach($timesheet->getDays() as $date)
                                    <th class="text-center">{{ $date->format('D') }}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($timesheet->getProjects() as $project)
                                <tr style="background-color: #f0efef">
                                    <th colspan="{{ $timesheet->getDays()->count() + 4 }}">{{ $project->name }}</th>
                                </tr>
                                @foreach($timesheet->getIssuesByProject($project) as $issue)
                                    <tr>
                                        <td>{{ link_to_route('issues.show',$issue->summary,[$issue]) }}</td>
                                        <th class="text-center">{{ $timesheet->getHoursByIssue($issue) }}</th>
                                        @foreach($timesheet->getDays() as $date)
                                            <td class="text-center">{{ $timesheet->getHoursByIssueInDate($issue,$date) }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Total</th>
                                <th></th>
                                @foreach($timesheet->getDays() as $date)
                                    <th class="text-center">{{ $timesheet->getHoursByDate($date) }}</th>
                                @endforeach
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
