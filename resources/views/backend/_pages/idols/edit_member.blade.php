@extends('backend._layouts.admin')
@section('main')
<div class="row panel idol_members">
    @if(count($getData['members']) > 0)
    <form id="edit_member_idol" class="form-horizontal" name="edit_member" accept-charset="UTF-8" action="{{URL::to('admin/idols/editmember')}}" method="POST" enctype="multipart/form-data">
        <input type="hidden" value="{{ csrf_token() }}" name="_token">
        <input type="hidden" value="{{count($getData['members'])}}" name="number_member" id="number_member">
        <input type="hidden" value="{{$getData['id_idol']}}" name="id_idol">
        @foreach ($getData['members'] AS $k => $member)
        <div class="idol-title-no">メンバー{{$k+1}}人目</div>
        <input type="hidden" value="{{$member['id']}}" name="member_id_{{($k)}}">
        <div class="idol-member-item">
            <div class="col-sm-3 avatar_member">
                <div class="form-group">
                    <div style="display: none" id="crop-image-member-{{$k}}" class="crop-image-member-item"></div>
                    <img id="result-image-member-{{$k}}" src="{{$member['avatar'] != '' ? $member['avatar'] : URL::to('/').'/'.'public/uploads/default/avatar_member.png'}}" class="avatar_user avatar_border preview_avatar_{{$k}}" width="175px" height="275px"/>
                    <!--<small class="help-block">(イメージ サイズ：440px x 690px)</small>-->
                </div>
                <div class="form-group" style="text-align: center">
                    <button style="display: none" class="btn btn-info fa fa-rotate-left fa-lg vanilla-rotate-{{$k}}" data-deg="-90" type="button"></button>
                    <button style="margin-left: 8px;display: none" class="btn btn-info fa fa-rotate-right fa-lg vanilla-rotate-{{$k}}" data-deg="90" type="button"></button>
                </div>
                <div class="form-group">
                    <span class="pull-left btn btn-default btn-file">
                        ブラウズ... <input id="upload_member_{{$k}}" type="file" class="up_avatar_user" accept="image/*">
                    </span>
                    <input type="hidden" value="" id="upload_image_crop_member_{{$k}}" name="image_crop_member_{{$k}}"/>
                    <button style="margin-left: 15px;display: none" type="button" class="btn btn-info btn-labeled fa fa-crop fa-lg" id="crop_image_upload_member_{{$k}}">Crop</button>
                </div>
            </div>
            <div class="col-sm-9 infomation_member">
                <div class="form-group">
                    <label class="col-sm-2 control-label">名前</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control required" placeholder="名前" value="{{$member['fullname'] != '' ? $member['fullname'] : ''}}" name="member_fullname_{{($k)}}" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">生年月日</label>
                    <div class="col-sm-9">
                        <div id="birthday-component">
                            <div class="input-group date">
                                <input type="text" class="form-control birthday_member" value="{{$member['birthday'] != '0000-00-00' ? date('Y/m/d', strtotime($member['birthday'])) : ''}}" name="member_birthday_{{($k)}}" placeholder="生年月日">
                                <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">身長</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" class="form-control required" placeholder="身長" value="{{$member['height'] != '' ? $member['height'] : ''}}" name="member_height_{{($k)}}" />
                            <span class="input-group-addon">cm</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">体重</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" class="form-control required" placeholder="体重" value="{{$member['weight'] != '' ? $member['weight'] : ''}}" name="member_weight_{{($k)}}" />
                            <span class="input-group-addon">kg</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">趣味</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control required" placeholder="趣味" value="{{$member['interest'] != '' ? $member['interest'] : ''}}" name="member_interest_{{($k)}}" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">コメント</label>
                    <div class="col-sm-9">
                        <textarea class="form-control required" rows="3" placeholder="コメント" name="member_comment_{{($k)}}">{{$member['comment'] != '' ? $member['comment'] : ''}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <label class="control-label icon_sns icon_sns_facebook form-sns">
                            <input type="text" class="form-control required" placeholder="http://sample/facebook" value="{{$member['sns_facebook'] != '' ? $member['sns_facebook'] : ''}}" name="member_sns_facebook_{{($k)}}" />
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <label class="control-label icon_sns icon_sns_twitter form-sns">
                            <input type="text" class="form-control required" placeholder="http://sample/twitter" value="{{$member['sns_twitter'] != '' ? $member['sns_twitter'] : ''}}" name="member_sns_twitter_{{($k)}}" />
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <label class="control-label icon_sns icon_sns_instagram form-sns">
                            <input type="text" class="form-control required" placeholder="http://sample/instagram" value="{{$member['sns_instagram'] != '' ? $member['sns_instagram'] : ''}}" name="member_sns_instagram_{{($k)}}" />
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12" style="text-align: right;padding-right: 54px;">
                        <a data="{{URL::to('admin/idols/deletemember?id='.$member['id']).'&id_idol='.$getData['id_idol']}}" href="javascript::void(0)" class="btn btn-default btn-labeled fa fa-trash fa-lg delete_member_idol">削除</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="idol-member-line"></div>
        @endforeach
        <div class="row">
            <div class="col-sm-9 col-sm-offset-3">
                <button type="submit" class="btn btn-info btn-labeled fa fa-edit fa-lg" id="edit_user_for_admin">編集</button>
                <a href="{{URL::to('admin/idols/addmember?id_idol='.$getData['id_idol'])}}" class="btn btn-warning btn-labeled fa fa-plus-circle fa-lg">メンバー追加</a>
                <a href="{{URL::to('admin/idols/idolmember?id_idol='.$getData['id_idol'])}}" class="btn btn-default btn-labeled fa fa-rotate-left fa-lg">キャンセル</a>
            </div>
        </div>
    </form>
    @endif
    <br/>
    <br/>
    <br/>
    <br/>
</div>
@stop