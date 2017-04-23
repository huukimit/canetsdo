@extends('layouts.admin')
@section('title', 'Giup viec mot lan')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Giup viec mot lan</div>
            <div class="panel-body">
                <form action="">
                    <div class="col-md-3">
                        <div class="form-group has-success">
                            <input placeholder="Nhập tiêu chí tìm kiếm..." type="text" class="form-control" value="{{ app('request')->input('search') }}" name="search">
                        </div>
                    </div>
                    <div class="col-md-4">
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
                        <a href="/secret/bookings/creategvml" class="btn btn-info">Tạo công việc</a>
                    </div>
                </form>
                    
                <table class="table  table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Time</th>
                            <th>Customer</th>
                            <th>Phone number</th>
                            <th>Address work</th>
                            <th class="text-center">Updated time </th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td><b class="text-success">{{ date('H:i', strtotime($booking->time_start)) . ' - ' . date('H:i', strtotime($booking->time_end)) }}</b></td>
                            <td>
                                @if (isset($booking->customer->fullname))
                                    {{ $booking->customer->fullname }}
                                @else
                                    <label class="label label-danger">Error by app</label>
                                @endif
                            </td>
                            <td>
                                @if (isset($booking->customer->phone_number))
                                    {{ $booking->customer->phone_number }}
                                @endif
                            </td>
                            <td>{{ $booking->address }}</td>
                            <td class="text-center">{{ date('H:i d/m/Y', strtotime($booking->updated_at)) }}</td>
                            <td class="text-center">
                            @if ($booking->status == -2)
                                <label class="label label-warning">Expiry</label>
                            @elseif ($booking->status == -1)
                                <label class="label label-danger">Cancel</label>
                            @elseif ($booking->status == 0)
                                <label class="label label-info">Waiting</label>
                            @elseif ($booking->status == 1)
                                <label class="label label-success">Doing</label>
                            @elseif ($booking->status == 2)
                                <label class="label label-default">Done</label>
                            @endif
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