@extends('backend._layouts.admin')
@section('main')
<?php
$edit = 0;
if (isset($getData['item']->id) && $getData['item']->id > 0) {
    $edit = 1;
}
?>
<form id="edit_item_waiting" class="form-horizontal" name="edit_item_waiting" accept-charset="UTF-8" action="{{URL::to('admin/idols/edititemwaiting')}}" method="POST" enctype="multipart/form-data">
    <div class="row panel">
        <input type="hidden" value="{{ csrf_token() }}" name="_token">
        <input type="hidden" name="id" id="id" value="{{$edit == 1 ? $getData['item']->id : ''}}">
        <input type="hidden" name="id_idol" id="id_idol" value="{{isset($getData['id_idol']) ? $getData['id_idol'] : ''}}">
        <br/>
        <br/>
        <br/>
        <div class="panel-body">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="col-sm-4 control-label" style="margin-top: 50px">待受イメージ</label>
                    <div class="col-sm-4">
                        <div style="display: none" id="crop-image-itemwaiting"></div>
                        <img id="result-image" src="{{isset($getData['item']) && $getData['item']->image != '' ? URL::to('/').'/'.$getData['item']->image : URL::to('/').'/public/uploads/default/avatar_member.png'}}" class="avatar_user avatar_border preview_avatar" width="275px" height="auto"/>
<!--                        <small class="help-block">(イメージ サイズ：750px x 1143px)</small>-->
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label padding-label">待受イメージ変更</label>
                    <div class="col-sm-6">
                        <span class="pull-left btn btn-default btn-file">
                            ブラウズ... <input id="upload" type="file" class="up_avatar_user" accept="image/*">
                        </span>
                        <input type="hidden" value="" id="upload_image_crop" class="{{$edit == 0 ? 'required' : ''}}" name="image_crop"/>
                        <button style="float: left;margin-left: 15px;display: none" type="button" class="btn btn-info btn-labeled fa fa-crop fa-lg upload-result" id="crop_image_upload">Crop</button>
                        <button style="float: left;margin-left: 8px;display: none" class="btn btn-info fa fa-rotate-left fa-lg vanilla-rotate" data-deg="-90" type="button"></button>
                        <button style="float: left;margin-left: 8px;display: none" class="btn btn-info fa fa-rotate-right fa-lg vanilla-rotate" data-deg="90" type="button"></button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">達成ポイント</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control required" placeholder="達成ポイント" value="{{isset($getData['item']->zeni) ? $getData['item']->zeni : ''}}" name="zeni" >
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-4">
                <button type="submit" class="btn btn-info btn-labeled fa fa-edit fa-lg" id="edit_user_for_admin">保存</button>
                <a href="{{URL::to('admin/idols/itemwaitinglist?id_idol='.$getData['id_idol'])}}" class="btn btn-default btn-labeled fa fa-rotate-left fa-lg">キャンセル</a>
            </div>
            <br/>
            <br/>
            <br/>
        </div>
    </div>
</form>
@stop