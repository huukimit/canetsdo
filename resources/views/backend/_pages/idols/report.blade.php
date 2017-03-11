@extends('backend._layouts.admin')
@section('main')
<div class="row panel idol_dashboard" id="idol_report">
    <form method="GET" action="{{URL::to('admin/idols/report')}}" id="report-hiro">
        <input type="hidden" name="id_idol" value="{{$getData['idol']->id}}" />
        <div class="control-report">
            <div class="percent-hiro">
                <div class="title-percent">利益配分率<span>HIROPRO</span></div>
                <div class="value-percent">
                    <select name="percent_hiro" id="setting_percent">
                        <option value="0" {{$getData['setting'] == 0 ? 'selected' : ''}}>0</option>
                        <option value="5" {{$getData['setting'] == 5 ? 'selected' : ''}}>5</option>
                        <option value="10" {{$getData['setting'] == 10 ? 'selected' : ''}}>10</option>
                        <option value="15" {{$getData['setting'] == 15 ? 'selected' : ''}}>15</option>
                        <option value="20" {{$getData['setting'] == 20 ? 'selected' : ''}}>20</option>
                        <option value="25" {{$getData['setting'] == 25 ? 'selected' : ''}}>25</option>
                        <option value="30" {{$getData['setting'] == 30 ? 'selected' : ''}}>30</option>
                        <option value="35" {{$getData['setting'] == 35 ? 'selected' : ''}}>35</option>
                        <option value="40" {{$getData['setting'] == 40 ? 'selected' : ''}}>40</option>
                        <option value="45" {{$getData['setting'] == 45 ? 'selected' : ''}}>45</option>
                        <option value="50" {{$getData['setting'] == 50 ? 'selected' : ''}}>50</option>
                        <option value="55" {{$getData['setting'] == 55 ? 'selected' : ''}}>55</option>
                        <option value="60" {{$getData['setting'] == 60 ? 'selected' : ''}}>60</option>
                        <option value="65" {{$getData['setting'] == 65 ? 'selected' : ''}}>65</option>
                        <option value="70" {{$getData['setting'] == 70 ? 'selected' : ''}}>70</option>
                        <option value="75" {{$getData['setting'] == 75 ? 'selected' : ''}}>75</option>
                        <option value="80" {{$getData['setting'] == 80 ? 'selected' : ''}}>80</option>
                        <option value="85" {{$getData['setting'] == 85 ? 'selected' : ''}}>85</option>
                        <option value="90" {{$getData['setting'] == 90 ? 'selected' : ''}}>90</option>
                        <option value="95" {{$getData['setting'] == 95 ? 'selected' : ''}}>95</option>
                        <option value="100" {{$getData['setting'] == 100 ? 'selected' : ''}}>100</option>
                    </select>
                </div>
                <div class="percent">%</div>
            </div>
            <div class="preview-report">
                <a href="{{URL::to('admin/idols/previewexport?id_idol='.$getData['idol']->id.'&percent_hiro='.$getData['setting'].'&time_report='.$getData['time_report'])}}" class="btn btn-danger btn-labeled fa fa-external-link fa-lg btn-preview-pdf">レポートをプレビュー</a>
            </div>
        </div>
        <div class="report-infomation">
            <div class="amount-zeni">
                <div class="title-info">収益額</div>
                <div class="value-info"><span class="zeni">{{$getData['idol']->amount}}</span>円</div>
            </div>
            <div class="amount-zeni total-zeni">
                <div class="title-info">総獲得pt</div>
                <div class="value-info"><span class="zeni">{{$getData['idol']->zeni}}</span>pt</div>
            </div>
        </div>
        <div class="bottom-dashboard">
            <div class="title-chart">
                <div class="center-title-chart">
                    <span class="zeni-chart">獲得pt <span>{{$getData['total_plot1']}}</span>pt</span>
                    <span class="point-chart">収益額 <span>{{$getData['total_plot2']}}</span>円</span>
                </div>
                <div class="time-action">
                    <select name="time_report" id="time_report">
                        @foreach($getData['listMonth'] AS $k => $month)
                        <option value="{{$k}}" {{$getData['time_report'] == $k ? 'selected' : ''}}>{{$month}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div id="content-witget-chart">
            </div>
        </div>
    </form>
    <div class="report-user">
        <div class="user-devices item-report">
            <div class="item-report-title">応援人数</div>
            <div class="item-report-value">
                <span class="zeni-value">{{isset($getData['percentDevices']['total']) ? $getData['percentDevices']['total'] : 0}}</span>
            </div>
            <div class="user-bar">
                <div class="bar-chart">
                    @if(isset($getData['percentDevices']['apple']) && $getData['percentDevices']['apple'] > 0)
                    <span class="user-apple" style="width: {{isset($getData['percentDevices']['apple']) ? $getData['percentDevices']['apple'] : 0}}%">{{isset($getData['percentDevices']['apple']) ? $getData['percentDevices']['apple'] : 0}}%</span>
                    @endif
                    @if(isset($getData['percentDevices']['google']) && $getData['percentDevices']['google'] > 0)
                    <span class="user-google" style="width: {{isset($getData['percentDevices']['google']) ? $getData['percentDevices']['google'] : 0}}%">{{isset($getData['percentDevices']['google']) ? $getData['percentDevices']['google'] : 0}}%</span>
                    @endif
                </div>
            </div>
            <div class="text-help-user">
                <div class="bar-chart">
                    <span class="text-apple">apple</span>
                    <span class="text-google">google</span>
                </div>
            </div>
        </div>
        <div class="user-zeni-report item-report">
            <div class="item-report-title">平均</div>
            <div class="group-user-report group-user-report-first">
                <div class="value-zeni">{{$getData['averageZeni']}}</div>
                <div class="text-help">平均pt</div>
            </div>
            <div class="group-user-report">
                <div class="value-zeni">{{$getData['averageAmount']}}</div>
                <div class="text-help">平均収益</div>
            </div>
        </div>
    </div>
</div>
<script src="{{URL::to('/')}}/public/templates/backend/js/highstock.js"></script>
<script type="text/javascript">
        Number.prototype.format = function (n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
                return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
        };
        $(function () {
        $('#content-witget-chart').highcharts('StockChart', {
        title: {
        text: '.'
        },
                rangeSelector: {
                selected: 1
                }, xAxis: {
        type: 'datetime',
                labels: {
                format: '{value:%Y年<br/>%m月%d日}',
                }
        },
                yAxis: {
                showLastLabel: true,
                        labels: {
                        formatter: function () {
                        return  this.value.format() + ' 円';
                        }
                        }, plotLines: [{
                value: 0,
                        width: 2,
                        color: 'silver'
                }],
                        opposite: false,
                        gridLineDashStyle: 'longdash',
                },
                plotOptions: {
                series: {
                threshold: 0
                },
                },
                rangeSelector : {
                enabled: false
                },
                tooltip: {
                crosshairs: true,
                        borderWidth: 0,
                        borderRadius: 1,
                        formatter: function () {
                        console.log(this);
                                var s = '';
                                $.each(this.points, function () {
                                s += '<span style="font-weight:bold;font-size:11px;line-hight:20px; color:' + this.series.color + ';font-family:' + "Meiryo" + '">● ' + this.series.name + ' : ' + Highcharts.numberFormat(this.y, 0, ' ', ',') + ' 円 </span><br/>';
                                });
                                return s;
                        },
                        headerFormat: '',
                        valueSuffix: ' 円'
                },
                series: [{
                name: '獲得pt',
                        color: '#6fece3',
                        marker: {
                        symbol: 'circle'
                        },
                        data: {{$getData['plot1']}}

                }, {
                name: '収益額',
                        color: '#ffa2ce',
                        marker: {
                        symbol: 'circle'
                        },
                        data: {{$getData['plot2']}}
                }]
        });
        });
</script>
@stop