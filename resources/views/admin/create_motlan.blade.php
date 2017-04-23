@extends('layouts.admin')
@section('title', 'Tạo giúp việc một lần')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Tạo giúp việc một lần</div>
            <div class="panel-body">
            	<form action="" method="post"  role="form">
            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
            	<div class="col-md-7">
					<div id="pac-container" class="has-success">
			        	<input id="pac-input" class="form-control" type="text"
			            placeholder="Enter a location">
			        </div>
					<div id="map" style="width:100%;height:500px;"></div>
					<div id="infowindow-content">
				      <img src="" width="16" height="16" id="place-icon">
				      <span id="place-name"  class="title"></span><br>
				      <span id="place-address"></span>
				    </div>
				</div>
				<div class="col-md-5">
					<div class="form-group">
						<label>Địa điểm</label>
						<input class="form-control" name="address" value="">
						<label>Thời gian bắt đầu</label>
						<input class="form-control" name="time_start" value="">
						<label>Thời gian kết thúc</label>
						<input class="form-control" name="time_end"  required  value="">
						<label>Ghi chú</label>
						<textarea class="form-control" name="note" placeholder="Nhập ghi chú" required=""></textarea> 
						<label>Lương</label>
						<input class="form-control" name="luong" value="" id="luong">
						<label>Thưởng</label>
						<select class="form-control" name="thuong" id="thuong">
							@foreach($mucthuongs as $mucthuong)
								<option value="{{ $mucthuong['key'] }}">{{ $mucthuong['value']}}</option>
							@endforeach
						</select>
						<label>Tổng thu nhập</label>
						<input class="form-control" name="tongchiphi" id="tongchiphi" value="" readonly="">
						<label>Latitude</label>
						<input class="form-control" name="lat" id="lat" value="" readonly="">
						<label>Longtitude</label>
						<input class="form-control" name="long" id="long" value="" readonly="">
					</div>
				</div>
				
	            <div class="col-md-10"></div>
	            <div class="col-md-1">
	            	<input type="submit" class="btn btn-primary" value="Tạo mới">
	            </div>
            	</form>
            </div>
        </div>
    </div>
</div>
@stop