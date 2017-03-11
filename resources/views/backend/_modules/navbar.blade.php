<?php
$list_param = \Route::current()->parameters();
$cms = isset($list_param['cmd']) ? $list_param['cmd'] : '';
?>
<div id="mainnav">
    <div id="mainnav-menu-wrap">
        <div class="nano has-scrollbar">
            <div class="nano-content" tabindex="0" style="right: -15px;">
                <ul class="list-group" id="mainnav-menu">
                    @if(isset($getData['id_idol']))
                    <li class="{{$cms == 'newslist' ? 'active' : ''}}">
                        <a href="javascript:void(0);">
                            <i class="fa fa-newspaper-o"></i><span class="menu-title"><strong>ニュース</strong></span>
                        </a>
                    </li>
                    <li class="list-divider"></li>
                    <li class="{{in_array($cms, array('editprofile')) ? 'active' : ''}}">
                        <a href="{{URL::to('admin/idols/editprofile?id_idol='.$getData['id_idol'])}}">
                            <i class="fa fa-users"></i><span class="menu-title"><strong>グループ情報</strong></span>
                        </a>
                    </li>
                    <li class="list-divider"></li>
                    <li class="{{in_array($cms, array('idolmember', 'editmember', 'addmember')) ? 'active' : ''}}">
                        <a href="{{URL::to('admin/idols/idolmember?id_idol='.$getData['id_idol'])}}">
                            <i class="fa fa-microphone"></i><span class="menu-title"><strong>メンバー情報</strong></span>
                        </a>
                    </li>
                    <li class="list-divider"></li>
                    <li class="{{in_array($cms, array('itemwaitinglist', 'edititemwaiting')) ? 'active' : ''}}">
                        <a href="{{URL::to('admin/idols/itemwaitinglist?id_idol='.$getData['id_idol'])}}">
                            <i class="fa fa-image"></i><span class="menu-title"><strong>待ち受け画像</strong></span>
                        </a>
                    </li>
                    <li class="list-divider"></li>
                    <li class="{{in_array($cms, array('giftlist', 'editgift')) ? 'active' : ''}}">
                        <a href="{{URL::to('admin/idols/giftlist?id_idol='.$getData['id_idol'])}}">
                            <i class="fa fa-gift"></i><span class="menu-title"><strong>バッジ画像</strong></span>
                        </a>
                    </li>
                    <li class="list-divider"></li>
                    @else
                    <li class="{{$getData['current_page'] == '' ? 'active' : ''}}">
                        <a href="{{URL::to('admin')}}"><i class="fa fa-heart"></i><span class="menu-title"><strong>アイドル一覧</strong></span></a>
                    </li>
                    <li class="list-divider"></li>
                    <li class="{{$getData['current_page'] == 'users' ? 'active' : ''}}">
                        <a href="{{URL::to('admin/users/list')}}"><i class="fa fa-user"></i><span class="menu-title"><strong>ユーザー情報</strong></span></a>
                    </li>
                    <li class="list-divider"></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>