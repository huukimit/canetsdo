@extends('backend._layouts.admin')
@section('main')
<?php
$edit = 0;
if (isset($getData['uinfo']->id) && $getData['uinfo']->id > 0) {
    $edit = 1;
}
?>
<form id="edit_idoladmin" class="form-horizontal" name="edit_idol" accept-charset="UTF-8" action="{{URL::to('admin/idols/edit')}}" method="POST" enctype="multipart/form-data">
    <div class="row panel">
        <input type="hidden" value="{{ csrf_token() }}" name="_token">
        <input type="hidden" name="id" id="id" value="{{$edit == 1 ? $getData['uinfo']->id : ''}}">
        <div class="panel-heading">
            <h3 class="panel-title">アイドル詳細</h3>
        </div>
        <div class="panel-body">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label" style="margin-top: 50px">アイドルプロフィール</label>
                    <div class="col-sm-8">
                        <img src="{{isset($getData['uinfo']->avatar) ? $getData['uinfo']->avatar : URL::to('/').'/public/uploads/default/avatar.png'}}" class="avatar_user img-circle avatar_border preview_avatar" width="100px" height="100px"/>
                        <br/>
                        <br/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label padding-label">プロフィール画像の変更</label>
                    <div class="col-sm-8">
                        <span class="pull-left btn btn-default btn-file">
                            ブラウズ... <input type="file" name="avatar" class="up_avatar_user" onchange="previewAvatar()">
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">グループ名</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control {{isset($getData['uinfo']->members) && $getData['uinfo']->members > 1 ? 'required' : ''}}" placeholder="グループ名" value="{{isset($getData['uinfo']->nickname) ? $getData['uinfo']->nickname : ''}}" name="nickname" id="nickname">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">メールアドレス</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control required" placeholder="メールアドレス" value="{{isset($getData['uinfo']->email) ? $getData['uinfo']->email : ''}}" name="email">
                    </div>
                </div>
                @if($edit == 0)
                <div class="form-group">
                    <label class="col-sm-4 control-label">パスワード</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control required" placeholder="パスワード" value="" name="password" id="password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">再度パスワード</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control required" placeholder="再度パスワード" value="" name="confirm_password" id="confirm_password">
                    </div>
                </div>
                @endif
                <div class="form-group">
                    <label class="col-sm-4 control-label">出身地</label>
                    <div class="col-sm-8 input-group">
                        <select data-placeholder="出身地" id="place-of-birth-select-idol" name="place_of_birth">
                            @foreach ($getData['locations'] AS $location)
                            <option value="{{$location->location_name}}" {{isset($getData['uinfo']->place_of_birth) && $getData['uinfo']->place_of_birth == $location->location_name ? 'selected' : ''}}>{{$location->location_name}}</option>
                            @endforeach
                        </select>
                        <span class="input-group-addon">
                            <label class="form-icon">
                                <input id="sw-checked-place-of-birth" type="checkbox" {{isset($getData['uinfo']->is_public_place_of_birth) && $getData['uinfo']->is_public_place_of_birth == 1 ? 'checked' : ''}} value="1" name="is_public_place_of_birth">
                            </label>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">活動地域</label>
                    <div class="col-sm-8 input-group">
                        <?php
                        $location_action = array();
                        if (isset($getData['uinfo']->action_location)) {
                            $arrList = explode(',', $getData['uinfo']->action_location);
                            foreach ($arrList AS $itemlocation) {
                                $location_action[] = trim($itemlocation);
                            }
                        }
                        ?>
                        <select data-placeholder="活動地域" id="action-location-select-idol" name="action_location" multiple>
                            <option value="全国" {{count($location_action) > 0 && in_array('全国',$location_action) ? 'selected' : ''}}>全国</option>
                            @foreach ($getData['locations'] AS $location)
                            <option value="{{$location->location_name}}" {{count($location_action) > 0 && in_array($location->location_name,$location_action) ? 'selected' : ''}}>{{$location->location_name}}</option>
                            @endforeach
                            <option value="海外" {{count($location_action) > 0 && in_array('海外',$location_action) ? 'selected' : ''}}>海外</option>
                        </select>
                        <input type="hidden" name="action_location" value="{{isset($getData['uinfo']->action_location) ? $getData['uinfo']->action_location : ''}}" id="action_location"/>
                        <span class="input-group-addon">
                            <label class="form-icon">
                                <input id="sw-checked-action-location" type="checkbox" {{isset($getData['uinfo']->is_public_action_location) && $getData['uinfo']->is_public_action_location == 1 ? 'checked' : ''}} value="1" name="is_public_action_location">
                            </label>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">メンバー数</label>
                    <div class="col-sm-8">
                        <select data-placeholder="メンバー数" id="number-select-idol" name="numbers">
                            @for ($i = 1;$i <= 50; $i++)
                            <option value="{{$i}}" {{isset($getData['uinfo']->members) && $i == $getData['uinfo']->members ? 'selected' : ''}}>{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group" style="{{$edit == 0 ? 'margin-top: 70px;margin-bottom: 10px' : 'margin-bottom: 10px'}}">
                    <label class="col-sm-4 control-label padding-label">所属団体、事務所等、名称入力</label>
                    <div class="col-sm-8 input-group">
                        <input type="text" class="form-control" placeholder="所属団体、事務所等、名称入力" value="" name="company" />
                        <span class="input-group-addon">
                            <label class="form-icon">
                                <input id="sw-checked-company" type="checkbox" {{isset($getData['uinfo']->is_public_company) && $getData['uinfo']->is_public_company == 1 ? 'checked' : ''}} value="1" name="is_public_company">
                            </label>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">郵便番号</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" placeholder="郵便番号" value="{{isset($getData['uinfo']->zipcode) ? $getData['uinfo']->zipcode : ''}}" name="zipcode" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">住所</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" placeholder="住所" value="{{isset($getData['uinfo']->address) ? $getData['uinfo']->address : ''}}" name="address" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">担当者名</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control required" placeholder="担当者名" value="{{isset($getData['uinfo']->leader) ? $getData['uinfo']->leader : ''}}" name="leader" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">電話番号</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control required" placeholder="電話番号" value="{{isset($getData['uinfo']->phone) ? $getData['uinfo']->phone : ''}}" name="phone" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">ジャンル</label>
                    <div class="col-sm-8 input-group">
                        <select data-placeholder="ジャンル" id="type-select-idol" name="type">
                            @foreach ($getData['cates'] AS $cate)
                            <option value="{{$cate->id}}" {{isset($getData['uinfo']->type) && $cate->id == $getData['uinfo']->type ? 'selected' : ''}}>{{$cate->cate_name}}</option>
                            @endforeach
                        </select>
                        <span class="input-group-addon">
                            <label class="form-icon">
                                <input id="sw-checked-type" type="checkbox" {{isset($getData['uinfo']->is_public_type) && $getData['uinfo']->is_public_type == 1 ? 'checked' : ''}} value="1" name="is_public_type">
                            </label>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">グループ説明</label>
                    <div class="col-sm-8 input-group">
                        <textarea placeholder="グループ説明" class="form-control" rows="5" id="demo-textarea-input" name="about">{{isset($getData['uinfo']->about) ? $getData['uinfo']->about : ''}}</textarea>
                        <span class="input-group-addon">
                            <label class="form-icon">
                                <input id="sw-checked-about" type="checkbox" {{isset($getData['uinfo']->is_public_about) && $getData['uinfo']->is_public_about == 1 ? 'checked' : ''}} value="1" name="is_public_about">
                            </label>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">登録日</label>
                    <div class="col-sm-8">
                        <input disabled="true" type="text" class="form-control" value="{{isset($getData['uinfo']->created_at) && $getData['uinfo']->created_at != '0000-00-00 00:00:00' ? date('Y/m/d', strtotime($getData['uinfo']->created_at)) : date('Y/m/d')}}" name="created_at">
                    </div>
                </div>
            </div>
        </div>
        <?php
        $lstMem = array();
        if (isset($getData['uinfo']->list_member) && count($getData['uinfo']->list_member) > 0) {
            $lstMem = $getData['uinfo']->list_member;
        }
        ?>
        @for($i=1;$i<51;$i++)
        <div class="group-member member-item-{{$i}}">
            <input type="hidden" id="id_member_{{$i}}" name="id_member_{{$i}}" value="{{isset($lstMem['member_'.$i]['id']) ? $lstMem['member_'.$i]['id'] : ''}}"/>
            <div class="panel-line-member"></div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" style="margin-top: 50px">メンバー{{$i}}人目</label>
                        <div class="col-sm-8">
                            <img src="{{isset($lstMem['member_'.$i]['avatar']) ? $lstMem['member_'.$i]['avatar'] : URL::to('/') . '/public/uploads/default/avatar.png'}}" class="avatar_user img-circle avatar_border preview_avatar_{{$i}}" width="100px" height="100px"/>
                            <br/>
                            <br/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label padding-label">プロフィール画像の変更</label>
                        <div class="col-sm-8">
                            <span class="pull-left btn btn-default btn-file">
                                ブラウズ... <input type="file" name="avatar_mem_{{$i}}" class="avatar_member up_avatar_user_{{$i}}" onchange="previewAvatarMember('{{$i}}')">
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">名前</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control fullname_member" placeholder="名前" value="{{isset($lstMem['member_'.$i]['fullname']) ? $lstMem['member_'.$i]['fullname'] : ''}}" name="fullname_{{$i}}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">性別</label>
                        <div class="col-sm-8 input-group">
                            <select data-placeholder="性別" class="gender-select-idol" name="gender_{{$i}}">
                                <option value="1" {{isset($lstMem['member_'.$i]['gender']) && $lstMem['member_'.$i]['gender'] == 1 ? 'selected' : ''}}>男性</option>
                                <option value="2" {{isset($lstMem['member_'.$i]['gender']) && $lstMem['member_'.$i]['gender'] == 2 ? 'selected' : ''}}>女性</option>
                            </select>
                            <span class="input-group-addon">
                                <label class="form-icon">
                                    <input id="sw-checked-gender-{{$i}}" type="checkbox" {{isset($lstMem['member_'.$i]['is_public_gender']) && $lstMem['member_'.$i]['is_public_gender'] == 1 ? 'checked' : ''}} value="1" name="is_public_gender_{{$i}}">
                                </label>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">生年月日</label>
                        <div class="col-sm-8 input-group">
                            <div id="birthday-component">
                                <div class="input-group date">
                                    <input type="text" class="form-control birthday_member" value="{{isset($lstMem['member_'.$i]['birthday']) && $lstMem['member_'.$i]['birthday'] != '0000-00-00' ? date('Y/m/d', strtotime($lstMem['member_'.$i]['birthday'])) : ''}}" name="birthday_{{$i}}" placeholder="生年月日">
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                                </div>
                            </div>
                            <span class="input-group-addon">
                                <label class="form-icon">
                                    <input id="sw-checked-birthday-{{$i}}" type="checkbox" {{isset($lstMem['member_'.$i]['is_public_birthday']) && $lstMem['member_'.$i]['is_public_birthday'] == 1 ? 'checked' : ''}} value="1" name="is_public_birthday_{{$i}}">
                                </label>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">出身地</label>
                        <div class="col-sm-8 input-group">
                            <select data-placeholder="出身地" class="localtion-select-idol" name="place_of_birth_{{$i}}">
                                @foreach ($getData['locations'] AS $location)
                                <option value="{{$location->location_name}}" {{isset($lstMem['member_'.$i]['place_of_birth']) && $lstMem['member_'.$i]['place_of_birth'] == $location->location_name ? 'selected' : ''}}>{{$location->location_name}}</option>
                                @endforeach
                            </select>
                            <span class="input-group-addon">
                                <label class="form-icon">
                                    <input id="sw-checked-place-of-birth-{{$i}}" type="checkbox" {{isset($lstMem['member_'.$i]['is_public_place_of_birth']) && $lstMem['member_'.$i]['is_public_place_of_birth'] == 1 ? 'checked' : ''}} value="1" name="is_public_place_of_birth_{{$i}}">
                                </label>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">趣味</label>
                        <div class="col-sm-8 input-group">
                            <input type="text" class="form-control interest_member" placeholder="趣味" value="{{isset($lstMem['member_'.$i]['interest']) ? $lstMem['member_'.$i]['interest'] : ''}}" name="interest_{{$i}}">
                            <span class="input-group-addon">
                                <label class="form-icon">
                                    <input id="sw-checked-interest-{{$i}}" type="checkbox" {{isset($lstMem['member_'.$i]['is_public_interest']) && $lstMem['member_'.$i]['is_public_interest'] == 1 ? 'checked' : ''}} value="1" name="is_public_interest_{{$i}}">
                                </label>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">身長</label>
                        <div class="col-sm-8 input-group">
                            <input type="text" class="form-control height_member" placeholder="身長" value="{{isset($lstMem['member_'.$i]['height']) ? $lstMem['member_'.$i]['height'] : ''}}" name="height_{{$i}}">
                            <span class="input-group-addon">
                                <label class="form-icon">
                                    <input id="sw-checked-height-{{$i}}" type="checkbox" {{isset($lstMem['member_'.$i]['is_public_height']) && $lstMem['member_'.$i]['is_public_height'] == 1 ? 'checked' : ''}} value="1" name="is_public_height_{{$i}}">
                                </label>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">体重</label>
                        <div class="col-sm-8 input-group">
                            <input type="text" class="form-control weight_member" placeholder="体重" value="{{isset($lstMem['member_'.$i]['weight']) ? $lstMem['member_'.$i]['weight'] : ''}}" name="weight_{{$i}}">
                            <span class="input-group-addon">
                                <label class="form-icon">
                                    <input id="sw-checked-weight-{{$i}}" type="checkbox" {{isset($lstMem['member_'.$i]['is_public_weight']) && $lstMem['member_'.$i]['is_public_weight'] == 1 ? 'checked' : ''}} value="1" name="is_public_weight_{{$i}}">
                                </label>
                            </span>
                        </div>
                    </div>
                    <div class="form-group metric_member">
                        <label class="col-sm-4 control-label">スリーサイズ</label>
                        <div class="col-sm-8">
                            <?php
                            $metric = array(
                                'b' => '',
                                'w' => '',
                                'h' => ''
                            );
                            if (isset($lstMem['member_' . $i]['metric']) && !empty($lstMem['member_' . $i]['metric'])) {
                                $metric_ex = explode("-", $lstMem['member_' . $i]['metric']);
                                $metric['b'] = isset($metric_ex[0]) ? $metric_ex[0] : '';
                                $metric['w'] = isset($metric_ex[1]) ? $metric_ex[1] : '';
                                $metric['h'] = isset($metric_ex[2]) ? $metric_ex[2] : '';
                            }
                            ?>
                            <div class="col-sm-3" style="padding: 0">
                                <label class="col-sm-4 control-label">B</label>
                                <div class="col-sm-8" style="padding: 0">
                                    <input type="text" class="form-control" placeholder="B" name="metric_b_{{$i}}" value="{{$metric['b']}}">
                                </div>
                            </div>
                            <div class="col-sm-3" style="padding: 0">
                                <label class="col-sm-4 control-label">W</label>
                                <div class="col-sm-8" style="padding: 0">
                                    <input type="text" class="form-control" placeholder="W" name="metric_w_{{$i}}" value="{{$metric['w']}}">
                                </div>
                            </div>
                            <div class="col-sm-3" style="padding: 0">
                                <label class="col-sm-4 control-label">H</label>
                                <div class="col-sm-8" style="padding: 0">
                                    <input type="text" class="form-control" placeholder="H" name="metric_h_{{$i}}" value="{{$metric['h']}}">
                                </div>
                            </div>
                            <div class="col-sm-3" style="padding: 0">
                                <div class="col-sm-8 input-group" style="padding: 0">
                                    <span class="input-group-addon">
                                        <label class="form-icon">
                                            <input id="sw-checked-metric-{{$i}}" type="checkbox" {{isset($lstMem['member_'.$i]['is_public_metric']) && $lstMem['member_'.$i]['is_public_metric'] == 1 ? 'checked' : ''}} value="1" name="is_public_metric_{{$i}}">
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label padding-label">過去に影響を受けたもの</label>
                        <div class="col-sm-8 input-group">
                            <textarea placeholder="過去に影響を受けたもの" class="form-control inspired_what_member" rows="3" id="demo-textarea-input" name="inspired_what_{{$i}}">{{isset($lstMem['member_'.$i]['inspired_what']) ? $lstMem['member_'.$i]['inspired_what'] : ''}}</textarea>
                            <span class="input-group-addon">
                                <label class="form-icon">
                                    <input id="sw-checked-inspired-what-{{$i}}" type="checkbox" {{isset($lstMem['member_'.$i]['is_public_inspired_what']) && $lstMem['member_'.$i]['is_public_inspired_what'] == 1 ? 'checked' : ''}} value="1" name="is_public_inspired_what_{{$i}}">
                                </label>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label padding-label">過去に影響を受けた人物</label>
                        <div class="col-sm-8 input-group">
                            <textarea placeholder="過去に影響を受けた人物" class="form-control inspired_person_member" rows="3" id="demo-textarea-input" name="inspired_person_{{$i}}" >{{isset($lstMem['member_'.$i]['inspired_person']) ? $lstMem['member_'.$i]['inspired_person'] : ''}}</textarea>
                            <span class="input-group-addon">
                                <label class="form-icon">
                                    <input id="sw-checked-inspired-person-{{$i}}" type="checkbox" {{isset($lstMem['member_'.$i]['is_public_inspired_person']) && $lstMem['member_'.$i]['is_public_inspired_person'] == 1 ? 'checked' : ''}} value="1" name="is_public_inspired_person_{{$i}}">
                                </label>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endfor
        @if($edit == 0)
        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-5">
                <button type="submit" class="btn btn-info btn-labeled fa fa-plus-circle fa-lg" id="edit_user_for_admin">新規登録</button>
                <a href="{{URL::to('admin/idols/list')}}" class="btn btn-default btn-labeled fa fa-rotate-left fa-lg">キャンセル</a>
            </div>
        </div>
        @else
        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-4">
                <a href="{{URL::to('admin/idols/detail?id='.$getData['uinfo']->id)}}" class="btn btn-default btn-labeled fa fa-arrow-left fa-lg">戻る</a>
                <button type="submit" class="btn btn-info btn-labeled fa fa-edit fa-lg" id="edit_user_for_admin">保存</button>
                <a href="{{URL::to('admin/users/list')}}" class="btn btn-default btn-labeled fa fa-rotate-left fa-lg">キャンセル</a>
            </div>
        </div>
        @endif
    </div>
</form>
@stop