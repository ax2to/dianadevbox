@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('users.index') }}">Users</a></li>
                    <li><a href="{{ route('users.show',$user) }}">{{ $user->fullName }}</a></li>
                    <li class="active">Update</li>
                </ol>
            </div>
        </section>
        <section class="row">
            <div class="col-md-6">
                {{ $form->open() }}
                <div class="panel panel-default">
                    <div class="panel-heading">Update user</div>
                    <div class="panel-body">
                        {!! $form->body() !!}
                    </div>
                    <div class="panel-footer text-right">
                        <a href="{{ route('issues.index') }}" class="btn btn-default">Cancel</a>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
                {{ $form->close() }}
            </div>
            <div class="col-md-6">
                {{ $form2->open() }}
                <div class="panel panel-default">
                    <div class="panel-heading">Change password</div>
                    <div class="panel-body">
                        {!! $form2->body() !!}
                    </div>
                    <div class="panel-footer text-right">
                        <a href="{{ route('issues.index') }}" class="btn btn-default">Cancel</a>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
                {{ $form2->close() }}
            </div>
        </section>
    </div>
@endsection
