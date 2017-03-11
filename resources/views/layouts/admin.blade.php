<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Canets - Dashboard</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/css/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('public/css/styles.css') }}" rel="stylesheet">
<link href="{{ asset('public/css/app.css') }}" rel="stylesheet">

<!--Icons-->
<script src="{{ asset('public/js/lumino.glyphs.js') }}"></script>

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span>CANETS</span>Admin</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>{{ Auth::user()->fullname }} <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							{{-- <li><a href="#"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Profile</a></li>
							<li><a href="#"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Settings</a></li> --}}
							<li><a href="/auth/logout"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div><!-- /.container-fluid -->
	</nav>
		
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<ul class="nav menu">
			<li class="active"><a href="/secret/dashboard"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg>Analytics</a></li>
			<li class="parent ">
				<a href="#">
					<span data-toggle="collapse" href="#sub-item-0"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg></span> Bookings 
				</a>
				<ul class="children collapse" id="sub-item-0">
					<li>
						<a class="" href="/secret/bookings/motlan">
							<svg class="glyph stroked female user"><use xlink:href="#stroked-female-user"/></svg>
							Giup viec mot lan
						</a>
					</li>
					<li>
						<a class="" href="/secret/bookings/thuongxuyen">
							<svg class="glyph stroked female user"><use xlink:href="#stroked-female-user"/></svg>
							Giup viec thuong xuyen
						</a>
					</li>
				</ul>
			</li>
			<li class="parent ">
				<a href="#">
					<span data-toggle="collapse" href="#sub-item-1"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg></span> Users 
				</a>
				<ul class="children collapse" id="sub-item-1">
					<li>
						<a class="" href="/secret/laborers">
							<svg class="glyph stroked female user"><use xlink:href="#stroked-female-user"/></svg>
							Laborers
						</a>
					</li>
					<li>
						<a class="" href="/secret/customers">
							<svg class="glyph stroked female user"><use xlink:href="#stroked-female-user"/></svg>
							Customers
						</a>
					</li>
					<li>
						<a class="" href="/secret/usersblocked">
							<svg class="glyph stroked flag"><use xlink:href="#stroked-flag"/></svg>
 							Users blocked
						</a>
					</li>
				</ul>
			</li>
			<li><a href="/secret/configs"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"/></svg>System config</a></li>
			<li><a href="tables.html"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Recharge</a></li>
			<li><a href="forms.html"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Forms</a></li>
			<li><a href="panels.html"><svg class="glyph stroked app-window"><use xlink:href="#stroked-app-window"></use></svg> Alerts &amp; Panels</a></li>
			<li><a href="secret/cashoutrequest"><svg class="glyph stroked star"><use xlink:href="#stroked-star"></use></svg> Cashout requested</a></li>
			
			<li role="presentation" class="divider"></li>
			<li><a href="secret/admins"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>Admin</a></li>
		</ul>

	</div><!--/.sidebar-->
		
	<!-- Start main -->	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">@yield('title')</li>
			</ol>
		</div><!--/.row-->
		
		<!-- <div class="row">
			<div class="col-lg-12">
				@section('sidebar')
		            <h1 class="page-header">Dashboard</h1>
		        @show
			</div>
		</div> -->
		<!--/.row-->

		@yield('content')

	</div>	<!--/.main-->
	@section('javascript')
	<script src="{{ asset('public/js/jquery-1.11.1.min.js') }}"></script>
	<script src="{{ asset('public/js/bootstrap.min.js') }}"></script>

	<script src="{{ asset('public/js/bootstrap-datepicker.js') }}"></script>
	<script src="{{ asset('public/js/jquery.blockUI.js') }}"></script>
	<script src="{{ asset('public/js/notify.min.js') }}"></script>
	<script src="{{ asset('public/js/ajax.js') }}"></script>
	<script src="{{ asset('public/js/app.js') }}"></script>
	
	@show	
</body>

</html>
