<!doctype html>
<html lang="{{App::getLocale()}}">
    <head>
        <title>Change password</title>
    </head>
    <body>
        <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family:arial;font-size:14px;color:#000">
            <tbody>
                <tr>
                    <td width="100%" align="center">
                        <table cellpadding="0" cellspacing="0" border="0" width="705">
                            <tbody>
                                <tr>
                                    <td align="right" width="100%">
                                        <table cellpadding="0" cellspacing="0" border="0" style="margin:20px 3px 0;font-size:13px">
                                            <tbody>
                                                <tr>
                                                    <td><br /></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #d3e8f3;border-top:none;border-left:none">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background:#fff;border:1px solid #b1d9ee">
                                            <tbody>
                                                <tr>
                                                    <td width="100%" style="padding:25px 20px 0;text-align:justify;" >
                                                        <p style="padding:0;margin:0" align="center">
                                                            <!--<img src="{{URL::to('/').'/public/uploads/default/logo.png'}}" width="164" border="0" alt="logo image" />-->
                                                        </p>
                                                        @if($getData['nickname'] != '')
                                                        <div>
                                                            <br/>
                                                            <br/>
                                                            <b>{{$getData['nickname']}}様</b>,<br /><br /><br />
                                                            <div class="alert alert-warning fade in">
                                                                新しいパスワードを設定し、メールにて送付いたしました。<br />
                                                                新しいパスワードにて、prize candyをご利用ください。
                                                            </div>
                                                            <br/>
                                                            <div>任意のパスワードをご希望の場合は、<br/>
                                                                ログイン後、「パスワード変更」をご利用下さい。</div>
                                                            <br/>
                                                            <div>
                                                                <p>prize candy</p>
                                                                <p><a href="{{URL::to('/')}}" style="color: #2095f2;">{{URL::to('/')}}</a></p>
                                                            </div>
                                                        </div>
                                                        @else
                                                        <div>
                                                            <br/>
                                                            <br/>
                                                            <div class="alert alert-warning fade in">
                                                                {{$getData['message']}}
                                                            </div>
                                                            <br/>
                                                            <div>
                                                                <p>prize candy</p>
                                                                <p><a href="{{URL::to('/')}}" style="color: #2095f2;">{{URL::to('/')}}</a></p>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        <br /><br /><br />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="font-family:Tahoma;font-size:11px;color:#7eabc3">
                                        <p style="margin:0;padding:20px 0;line-height:20px">
                                            Copyright © prize candy All Rights Reserved.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>

