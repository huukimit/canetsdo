@extends('layouts.admin')
@section('title', 'Detail laborer')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Detail laborer</div>
            <div class="panel-body">
            	<form action=""  role="form">
				<div class="col-md-6">
					<div class="form-group">
						<label>Họ tên</label>
						<input class="form-control" name="fullname" value="{{$data['fullname']}}">
						<label>Ngày sinh</label>
						<input class="form-control" name="birthday"  value="{{$data['birthday']}}">
						<label>Trường học</label>
						<input class="form-control" name="school" value="{{$data['school']}}">
						<label>Quên quán</label>
						<input class="form-control" name="quequan" value="{{$data['quequan']}}">
						<label>Kinh nghiệm</label>
						<select class="form-control" name="month_exp">
							<option value="0">Chưa có kinh nghiệm</option>
							<option value="1">1 tháng</option>
							<option value="2">2 tháng</option>
							<option value="3">3 tháng</option>
							<option value="4">4 tháng</option>
							<option value="5">4 tháng</option>
							<option value="6">Nhiều hơn 6 tháng</option>
						</select>
						<label>Công việc có thể làm</label>
						@foreach()
							<div class="checkbox">
								<label>
									<input type="checkbox" value="">Checkbox 1
								</label>
							</div>
						@endforeach
						
				</div>
				<div class="col-md-6">
					
				</div>
            		
            	</form>
            </div>
        </div>
    </div>
</div>
@stop