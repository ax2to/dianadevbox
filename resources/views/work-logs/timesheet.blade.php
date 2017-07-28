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
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-responsive table-bordered table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                @for($i = 1; $i <= $days_of_month; $i++)
                                    <th class="text-center">{{ $i }}</th>
                                @endfor
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Summary</th>
                                <th class="text-center">Hours</th>
                                @for($i = 1; $i <= $days_of_month; $i++)
                                    <th class="text-center">{{ date('D',mktime(0,0,0,date('m'),$i)) }}</th>
                                @endfor
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($issues as $issue)
                                <tr>
                                    <td>{{ $issue->id }}</td>
                                    <td>{{ $issue->summary }}</td>
                                    <th class="text-center">{{ $issue->workLogInHours() }}</th>
                                    @for($i = 1; $i <= $days_of_month; $i++)
                                        <td class="text-center">{{ $issue->workLogInHoursByDate(date('Y-m-'.$i)) }}</td>
                                    @endfor
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
