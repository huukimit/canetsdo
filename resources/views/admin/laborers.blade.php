@extends('layouts.admin')
@section('title', 'List laborer')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                List laborer
                
            </div>
            <div class="panel-body">
                <form action="">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" value="{{ app('request')->input('search') }}" name="search">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Tìm kiếm">
                        </div>
                    </div>
                </form>
                <table class="table  table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="text-right">No.</th>
                            <th>Mã NV</th>
                            <th>Họ Tên</th>
                            <th>Điện thoại</th>
                            <th>Trường</th>
                            <th>Ví tiền</th>
                            <th>Ví TK</th>
                            <th>CV 1 lần</th>
                            <th class="text-center">Updated at </th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($main_data as $data)
                        <tr>
                            <td class="text-right">{{ $data->id }}</td>
                            <td>{{ $data->manv_kh }}</td>
                            <td><a href="/secret/laborers/{{$data->id}}" title="Xem thông tin chi tiết, chỉnh sửa">{{ $data->fullname }}</a></td>
                            <td class="text-center">{{ $data->phone_number }}</td>
                            <td>{{ $data->school }}</td>
                            <td class="text-right">{{ number_format($data->vi_tien) }}</td>
                            <td class="text-right">{{ number_format($data->vi_taikhoan) }}</td>
                            <td title="Cho phép giúp việc thường xuyên" class="text-center"><input class="onoffgvthuongxuyen" type="checkbox" @if($data->allow_gv1lan == 1) checked="" @endif value="{{$data->id}}">
                            </td>
                            <td class="text-center">{{ date('d/m/Y', strtotime($data->updated_at)) }}
                            </td>

                            <td class="text-center">
                            @if ($data->status == 0)
                                <label class="label label-warning active_user" data-id="{{ $data->id }}" id="row_{{ $data->id }}">Waiting actived</label>
                            @elseif ($data->status == 1)
                                <label class="label label-success">Active</label>
                            @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $main_data->render() !!}
            </div>
        </div>
    </div>
</div>
@stop