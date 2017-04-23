@extends('layouts.admin')
@section('title', 'Detail laborer')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Detail laborer</div>
            <div class="panel-body">
            	<form action="" method="post"  role="form" enctype="multipart/form-data">
            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
            	<input type="hidden" name="id" value="{{ $data['id'] }}">
				<div class="col-md-6">
					<div class="form-group text-center">
						<label>Avatar</label>
						<a id="example1" href="/{{$data['avatar']}}">
							<img alt="example1" src="/{{($data['avatar']) ? $data['avatar'] : 'public/uploads/media/avatar/default.png'}}" alt="Avatar" class="img-circle" width="140px" height="140px">
						</a>
						<input type="file" name="avatar" accept="image/*" class="form-control" title="Thay đổi avatar">
					</div>
					<div class="form-group">
						<label>Họ tên</label>
						<input class="form-control" name="fullname" value="{{$data['fullname']}}">
						<label>Ngày sinh</label>
						<input class="form-control" name="birthday"  value="{{date('d/m/Y',strtotime($data['birthday']))}}">
						<label>Email</label>
						<input class="form-control" name="email" type="email" required  value="{{$data['email']}}">
						<label>Số điện thoại</label>
						<input class="form-control" name="phone_number"  value="{{$data['phone_number']}}">
						<label>Trường học</label>
						<input class="form-control" name="school" value="{{$data['school']}}">
						<label>Quên quán</label>
						<input class="form-control" name="quequan" value="{{$data['quequan']}}">
						<label>Kinh nghiệm</label>
						<select class="form-control" name="month_exp">
							@foreach($month_exps as $monthexp)
								<option value="{{ $monthexp }}" @if ($data['month_exp'] == $monthexp) {{ 'selected' }} @endif>
									@if ($monthexp == 0)
										{{ 'Chưa có kinh nghiệm' }}
									@else
										{{ $monthexp . ' tháng' }}
									@endif
								</option>
							@endforeach
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
						<label>Giới thiệu bản thân</label>
						<textarea name="gioithieubanthan" class="form-control" placeholder="Giới thiệu đôi nét về bản thân...">{{$data['gioithieubanthan']}}</textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Ảnh sinh viên(mặt trước)</label>
						<a id="example1" href="/{{$data['anhsv_truoc']}}">
							<img src="/{{($data['anhsv_truoc']) ? $data['anhsv_truoc'] : 'public/uploads/media/avatar/default.png'}}" alt="Ảnh sinh viên(mặt trước)" class="img-thumbnail img_truoc_sau">
						</a>
						<input type="file" name="anhsv_truoc" accept="image/*" class="form-control" placeholder="Thay đổi Ảnh sinh viên(mặt trước)" title="Ảnh sinh viên(mặt trước)">
					</div>
					<div class="form-group">
						<label>Ảnh sinh viên(mặt sau)</label>
						<a id="example1" href="/{{$data['anhsv_sau']}}">
							<img src="/{{($data['anhsv_sau']) ? $data['anhsv_sau'] : 'public/uploads/media/avatar/default.png'}}" alt="Ảnh sinh viên(mặt sau)" class="img-thumbnail img_truoc_sau">
						</a>
						<input type="file" name="anhsv_sau" accept="image/*" class="form-control" title="Thay đổi Ảnh sinh viên(mặt sau)">
					</div>
					<div class="form-group">
						<label>Ảnh CMTND (mặt trước)</label>
						<a id="example1" href="/{{$data['anhcmtnd_truoc']}}">
							<img src="/{{($data['anhcmtnd_truoc']) ? $data['anhcmtnd_truoc'] : 'public/uploads/media/avatar/default.png'}}" alt="Ảnh CMTND (mặt trước)" class="img-thumbnail img_truoc_sau">
						</a>
						<input type="file" name="anhcmtnd_truoc" accept="image/*" class="form-control" placeholder="Thay đổi Ảnh CMTND (mặt trước)">
					</div>
					<div class="form-group">
						<label>Ảnh CMTND (mặt sau)</label>
						<a id="example1" href="/{{$data['anhcmtnd_sau']}}">
							<img src="/{{($data['anhcmtnd_sau']) ? $data['anhcmtnd_sau'] : 'public/uploads/media/avatar/default.png'}}" alt="Ảnh CMTND (mặt sau)" class="img-thumbnail img_truoc_sau">
						</a>
					<input type="file" name="anhcmtnd_sau" accept="image/*" class="form-control" placeholder="Thay đổi Ảnh CMTND (mặt sau)">
					</div>
					<div class="form-group">
						<label for="">Khóa tài khoản</label>
						<div class="checkbox">
							<label>
								<input name="status" value="-1" type="checkbox" onclick="return confirm('Bạn có chắc chắn muốn ngừng hoạt động của tài khoản này không?')" > Block user
							</label>
						</div>
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