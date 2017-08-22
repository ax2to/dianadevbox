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
                {{ $form->open() }}
                <div class="panel panel-default">
                    <div class="panel-heading">Create new user</div>
                    <div class="panel-body">
                        {!! $form->body() !!}
                    </div>
                    <div class="panel-footer text-right">
                        <a href="{{ route('issues.index') }}" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                {{ $form->close() }}
            </div>
        </section>
    </div>
@endsection
