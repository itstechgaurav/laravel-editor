@extends('layouts.admin')

@section('nav-body')
    <div class="nav-body ml-3">
        <a href="{{route('tags-create')}}" class="btn btn-prime btn-s mr-1 ripple">+ New</a>
    </div>
@endsection

@section('content')
    <div class="class mt-4">
        <div class="row space-a">
            @foreach ($tags as $tag)
                <div class="card col-3 col-4-md col-6-sm col-12-xs">
                    <div class="card-body row space-b">
                        <div class="w-10">
                            <div class="heading-ter d-b my-2">{{$tag->name}}</div>
                        </div>
                      <a href="{{route('tags-edit', ['tag_id' => $tag->id])}}" class="link link-prime text-prime">Edit</a>
                      <a href="{{route('tags-confirm', ['tag_id' => $tag->id])}}" class="link link-warn text-warn">Delete</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection