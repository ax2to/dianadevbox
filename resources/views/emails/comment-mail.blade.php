@extends($layout)

@section('content')
    {!! nl2br($comment->message) !!}
@endsection