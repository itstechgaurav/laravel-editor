@extends('layouts.main')



<?php $colors = ['prime', 'sec', 'ter', 'warn', 'danger'] ?>

@section('content')
    <div class="class mt-4">
        <div class="row space-a">
            @foreach ($tags[0]->projects as $project)
                <div class="card col-8 my-3 col-9-md col-11-sm col-12-xs">
                    <div class="card-head">
                        <div class="heading-ter">
                            <a href="{{route('editor-boot', ['project_name' => $project->slug])}}" class="link link-prime text-ter">{{$project->name}}</a>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-7 col-12-sm projects-iframe-conteiner">
                                <iframe sandbox="" srcdoc="{{json_decode($project->file->meta)->result}}" frameborder="0"></iframe>
                        </div>
                        <div class="col-5 col-12-sm">
                            <div>
                                <p class="my-2">{{$project->meta}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-foot">
                        <span class="mr-2">by:</span> <a class="link link-prime text-prime" href="{{route('by-user', ['user_name' => $project->user->username])}}">{{'@' . $project->user->name}}</a>
                    </div>
                </div>  
            @endforeach  
        </div>
        </div>
        <div class="class text-center">
            <div class="pagination-menu">
                {{$tags->links()}}
            </div>
        </div>
    </div>
    <div id="footer-section" class="mt-2 bg-dark">
        <div class="text-white text-center">
            Made With <i class="ion ion-heart text-danger"></i> By Gaurav Bhardwaj
        </div>
    </div>
@endsection