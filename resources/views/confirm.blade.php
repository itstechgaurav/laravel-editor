@extends('layouts.app') 
@section('content')


<form action="" method="POST">
    {{csrf_field()}}
    <div class="class mt-4">
        <div class="row space-a">
            <div class="card col-4 col-6-md col-6-sm col-10-xs">
                <div class="card-body">
                    <div class="form-group">
                        <label for="" class="label mb-2">Type Confirm</label>
                        <input name="confirm" type="text" class="input-input shadow-prime">
                        <div class="input-a-anm input-a-anm-center"></div>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-prime ripple">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection