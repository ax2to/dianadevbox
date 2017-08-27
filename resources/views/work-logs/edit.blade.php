@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('projects.index') }}">Projects</a></li>
                    <li><a href="{{ route('issues.index') }}">Issues</a></li>
                    <li><a href="{{ route('work-logs.index') }}">Work Logs</a></li>
                    <li class="active">Update</li>
                </ol>
            </div>
        </section>
        <section class="row">
            <div class="col-md-12">
                {{ $form->open() }}
                <div class="panel panel-default">
                    <div class="panel-heading">Update Work log # {{ $workLog->id }}</div>
                    <div class="panel-body">
                        {!! $form->body() !!}
                    </div>
                    <div class="panel-footer text-right">
                        <a href="{{ route('work-logs.index') }}" class="btn btn-default">Cancel</a>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
                {{ $form->close() }}
            </div>
        </section>
    </div>
@endsection
