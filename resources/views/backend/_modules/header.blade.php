<style type="text/css">
    .mainnav-sm .brand-text{
        display: none;
    }
</style>
<div id="navbar-container" class="boxed">
    <div class="navbar-header">
        <a href="{{isset($getData['id_idol']) && $getData['id_idol'] > 0 ? URL::to('admin/idols/dashboard?id_idol='.$getData['id_idol']) : URL::to('admin')}}" class="navbar-brand">
            <div class="brand-title">
                <span class="brand-text">Admin Panel</span>
            </div>
        </a>
    </div>
    <div class="navbar-content clearfix">
        <ul class="nav navbar-top-links pull-left">
            <li class="tgl-menu-btn"><a class="mainnav-toggle" href="#"><i class="fa fa-navicon fa-lg"></i></a></li>
        </ul>
        <ul class="nav navbar-top-links pull-right">
            <li id="dropdown-user" class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                    <span class="pull-right">
                        <img class="img-circle img-user media-object" src="@if($getData['user_info']->avatar) {{$getData['user_info']->avatar}} @else {{url('public/uploads/default/avatar.png')}} @endif" alt="Profile Picture">
                    </span>
                    <div class="username hidden-xs">{{$getData['user_info']->fullname}}</div>
                </a>
                <div class="dropdown-menu dropdown-menu-right with-arrow panel-default">
                    <ul class="head-list">
                        <li><a href="{{URL::to('admin')}}" title="アイドル一覧"><i class="fa fa-heart fa-fw fa-lg"></i>アイドル一覧</a></li>
                        <li><a href="{{route('AminLogout')}}" title="ログアウト"><i class="fa fa-sign-out fa-fw fa-lg"></i>ログアウト</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>