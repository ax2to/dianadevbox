@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <section class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('users.index') }}">Users</a></li>
                    <li class="active">{{ $user->fullName }}</li>
                </ol>
            </section>
            <section class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $user->fullName }}</div>
                    <div class="panel-body">
                        <div class="form-group col-md-4">
                            <label>ID</label>
                            <p>{{ $user->id }}</p>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Name</label>
                            <p>{{ $user->name }}</p>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Last Name</label>
                            <p>{{ $user->lastName }}</p>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Role</label>
                            <p>{{ $user->role->name }}</p>
                        </div>
                        <div class="form-group col-md-8">
                            <label>Email</label>
                            <p>{{ $user->email }}</p>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Created At</label>
                            <p>{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Updated At</label>
                            <p>{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <button class="btn btn-primary">Update</button>
                        <button class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection