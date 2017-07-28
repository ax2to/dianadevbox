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
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $issue->summary }}</div>
                    <div class="panel-body">
                        <p>{!! nl2br($issue->description) !!}</p>
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
                                        <strong>{{ $comment->created_at->format('d/m/Y H:i') }}</strong>
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
                        <div class="form-group col-md-6">
                            <label>Project</label>
                            <p>{{ $issue->project->name }}</p>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Type</label>
                            <p>{{ $issue->type->name }}</p>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Priority</label>
                            <p>{{ $issue->priority->name }}</p>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Status</label>
                            <p>{{ $issue->status->name }}</p>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Resolution</label>
                            <p>{{ $issue->resolution->name ?? 'None' }}</p>
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
                            <a href="{{ route('issues.change-status',[$issue,5]) }}"
                               class="btn btn-danger">Close</a>
                        @endcan
                    </div>
                </div>
            </section>
            <section class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">People</div>
                    <div class="panel-body">
                        <div class="form-group col-md-6">
                            <label>Reported By</label>
                            <p>{{ $issue->reported->fullName }}</p>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Assigned To</label>
                            <p>{{ $issue->assign->fullName }}</p>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <a href="" class="btn btn-default">Derive</a>
                        <a href="" class="btn btn-primary">Claim</a>
                    </div>
                </div>
            </section>
            <section class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Work log</div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>Alan Tell Oyola</th>
                                <th>10 H</th>
                            </tr>
                            <tr>
                                <td>tesintgf1</td>
                                <td>3H</td>
                            </tr>
                            <tr>
                                <td>alka dkjad jakldj kaljdklaj</td>
                                <td>7H</td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel-footer text-right">
                        <button id="btnAddWorkLog" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @include('issues.modal.worklog')
@endsection
@push('scripts')
<script>
    $(function () {
        $('#btnAddWorkLog').click(function () {
            $('#modalWorkLog').modal('show');
        });
    });
</script>
@endpush