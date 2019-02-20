@extends('layouts.admin')

@section('nav-body')
    <div class="nav-body ml-3">
        <a href="{{route('proj-create')}}" class="btn btn-prime btn-s mr-1 ripple">+ New</a>
        <a href="{{route('proj-create-quick')}}" class="btn btn-white-dark btn-s mr-1 ripple">
            <i class="ion ion-jet icon-left"></i>
            <span>Quick Create</span>     
        </a>
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
                <div class="card col-4 my-3 col-6-md col-10-sm col-12-xs">
                    <div class="card-head row v-center px-0">
                        <div class="col-9 mb-0 v-center">
                            @if($project->is_private)
                                <i class="ion ion-key text-prime mr-1" style="font-size: 2.5rem"></i>
                            @endif
                            <div class="heading-ter">{{$project->name}}</div>
                        </div>
                        <div class="col-2 mb-0">
                            <div class="dropdown-white-dark dropdown dropdown-icon-hide">
                                <div class="dropdown-head ion ion-ios-arrow-down"></div>
                                <div class="dropdown-body" style="top: 100%;right: 0;max-height: auto !important;overflow: hidden !important;">   
                                    <a href="{{route('assets', ['project_slug' => $project->slug])}}" class="dropdown-item v-center text-dark" style="text-decoration: none;">
                                        <i class="ion ion-wineglass btn  btn-prime btn-s"></i>
                                        <span class="mx-2">
                                            Assets
                                        </span>
                                    </a>
                                    <a href="{{route('editor-boot', ['project_name' => $project->slug])}}" class="dropdown-item v-center text-dark" style="text-decoration: none;">
                                        <i class="ion ion-code btn  btn-dark btn-s"></i>
                                        <span class="mx-2">
                                            Launch Editor
                                        </span>
                                    </a>
                                    <a href="{{route('proj-edit', ['project_name' => $project->slug])}}" class="dropdown-item v-center text-dark" style="text-decoration: none;">
                                        <i class="ion ion-edit btn btn-sec btn-s"></i>
                                        <span class="mx-2">
                                            Edit Details
                                        </span>
                                    </a>
                                    <a href="{{route('full-view', ['project_name' => $project->slug])}}" class="dropdown-item v-center text-dark" style="text-decoration: none;">
                                        <i class="ion ion-jet btn-ter btn-s btn"></i>
                                        <span class="mx-2">
                                            Share Link
                                        </span>
                                    </a>
                                    <a href="{{route('proj-del-confirm', ['project_name' => $project->slug])}}" class="dropdown-item v-center text-dark" style="text-decoration: none;">
                                        <i class="ion ion-trash-a btn btn-danger btn-s"></i>
                                        <span class="mx-2">
                                            Delete Project
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row p-0">
                        <div class="w-10 projects-iframe-conteiner">
                            <iframe src="{{route('full-view', ['project_name' => $project->slug])}}" onload="console.log(this.contentWindow.document.body.style.overflow = 'hidden')" class="over w-10" frameborder="0"></iframe>
                        </div>
                        <div class="col-12 mb-0">
                            <div>
                                <p class="my-2">{{$project->meta}}</p>
                            </div>
                        </div>
                    </div>
                    @if (count($project->tags) > 0)
                        <div class="card-foot" style="flex-wrap: wrap;">
                            @foreach ($project->tags as $tag)
                                <a href="{{route('by-tag', ['tag_name' => $tag->name])}}" style="text-decoration: none;">
                                    <span class="mr-1 mb-1 badge badge-{{$colors[rand(0,4)]}}">{{$tag->name}}</span>
                                </a>  
                            @endforeach
                        </div>
                    @endif
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