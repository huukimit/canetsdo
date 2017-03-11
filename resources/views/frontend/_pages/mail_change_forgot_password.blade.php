<style>
    body{
        width: 100%;
        background: #f5f5f5;
        float: left;
        margin: 0;
        color: #626262;
        font-size: 14px;
    }
    .wapper{
        width: 730px;
        margin: 0 auto;
    }
    .container-full{
        margin-top: 60px;
        border-radius: 4px;
        float: left;
        width: 100%;
    }
    #site-header{
        float: left;
        width: 100%;
        border-radius: 6px 6px 0 0;
    }
    #site-header p{
        text-align: center;
        margin: 0;
    }
    #site-header p img{
        width: 188px;
        height: auto;
    }
    #site-main{
        float: left;
        width: 88%;
        padding: 44px;
        background: #fff;
        border-radius: 10px;
    }
    .site-main-title{
        float: left;
        width: 100%;
        border-bottom: 1px solid #dedede;
        padding-top: 20px;
        padding-bottom: 50px;
    }
    .site-main-title p{
        text-align: center;
        margin: 0;
        line-height: 20px;
    }
    .site-main-title p.last{
        margin-top: 20px;
    }
    table{
        float: left;
        width: 100%;
        border-bottom: 1px solid #dedede;
        padding-top: 25px;
        padding-bottom: 40px;
    }
    table td{
        padding: 10px 17px;
        text-align: justify;
    }
    table td.first{
        text-align: right;
        width: 150px;
    }
    #site-main-footer{
        padding: 67px 0 40px 0;
        float: left;
        width: 100%;

    }
    #site-main-footer p{
        text-align: center;
    }
    #site-footer{
        float: left;
        width: 100%;
        padding-top: 60px;
        padding-bottom: 50px;
    }
    #site-footer p{
        text-align: center;
    }
    #site-footer p img{
        width: 20px;
        height: 26px;
    }
</style>
<body style="background: #f8f8f9;">
    <div class="wapper">
        <div class="container-full">
            <div id="site-header">
                <div class="logo">
                </div>
            </div>
            <div id="site-main">
                <p>{{$nickname}}様</p>
                <br />
                <p>★prize candy★パスワードの再発行が完了いたしました。</p>
                <p>パスワード：<span style="color: #2095f2;font-weight: bold"> {{$password}}</span></p>
                <br/>
                <p>任意のパスワードをご希望の場合は、</p>
                <p>ログイン後、「パスワード変更」のお手続きをご利用下さい。</p>
                <br/>
                <p>**********************************************************************</p>
                <p>株式会社HIROPRO</p>
                <p>◆サポートデスク◆</p>
                <p><a href="mailto:support@hiropro.co.jp"></a>support@hiropro.co.jp</p>
                <p>**********************************************************************</p>
            </div>
            <div id="site-footer"></div>
        </div>
</body>

