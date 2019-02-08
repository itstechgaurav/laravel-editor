@extends('layouts.admin')

@section('nav-body')
    <div class="nav-body ml-3">
        <a href="{{route('roles-create')}}" class="btn btn-prime btn-s mr-1 ripple">+ New</a>
    </div>
@endsection

@section('content')
    <div class="class mt-4">
        <div class="row space-a">
            @foreach ($roles as $role)
                <div class="card col-4">
                    <div class="card-body row space-b">
                        <div class="col-3 v-center">
                            <img class="w-10" src="{{$role->image}}" alt="">
                        </div>
                        <div class="col-8 v-center">
                            <div class="w-10">
                                <div class="heading-ter d-b my-2">{{$role->name}}</div>
                                <p class="mute">{{$role->meta}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection