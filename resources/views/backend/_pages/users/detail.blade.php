@extends('backend._layouts.admin')
@section('main')
<div class="row panel">
    <div class="col-sm-8 col-sm-offset-3">
        <div class="form-group">
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label" style="margin-top: 50px">ユーザーイメージ</label>
            <div class="col-sm-8">
                <img src="{{$getData['uinfo']->avatar != '' ? URL::to('/').'/'.$getData['uinfo']->avatar : URL::to('/').'/public/uploads/default/avatar.png'}}" class="avatar_user img-circle avatar_border" width="100px" height="100px"/>
                <br/>
                <br/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">ユーザーID</label>
            <div class="col-sm-8">
                <label class="mar-lft">{{$getData['uinfo']->username != '' ? $getData['uinfo']->username : '&nbsp;'}}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">ニックネーム</label>
            <div class="col-sm-8">
                <label class="mar-lft">{{$getData['uinfo']->nickname != '' ? $getData['uinfo']->nickname : '&nbsp;'}}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">メールアドレス</label>
            <div class="col-sm-8">
                <label class="mar-lft">{{$getData['uinfo']->email != '' ? $getData['uinfo']->email : '&nbsp;'}}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">登録日</label>
            <div class="col-sm-8">
                <label class="mar-lft">{{date('Y/n/j', strtotime($getData['uinfo']->created_at))}}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">所持pt</label>
            <div class="col-sm-8">
                <label class="mar-lft">{{$getData['uinfo']->point}}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">消費pt</label>
            <div class="col-sm-8">
                <label class="mar-lft">{{$getData['uinfo']->use_zeni}}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">購入pt</label>
            <div class="col-sm-8">
                <label class="mar-lft">{{$getData['uinfo']->all_zeni}}</label>
                <br/>
                <br/>
                <br/>
            </div>
        </div>
        <!--        <div class="form-group">
                    <label class="col-sm-4 control-label">課金額</label>
                    <div class="col-sm-8">
                        <label class="mar-lft">{{$getData['uinfo']->point}}</label>
                        <br/>
                        <br/>
                        <br/>
                    </div>
                </div>-->
        <div class="form-group">
            <div class="col-sm-12">
                <a href="{{URL::to('admin/users/list')}}" class="btn btn-default btn-labeled fa fa-arrow-left fa-lg">戻る</a>
                <a href="{{URL::to('admin/users/edit?id='.$getData['uinfo']->id)}}" class="btn btn-info btn-labeled fa fa-edit fa-lg">編集</a>
                <a href="{{URL::to('admin/users/changepassword?id='.$getData['uinfo']->id)}}" class="btn btn-warning btn-labeled fa fa-asterisk fa-lg">パスワードリセット</a>
                @if($getData['uinfo']->status == 1)
                <a href="javascript:void(0)" data="{{URL::to('admin/users/status?id='.$getData['uinfo']->id.'&status=0')}}" class="btn btn-danger btn-labeled fa fa-arrow-circle-down fa-lg block_user">ブロック</a>
                @else
                <a href="{{URL::to('admin/users/status?id='.$getData['uinfo']->id.'&status=1')}}" class="btn btn-success btn-labeled fa fa-arrow-circle-up fa-lg">アクティブ</a>
                @endif
                <br/>
                <br/>
                <br/>
                <br/>
            </div>
        </div>
    </div>
</div>
@stop