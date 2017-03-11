@extends('layouts.admin')
@section('title', 'List laborer')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">List customer</div>
            <div class="panel-body">
                <table class="table  table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="text-right">No.</th>
                            <th>Ma KH</th>
                            <th>Full name</th>
                            <th>Phone number</th>
                            <th>School</th>
                            <th>Vi tien</th>
                            <th>Vi tai khoan</th>
                            <th class="text-center">Updated at </th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($main_data as $data)
                        <tr>
                            <td class="text-right">{{ $data->id }}</td>
                            <td>{{ $data->manv_kh }}</td>
                            <td>{{ $data->fullname }}</td>
                            <td class="text-center">{{ $data->phone_number }}</td>
                            <td>{{ $data->school }}</td>
                            <td class="text-right">{{ $data->vi_tien }}</td>
                            <td class="text-right">{{ $data->vi_taikhoan }}</td>
                            <td class="text-center">{{ date('H:i d/m/Y', strtotime($data->updated_at)) }}</td>
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
                {!! $main_data->render() !!}
            </div>
        </div>
    </div>
</div>
@stop