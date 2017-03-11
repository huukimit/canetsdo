<meta http-equiv="Content-Language" content="{{App::getLocale()}}" />
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<base href="{{ url('/').'/' }}" /><!--[if IE]></base><![endif]-->
<title>{{$website_info['title']}}</title>
<meta name="TITLE" content="{{$website_info['title']}}" />
<meta name="DESCRIPTION" content="{{$website_info['description']}}" />
<link type="image/x-icon" rel="icon" href="{{$website_info['favicon']}}">
<link rel="shortcut icon" href="{{$website_info['favicon']}}" />
<link rel="icon" type="image/png" href="{{$website_info['favicon']}}" />
<meta name="LANGUAGE" content="{{App::getLocale()}}" />
<meta name="AUTHOR" content="{{$website_info['author_name']}}" />
<link rel="author" href="{{URL::to('/humans.txt')}}" />
<link rel="publisher" href="{{$website_info['author_link']}}"/>
<link rel="author" href="{{$website_info['author_name']}}" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
{!! $extraHeaderCSS !!}
{!! $extraHeader !!}
{!! $extraHeaderJS !!}