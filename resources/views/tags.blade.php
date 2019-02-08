@extends('layouts.main', ['title' => 'All Tags'])

<?php $colors = ['prime', 'sec', 'ter', 'warn', 'danger'] ?>

@section('content')
    <div class="class mt-4">
        <div class="row space-a">
            @foreach ($tags as $tag)
            <a href="{{route('by-tag', ['tag_name' => $tag->name])}}" style="text-decoration: none;">
                    <div class="card col-4">
                        <div class="card-body row space-b bg-{{$colors[rand(0,4)]}}">
                            <div class="col-12 mb-0 v-center">
                                <div class="w-10 text-center">
                                    <div class="heading-ter d-b my-2 text-white">{{$tag->name}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection