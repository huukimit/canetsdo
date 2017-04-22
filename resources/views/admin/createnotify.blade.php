@extends('layouts.admin')
@section('title', 'Thông báo')
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
						<label>Tiêu đề</label>
						<input class="form-control" name="title" value="" required="">
					</div>
					<div class="form-group">
						<label>Nội dung</label>
						<textarea class="form-control" rows=5 name="content" required="" placeholder="Nhập nội dung cần thông báo..."></textarea>
					</div>
					<div class="form-group">
						<label>Đối tượng nhận thông báo</label>
						<div class="radio">
							<label>
								<input type="radio" name="type" id="type" value="1" checked>Lao động
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="type" id="type" value="2" checked>Khách hàng
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="type" id="type" value="0" checked>Lao động và khách hàng
							</label>
						</div>
					</div>
					<div class="form-group">
	            		<input type="submit" class="btn btn-primary" value="Gửi thông báo">
					</div>

				</div>

	            <div class="col-md-8">
	            	<table class="table  table-striped table-bordered">
	                    <thead>
	                        <tr>
	                            <th class="text-center">Ngày tạo</th>
	                            <th>Tiêu đề</th>
	                            <th>Nội dung</th>
	                            <th>Thông báo tới:</th>
	                        </tr>
	                    </thead>

	                    <tbody>
		                     @foreach ($thongbaos as $thongbao)
	                        <tr>
	                        	<td class="text-center">
	                        		{{ date('d/m/Y', strtotime($thongbao->created_at))}}
	                        	</td>
	                        	<td>{{ $thongbao->title }}</td>
	                        	<td>{{ $thongbao->content }}</td>
	                        	<td>
	                        		@if ($thongbao->type == 0)
	                        			{{ 'KH&LĐ' }}
	                        		@elseif($thongbao->type == 1)
	                        			{{ 'Lao động' }}
	                        		@else
	                        			{{ 'Khách hàng' }}
	                        		@endif
	
	                        	</td>
	                        </tr>
	                        @endforeach
	                    </tbody>
                    </table>
					{!! $thongbaos->render() !!}
	            </div>
            	</form>
            </div>
        </div>
    </div>
</div>
@stop