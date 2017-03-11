<div id="page-title">
    <h1 class="page-header text-overflow">{{$website_info['title']}}</h1>
    <div class="searchbox" @if(!$getData['search_form'])style="display:none;"@endif >
         <div class="input-group custom-search-form">
            {!! Form::open(array('class' => 'form' , 'name' => 'search-form')) !!}
            {!! Form::text('text', null, ['required','class'=>'form-control','placeholder'=>'Search..']) !!}
            <span class="input-group-btn">
                <button type="button" class="text-muted"><i class="fa fa-search"></i></button>
            </span>
            {!! Form::close() !!}
        </div>
    </div>
    @if (Session::has('message'))
    <div class="alert alert-success fade in">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <i class="fa fa-info fa-fw fa-lg"></i>{{ Session::get('message') }}
    </div>
    @endif
    @if (Session::has('error'))
    <div class="alert alert-danger fade in">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <i class="fa fa-info fa-fw fa-lg"></i>{{ Session::get('error') }}
    </div>
    @endif
</div>

<!--<ol class="breadcrumb">
    <li><a href="{{route('AminPost')}}">Home</a></li>{!!$getData['breadcrumb']!!}<li class="active">{{$website_info['title']}}</li>
</ol>-->

<div id="page-content">@yield('main')</div>