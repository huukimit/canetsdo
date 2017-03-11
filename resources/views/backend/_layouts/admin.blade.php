<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
    <head>
        @include('backend._includes.page_begin')
    </head>
    <body class="nifty-ready pace-done">
        <div id="container" class="slide effect mainnav-lg navbar-fixed mainnav-fixed">
            <header id="navbar">@include('backend._modules.header')</header>
            <div class="boxed">
                <div id="content-container">@include('backend._modules.content')</div>
                <nav id="mainnav-container" class="affix" style="height:999px;">@include('backend._modules.navbar')</nav>
            </div>
            <footer id="footer">@include('backend._modules.footer')</footer>
        </div>
        <button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
        @include('backend._includes.page_end')
    </body>
</html>