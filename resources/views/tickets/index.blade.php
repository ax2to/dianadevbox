@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <panel header="Tickets" footer="footer">
            <datagrid user_id="{{ auth()->id() }}"></datagrid>
        </panel>
    </div>
@endsection