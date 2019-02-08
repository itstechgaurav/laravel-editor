<div id="nav-welcome" class="nav nav-hide-sm py-0 px-1 nav-corner shadow-black">
        <div class="nav-logo">
            <img src="/favicon.svg" width="50" alt="">
        </div>
        <div class="nav-opener">
            <div class="hamburger"></div>
        </div>
        <div class="nav-body pb-4-sm text-center">
            <div class="nav-item">
                <a href="/" class="link link-prime">HOME</a>
            </div>
            <div class="nav-item">
                <a href="/editor/demo-project" class="link link-prime">Demo</a>
            </div>
            @auth
                <div class="nav-item">
                    <a href="{{route('main-dash')}}" class="text-prime link link-prime">{{\Auth::user()->name}}</a>
                </div>
            @else
                <div class="nav-item">
                    <a href="/login" class="link link-prime">Login</a>
                </div>
                <div class="nav-item">
                    <a href="/register" class="link link-prime">Register</a>
                </div>
            @endauth
        </div>
    </div>