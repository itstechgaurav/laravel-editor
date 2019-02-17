<!DOCTYPE html>
<html lang="en">
<head>
    @include('comp.common')
    @yield('seo')
</head>
<body>
    <div id="app">
        <nav class="nav nav-dark nav-corner nav-hide-sm p-1-sm" style="padding: .3rem">
            <div class="nav-logo">
                <a class="nav-text link link-dark" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>
            <div class="nav-opener">
                <div class="hamburger"></div>
            </div>
            <div class="nav-body">
                @guest
                    <li class="nav-item">
                        <a class="link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="link" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endguest
            </div>
        </nav>

        <main class="py-4">
            @include('comp.errors')
            @yield('content')
        </main>
    </div>
</body>
</html>
