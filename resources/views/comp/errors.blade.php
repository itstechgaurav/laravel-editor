<div class="alerts-container" id="alert-container-editor">
    @if ($errors->any()) @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
            <div class="alert-close"></div>
            <div class="alert-body">
                {{ $error }}
            </div>
        </div>
    @endforeach @endif
    
    @foreach(['prime', 'sec', 'ter', 'warn', 'danger', 'dark', 'black', 'white'] as $type)
        @if(Session::has($type))
            <div class="alert alert-{{$type}}">
                <div class="alert-close"></div>
                <div class="alert-body">
                    {{ Session::get($type) }}
                </div>
            </div>
        @endif
    @endforeach
</div>