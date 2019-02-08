@extends('layouts.admin')

@section('nav-body')
    <div class="nav-body ml-3">
        <a href="{{url()->previous()}}" class="btn btn-white btn-s mr-1">Go Back</a>
    </div>
@endsection

<?php $user = Auth::user(); ?>

@section('content')
    <div class="class mt-4">
        <div class="row space-a">
            <div class="card col-6">
                <div class="card-head text-center">
                    <div class="heading-ter">Edit Profile</div>
                </div>
                <div class="card-body w-9 mx-a">
                    <form action="" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group text-center">
                            <label class="profile-image w-10 v-center space-e" for="profileImage">
                                <img src="{{'/uploads/' . $user->profile->image}}" width="100" height="100" class="rad-circle" alt="">
                                <input type="file" class="file" name="profileImage" id="profileImage" accept="image/*">
                            </label>
                        </div>
                        <div class="form-group">
                        <input spellcheck="false" name="name" value="{{$user->name}}" type="text" class="input-input" placeholder="Project Name">
                            <div class="input-a-anm input-a-anm-center"></div>
                        </div>
                        <div class="form-group">
                        <textarea name="meta" class="textarea" placeholder="Brief Discription About This Project">{{$user->profile->meta}}</textarea>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-ter ripple">Save Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection