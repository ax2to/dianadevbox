@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <panel header="Tickets" footer="footer">
            <pipeline user_id="{{ auth()->id() }}" role_id="{{ auth()->user()->role_id }}"></pipeline>
            <create user_id="{{ auth()->id() }}"></create>
            <datagrid user_id="{{ auth()->id() }}" role_id="{{ auth()->user()->role_id }}"></datagrid>
        </panel>
    </div>
@endsection