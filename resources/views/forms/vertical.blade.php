<div class="form-group{{ $errors->has($element->name) ? ' has-error' : '' }} {{ $element->class }}">
    {{ Form::label($element->name, $element->label, ['class'=>'control-label']) }}

    @if(isset($element->type) && $element->type == 'select')
        {{ Form::select($element->name, $element->data, old($element->name, $element->default), ['class'=>'form-control select2']) }}
    @elseif(isset($element->type) && $element->type == 'textarea')
        {{ Form::textarea($element->name, old($element->name, $element->default), ['class'=>'form-control']) }}
    @elseif(isset($element->type) && $element->type == 'password')
        {{ Form::password($element->name, ['class'=>'form-control']) }}
    @elseif(isset($element->type) && $element->type == 'date')
        {{ Form::text($element->name, old($element->name, $element->default), ['class'=>'form-control']) }}
    @else
        {{ Form::text($element->name, old($element->name, $element->default), ['class'=>'form-control']) }}
    @endif

    @if ($errors->has($element->name))
        <span class="help-block">
            <strong>{{ $errors->first($element->name) }}</strong>
        </span>
    @endif
</div>