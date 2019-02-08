@extends('layouts.main', ['title' => 'Register Page'])

@section('seo')
    <meta name="description" content="Page Is Used To create New users if you are interested the try to signup and get many benifits like you can create projects select tag share project and many things">
@endsection

@section('content')
<div class="class mt-5">
    <div class="row space-c">
        <div class="col-5 col-8-md col-10-sm col-12-xs">
            <div class="card">
                <div class="card-head">
                    <h1 class="heading-ter">Sign up</h1>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="form-group">
                            <input type="text" id="name" name="name" class="input-input b-0" placeholder="Name">
                            <div class="input-a-anm input-a-anm-center"></div>
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" class="input-input b-0" placeholder="Email">
                            <div class="input-a-anm input-a-anm-center"></div>
                        </div>
                        <div class="form-group">
                            <input type="password" id="password" name="password" class="input-input b-0" placeholder="Password">
                            <div class="input-a-anm input-a-anm-center"></div>
                        </div>
                        <div class="form-group">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="input-input b-0" placeholder="Confirm Password">
                            <div class="input-a-anm input-a-anm-center"></div>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-prime ripple">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
