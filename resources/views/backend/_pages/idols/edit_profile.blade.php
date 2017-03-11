@extends('backend._layouts.admin')
@section('main')
<?php
$edit = 0;
if (isset($getData['uinfo']->id) && $getData['uinfo']->id > 0) {
    $edit = 1;
}
?>
<form id="edit_idoladmin" class="form-horizontal" name="edit_idol" accept-charset="UTF-8" action="{{URL::to('admin/idols/editprofile')}}" method="POST" enctype="multipart/form-data">
    <div class="row panel">
        <input type="hidden" value="{{ csrf_token() }}" name="_token">
        <input type="hidden" name="id" id="id" value="{{$edit == 1 ? $getData['uinfo']->id : ''}}">
        <div class="panel-heading">
            <h3 class="panel-title">アイドル詳細</h3>
        </div>
        <div class="panel-body">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="col-sm-4 control-label" style="margin-top: 50px">グループイメージ</label>
                    <div class="col-sm-6">
                        <div style="display: none" id="crop-image-banner"></div>
                        <img id="result-image" src="{{$getData['uinfo']->banner != '' ? URL::to('/').'/'.$getData['uinfo']->banner : URL::to('/').'/public/uploads/default/banner.png'}}" class="avatar_user avatar_border preview_avatar" width="356px" height="auto"/>
                        <!--<small class="help-block">(イメージ サイズ：1070px x 714px)</small>-->
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label padding-label">グループイメージの変更</label>
                    <div class="col-sm-6">
                        <span class="pull-left btn btn-default btn-file">
                            ブラウズ... <input id="upload" type="file" class="up_avatar_user" accept="image/*">
                        </span>
                        <input type="hidden" value="" id="upload_image_crop" name="image_crop_banner"/>
                        <button style="float: left;margin-left: 15px;display: none" type="button" class="btn btn-info btn-labeled fa fa-crop fa-lg upload-result" id="crop_image_upload">Crop</button>
                        <button style="float: left;margin-left: 8px;display: none" class="btn btn-info fa fa-rotate-left fa-lg vanilla-rotate" data-deg="-90" type="button"></button>
                        <button style="float: left;margin-left: 8px;display: none" class="btn btn-info fa fa-rotate-right fa-lg vanilla-rotate" data-deg="90" type="button"></button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">グループロゴ</label>
                    <div class="col-sm-6">
                        <div style="display: none" id="crop-image-avatar"></div>
                        <img id="result-image-avatar" src="{{$getData['uinfo']->avatar != '' ? URL::to('/').'/'.$getData['uinfo']->avatar : URL::to('/').'/public/uploads/default/logo.png'}}" class="avatar_user avatar_border preview_logo" width="356px" height="auto"/>
                        <!--<small class="help-block">(イメージ サイズ：500px x 500px)</small>-->
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label padding-label">グループロゴの変更</label>
                    <div class="col-sm-6">
                        <span class="pull-left btn btn-default btn-file">
                            ブラウズ... <input id="upload_avatar" type="file" class="up_avatar_user" accept="image/*">
                        </span>
                        <input type="hidden" value="" id="upload_image_crop_avatar" name="image_crop_avatar"/>
                        <button style="float: left;margin-left: 15px;display: none" type="button" class="btn btn-info btn-labeled fa fa-crop fa-lg" id="crop_image_upload_avatar">Crop</button>
                        <button style="float: left;margin-left: 8px;display: none" class="btn btn-info fa fa-rotate-left fa-lg vanilla-rotate-avatar" data-deg="-90" type="button"></button>
                        <button style="float: left;margin-left: 8px;display: none" class="btn btn-info fa fa-rotate-right fa-lg vanilla-rotate-avatar" data-deg="90" type="button"></button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">グループ名</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control required" placeholder="グループ名" value="{{isset($getData['uinfo']->nickname) ? $getData['uinfo']->nickname : ''}}" name="nickname" id="nickname">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">グループ説明</label>
                    <div class="col-sm-6">
                        <textarea name="about" placeholder="グループ説明" class="form-control required" style="width: 100%" rows="4">{{isset($getData['uinfo']->about) ? $getData['uinfo']->about : ''}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">SNS</label>
                    <div class="col-sm-6 input-group">
                        <span class="input-group-addon"><i class="fa fa-facebook fa-lg"></i></span>
                        <input type="text" class="form-control" placeholder="http://sample/facebook" name="sns_facebook" value="{{isset($getData['uinfo']->sns_facebook) ? $getData['uinfo']->sns_facebook : ''}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"></label>
                    <div class="col-sm-6 input-group">
                        <span class="input-group-addon"><i class="fa fa-twitter fa-lg"></i></span>
                        <input type="text" class="form-control" placeholder="http://sample/twitter" name="sns_twitter" value="{{isset($getData['uinfo']->sns_twitter) ? $getData['uinfo']->sns_twitter : ''}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"></label>
                    <div class="col-sm-6 input-group">
                        <span class="input-group-addon"><i class="fa fa-instagram fa-lg"></i></span>
                        <input type="text" class="form-control" placeholder="http://sample/instagram" name="sns_instagram" value="{{isset($getData['uinfo']->sns_instagram) ? $getData['uinfo']->sns_instagram : ''}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-4">
                <a href="{{URL::to('admin/idols/dashboard?id_idol='.$getData['uinfo']->id)}}" class="btn btn-default btn-labeled fa fa-arrow-left fa-lg">戻る</a>
                <button type="submit" class="btn btn-info btn-labeled fa fa-edit fa-lg" id="edit_user_for_admin">保存</button>
                <a href="{{URL::to('admin/idols/dashboard?id_idol='.$getData['uinfo']->id)}}" class="btn btn-default btn-labeled fa fa-rotate-left fa-lg">キャンセル</a>
            </div>
        </div>
    </div>
</form>
@stop