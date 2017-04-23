@extends('layouts.admin')
@section('title', 'Tạo công việc thường xuyên')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Tạo công việc thường xuyên</div>
            <div class="panel-body">
            	<form action="" method="post"  role="form" enctype="multipart/form-data">
            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
            	<div class="col-md-12">
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
				<div class="col-md-6">
					<div class="form-group">
						<label>Địa điểm</label>
						<input class="form-control" name="address" value="" required="">
						<label>Thời gian bắt đầu</label>
						<input class="form-control" name="time_start" value="" required="">
						<label>Thời gian kết thúc</label>
						<input class="form-control" name="time_end"  required  value="" required="">
						<label>Ngày làm trong tuần</label>
						@foreach($thutrongtuan as $thu)
							<div class="checkbox">
								<label>
									<input class="ngaylamtrongtuan" name="ngaylamtrongtuan[]" value={{ $thu }} type="checkbox">
									{{ $thu }}
								</label>
							</div>
						@endforeach
						<label>Yêu cầu công việc</label>
						@foreach($requires as $require)
							<div class="checkbox">
								<label>
									<input class="viecphailam" name="viecphailam[]" value={{$require->id}} type="checkbox">
									{{$require->name}}
								</label>
							</div>
						@endforeach
						<label for=""><b>Ưu tiên</b></label><br/>
						<label for="">- Có thể làm trong</label>
						<select class="form-control" name="thoigianlam">
							@foreach($thoigianlam as $month)
								<option value="{{ $month }}">
									{{ $month . ' tháng'}}
								</option>
							@endforeach
						</select>
						<div class="checkbox">
							<label>
								<input name="has_phuongtien" value="1" type="checkbox">
								Có phương tiện đi lại
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input name="has_ancunggd" value="1" type="checkbox">
								Ăn cơm cùng gia đình
							</label>
						</div>
					</div>
				</div>
						
				<div class="col-md-6">
					<div class="form-group">
						
						<label>Ghi chú</label>
						<textarea class="form-control" name="note" placeholder="Nhập ghi chú" required=""></textarea> 
						<label>Lương</label>
						<input class="form-control" name="luong" value="" id="luong" type="number" required="">
						<label>Thưởng</label>
						<select class="form-control" name="thuong" id="thuong" required="">
							@foreach($mucthuongs as $mucthuong)
								<option value="{{ $mucthuong['key'] }}">{{ $mucthuong['value'] }}</option>
							@endforeach
						</select>
						<label>Tổng thu nhập</label>
						<input class="form-control" name="tongchiphi" id="tongchiphi" value="" readonly="">
						<label>Ảnh nhà(1)</label>
						<input type="file" name="anh1" accept="image/*" class="form-control" title="Ảnh căn hộ">
						<label>Ảnh nhà(2)</label>
						<input type="file" name="anh2" accept="image/*" class="form-control" title="Ảnh căn hộ">
						<label>Ảnh nhà(3)</label>
						<input type="file" name="anh3" accept="image/*" class="form-control" title="Ảnh căn hộ">
						<label>Latitude</label>
						<input class="form-control" name="lat" id="lat" value="" readonly="" required="">
						<label>Longtitude</label>
						<input class="form-control" name="long" id="long" value="" readonly="" required="">
					</div>
				</div>
				
	            <div class="col-md-10"></div>
	            <div class="col-md-1">
	            	<input type="submit" class="btn btn-primary" onclick="return validateCreateTX()" id="create_thuongxuyen" value="Tạo mới">
	            </div>
            	</form>
            </div>
        </div>
    </div>
</div>
@stop