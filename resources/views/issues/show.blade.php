@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <section class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('projects.index') }}">Projects</a></li>
                    <li><a href="{{ route('projects.show', $issue->project) }}">{{ $issue->project->name }}</a></li>
                    <li><a href="{{ route('issues.index') }}">Issues</a></li>
                    <li class="active">{{ $issue->summary }}</li>
                </ol>
            </section>
            <section class="col-md-8">
                <div class="panel panel-default issue">
                    <div class="panel-heading">{{ $issue->summary }}</div>
                    <div class="panel-body">
                        <p>{!! $issue->description !!}</p>
                    </div>
                    <div class="panel-footer text-right">
                        <a href="{{ route('issues.edit', $issue) }}" class="btn btn-primary">Update</a>
                        <a href="#" class="btn btn-danger">Delete</a>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Attachments</div>
                    <div class="panel-body">
                        <div class="row">
                            @forelse($issue->attachments as $attachment)
                                @if($attachment->getMime() == 'image')
                                    <a href="{{ $attachment->getHref() }}" data-toggle="lightbox"
                                       data-gallery="attachments" class="col-md-2">
                                        <img src="{{ $attachment->getHref() }}"
                                             class="img-fluid img-responsive img-rounded img-thumbnail"/>
                                    </a>
                                @else
                                    <p>{{ $attachment->filename }}</p>
                                @endif
                            @empty
                                <p class="col-md-12">No attachments.</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            {{ Form::open(['route'=>['issues.attachments.store',$issue],'files'=>true]) }}
                            <div class="col-md-6">
                                <input type="file" name="attachments[]" multiple>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Comments</div>
                    <div class="panel-body">
                        @forelse($issue->comments as $comment)
                            <div class="comment">
                                <div class="row">
                                    <p class="col-md-6">
                                        <strong>{{ $comment->user->fullName }}</strong>
                                    </p>
                                    <p class="col-md-6 text-right">
                                        <strong>{{ Auth::user()->tzDateTime($comment->created_at) }}</strong>
                                    </p>
                                </div>
                                <p>{!! nl2br($comment->message) !!}</p>
                            </div>
                        @empty
                            <p>No Comments</p>
                        @endforelse
                    </div>
                    <div class="panel-footer">
                        <div class="row text-right">
                            <div class="col-md-12">
                                {{ Form::open(['route'=>['issues.comments.store',$issue]]) }}
                                <textarea name="message" class="form-control"></textarea>
                                <button class="btn btn-primary">Save</button>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Details</div>
                    <div class="panel-body">
                        <div class="form-group col-md-4">
                            <label>Project</label>
                            <p>{{ $issue->project->name }}</p>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Type</label>
                            <p>{{ $issue->type->name }}</p>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Priority</label>
                            <p>{{ $issue->priority->name }}</p>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Status</label>
                            <p>{{ $issue->status->name }}</p>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Resolution</label>
                            <p>{{ $issue->resolution->name ?? 'None' }}</p>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Resolution Date</label>
                            <p>-</p>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Created at</label>
                            <p>{{ Auth::user()->tzDateTime($issue->created_at) }}</p>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Updated at</label>
                            <p>{{ Auth::user()->tzDateTime($issue->updated_at) }}</p>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        @can('stop-progress',$issue)
                            <a href="{{ route('issues.change-status',[$issue,2]) }}" class="btn btn-default">Stop
                                Progress</a>
                        @endcan
                        @can('start-progress',$issue)
                            <a href="{{ route('issues.change-status',[$issue,3]) }}" class="btn btn-default">Start
                                Progress</a>
                        @endcan

                        @can('resolve',$issue)
                            <a href="{{ route('issues.change-status',[$issue,4]) }}"
                               class="btn btn-primary">Resolve</a>
                        @endcan
                        @can('reopen',$issue)
                            <a href="{{ route('issues.change-status',[$issue,2]) }}"
                               class="btn btn-primary">Reopen</a>
                        @endcan
                        @can('close',$issue)
                            <span>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Close <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{ route('issues.change-status',[$issue,5,1]) }}">Done</a></li>
                                        <li><a href="{{ route('issues.change-status',[$issue,5,2]) }}">Fixed</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="{{ route('issues.change-status',[$issue,5,3]) }}">Rejected</a></li>
                                        <li><a href="{{ route('issues.change-status',[$issue,5,4]) }}">Duplicate</a></li>
                                        <li><a href="{{ route('issues.change-status',[$issue,5,5]) }}">Won't Fix</a></li>
                                        <li><a href="{{ route('issues.change-status',[$issue,5,6]) }}">Won't Do</a></li>
                                        <li><a href="{{ route('issues.change-status',[$issue,5,7]) }}">Cannot Reproduce</a></li>
                                    </ul>
                                </div>
                            </span>
                        @endcan
                    </div>
                </div>
            </section>
            <section class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">People</div>
                    <div class="panel-body">
                        <div class="form-group col-md-6">
                            <label>Assigned To</label>
                            <p>{{ $issue->assign->fullName }}</p>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Reported By</label>
                            <p>{{ $issue->reported->fullName }}</p>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <span>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Derive <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    @foreach(\App\User::orderBy('name')->where('company_id',Auth::user()->company_id)->orderBy('lastName')->get() as $user)
                                        <li><a href="{{ route('issues.derive-to',[$issue,$user]) }}">{{ $user->fullName }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </span>
                        <a href="{{ route('issues.derive-to',[$issue,1]) }}" class="btn btn-primary">Claim</a>
                    </div>
                </div>
            </section>
            <section class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Work log</div>
                    <div class="panel-body">
                        <table class="table">
                            @foreach($issue->workLogs as $workLog)
                                <tr>
                                    @if($workLog->in_progress)
                                        <td>working</td>
                                    @else
                                        <td>{{ link_to_route('work-logs.show',$workLog->worked,[$workLog]) }}</td>
                                    @endif
                                    <td>{{ $workLog->description }}</td>
                                    <td>{{ $workLog->user->fullName }}</td>
                                    <td class="text-right">{{ $workLog->date->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="panel-footer text-right">
                        <a href="{{ route('work-logs.create',['issue_id'=>$issue]) }}" class="btn btn-primary">Add</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            $('.panel.issue table').addClass('table');
        });
    </script>
@endpush