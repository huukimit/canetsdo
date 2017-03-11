@extends('backend._layouts.admin')
@section('main')
<form id="edit_idoladmin" class="form-horizontal" name="edit_idol" accept-charset="UTF-8" action="{{URL::to('admin/newidol')}}" method="POST" enctype="multipart/form-data">
    <div class="row panel">
        <input type="hidden" value="{{ csrf_token() }}" name="_token">
        <input type="hidden" name="id" id="id" value="{{isset($getData['idol']->id) ? $getData['idol']->id : ''}}">
        <div class="panel-heading">
            <h3 class="panel-title"></h3>
        </div>
        <div class="panel-body">
            <div class="col-sm-9">
                <div class="form-group">
                    <label class="col-sm-4 control-label">名前</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control required" placeholder="名前" value="{{isset($getData['idol']->nickname) ? $getData['idol']->nickname : ''}}" name="nickname" id="nickname">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">メールアドレス</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control required" {{isset($getData['idol']->id) && $getData['idol']->id > 0 ? 'readonly' : ''}} placeholder="メールアドレス" value="{{isset($getData['idol']->email) ? $getData['idol']->email : ''}}" name="email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">アクティベーション</label>
                    <div class="col-sm-8">
                        <label class="form-icon">
                            <input id="sw-checked-status-add-idol" type="checkbox" value="1" name="status" {{isset($getData['idol']->status) && $getData['idol']->status==1 ? 'checked' : ''}}>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">会社名</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control required" placeholder="会社名" value="{{isset($getData['idol']->clubname) ? $getData['idol']->clubname : ''}}" name="clubname">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">郵便番号</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control required" placeholder="郵便番号" value="{{isset($getData['idol']->zipcode) ? $getData['idol']->zipcode : ''}}" name="zipcode">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">住所</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control required" placeholder="住所" value="{{isset($getData['idol']->address) ? $getData['idol']->address : ''}}" name="address">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">担当者名</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control required" placeholder="担当者名" value="{{isset($getData['idol']->leader) ? $getData['idol']->leader : ''}}" name="leader">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">電話番号</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control required" placeholder="電話番号" value="{{isset($getData['idol']->phone) ? $getData['idol']->phone : ''}}" name="phone">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">担当者のメールアドレス</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control required" placeholder="担当者のメールアドレス" value="{{isset($getData['idol']->leader_email) ? $getData['idol']->leader_email : ''}}" name="leader_email">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-5">
                <button type="submit" class="btn btn-info btn-labeled fa fa-plus-circle fa-lg" id="edit_user_for_admin">保存</button>
                <a href="{{URL::to('admin')}}" class="btn btn-default btn-labeled fa fa-rotate-left fa-lg">キャンセル</a>
            </div>
        </div>
    </div>
</form>
@stop