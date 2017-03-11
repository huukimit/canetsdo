@extends('layouts.admin')
@section('title', 'Config system')
@section('content')
<div class="panel panel-default">
    <div class="panel-body">
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
    </div>
</div>
@stop
