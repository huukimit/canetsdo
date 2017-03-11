<!doctype html>
<html lang="{{App::getLocale()}}">
    <head>
        @include('backend._includes.page_begin')
    </head>
    <body id="nifty-ready pace-done">
        <div id="container" class="cls-container">@yield('main')</div>
        @include('backend._includes.page_end')
    </body>
</html>