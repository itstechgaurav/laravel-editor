@extends('layouts.main', ['title' => 'Login Page'])

@section('seo')
    <meta name="description" content="Page Is Used To Login users if you are interested the try to Login and get started to create projects and share them">
@endsection

@section('content')
<div class="class mt-5">
    <div class="row space-c">
        <div class="col-5 col-8-md col-10-sm col-12-xs">
            <div class="card">
                <div class="card-head">
                    <h1 class="heading-ter">Login</h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <input type="email" id="email" name="email" class="input-input b-0" placeholder="Email">
                            <div class="input-a-anm input-a-anm-center"></div>
                        </div>
                        <div class="form-group">
                            <input type="password" id="password" name="password" class="input-input b-0" placeholder="Password">
                            <div class="input-a-anm input-a-anm-center"></div>
                        </div>
                        <div class="form-group">
                            <label class="label v-center mute">
                                <input type="checkbox" name="remember" class="checkbox">
                                <span>Remember Me</span>
                            </label>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-prime ripple">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
