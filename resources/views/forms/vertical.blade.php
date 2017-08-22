<div class="form-group{{ $errors->has($element['field']) ? ' has-error' : '' }} {{ $element['class'] }}">
    {{ Form::label($element['field'], $element['label'], ['class'=>'control-label']) }}

    @if(isset($element['type']) && $element['type'] == 'select')
        {{ Form::select($element['field'], $element['data'], old($element['field']), ['class'=>'form-control']) }}
    @elseif(isset($element['type']) && $element['type'] == 'textarea')
        {{ Form::textarea($element['field'], old($element['field']), ['class'=>'form-control']) }}
    @elseif(isset($element['type']) && $element['type'] == 'password')
        {{ Form::password($element['field'], ['class'=>'form-control']) }}
    @else
        {{ Form::text($element['field'], old($element['field']), ['class'=>'form-control']) }}
    @endif

    @if ($errors->has($element['field']))
        <span class="help-block">
            <strong>{{ $errors->first($element['field']) }}</strong>
        </span>
    @endif
</div>