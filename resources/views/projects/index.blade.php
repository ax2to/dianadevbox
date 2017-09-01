@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li class="active">Projects</li>
                </ol>
            </div>
        </section>
        @include('flash::message')
        <section>
            @foreach($projects as $project)
                @can('view',$project)
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">{{ link_to_route('projects.show', $project->name, [$project->id])  }}</div>
                            <div class="panel-body">
                                <table class="table">
                                    <tr>
                                        <th>Issues</th>
                                        <th>{{ $project->issues->count() }}</th>
                                    </tr>
                                    @foreach(\App\Models\Issue\StatusModel::all() as $status)
                                        <tr>
                                            <td>{{ $status->name }}</td>
                                            <td>{{ $project->issues()->where('status_id',$status->id)->get()->count() }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                @endcan
            @endforeach
        </section>

    </div>
@endsection
