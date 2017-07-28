@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('users.index') }}">Users</a></li>
                    <li class="active">New</li>
                </ol>
            </div>
        </section>
        <section class="row">
            <div class="col-md-12">
                {{ Form::open(['route'=>'users.store']) }}
                <div class="panel panel-default">
                    <div class="panel-heading">Create new user</div>
                    <div class="panel-body">
                        <div class="form-group col-md-6">
                            {{ Form::label('name','Name') }}
                            {{ Form::text('name',null,['class'=>'form-control']) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('lastName','Last Name') }}
                            {{ Form::text('lastName',null,['class'=>'form-control']) }}
                        </div>
                        <div class="form-group col-md-12">
                            {{ Form::label('email','Email') }}
                            {{ Form::text('email',null,['class'=>'form-control']) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('password','Password') }}
                            {{ Form::text('password',null,['class'=>'form-control']) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('password_confirmation','Confirm Password') }}
                            {{ Form::text('password_confirmation',null,['class'=>'form-control']) }}
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
