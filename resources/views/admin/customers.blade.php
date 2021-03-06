@extends('layouts.admin')
@section('title', 'List customer')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">List customer</div>
            <div class="panel-body">
                <form action="">

                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" name="search" value="{{ app('request')->input('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group has-success">
                            <input type="date" class="form-control" value="{{ app('request')->input('create_date') }}" name="create_date" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Tìm kiếm">
                        </div>
                    </div>
                </form>
                <table class="table  table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="text-right">No.</th>
                            <th>Ma KH</th>
                            <th>Full name</th>
                            <th>Phone number</th>
                            <th>School</th>
                            <th>Vi tai khoan</th>
                            <th class="text-center">Created at </th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($main_data as $data)
                        <tr>
                            <td class="text-right">{{ $data->id }}</td>
                            <td>{{ $data->manv_kh }}</td>
                            <td>
                                <a href="/secret/laborers/{{$data->id}}" title="Xem thông tin chi tiết, chỉnh sửa">{{ $data->fullname }}
                                </a>
                            </td>
                            <td>{{ $data->phone_number }}</td>
                            <td>{{ $data->school }}</td>
                            <td class="text-right">{{ number_format($data->vi_taikhoan) }}</td>
                            <td class="text-center">{{ date('H:i d/m/Y', strtotime($data->created_at)) }}</td>
                            <td class="text-center">
                            @if ($data->status == 0)
                                <label class="label label-warning">Registered</label>
                            @elseif ($data->status == 1)
                                <label class="label label-success">Verified</label>
                            @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $main_data->appends(Input::except('page'))->render() !!}
            </div>
        </div>
    </div>
</div>
@stop