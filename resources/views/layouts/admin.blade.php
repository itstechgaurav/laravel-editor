<!DOCTYPE html>
<html lang="en">
<head>
    @include('comp.common')
</head>
<body class="over">
    <div id="app">
        <div class="panel panel-open" data-usePanel="left" id="mainAdminPanel" style="height: 100vh;">
            <div class="panel-left panel-left-admin d-f dir-col">
                @include('admin.comp.nav')
            </div>
            <div class="panel-right panel-right-admin">
                <div class="nav nav-dark">
                    <div class="nav-logo m-0">
                        <div class="c-hm" data-panel="mainAdminPanel">
                            <div class="c-hm-bar"></div>
                        </div>
                    </div>
                    @yield('nav-body')
                </div>
                @include('comp.errors')
                @yield('content')
            </div>
        </div>
    </div>
    <script src="/js/app.js"></script>
    <script>
        loaded(function() {
            document.querySelectorAll("[type='checkbox']").forEach(function(it) {
                doIt(it);
                it.addEventListener("change", function() {
                    doIt(it);
                });
            });

            function doIt(it) {
                if(it.checked) {
                    it.value = it.getAttribute('true-value') ? it.getAttribute('true-value') : true;
                } else {
                    it.value = it.getAttribute('false-value') ? it.getAttribute('false-value') : false;
                }
            }
        })
    </script>
</body>
</html>