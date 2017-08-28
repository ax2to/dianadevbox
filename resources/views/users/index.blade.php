@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li class="active">Users</li>
                </ol>
            </div>
        </section>
        @include('flash::message')
        <section class="panel panel-default">
            <div class="panel-heading">Users</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-responsive table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Role</th>
                                <th>Name</th>
                                <th>LastName</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->role->name }}</td>
                                    <td>{{ link_to_route('users.show',$user->name,$user) }}</td>
                                    <td>{{ link_to_route('users.show',$user->lastName,$user) }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d/m/y H:i') }}</td>
                                    <td>{{ $user->updated_at->format('d/m/y H:i') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
