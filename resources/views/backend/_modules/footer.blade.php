<div class="show-fixed pull-right">
    <ul class="footer-list list-inline">
        <li>
            <p class="text-sm">SEO Proggres</p>
            <div class="progress progress-sm progress-light-base">
                <div style="width: 80%" class="progress-bar progress-bar-danger"></div>
            </div>
        </li>

        <li>
            <p class="text-sm">Online Tutorial</p>
            <div class="progress progress-sm progress-light-base">
                <div style="width: 80%" class="progress-bar progress-bar-primary"></div>
            </div>
        </li>
        <li>
            <button class="btn btn-sm btn-dark btn-active-success">Checkout</button>
        </li>
    </ul>
</div>

<div class="hide-fixed pull-right pad-rgt">Website version {{config('manager.version.code')}}.</div>
<p class="pad-lft">Copyright &copy; {{date('Y',time())}}. All rights reserved.<br /> This page took <strong> {{ (microtime(true) - LARAVEL_START) }} </strong> seconds to render</p>