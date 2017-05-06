@extends('layouts.admin')
@section('title', 'Feedbacks từ phía khách hàng')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Feedbacks từ phía khách hàng</div>
            <div class="panel-body">
	            <div class="col-md-12">
	            	<table class="table  table-striped table-bordered">
	                    <thead>
	                        <tr>
	                            <th class="text-center">Thời gian</th>
	                            <th>Đối tượng</th>
	                            <th>Số điện thoại</th>
	                            <th>Name</th>
	                            <th class="col-md-5">Lời góp ý, hỗ trợ</th>
	                            <th class="col-md-1">Đánh dấu supported</th>
	                        </tr>
	                    </thead>

	                    <tbody>
		                    @foreach ($feedbacks as $feedback)
			                    @if ($feedback->customer)
	                        	<tr>
		                        	<td class="text-center">
		                        		{{ date('d/m/Y', strtotime($feedback->created_at))}}
		                        	</td>
		                        	<td>
		                        		@if($feedback->customer->type_customer == 1)
		                        			<label class="label label-info">Lao động</label>
		                        		@else
		                        			<label class="label label-success">Khách hàng</label>
		                        		@endif
		                        	</td>
		                        	<td>{{ $feedback->customer->phone_number }}</td>
		                        	<td>{{ $feedback->customer->fullname }}</td>
		                        	<td>{{ $feedback->feedback }}</td>
		                        	<td>
		                        		@if ($feedback->replied == 0)
		                        			<input type="checkbox" class="mark_supported" data-id ="{{ $feedback->id }}">
		                        		@else
		                        			<label class="label label-primary">Supported</label>
		                        		@endif
		                        	</td>
		                        </tr>
		                        @endif
	                        @endforeach
	                    </tbody>
                    </table>
					{!! $feedbacks->render() !!}
	            </div>
            </div>
        </div>
    </div>
</div>
@stop