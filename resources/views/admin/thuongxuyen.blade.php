@extends('layouts.admin')
@section('title', 'Giup viec thuong xuyen')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Giup viec thuong xuyen</div>
            <div class="panel-body">
                <form action="">
                    <div class="col-md-3">
                        <div class="form-group has-success">
                            <input placeholder="Nhập từ khóa  tìm kiếm..." type="text" class="form-control" value="{{ app('request')->input('search') }}" name="search">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group has-success">
                            <input type="date" class="form-control" value="{{ app('request')->input('create_date') }}" name="create_date" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group has-success">
                            <select name="status" id="" class="form-control">
                            @foreach($statuses as $status => $nameStatus)
                                <option value="{{ $status }}" @if((int) app('request')->input('status') == $status) {{ 'selected' }} @endif>
                                {{$nameStatus}}
                                </option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Tìm kiếm">
                        </div>
                    </div>
                    <div class="col-md-2">
                        {{-- <a href="/secret/bookings/creategvtx" class="btn btn-info">Tạo công việc</a> --}}
                    </div>
                </form>
                <table class="table  table-striped table-bordered" style="width: 1300px">
                    <thead>
                        <tr>
                            <th class="col-md-1">Time</th>
                            <th class="col-md-1">Customer</th>
                            <th class="col-md-2">Address work</th>
                            <th class="col-md-1">Lao động</th>
                            <th class="text-center col-md-1">Status</th>
                            <th class="text-center col-md-1">Hình ảnh căn hộ</th>
                            <th class="text-center col-md-1">Ngày tạo</th>
                            <th class="text-center col-md-2">Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                        <tr>
                            <td><b class="text-success">{{ $booking->time_start . ' - ' . $booking->time_end }}</b></td>
                            <td>
                                @if (isset($booking->customer->fullname))
                                    {{ $booking->customer->fullname }}<br/>
                                    @if($booking->customer->phone_number != '')
                                        <label>0{{ number_format((int) $booking->customer->phone_number, 0, ",", ".") }}</label>
                                    @endif
                                @else
                                    <label class="label label-danger">Error by app</label>
                                @endif
                            </td>
                            
                            <td>
                                {{ $booking->address }}
                                @if($booking->note != '')
                                    <p class="text-red">Ghi chú: {{ $booking->note }}</p>
                                @endif
                            </td>
                            <td>
                                @foreach($booking->bids as $bid)
                                    @if(isset($bid->laodong->id))
                                        <a class=" {{ ($bid->status == 0) ? 'text-muted' : '' }}" href="/secret/laborers/{{ $bid->laodong_id }}">{{ $bid->laodong->fullname }}</a><br/>
                                    @endif
                                @endforeach
                            </td>
                            
                            <td class="text-center">
                            <?php
                                switch($booking->status) {
                                    case -13:
                                        $label = '<label class="label label-warning">Khách hàng không nhận</label>';
                                        break;
                                    case -12:
                                        $label = '<label class="label label-danger">SV hủy</label>';
                                        break;
                                    case -11:
                                        $label = '<label class="label label-danger">KH hủy</label>';
                                    case -2:
                                        $label = '<label class="label label-danger">Hết hạn</label>';
                                        break;
                                    case 1:
                                        $label = '<label class="label label-info">Đã có sv nhận việc</label>';
                                        break;
                                    case 3:
                                        $label = '<label class="label label-info">KH đã chọn SV</label>';
                                        break;
                                    case 2:
                                        $label = '<label class="label label-success">Giao dịch thành công</label>';
                                        break;
                                    default:
                                        $label = '<label class="label label-info">Waiting</label>';
                                        break;
                                }
                                echo $label;
                            ?>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <a href="/{{ $booking->anh1 }}">
                                                <img src="/{{($booking->anh1) ? $booking->anh1 : 'public/uploads/media/avatar/default.png'}}" alt="Ảnh ăn hộ" class="img_mini">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="/{{ $booking->anh2 }}">
                                                <img src="/{{($booking->anh2) ? $booking->anh2 : 'public/uploads/media/avatar/default.png'}}" alt="Ảnh ăn hộ" class="img_mini">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="/{{ $booking->anh3 }}">
                                                <img src="/{{($booking->anh3) ? $booking->anh3 : 'public/uploads/media/avatar/default.png'}}" alt="Ảnh ăn hộ" class="img_mini">
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="text-center">{{ date('H:i d/m/Y', strtotime($booking->created_at)) }}</td>
                            <td>
                                <textarea class="note_booking form-control" data-id={{$booking->id}} name="note_byadmin"cols="30" rows="2" placeholder="Nhập chú thích">{{$booking->note_byadmin}}</textarea>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $bookings->render() !!}
            </div>
        </div>
    </div>
</div>
@stop