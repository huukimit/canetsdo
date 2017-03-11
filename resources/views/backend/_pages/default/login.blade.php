@extends('backend._layouts.login')

@section('main')

<div class="cls-container" id="container">
    <div class="bg-img img-balloon" id="bg-overlay"></div>
    <br/><br/><br/><br/><br/><br/><br/>
    <div class="cls-content" id="form-login">
        <div class="cls-content-sm panel">
            <div class="panel-body">
                <h3><p class="pad-btm">Login to prize candy admin</p></h3>
                @if (Session::has('error'))
                <div class="alert alert-warning fade in">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <i class="fa fa-warning fa-fw fa-lg"></i>{{ Session::get('error') }}
                </div>
                @endif
                @if (Session::has('message'))
                <div class="alert alert-success fade in">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <i class="fa fa-success fa-fw fa-lg"></i>{{ Session::get('message') }}
                </div>
                @endif
                <form role="form" method="POST" action="{{route('AminLogin')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="url_previous" value="{{$getData['url_previous']}}">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                            <input type="text" placeholder="メールアドレス" class="form-control" autocomplete="off" name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                            <input type="password" placeholder="パスワド" class="form-control" autocomplete="off" name="password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 text-left checkbox">
                            <label class="form-icon form-text" onclick="cLogin.ShowFormForget();" style="padding: 0 0 0 5px;">
                                パスワードをお忘れですか？
                            </label>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group text-right" style="float: right;margin-right: 5px;">
                                <button type="submit" class="btn btn-success btn-labeled fa fa-check fa-lg" >ログイン</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="cls-content" id="form-forget" style="display:none;">
        <div class="cls-content-sm panel">
            <div class="panel-body">
                <h4><p class="pad-btm">登録時に登録されたメールアドレスを入力してください。</p></h4>
                <form role="form" method="POST" action="{{URL::to('admin/forgotpassword')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                            <input type="email" name="email_reset" placeholder="メールアドレス" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6" style="padding-left: 12px;">
                            <div class="form-group text-left">
                                <button type="button" onclick="cLogin.ShowFormLogin();" class="btn btn-default btn-labeled fa fa-arrow-left fa-lg" >送信</button>
                            </div>
                        </div>
                        <div class="col-xs-6" style="padding-right: 12px;">
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success btn-labeled fa fa-check fa-lg" >送信</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var cLogin = {};
        cLogin.ShowFormForget = function () {
            $(".cls-content").hide(1000);
            $("#form-forget").show("slow");
        };
        cLogin.ShowFormLogin = function () {
            $(".cls-content").hide(1000);
            $("#form-login").show("slow");
        };
    </script>

</div>


@stop