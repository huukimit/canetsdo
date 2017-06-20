@extends('layouts.admin')
@section('title', 'Giao dịch nạp thẻ')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Giao dịch nạp thẻ</div>
            <div class="panel-body">
                    
                <table class="table  table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Time</th>
                            <th>Customer</th>
                            <th>Nhà mạng</th>
                            <th>Mã thẻ</th>
                            <th>Serial</th>
                            <th class="text-center">Mệnh giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($napthes as $napthe)
                        <tr>
                            <td class="text-center">{{ $napthe->id }}</td>
                            <td class="text-center"><b class="text-success">{{ $napthe->created_at }}</b></td>
                            <td>
                                @if (isset($napthe->customer->fullname))
                                    <a href="/secret/laborers/{{$napthe->customer->id}}">
                                    {{ ($napthe->customer->type_customer == 2) ? 'KH: ' : 'LĐ: ' }}
                                    {{ $napthe->customer->fullname }}<br/>
                                    </a>
                                    @if($napthe->customer->phone_number != '')
                                    <label>0{{ number_format((int) $napthe->customer->phone_number, 0, ",", ".") }}</label>
                                    @endif
                                @else
                                    <label class="label label-danger">Error by app</label>
                                @endif
                            </td>
                            <td class="text-center"> {{ $napthe->reason }}<br/> </td>
                            <td class="text-center"> {{ $napthe->masothecao }}<br/> </td>
                            <td class="text-center"> {{ $napthe->seri }}<br/> </td>
                            <td class="text-center">
                                <label class="label label-success">+ {{ number_format($napthe->amount_moneys) }} </label>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $napthes->render() !!}
            </div>
        </div>
    </div>
</div>
@stop