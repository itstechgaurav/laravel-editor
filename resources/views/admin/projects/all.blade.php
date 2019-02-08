@extends('layouts.admin')

@section('nav-body')
    <div class="nav-body ml-3">
        <a href="{{route('proj-create')}}" class="btn btn-prime btn-s mr-1 ripple">+ New</a>
        @if(Auth::user()->role_id < 3)
        <a href="{{route('proj-all')}}" class="btn btn-ter btn-s mr-1 ripple">All</a>
        @endif
    </div>
@endsection

<?php $colors = ['prime', 'sec', 'ter', 'warn', 'danger'] ?>

@section('content')
    <div class="class mt-4">
        <div class="row space-a">
            @foreach ($projects as $project)
                <div class="card col-8 my-3 col-9-md col-11-sm col-12-xs">
                    <div class="card-head">
                        @if($project->is_private)
                            <i class="ion ion-ios-locked-outline text-prime mr-1" style="font-size: 2.5rem"></i>
                        @endif
                        <div class="heading-ter">{{$project->name}}</div>
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
                    <div class="card-foot" style="flex-wrap: wrap;">
                        @foreach ($project->tags as $tag)
                            <a href="{{route('by-tag', ['tag_name' => $tag->name])}}" style="text-decoration: none;">
                                <span class="mr-1 mb-1 badge badge-{{$colors[rand(0,4)]}}">{{$tag->name}}</span>
                            </a>  
                        @endforeach
                    </div>
                    <div class="card-foot d-f">
                        <a data-title="Launch Editor" href="{{route('editor-boot', ['project_name' => $project->slug])}}" class="btn mr-1 btn-dark btn-s title-tip title-tip-top title-tip-dark">
                            <i class="ion ion-code"></i>
                        </a>
                        <a data-title="Edit Project Details" href="{{route('proj-edit', ['project_slug' => $project->slug])}}" class="btn mr-1 btn-dark-o btn-s title-tip title-tip-top title-tip-dark">
                            <i class="ion ion-edit"></i>
                        </a>
                        <a data-title="Delete Project" href="{{route('proj-del-confirm', ['project_slug' => $project->slug])}}" class="btn mr-1 btn-danger btn-s title-tip title-tip-top title-tip-dark">
                            <i class="ion ion-trash-a"></i>
                        </a>
                        <a data-title="Share Link" target="_blank" href="{{route('full-view', ['project_name' => $project->slug])}}" class="btn mr-1 btn-ter btn-s title-tip title-tip-top title-tip-dark">
                            <i class="ion ion-jet"></i>
                        </a>
                    </div>
                </div>  
            @endforeach  
        </div>
        </div>
        <div class="class text-center">
            <div class="pagination-menu">
                {{$projects->links()}}
            </div>
        </div>
    </div>
@endsection