@extends('backend._layouts.admin')
@section('main')
<div class="row panel idol_detail">
    <div class="panel-heading">
        <h3 class="panel-title">アイドル詳細</h3>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-4 control-label" style="margin-top: 50px">アイドルプロフィール</label>
                <div class="col-sm-8">
                    <img src="{{isset($getData['uinfo']['avatar']) ? $getData['uinfo']['avatar'] : URL::to('/').'public/uploads/default/avatar.png'}}" class="avatar_user img-circle avatar_border" width="100px" height="100px"/>
                    <br/>
                    <br/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">グループ名</label>
                <div class="col-sm-8">
                    <label>{{$getData['uinfo']['nickname'] != '' ? $getData['uinfo']['nickname'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">タイプ</label>
                <div class="col-sm-8">
                    <label>{{$getData['uinfo']['members'] != '' && $getData['uinfo']['members'] > 1 ? 'グループ' : 'ソロ'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">メールアドレス</label>
                <div class="col-sm-8">
                    <label>{{$getData['uinfo']['email'] != '' ? $getData['uinfo']['email'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">出身地</label>
                <div class="col-sm-8">
                    <label>{{$getData['uinfo']['place_of_birth'] != '' ? $getData['uinfo']['place_of_birth'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">活動地域</label>
                <div class="col-sm-8">
                    <label>{{$getData['uinfo']['action_location'] != '' ? $getData['uinfo']['action_location'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">メンバー数</label>
                <div class="col-sm-8">
                    <label>{{$getData['uinfo']['members'] != '' ? $getData['uinfo']['members'] : '0'}}</label>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group" style="margin-top: 55px">
                <label class="col-sm-4 control-label padding-label-detail">所属団体、事務所等、名称入力</label>
                <div class="col-sm-8">
                    <label>{{$getData['uinfo']['company'] != '' ? $getData['uinfo']['company'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">郵便番号</label>
                <div class="col-sm-8">
                    <label>{{$getData['uinfo']['zipcode'] != '' ? $getData['uinfo']['zipcode'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">住所</label>
                <div class="col-sm-8">
                    <label>{{$getData['uinfo']['address'] != '' ? $getData['uinfo']['address'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">担当者名</label>
                <div class="col-sm-8">
                    <label>{{$getData['uinfo']['leader'] != '' ? $getData['uinfo']['leader'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">電話番号</label>
                <div class="col-sm-8">
                    <label>{{$getData['uinfo']['phone'] != '' ? $getData['uinfo']['phone'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">ジャンル</label>
                <div class="col-sm-8">
                    <?php
                    $type = \App\Models\Idol\Category::find($getData['uinfo']['type']);
                    ?>
                    <label>{{!empty($type) ? $type->cate_name : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">グループ説明</label>
                <div class="col-sm-8">
                    <label>{{$getData['uinfo']['about'] != '' ? $getData['uinfo']['about'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">登録日</label>
                <div class="col-sm-8">
                    <label>{{isset($getData['uinfo']['created_at']) && $getData['uinfo']['created_at'] != '' ? date('Y/m/d', strtotime($getData['uinfo']['created_at'])) : '&nbsp;'}}</label>
                </div>
            </div>
        </div>
    </div>
    @if($getData['uinfo']['members'] > 0)
    @foreach($getData['uinfo']['list_member'] AS $key => $mem)
    <div class="panel-heading"></div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-4 control-label" style="margin-top: 50px">メンバー{{$key+1}}人目</label>
                <div class="col-sm-8">
                    <img src="{{$mem['avatar']}}" class="avatar_user img-circle" width="100px" height="100px"/>
                    <br/>
                    <br/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">名前</label>
                <div class="col-sm-8">
                    <label>{{$mem['fullname'] != '' ? $mem['fullname'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">性別</label>
                <div class="col-sm-8">
                    <label>{{$mem['gender'] == 1 ? '男性' : '女性'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">生年月日</label>
                <div class="col-sm-8">
                    <label>{{$mem['birthday'] != '' && $mem['birthday'] != '0000-00-00' ? date('Y/m/d', strtotime($mem['birthday'])) : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">出身地</label>
                <div class="col-sm-8">
                    <label>{{$mem['place_of_birth'] != '' ? $mem['place_of_birth'] : '&nbsp;'}}</label>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group" style="margin-top: 50px">
                <label class="col-sm-4 control-label">趣味</label>
                <div class="col-sm-8">
                    <label>{{$mem['interest'] != '' ? $mem['interest'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">身長</label>
                <div class="col-sm-8">
                    <label>{{$mem['height'] != '' ? $mem['height'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">体重</label>
                <div class="col-sm-8">
                    <label>{{$mem['weight'] != '' ? $mem['weight'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">スリーサイズ</label>
                <div class="col-sm-8">
                    <label>{{$mem['metric'] != '' ? $mem['metric'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label padding-label-detail">過去に影響を受けたもの</label>
                <div class="col-sm-8">
                    <label>{{$mem['inspired_what'] != '' ? $mem['inspired_what'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label padding-label-detail">過去に影響を受けた人物</label>
                <div class="col-sm-8">
                    <label>{{$mem['inspired_person'] != '' ? $mem['inspired_person'] : '&nbsp;'}}</label>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <a href="{{URL::to('admin/idols/list')}}" class="btn btn-default btn-labeled fa fa-arrow-left fa-lg">戻る</a>
            <a href="{{URL::to('admin/idols/edit?id='.$getData['uinfo']['id'])}}" class="btn btn-info btn-labeled fa fa-edit fa-lg">編集</a>
            <a href="{{URL::to('admin/idols/changepassword?id='.$getData['uinfo']['id'])}}" class="btn btn-warning btn-labeled fa fa-asterisk fa-lg">パスワードのリセット</a>
            @if($getData['uinfo']['status'] == 1)
            <a href="javascript:void(0)" data="{{URL::to('admin/idols/status?id='.$getData['uinfo']['id'].'&status=0')}}" class="btn btn-danger btn-labeled fa fa-arrow-circle-down fa-lg block_user">ブロック</a>
            @else
            <a href="{{URL::to('admin/idols/status?id='.$getData['uinfo']['id'].'&status=1')}}" class="btn btn-success btn-labeled fa fa-arrow-circle-up fa-lg">アクティブ</a>
            @endif
        </div>
    </div>
    <br/>
    <br/>
    <br/>
    <br/>
</div>
@stop