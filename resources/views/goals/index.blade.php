@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="#">Projects</a></li>
                    <li class="active">Goals</li>
                </ol>
            </div>
        </section>
        @include('flash::message')
        <section class="panel panel-default">
            <div class="panel-heading">
                Goals
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-responsive table-bordered table-striped" style="margin-top: 20px">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Project</th>
                                <th>Goal</th>
                                <th>Completed</th>
                                <th>Due Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($goals as $goal)
                                <tr>
                                    <td>{{ $goal->id }}</td>
                                    <td>{{ link_to_route('projects.show',$goal->project->name,[$goal->project]) }}</td>
                                    <td>{{ link_to_route('goals.show',$goal->name,[$goal]) }}</td>
                                    <td>{{ $goal->progressCompleted() }}%</td>
                                    <td>{{ $goal->end_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                {{ $goals->appends(request()->all())->links() }}
            </div>
        </section>
    </div>
@endsection
