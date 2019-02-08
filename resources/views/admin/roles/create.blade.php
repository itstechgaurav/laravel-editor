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
                    <div class="heading-ter">Create Role</div>
                </div>
                <div class="card-body w-9 mx-a">
                    <form action="" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input name="name" spellcheck="false" type="text" class="input-input" placeholder="Role Name">
                            <div class="input-a-anm input-a-anm-center"></div>
                        </div>
                        <div class="form-group">
                            <input name="img" spellcheck="false" type="text" class="input-input" placeholder="Role Image url">
                            <div class="input-a-anm input-a-anm-center"></div>
                        </div>
                        <div class="form-group">
                            <textarea name="meta" class="textarea" placeholder="Some Discription"></textarea>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-ter ripple">Add Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection