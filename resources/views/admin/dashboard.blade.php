@extends('layouts.admin')
@section('title', 'Analytics')
@section('content')
<div class="row">
    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="panel panel-blue panel-widget ">
            <div class="row no-padding">
                <div class="col-sm-3 col-lg-5 widget-left">
                    <svg class="glyph stroked bag"><use xlink:href="#stroked-bag"></use></svg>
                </div>
                <div class="col-sm-9 col-lg-7 widget-right">
                    <div class="large">{{ $customerNumber }}</div>
                    <div class="text-muted">Customers</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="panel panel-orange panel-widget">
            <div class="row no-padding">
                <div class="col-sm-3 col-lg-5 widget-left">
                    <svg class="glyph stroked empty-message"><use xlink:href="#stroked-empty-message"></use></svg>
                </div>
                <div class="col-sm-9 col-lg-7 widget-right">
                    <div class="large">{{ $laborersNumber }}</div>
                    <div class="text-muted">Laborers</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="panel panel-teal panel-widget">
            <div class="row no-padding">
                <div class="col-sm-3 col-lg-5 widget-left">
                    <svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
                </div>
                <div class="col-sm-9 col-lg-7 widget-right">
                    <div class="large">{{ $bookingNumber }}</div>
                    <div class="text-muted">Bookings</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="panel panel-red panel-widget">
            <div class="row no-padding">
                <div class="col-sm-3 col-lg-5 widget-left">
                    <svg class="glyph stroked app-window-with-content"><use xlink:href="#stroked-app-window-with-content"></use></svg>
                </div>
                <div class="col-sm-9 col-lg-7 widget-right">
                    <div class="large">{{ $bookingDoneNumber }}</div>
                    <div class="text-muted">Bookings done</div>
                </div>
            </div>
        </div>
    </div>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Booking traffic</div>
            <div class="panel-body">
                <div class="canvas-wrapper">
                    <canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>
                </div>
                <input type="hidden" id="lastweek" name="" value="{{$lastw}}">
                <input type="hidden" id="thisweek" name="" value="{{$thisw}}">
            </div>
        </div>
    </div>
</div><!--/.row-->

<div class="row">
    <div class="col-xs-6 col-md-3">
        <div class="panel panel-default">
            <div class="panel-body easypiechart-panel">
                <h4>New Booking</h4>
                <div class="easypiechart" id="easypiechart-blue" data-percent="92" ><span class="percent">92%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-6 col-md-3">
        <div class="panel panel-default">
            <div class="panel-body easypiechart-panel">
                <h4>Doing or received</h4>
                <div class="easypiechart" id="easypiechart-orange" data-percent="65" ><span class="percent">65%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-6 col-md-3">
        <div class="panel panel-default">
            <div class="panel-body easypiechart-panel">
                <h4>New Users</h4>
                <div class="easypiechart" id="easypiechart-teal" data-percent="56" ><span class="percent">56%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-6 col-md-3">
        <div class="panel panel-default">
            <div class="panel-body easypiechart-panel">
                <h4>Visitors</h4>
                <div class="easypiechart" id="easypiechart-red" data-percent="27" ><span class="percent">27%</span>
                </div>
            </div>
        </div>
    </div>
</div><!--/.row-->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
                <div class="panel-heading">Follow booking locations </div>
                <div class="panel-body">
                    <div id="googleMap" style="width:100%;height:500px;"></div>
                </div>
                <div id="danhdau" style="display: none">{{$markers}}</div>
        </div>
    </div>
</div>
@stop
@section('javascript')
    @parent
    <script src="{{ asset('public/js/chart.min.js') }}"></script>
    <script src="{{ asset('public/js/chart-data.js') }}"></script>
    <script src="{{ asset('public/js/easypiechart.js') }}"></script>
    <script src="{{ asset('public/js/easypiechart-data.js') }}"></script>
    <script>
        $('#calendar').datepicker({
        });
        !function ($) {
            $(document).on("click","ul.nav li.parent > a > span.icon", function(){          
                $(this).find('em:first').toggleClass("glyphicon-minus");      
            }); 
            $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
        }(window.jQuery);

        $(window).on('resize', function () {
          if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
        })
        $(window).on('resize', function () {
          if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
        })
    </script>
    <script>
        var map;
        var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
        var icons = {
          gvmotlan: {
            icon: iconBase + 'parking_lot_maps.png'
          },
          gvthxuyen: {
            icon: iconBase + 'library_maps.png'
          },
          giasu: {
            icon: iconBase + 'info-i_maps.png'
          }
        };
        function initMap() {
            var uluru = {lat: 21.027066, lng: 105.854064};
            map = new google.maps.Map(document.getElementById('googleMap'), {
                zoom: 12,
                center: uluru,
                mapTypeId: 'roadmap',
                animation:google.maps.Animation.BOUNCE
            });
            var marker = new google.maps.Marker({
                position: uluru,
                map: map
            });
            var lls = JSON.parse($('#danhdau').text());
            var len = lls.length;
            var doings = [];
            var typebk;
            for(var i = 0; i < len; i++ ) {
                if (lls[i]['type'] == 1) {
                    typebk = 'gvmotlan';
                } else if(lls[i]['type'] == 2) {
                    typebk = 'gvthxuyen';
                }
                doings.push({
                    position: new google.maps.LatLng(lls[i]['lat'], lls[i]['long']),
                    type: typebk
                }); 
            }

            for (var i = 0, feature; feature = doings[i]; i++) {
                addMarker(feature);
            }
        }

        function addMarker(feature) {
            var marker = new google.maps.Marker({
                position: feature.position,
                icon: icons[feature.type].icon,
                map: map
            });
        }
    </script>
    <script async defer src="http://maps.googleapis.com/maps/api/js?key=AIzaSyD6J8yqv8PPT9su-UjX1YO2QXOLcnVj8bw&callback=initMap"></script>
@stop