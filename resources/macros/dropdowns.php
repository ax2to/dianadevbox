<?php
Form::macro('projects', function ($key, $default, $options) {
    $values = \App\Models\ProjectModel::where('company_id', Auth::user()->company_id)
        ->allowedForUser(Auth::user())
        ->orderBy('name')
        ->pluck('name', 'id');
    if (isset($options['all']) && $options['all'] == true) {
        $values = ['all' => 'All'] + $values->toArray();
    }
    return Form::select($key, $values, $default, $options);
});

Form::macro('issues', function ($key, $default, $options) {
    $values = \App\Models\IssueModel::where('company_id', Auth::user()->company_id)
        ->pluck('summary', 'id');
    if (isset($options['all']) && $options['all'] == true) {
        $values = ['all' => 'All'] + $values->toArray();
    }
    return Form::select($key, $values, $default, $options);
});

Form::macro('issueTypes', function ($key, $default, $options) {
    $values = \App\Models\Issue\TypeModel::all()->pluck('name', 'id');
    if (isset($options['all']) && $options['all'] == true) {
        $values = ['all' => 'All'] + $values->toArray();
    }
    return Form::select($key, $values, $default, $options);
});

Form::macro('issueStatus', function ($key, $default, $options) {
    $values = \App\Models\Issue\StatusModel::all()->pluck('name', 'id');
    if (isset($options['all']) && $options['all'] == true) {
        $values = ['all' => 'All'] + $values->toArray();
    }
    return Form::select($key, $values, $default, $options);
});

Form::macro('issueResolutions', function ($key, $default, $options) {
    $values = \App\Models\Issue\ResolutionModel::all()->pluck('name', 'id');
    if (isset($options['all']) && $options['all'] == true) {
        $values = ['all' => 'All'] + $values->toArray();
    }
    return Form::select($key, $values, $default, $options);
});

Form::macro('priorities', function ($key, $default = null, $options = []) {
    $default = $default ?? \App\Models\Issue\PriorityModel::DEFAULT;
    $values = \App\Models\Issue\PriorityModel::all()->pluck('name', 'id');
    if (isset($options['all']) && $options['all'] == true) {
        $values = ['all' => 'All'] + $values->toArray();
    }

    return Form::select($key, $values, $default, $options);
});

Form::macro('users', function ($key, $default, $options) {
    $values = \App\User::where('company_id', Auth::user()->company_id)
        ->pluck('name', 'id');
    if (isset($options['all']) && $options['all'] == true) {
        $values = ['all' => 'All'] + $values->toArray();
    }
    return Form::select($key, $values, $default, $options);
});
