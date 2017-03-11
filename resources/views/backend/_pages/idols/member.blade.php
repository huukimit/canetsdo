@extends('backend._layouts.admin')
@section('main')
<div class="row panel idol_members idol_member_list">
    <a href="{{URL::to('admin/idols/addmember?id_idol='.$getData['id_idol'])}}" class="btn btn-warning btn-labeled fa fa-plus-circle fa-lg">メンバー追加</a>
    @if(count($getData['members']) > 0)
    @foreach ($getData['members'] AS $k => $member)
    <div class="idol-title-no">メンバー{{$k+1}}人目</div>
    <div class="idol-member-item">
        <div class="col-sm-3 avatar_member">
            <div class="form-group">
                <img src="{{$member['avatar'] != '' ? $member['avatar'] : URL::to('/').'/'.'public/uploads/default/avatar_member.png'}}" class="avatar_user avatar_border" width="175px" height="275px"/>
            </div>
        </div>
        <div class="col-sm-8 infomation_member">
            <div class="form-group">
                <label class="col-sm-2 control-label">名前</label>
                <div class="col-sm-9">
                    <label class="control-label">{{$member['fullname'] != '' ? $member['fullname'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">生年月日</label>
                <div class="col-sm-9">
                    <label class="control-label">{{$member['birthday'] != '' ? date('Y/m/d', strtotime($member['birthday'])) : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">身長</label>
                <div class="col-sm-9">
                    <label class="control-label">{{$member['height'] != '' ? $member['height'] : '&nbsp;'}}cm</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">体重</label>
                <div class="col-sm-9">
                    <label class="control-label">{{$member['weight'] != '' ? $member['weight'] : '&nbsp;'}}kg</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">趣味</label>
                <div class="col-sm-9">
                    <label class="control-label">{{$member['interest'] != '' ? $member['interest'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">コメント</label>
                <div class="col-sm-9">
                    <label class="control-label">{{$member['comment'] != '' ? $member['comment'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-9">
                    <label class="control-label icon_sns icon_sns_facebook">{{$member['sns_facebook'] != '' ? $member['sns_facebook'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-9">
                    <label class="control-label icon_sns icon_sns_twitter">{{$member['sns_twitter'] != '' ? $member['sns_twitter'] : '&nbsp;'}}</label>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-9">
                    <label class="control-label icon_sns icon_sns_instagram">{{$member['sns_instagram'] != '' ? $member['sns_instagram'] : '&nbsp;'}}</label>
                </div>
            </div>
        </div>
    </div>
    <div class="idol-member-line"></div>
    @endforeach
    <div class="row">
        <div class="col-sm-9 col-sm-offset-3">
            <a href="{{URL::to('admin/idols/editmember?id_idol='.$getData['id_idol'])}}" class="btn btn-info btn-labeled fa fa-edit fa-lg" id="edit_user_for_admin">編集</a>
        </div>
    </div>
    @endif
    <br/>
    <br/>
    <br/>
    <br/>
</div>
@stop