<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.1.1/ekko-lightbox.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
</head>
<body>
<div id="app">
    <!-- Modal -->
    <div id="addIssue" class="modal fade" role="dialog">
      <div class="modal-dialog">
        @if(Auth::check())
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create new Issue</h4>
              </div>
              {{ Form::open(['url' => 'newIssue', 'method' => 'post']) }}
                <div class="modal-body">
                    <div class="form-group">
                            {{ Form::label('project_id','Project') }}
                            <select name="project_id" id="project_id">
                                @foreach(App\Models\ProjectModel::where('company_id', Auth::user()->company_id)->get() as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                    </div>
                    {{ Form::label('summary','Summary') }}
                    {{ Form::text('summary',null,['class'=>'form-control']) }}
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              {{ Form::close() }}
            </div>
        @endif
      </div>
    </div>

    @include('layouts.navbar')

    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="//use.fontawesome.com/d060f5688b.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.1.1/ekko-lightbox.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="//cdn.ckeditor.com/4.7.2/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    $(function () {
        // lightbox
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
        // select2
        $('.select2').select2();
    });
</script>
@stack('scripts')
</body>
</html>