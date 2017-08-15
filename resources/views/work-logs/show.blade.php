@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <section class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('projects.index') }}">Projects</a></li>
                    <li>
                        <a href="{{ route('projects.show', $workLog->issue->project) }}">{{ $workLog->issue->project->name }}</a>
                    </li>
                    <li><a href="{{ route('issues.index') }}">Issues</a></li>
                    <li><a href="{{ route('work-logs.index') }}">Work logs</a></li>
                    <li class="active">{{ $workLog->id }}</li>
                </ol>
            </section>
            <section class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Work log #{{ $workLog->id }}</div>
                    <div class="panel-body">
                        <div class="form-group col-md-12">
                            {{ Form::label('issue_id','Issue') }}
                            <p>{{ $workLog->issue->summary }}</p>
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('worked','Worked') }}
                            <p>{{ $workLog->worked2string }}</p>
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('date','Date') }}
                            <p>{{ $workLog->date }}</p>
                        </div>
                        <div class="form-group col-md-12">
                            {{ Form::label('description','Description') }}
                            <p>{!! nl2br($workLog->description) !!}</p>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <a href="{{ route('work-logs.index') }}" class="btn btn-default">Volver</a>
                        <a href="{{ route('work-logs.edit', $workLog) }}" class="btn btn-primary">Update</a>
                        <a href="#" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('scripts')

@endpush