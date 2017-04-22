@extends('layouts.admin')
@section('title', 'Detail laborer')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Detail laborer</div>
            <div class="panel-body">
            	<form action="" method="post"  role="form">
            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="col-md-6">
					<div class="form-group text-center">
						<label>Avatar</label>
						<img src="/{{($data['avatar']) ? $data['avatar'] : 'public/uploads/media/avatar/default.png'}}" alt="Avatar" class="img-circle" width="140px" height="140px">
						<input type="file" name="avatar" accept="image/*" class="form-control" title="Thay đổi avatar">
					</div>
					<div class="form-group">
						<label>Họ tên</label>
						<input class="form-control" name="fullname" value="{{$data['fullname']}}">
						<label>Ngày sinh</label>
						<input class="form-control" name="birthday"  value="{{date('d/m/Y',strtotime($data['birthday']))}}">
						<label>Email</label>
						<input class="form-control" name="birthday" type="email" required  value="{{$data['email']}}">
						<label>Số điện thoại</label>
						<input class="form-control" name="birthday"  value="{{$data['phone_number']}}">
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
						@foreach($requires as $require)
							<div class="checkbox">
								<label>
									<input name="cando[]" value={{$require->id}} type="checkbox" value="" @if(in_array($require->id, json_decode($data['cando'], true))) {{ 'checked' }} @endif>
									{{$require->name}}
								</label>
							</div>
						@endforeach
						<label>Công việc khác</label>
						<input class="form-control" name="congviec_khac" value="{{$data['congviec_khac']}}">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Ảnh sinh viên(mặt trước)</label>
						<img src="/{{($data['anhsv_truoc']) ? $data['anhsv_truoc'] : 'public/uploads/media/avatar/default.png'}}" alt="Ảnh sinh viên(mặt trước)" class="img-thumbnail img_truoc_sau">
						<input type="file" name="anhsv_truoc" accept="image/*" class="form-control" placeholder="Thay đổi Ảnh sinh viên(mặt trước)" title="Ảnh sinh viên(mặt trước)">
					</div>
					<div class="form-group">
						<label>Ảnh sinh viên(mặt sau)</label>
						<img src="/{{($data['anhsv_sau']) ? $data['anhsv_sau'] : 'public/uploads/media/avatar/default.png'}}" alt="Ảnh sinh viên(mặt sau)" class="img-thumbnail img_truoc_sau">
						<input type="file" name="anhsv_sau" accept="image/*" class="form-control" title="Thay đổi Ảnh sinh viên(mặt sau)">
					</div>
					<div class="form-group">
						<label>Ảnh CMTND (mặt trước)</label>
						<img src="/{{($data['anhcmtnd_truoc']) ? $data['anhcmtnd_truoc'] : 'public/uploads/media/avatar/default.png'}}" alt="Ảnh CMTND (mặt trước)" class="img-thumbnail img_truoc_sau">
						<input type="file" name="anhcmtnd_truoc" accept="image/*" class="form-control" placeholder="Thay đổi Ảnh CMTND (mặt trước)">
					</div>
					<div class="form-group">
						<label>Ảnh CMTND (mặt sau)</label>
						<img src="/{{($data['anhcmtnd_sau']) ? $data['anhcmtnd_sau'] : 'public/uploads/media/avatar/default.png'}}" alt="Ảnh CMTND (mặt sau)" class="img-thumbnail img_truoc_sau">
					<input type="file" name="anhcmtnd_sau" accept="image/*" class="form-control" placeholder="Thay đổi Ảnh CMTND (mặt sau)">
					</div>
				</div>
					
	            <div class="col-md-12">
	            	<input type="submit" class="btn btn-primary" value="Lưu thông tin">
	            </div>
            	</form>
            </div>
        </div>
    </div>
</div>
@stop