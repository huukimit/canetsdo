@extends('backend._layouts.admin')
@section('main')
<div class="row panel idol_members">
    <form id="add_member_idol" class="form-horizontal" name="add_member" accept-charset="UTF-8" action="{{URL::to('admin/idols/addmember')}}" method="POST" enctype="multipart/form-data">
        <input type="hidden" value="{{ csrf_token() }}" name="_token">
        <input type="hidden" value="{{$getData['id_idol']}}" name="id_idol">
        <div class="idol-member-item">
            <div class="col-sm-3 avatar_member">
                <div class="form-group">
                    <div style="display: none" id="crop-image-member"></div>
                    <img id="result-image-member" src="{{URL::to('/').'/'.'public/uploads/default/avatar_member.png'}}" class="avatar_user avatar_border preview_avatar" width="175px" height="275px"/>
                    <!--<small class="help-block">(イメージ サイズ：440px x 690px)</small>-->
                </div>
                <div class="form-group" style="text-align: center">
                    <button style="display: none" class="btn btn-info fa fa-rotate-left fa-lg vanilla-rotate" data-deg="-90" type="button"></button>
                    <button style="margin-left: 8px;display: none" class="btn btn-info fa fa-rotate-right fa-lg vanilla-rotate" data-deg="90" type="button"></button>
                </div>
                <div class="form-group">
                    <span class="pull-left btn btn-default btn-file">
                        ブラウズ... <input id="upload_member" type="file" class="up_avatar_user" accept="image/*">
                    </span>
                    <input type="hidden" value="" id="upload_image_crop_member" name="image_crop_member"/>
                    <button style="float: left;margin-left: 15px;display: none" type="button" class="btn btn-info btn-labeled fa fa-crop fa-lg" id="crop_image_upload_member">Crop</button>
                </div>
            </div>
            <div class="col-sm-9 infomation_member">
                <div class="form-group">
                    <label class="col-sm-2 control-label">名前</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control required" placeholder="名前" value="" name="member_fullname" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">生年月日</label>
                    <div class="col-sm-9">
                        <div id="birthday-component">
                            <div class="input-group date">
                                <input type="text" class="form-control birthday_member required" value="" name="member_birthday" placeholder="生年月日">
                                <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">身長</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" class="form-control required" placeholder="身長" value="" name="member_height" />
                            <span class="input-group-addon">cm</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">体重</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" class="form-control required" placeholder="体重" value="" name="member_weight" />
                            <span class="input-group-addon">kg</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">趣味</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control required" placeholder="趣味" value="" name="member_interest" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">コメント</label>
                    <div class="col-sm-9">
                        <textarea class="form-control required" rows="3" placeholder="コメント" name="member_comment"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <label class="control-label icon_sns icon_sns_facebook form-sns">
                            <input type="text" class="form-control" placeholder="http://sample/facebook" value="" name="member_sns_facebook" />
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <label class="control-label icon_sns icon_sns_twitter form-sns">
                            <input type="text" class="form-control" placeholder="http://sample/twitter" value="" name="member_sns_twitter" />
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <label class="control-label icon_sns icon_sns_instagram form-sns">
                            <input type="text" class="form-control" placeholder="http://sample/instagram" value="" name="member_sns_instagram" />
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-9 col-sm-offset-4">
                <br/>
                <br/>
                <button type="submit" class="btn btn-info btn-labeled fa fa-plus-circle fa-lg" id="edit_user_for_admin">メンバー追加</button>
                <a href="{{URL::to('admin/idols/idolmember?id_idol='.$getData['id_idol'])}}" class="btn btn-default btn-labeled fa fa-rotate-left fa-lg">キャンセル</a>
            </div>
        </div>
    </form>
    <br/>
    <br/>
    <br/>
    <br/>
</div>
@stop