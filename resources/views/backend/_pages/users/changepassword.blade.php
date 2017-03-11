@extends('backend._layouts.admin')
@section('main')
<form id="changepassword_useradmin" class="form-horizontal" name="change_password" accept-charset="UTF-8" action="{{URL::to('admin/users/changepassword')}}" method="POST">
    <div class="row panel">
        <div class="col-sm-10">
            <input type="hidden" value="{{ csrf_token() }}" name="_token">
            <input type="hidden" name="id" id="id" value="{{$getData['id']}}">
            <div class="form-group"></div>
            <div class="form-group"></div>
            <div class="form-group">
                <label class="col-sm-4 control-label">新規パスワード</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control required" id="password" placeholder="新規パスワード" value="" name="password">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">パスワード確認</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control required" id="confirm_password" placeholder="パスワード確認" value="" name="confirm_password">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-4">
                    <a href="{{URL::to('admin/users/detail?id='.$getData['id'])}}" class="btn btn-default btn-labeled fa fa-arrow-left fa-lg">戻る</a>
                    <button type="submit" class="btn btn-info btn-labeled fa fa-check fa-lg">保存</button>
                </div>
            </div>
        </div>
    </div>
</form>
@stop