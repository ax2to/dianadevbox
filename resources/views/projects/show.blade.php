@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <section class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('projects.index') }}">Projects</a></li>
                    <li class="active">{{ $project->name }}</li>
                </ol>
            </section>
        </div>
        <div class="row">
            <section class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $project->name }}</div>
                    <div class="panel-body">
                        <p>{!! nl2br($project->description) !!}</p>
                    </div>
                    <div class="panel-footer text-right">
                        @can('update', $project)
                            <a href="{{ route('projects.edit', $project) }}" class="btn btn-primary">Update</a>
                        @endcan
                        @can('delete', $project)
                            <a href="#" class="btn btn-danger">Delete</a>
                        @endcan
                    </div>
                </div>
            </section>
            <section class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Issues</div>
                    <div class="panel-body">
                        <table class="table table-responsive">
                            @foreach(\App\Models\Issue\StatusModel::all() as $status)
                                <tr>
                                    <td>{{ $status->name }}</td>
                                    <td>{{ $project->issues()->where('status_id',$status->id)->get()->count() }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="panel-footer text-right">

                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Members</div>
                    <div class="panel-body">
                        <table class="table table-responsive">
                            @foreach($project->members as $member)
                                <tr>
                                    <td>{{ $member->fullName }}</td>
                                    <td class="text-right">
                                        @can('remove-member',$project)
                                            <a href="{{ route('projects.add-member', [$project, $member]) }}"
                                               class="btn btn-danger">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="panel-footer text-right">
                        @can('add-member',$project)
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Add Member <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    @foreach($project->company->users as $user)
                                        <li>
                                            <a href="{{ route('projects.add-member', [$project, $user]) }}">
                                                {{ $user->fullName }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endcan
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
