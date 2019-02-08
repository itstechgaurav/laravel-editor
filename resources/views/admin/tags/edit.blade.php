@extends('layouts.admin')

@section('nav-body')
    <div class="nav-body ml-3">
        <a href="{{url()->previous()}}" class="btn btn-white btn-s mr-1">Go Back</a>
    </div>
@endsection

@section('content')
    <div class="class mt-4">
        <div class="row space-a">
            <div class="card col-6">
                <div class="card-head text-center">
                    <div class="heading-ter">Edit Tag</div>
                </div>
                <div class="card-body w-9 mx-a">
                    <form action="" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                        <input name="name" spellcheck="false" type="text" class="input-input" placeholder="Tag Name" value="{{$tag->name}}">
                            <div class="input-a-anm input-a-anm-center"></div>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-ter ripple">Save Tag</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection