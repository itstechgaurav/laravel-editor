<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('comp.common', ['title' => $project->user->name  . '\'s Editor'])

    <meta name="description" content="{{$project->meta}}">

    </head>
    <body>
        <div id="app">
            <h1>{{$project->name}}</h1>
            <editor></editor>
        </div>
        <div class="alerts-container" id="alert-container-editor"></div>
    </body>
</html>
