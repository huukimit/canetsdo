@extends('layouts.admin')
@section('title', 'Cộng trừ tiền')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Thông báo</div>
            <div class="panel-body">
            	<form action="" method="post"  role="form" enctype="multipart/form-data">
	            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="col-md-4">
						<div class="form-group">
							<label>Chọn Customer hoặc Lao động</label>
							<select class="form-control" name="id" id="use_select2">
								@foreach($customers as $customer)
									<option value="{{ $customer->id }}">
										{{ $customer->manv_kh . ' - '. $customer->fullname }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="form-group has-warning">
							<label>Hành động</label>
							<select class="form-control" name="type" class="">
								<option value="1">Cộng tiền</option>
								<option value="-1">Trừ tiền</option>
							</select>
						</div>
						<div class="form-group has-warning">
							<label>Thao tác trên</label>
							<select class="form-control" name="vi" class="">
								<option value="vi_taikhoan">Ví tài khoản</option>
								<option value="vi_tien">Ví tiền</option>
							</select>
						</div>
						<div class="form-group has-warning">
							<label>Số tiền</label>
							<input type="number" class="form-control" name="sotien" value="" required="">
						</div>
						<div class="form-group has-warning">
							<label>Lý do</label>
							<textarea class="form-control" name="reason" required="" placeholder="Nhập nội dung cần thông báo..."></textarea>
						</div>
						<div class="form-group">
		            		<input type="submit" class="btn btn-primary" value="Thực hiện giao dịch">
						</div>
					</div>
        		</form>
        	</div>
        </div>
    </div>
</div>

@stop