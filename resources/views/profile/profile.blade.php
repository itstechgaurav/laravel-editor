@extends('layouts.admin')

@section('content')


@section('nav-body')
    <div class="nav-body ml-3">
        <a href="{{route('profile-edit')}}" class="btn btn-prime btn-s mr-1 ripple"><i class="ion icon-left ion-edit"></i> Edit</a>
    </div>
@endsection
    
<?php $user = Auth::user(); ?>

<div id="user-section" style="height: 100vh;">
        <h1 class="my-3 d-b text-center text-white heading-sec">Profile</h1>
        <div class="class">
            <div class="row space-a">
                <div class="card col-6 col-8-md col-10-sm col-12-xs">
                    <div class="card-body py-4">
                        <div class="row">
                            <div class="col-3 col-12-sm v-center text-center">
                            <img class="user-img" src="{{'/uploads/' . $user->profile->image}}" style="background: none !important;">
                            </div>
                            <div class="col-9 col-12-sm">
                            <h2 class="d-b my-2 heading-sec user-name text-prime">{{$user->name}}</h2>
                                <p class="mute mb-2 text-justify">
                                    {{$user->profile->meta}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection