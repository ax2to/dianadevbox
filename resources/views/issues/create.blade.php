@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="#">Projects</a></li>
                    <li><a href="{{ route('issues.index') }}">Issues</a></li>
                    <li class="active">New</li>
                </ol>
            </div>
        </section>
        <section class="row">
            <div class="col-md-12">
                {{ Form::open(['route'=>'issues.store']) }}
                <div class="panel panel-default">
                    <div class="panel-heading">Create new issue</div>
                    <div class="panel-body">
                        <div class="form-group col-md-6">
                            {{ Form::label('project_id','Project') }}
                            {{ Form::projects('project_id',null,['class'=>'form-control']) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('type_id','Issue Type') }}
                            {{ Form::issueTypes('type_id',null,['class'=>'form-control']) }}
                        </div>
                        <div class="form-group col-md-12">
                            {{ Form::label('summary','Summary') }}
                            {{ Form::text('summary',null,['class'=>'form-control']) }}
                        </div>
                        <div class="form-group col-md-12">
                            {{ Form::label('description','Description') }}
                            {{ Form::textarea('description',null,['class'=>'form-control']) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('priority_id','Priority') }}
                            {{ Form::priorities('priority_id',null,['class'=>'form-control']) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('assign_to','Assign to') }}
                            {{ Form::users('assign_to',null,['class'=>'form-control']) }}
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
