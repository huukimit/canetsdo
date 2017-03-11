@extends('backend._layouts.admin')
@section('main')
<form id="edit_useradmin" class="form-horizontal" name="change_password" accept-charset="UTF-8" action="{{URL::to('admin/users/edit')}}" method="POST" enctype="multipart/form-data">
    <div class="row panel">
        <div class="col-sm-10">

            <input type="hidden" value="{{ csrf_token() }}" name="_token">
            <input type="hidden" name="id" id="id" value="{{$getData['uinfo']->id}}">
            <div class="form-group"></div>
            <div class="form-group"></div>
            <div class="form-group">
                <label class="col-sm-4 control-label" style="margin-top: 50px">ユーザーイメージ</label>
                <div class="col-sm-8">
                    <img src="{{$getData['uinfo']->avatar != '' ? URL::to('/').'/'.$getData['uinfo']->avatar : URL::to('/').'/public/uploads/default/avatar.png'}}" class="avatar_user img-circle preview_avatar avatar_border" width="100px" height="100px"/>
                    <br/>
                    <br/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">ユーザーイメージの変更</label>
                <div class="col-sm-8">
                    <span class="pull-left btn btn-default btn-file">
                        ブラウズ... <input type="file" name="avatar" onchange="previewAvatar()" class="up_avatar_user">
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">名前</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control required" placeholder="名前" value="{{isset($getData['uinfo']->username) ? $getData['uinfo']->username : ''}}" name="username">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">ニックネーム</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control required" placeholder="ニックネーム" value="{{isset($getData['uinfo']->nickname) ? $getData['uinfo']->nickname : ''}}" name="nickname">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">メールアドレス</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control required" placeholder="メールアドレス" name="email" value="{{isset($getData['uinfo']->email) ? $getData['uinfo']->email : ''}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">登録日</label>
                <div class="col-sm-8">
                    <input disabled="true" type="text" class="form-control" value="{{isset($getData['uinfo']->created_at) && $getData['uinfo']->created_at != '0000-00-00 00:00:00' ? date('Y/m/d', strtotime($getData['uinfo']->created_at)) : date('Y/m/d')}}" name="created_at">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-4">
                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-2">
                            <a href="{{URL::to('admin/users/detail?id='.$getData['uinfo']->id)}}" class="btn btn-default btn-labeled fa fa-arrow-left fa-lg">戻る</a>
                            <button type="submit" class="btn btn-info btn-labeled fa fa-edit fa-lg" id="edit_user_for_admin">保存</button>
                            <a href="{{URL::to('admin/users/list')}}" class="btn btn-default btn-labeled fa fa-rotate-left fa-lg">キャンセル</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@stop