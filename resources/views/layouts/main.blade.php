<!DOCTYPE html>
<html lang="en">
<head>
    @include('comp.common')
    @yield('seo')
</head>
<body>
    <div id="app">
        @include('comp.nav')
        <div class="start-content">
            @yield('content')
        </div>
        @include('comp.errors')
    </div>
</body>
</html>