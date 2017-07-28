@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('projects.index') }}">Projects</a></li>
                    <li><a href="{{ route('issues.index') }}">Issues</a></li>
                    <li><a href="{{ route('work-logs.index') }}">Work Logs</a></li>
                    <li class="active">New</li>
                </ol>
            </div>
        </section>
        <section class="row">
            <div class="col-md-12">
                {{ Form::open(['route'=>'work-logs.store']) }}
                <div class="panel panel-default">
                    <div class="panel-heading">Create new work log</div>
                    <div class="panel-body">
                        <div class="form-group col-md-12">
                            {{ Form::label('issue_id','Issue') }}
                            {{ Form::issues('issue_id',null,['class'=>'form-control']) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('worked','Worked') }}
                            {{ Form::text('worked', old('worked', '1H'), ['class'=>'form-control']) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('date','Date') }}
                            {{ Form::text('date', old('date',date('Y-m-d H:i:s')),['class'=>'form-control']) }}
                        </div>
                        <div class="form-group col-md-12">
                            {{ Form::label('description','Description') }}
                            {{ Form::textarea('description',null,['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <a href="{{ route('issues.index') }}" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </section>
    </div>
@endsection
