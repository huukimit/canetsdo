<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/bootstrap.min.css') }}"">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script>
      new WOW().init();
    </script>
</head>
<body>
    <header>
        <div class="my_container_header">
            <div class="header">
                <div class="header_logo">
                    <div class="header_logo_img">
                        <a href="#">
                            <img src="{{ asset('public/frontend/img/logo.png') }}" alt="" class="img img-responsive">
                        </a>
                    </div>
                </div>
                <div class="header_menu">
                    <ul>
                        <li><a href="/dang-ky-di-lam" id="dangkydilam">Đăng ký đi làm</a></li>
                        <li><a href="#gioi-thieu-ve-canets">Về chúng tôi</a></li>
                        <li><a href="/tro-giup">Trợ giúp</a></li>
                    </ul>
                    <div class="menu_xs_sm">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </div>
                </div>

                <div class="clear"></div>
            </div>
        </div>
    </header>

   {{--  <div id="categories">
        <div>
            <i class="fa fa-times closes" aria-hidden="true"></i>
        </div>
        <ul class="mobile_menu">
            <li><a href="#">Trang chủ</a></li>
            <li class="has_sub"><a href="#">Giới thiệu</a></li>
            <li>
                <a href="#">News</a>
            </li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">About</a></li>

        </ul>
    </div> --}}
    

    @yield('content')




    <footer>
        <div class="my_container_footer">
            <div class="footer">
                <div class="footer_item">
                    <ul class="menu">
                        
                        <li><span class="fa fa-users fa-lg"></span>&nbsp;&nbsp;<a href="#">Về chúng tôi</a></li>
                        <div class="mota" id="gioi-thieu-ve-canets">
                            <p>
                            Canets được coi là mô hình dẫn đầu trong việc kết nối sinh viên và gia đình. Chúng tôi đã có hơn 3 năm kinh nghiệm trong mô hình truyền thống với hơn bảy nghìn công việc được tạo.<br/>
                            </p>
                            <p>    
                            Bên cạnh đó với đội ngũ sáng lập trẻ và nhiệt huyết, chúng tôi luôn mong muốn tạo ra giá trị tốt đẹp nhất cho cộng đồng.
                            </p>
                        </div>
                        <li><a href="#linkcanetsdo"><span class="fa fa-money fa-lg"></span>&nbsp;&nbsp;Đăng ký đi làm</a></li>
                        <li><a href="javascript:void(0)"><span class="fa fa-phone fa-lg"></span>&nbsp;&nbsp;0943. 123. 365</a></li>
                        <li><a href="canets2016@gmail.com" mailto><span class="fa fa-envelope fa-lg"></span>&nbsp;&nbsp;canets2016@gmail.com</a></li>
                    </ul>
                    <div class="columns">
                        <a href="http://r.Canets.com/iosbadge"><img alt="App-store-badge" src="https://files.handy.com/assets/miscellaneous/app-store-badge-231469be108d5b87c206dd3ad4c43028.svg"></a>
                        <a href="http://r.Canets.com/androidbadge"><img alt="Play-store-badge" src="https://files.handy.com/assets/miscellaneous/play-store-badge-ef8e50389113795ce26d0ad4d3b3f131.svg"></a>
                    </div>
                    <ul class="link_icon">
                        <li><a href="#" class="icon-link" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="https://www.facebook.com/canetsgiupviec" class="icon-link" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="https://www.instagram.com/canets2017/" class="icon-link" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a href="#" class="icon-link" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                    </ul>
                </div>

                <div class="footer_item">
                    <h4>Video giới thiệu</h4>
                    <iframe width="98%" height="300px" src="https://www.youtube.com/embed/wf3BDt5X7FM" frameborder="0" allowfullscreen>
                    </iframe>
                </div>

                <div class="footer_item">
                    <h4>Fanpage</h4>
                    <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                      var js, fjs = d.getElementsByTagName(s)[0];
                      if (d.getElementById(id)) return;
                      js = d.createElement(s); js.id = id;
                      js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8";
                      fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));
                    </script>
                    <div class="fb-page" data-href="https://www.facebook.com/canetsgiupviec/" data-tabs="timeline" data-width="450" data-height="300" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/canetsgiupviec/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/canetsgiupviec/">Canets - Sinh Viên Giúp Việc</a></blockquote></div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="footer_b">
                <div class="footer_b_left">
                    <ul>
                        <li><a href="#">Privacy</a></li>
                        <li><a href="#">Cookies</a></li>
                        <li><a href="#">Terms</a></li>
                        <li><a href="#">Cancellation Policy</a></li>
                    </ul>
                </div>
                <div class="footer_b_right">
                    <p>© 2016 Canets. All rights reserved.</p>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </footer>

    <script type="text/javascript" src="{{ asset('public/frontend/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/js/owl.carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/js/myscript.js') }}"></script>
    <!-- <script type="text/javascript" src="{{ asset('public/frontend/js/my.js') }}"></script> -->
    <!--Start of Zendesk Chat Script-->
    <script type="text/javascript">
    window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
    d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
    _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
    $.src="https://v2.zopim.com/?2LDrsMcrCev0bP2ift5CtSHYhMbslW6Q";z.t=+new Date;$.
    type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
    </script>
    <!--End of Zendesk Chat Script-->
</body>
</html>
