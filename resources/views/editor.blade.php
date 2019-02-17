<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('comp.common', ['title' => $project->user->name  . '\'s Editor'])

    <meta name="description" content="{{$project->meta}}">

    </head>
    <body>
        <div id="app">
            <h1 class="d-none">{{$project->name}}</h1>
            <editor></editor>
            <div id="loading-screen">
                <div class="code-loader">
                    <div class="bouncing-ball ion ion-beer"></div>
                </div>
            </div>
        </div>
        <div class="alerts-container" id="alert-container-editor"></div>
    </body>
</html>
