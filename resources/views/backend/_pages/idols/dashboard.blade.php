@extends('backend._layouts.admin')
@section('main')
<div class="row panel idol_dashboard">
    <div class="row header-dashboard">
        <div class="col-md-5 idol-image">
            <div class="idol-banner">
                <img src="{{$getData['idol']->banner != '' ? URL::to('/').'/'.$getData['idol']->banner : URL::to('/').'/public/uploads/default/banner.png'}}" />
            </div>
            <div class="idol-logo"><img src="{{$getData['idol']->avatar != '' ? URL::to('/').'/'.$getData['idol']->avatar : URL::to('/').'/public/uploads/default/logo.png'}}" /></div>
        </div>
        <div class="col-md-7 idol-info">
            <div class="form-group">
                <label class="control-label">登録名 : {{$getData['idol']->nickname}}</label>
            </div>
            <div class="form-group">
                <label class="control-label">登録日 : {{date('Y/m/d', strtotime($getData['idol']->created_at))}}</label>
            </div>
        </div>
    </div>
    <div class="middle-dashboard">
        <div class="count-item">
            <div class="title-count-item">応援人数</div>
            <div class="no-count-item">{{$getData['idol']->count_click_zeni}}</div>
        </div>
        <div class="count-item">
            <div class="title-count-item">総獲得pt</div>
            <div class="no-count-item">{{$getData['idol']->zeni}}</div>
        </div>
        <div class="count-item">
            <div class="title-count-item">収益</div>
            <div class="no-count-item">{{$getData['idol']->amount}}</div>
        </div>
    </div>
    <div class="bottom-dashboard">
        <div class="title-chart">
            <div class="left-title-chart">収益</div>
            <div class="center-title-chart">
                <span class="zeni-chart">獲得pt <span>{{$getData['total_plot1']}}</span>pt</span>
                <span class="point-chart">収益額 <span>{{$getData['total_plot2']}}</span>円</span>
            </div>
            <form action="{{URL::to('admin/idols/dashboard')}}" id="chart_time" method="GET">
                <input type="hidden" name="id_idol" value="{{$getData['idol']->id}}" />
                <div class="time-action">
                    <select name="type" id="time_action_chart">
                        <option value="1" {{$getData['type_report'] == 1 ? 'selected' : ''}}>過去1週間</option>
                        <option value="2" {{$getData['type_report'] == 2 || $getData['type_report'] == 0 ? 'selected' : ''}}>今月</option>
                        <option value="3" {{$getData['type_report'] == 3 ? 'selected' : ''}}>先月</option>
                        <option value="4" {{$getData['type_report'] == 4 ? 'selected' : ''}}>過去3か月</option>
                        <option value="5" {{$getData['type_report'] == 5 ? 'selected' : ''}}>過去6か月</option>
                        <option value="6" {{$getData['type_report'] == 6 ? 'selected' : ''}}>過去1年</option>
                    </select>
                </div>
            </form>
        </div>
        <div id="content-witget-chart">
        </div>
    </div>
    <div class="view-more-hiro"><a href="{{URL::to('admin/idols/report?id_idol='.$getData['idol']->id)}}">詳しく見る</a></div>
</div>
<script type="text/javascript">
    $(document).ready(function (){
    var img_height = $(".header-dashboard .idol-banner img").height();
            $(".idol_dashboard .header-dashboard").height(img_height);
    });</script>
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