@extends('layouts.admin')
@section('title', 'Config system')
@section('content')
<div class="panel panel-default">
    <div class="panel-body">
                <div class="row">
            <div class="col-md-12">
                <b>Config theo số điện thoại tài khoản Test Khách hàng và Lao động(ID cách nhau bới dấu phẩy) *** <p class="text-success">Khải đừng chỉnh cái này nhé</p></b> <label class="label label-info "></label>
                <hr/>
                <table class="table table-bordered" id="">
                    <tr>
                        <th class="text-center">Danh sách điện thoại KH</th>
                        <th class="text-center">Danh sách điện thoại LĐ</th>
                    </tr>
                    <tr>
                        <td>
                            <textarea class="form-control" placeholder="ID ngăn cách nhau bới dấu phẩy nhé" rows="3" id="fake_kh">{{$mainData->fake_kh}}</textarea>
                        </td>
                        <td>
                            <textarea class="form-control" placeholder="ID ngăn cách nhau bới dấu phẩy nhé" rows="3" id="fake_ld">{{$mainData->fake_ld}}</textarea>
                        </td>
                        
                    </tr>
                    <tr>
                        <td colspan="2" id=""><button class="btn btn-info btn-sm" id="fake_dev">Update</button></td>
                    </tr>
                </table>
            </div>
        </div><!-- /.row -->
        
        <div class="row">
            <div class="col-md-12">
                <b>Lương giúp việc một lần</b> <label class="label label-info "></label>
                <hr/>
                <table class="table table-bordered" id="">
                    <tr>
                        <th>Time</th>
                        <th class="text-center">2H</th>
                        <th class="text-center">3H</th>
                        <th class="text-center">4H</th>
                        <th class="text-center">5H</th>
                        <th class="text-center">6H</th>
                        <th class="text-center">7H</th>
                        <th class="text-center">8H</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <th>Cost</th>
                        @foreach (json_decode($mainData->luonggiupviec1lan, true) as $value)
                        <td>
                            <input type="" name="luonggiupviec1lan[]" class="form-control luonggiupviec1lan" readonly="true" data-hours={{$value['key']}} value="{{$value['value']}}">
                        </td>
                        @endforeach
                        <td id="td_gv1lan"><button class="btn btn-warning btn-sm" id="edit_gv1lan">Edit</button></td>
                    </tr>
                </table>
            </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <b>Lương Giúp việc thường xuyên</b> <label class="label label-info "></label>
                <hr/>
                <table class="table table-bordered" id="">
                    <tr>
                        <td class="text-center" style="vertical-align: middle;">
                            <b>Đơn giá thấp nhất/1h</b>
                        </td>
                        <td>
                            <input name="" class="form-control" id="luong1h_thuongxuyen" value="{{$mainData->luong1h_thuongxuyen}}" readonly="true">
                        </td>
                        <td class="text-center" id="td_gvthuongxuyen">
                            <button class="btn btn-warning" id="edit_gvthuongxuyen">Edit</button>
                        </td>
                </table>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <b>Thong tin chuyen khoan</b> <label class="label label-info hide_show_chuyenkhoan">(Click to show or hide)</label>
                <hr/>
                <table class="table table-bordered" id="ttchuyenkhoan">
                    <tr>
                        <th>No.</th>
                        <th class="text-center">Ngan hang</th>
                        <th class="text-center">Chu tai khoan</th>
                        <th class="text-center">So tai khoan</th>
                        <th class="text-center">Noi dung chuyen khoan</th>
                    </tr>
                    @foreach (json_decode($mainData->thongtinchuyenkhoan, true) as $key => $value)
                    <tr class="cactaikhoan">
                        <td>{{ ++$key }}</td>
                        <td>
                            <input type="" class="form-control nganhang ttck" readonly="true" value="{{$value['nganhang']}}">
                        </td>
                        <td>
                            <input type="" class="form-control chutaikhoan ttck" readonly="true" value="{{$value['chutaikhoan']}}">
                        </td>
                        <td>
                            <input type="" class="form-control sotaikhoan ttck" readonly="true" value="{{$value['sotaikhoan']}}">
                        </td>
                        <td>
                            <input type="" class="form-control noidungchuyen ttck" readonly="true" value="{{$value['noidungchuyen']}}">
                        </td>
                    </tr>
                    @endforeach
                    
                    <tr>
                        <td id="td_thongtinchuyenkhoan" colspan="5"><button class="btn btn-warning btn-sm" id="edit_ttchuyenkhoan">Edit</button></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <b>App Version</b> <label class="label label-info "></label>
                <hr/>
                <table class="table table-bordered" id="">
                    <tr>
                        <th class="text-center">Android - Canets</th>
                        <th class="text-center">Android - CanetsDo</th>
                        <th class="text-center">IOS - Canets</th>
                        <th class="text-center">IOS - CanetsDo</th>
                        
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td>
                            <input type="" name="canets_android" id="canets_android" class="form-control" value="{{$mainData->canets_android}}">
                        </td>
                        <td>
                            <input type="" name="canets_do_android" id="canets_do_android" class="form-control" value="{{$mainData->canets_do_android}}">
                        </td>
                        <td>
                            <input type="" name="canets_ios" id="canets_ios" class="form-control" value="{{$mainData->canets_ios}}">
                        </td>
                        <td>
                            <input type="" name="canets_do_ios" id="canets_do_ios" class="form-control" value="{{$mainData->canets_do_ios}}">
                        </td>
                       
                        <td id="versions"><button class="btn btn-info btn-sm" id="updateversionapp">Update</button></td>
                    </tr>
                </table>
            </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <b>Điều khoản sử dụng</b> <label class="label label-info "></label>
                <hr/>
                <table class="table table-bordered" id="">
                    <tr>
                        <th class="text-center">Dành cho Khách hàng</th>
                        <th class="text-center">Dành cho Lao động</th>
                        
                        
                    </tr>
                    <tr>
                        <td>
                            <textarea class="form-control" rows="10" id="policy_customer">{{$mainData->policy_customer}}</textarea>
                        </td>
                        <td>
                            <textarea class="form-control" rows="10" id="policy_worker">{{$mainData->policy_worker}}</textarea>
                        </td>
                        
                       
                        
                    </tr>
                    <tr>
                        <td colspan="2" id="versions"><button class="btn btn-info btn-sm" id="updatepolicy">Update</button></td>
                    </tr>
                </table>
            </div>
        </div><!-- /.row -->
    </div>
</div>
@stop
