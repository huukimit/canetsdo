@extends('backend._layouts.admin')
@section('main')
<div class="row panel idol_dashboard" id="idol_preview_export">
    <div class="control-report">
        <a href="{{URL::to('admin/idols/exportpdf?id_idol='.$getData['id_idol'].'&percent_hiro='.$getData['setting'].'&time_report='.$getData['time_report'])}}" class="btn btn-danger btn-labeled fa fa-external-link fa-lg btn-preview-pdf">レポートをダウンロード</a>
    </div>
    <div class="data-preview">
        <div class="report-from-to">期間：{{$getData['dateRange']['from']}}〜{{$getData['dateRange']['to']}}</div>
        <div id="data_table">
            <table cellspacing="0" cellpadding="0" border="0">
                <tbody><tr>
                        <th>年月日</th>
                        <th>獲得応援数</th>
                        <th>応援人数</th>
                        <th>平均応援数</th>
                        <th>お客様収益</th>
                    </tr>
                    @if(count($getData['lstTable']) > 0)
                    @foreach($getData['lstTable'] AS $data)
                    <tr>
                        <td>{{$data['date']}}</td>
                        <td>{{$data['zeni']}}</td>
                        <td>{{$data['count_user']}}</td>
                        <td>{{$data['average_zeni']}}</td>
                        <td>{{$data['amount']}}</td>
                    </tr>
                    @endforeach
                    @endif
                    <tr>
                        <td>計</td>
                        <td>{{$getData['data_total']['total_zeni']}}</td>
                        <td>{{$getData['percentDevices']['total']}}</td>
                        <td>{{$getData['data_total']['total_average']}}</td>
                        <td>{{$getData['data_total']['total_amout']}}</td>
                    </tr>
                </tbody></table>
        </div>
    </div>
</div>
@stop