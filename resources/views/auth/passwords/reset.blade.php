@extends('layouts.app')

@section('content')
<div class="class">
    <div class="row space-c">
        <div class="col-md-8 col-8-md col-10-sm col-12-xs">
            <div class="card">
                <div class="card-head">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" placeholder="Email" required autofocus>
                        </div>

                        <div class="form-group">
                            <input id="password" type="password" class="input{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                        </div>

                        <div class="form-group">
                            <input type="password" class="input" name="password_confirmation" required placeholder="Password Confirmation">
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-prime">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
