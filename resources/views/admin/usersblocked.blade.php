@extends('layouts.admin')
@section('title', 'List laborer')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">List user blocked</div>
            <div class="panel-body">
                <table class="table  table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="text-right">No.</th>
                            <th>Ma (NV-KH)</th>
                            <th>Full name</th>
                            <th>Phone number</th>
                            <th>School</th>
                            <th>Vi tien</th>
                            <th>Vi tai khoan</th>
                            <th class="text-center">Updated at </th>
                            <th class="text-center">Re-active</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($main_data as $data)
                        <tr id="{{ $data->id }}">
                            <td class="text-right">{{ $data->id }}</td>
                            <td>{{ $data->manv_kh }}</td>
                            <td>{{ $data->fullname }}</td>
                            <td class="text-center">{{ $data->phone_number }}</td>
                            <td>{{ $data->school }}</td>
                            <td class="text-right">{{ $data->vi_tien }}</td>
                            <td class="text-right">{{ $data->vi_taikhoan }}</td>
                            <td class="text-center">{{ date('H:i d/m/Y', strtotime($data->updated_at)) }}</td>
                            <td class="text-center">
                            	<label class="label label-info re-active" data-id="{{ $data->id }}"> Re-active</label>
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