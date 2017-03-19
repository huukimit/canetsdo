<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <title>Canets</title>
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
        <div class="my_container">
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
                        <li><a href="#">Home</a></li>
                        <li><a href="#">News</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">About</a></li>
                    </ul>
                    <div class="menu_xs_sm">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </div>
                </div>

                <div class="clear"></div>
            </div>
        </div>
    </header>

    <div id="categories">
        <div>
            <i class="fa fa-times closes" aria-hidden="true"></i>
        </div>
        <ul class="mobile_menu">
            <li><a href="#">Trang chủ</a></li>
            <li class="has_sub"><a href="#">Giới thiệu</a></li>
            <li>
                <a href="#">News</a>
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                <ul class="cat_furniture">
                    <li><a href="#">Catalogue</a></li>
                    <li><a href="#">Catalogue</a></li>
                    <li><a href="#">Catalogue</a></li>
                    <li><a href="#">Catalogue</a></li>
                    <li><a href="#">Catalogue</a></li>
                    <li><a href="#">Catalogue</a></li>
                </ul>
            </li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">About</a></li>

        </ul>
    </div>


    <section id="video">
        <div class="my_container">
            <div class="video">
                <div class="v_video">
                    <div class="video_text">
                        <h1>Ứng dụng tìm sinh viên giúp việc, gia sư đầu tiên</h1>
                        <p>Sinh viên trong mạng lưới Canets được đảm bảo</p>
                    </div>
                    <div class="video_play">
                        <div class="bor_play">
                            <i class="fa fa-play" style="margin-left: 7px" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="video_opt">
            <div class="opt">
                <!-- <a href="#" class="">Tạo công việc</a> -->
            </div>
            <div class="opt">
                <!-- <a href="#" class="">Xem tât cả dịch vụ</a> -->
            </div>
        </div>
    </section>

    <div class="sec_video">
        <iframe id="playVideo" width="100%" height="100%" src="https://www.youtube.com/embed/2eRwmbhm9Ic" frameborder="0" allowfullscreen></iframe>
    </div>

    <section id="section_two">
        <div class="my_container">
            <div class="section_two">
                <div class="section_two_item">
                    <div class="section_two_item_img">
                        <a href="#"><img src="{{ asset('public/frontend/img/furture_1.png') }}" class="img img-responsive wow rollIn" alt=""></a>
                    </div>
                    <div class="section_two_item_des">
                        <b><big>Sinh viên đã được <br/>
                        kiểm duyệt<br/></big></b><br/>
                       Toàn bộ sinh viên trên hệ thống đã được <b>Canets</b> xác nhận thông tin, có kinh nghiệm làm việc và độ tin tưởng cao
                        
                    </div>
                </div>

                <div class="section_two_item">
                    <div class="section_two_item_img">
                        <a href="#"><img src="{{ asset('public/frontend/img/furture_2.png') }}" class="img img-responsive wow pulse" alt=""></a>
                    </div>
                    <div class="section_two_item_des">
                        <b><big>Thời gian tìm người <br/>
                        Nhanh chóng<br/></big></b><br/>
                       Thời gian tìm người chỉ từ 10 phút<br/>
                       nhanh như pha 1 tách cà phê
                        
                    </div>
                </div>

                <div class="section_two_item">
                    <div class="section_two_item_img">
                        <a href="#"><img src="{{ asset('public/frontend/img/furture_3.png') }}" class="img img-responsive wow shake" alt=""></a>
                    </div>
                    <div class="section_two_item_des">
                        <b><big> Lựa chọn ứng viên <br/>
                        phù hợp<br/></big></b><br/>
                       Dự trên thông tin của sinh viên ứng tuyển, bạn có thể lựa chọn cho gia đình sinh viên phù hợp nhất theo nhiều tiêu chí
                        
                    </div>
                </div>

                <div class="section_two_item">
                    <div class="section_two_item_img">
                        <a href="#"><img src="{{ asset('public/frontend/img/furture_4.png') }}" class="img img-responsive wow lightSpeedIn" alt=""></a>
                    </div>
                    <div class="section_two_item_des">
                        <b><big>Chi phí tiết kiệm <br>
                       Chỉ từ  25.000 Đ/1h</big><br/></b><br/>
                       Bạn có thể tìm ngay cho gia đình sinh viên phụ giúp công việc gia đình hiệu quả
                    </div>
                </div>

                <div class="clear"></div>
            </div>
        </div>
    </section>



    <section id="section_three">
        <div class="section_three">
            <div class="section_three_borleft"></div>
            <div class="section_three_borright"></div>
        </div>
        <div class="my_container">
            <div class="title">
                <h3>Canets helps you get your home in order</h3>
            </div>
            <div class="stt_one" id="step_1">
                <div class="stt_one_left">
                    <img src="{{ asset('public/frontend/img/step1.png') }}" class="img img-responsive steps wow rollIn center" alt="">
                </div>
                <div class="stt_one_right">
                    <div class="number wow bounce">1</div>
                    <div class="description">
                        <p>Cài đặt ứng dụng Canets</p>
                    </div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="stt_one" id="step_2">
                <div class="stt_one_left">
                    <img src="{{ asset('public/frontend/img/step2.png') }}" class="img img-responsive steps wow rollIn left" alt="">
                </div>
                <div class="stt_one_right">
                    <div class="number wow bounceInRight center">2</div>
                    <div class="description">
                        <p>Nhập địa chỉ, thời gian, yêu cầu,....</p>
                    </div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="stt_one" id="step_3">
                <div class="stt_one_left">
                    <img src="{{ asset('public/frontend/img/step3.png') }}" class="img img-responsive steps wow rollIn center" alt="">
                </div>
                <div class="stt_one_right">
                    <div class="number wow shake">3</div>
                    <div class="description">
                        <p>Lựa chọn ứng viên phù hợp</p>
                    </div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="stt_one" id="step_4">
                <div class="stt_one_left">
                    <img src="{{ asset('public/frontend/img/step4.png') }}" class="img img-responsive steps wow bounceInDown center" alt="">
                </div>
                <div class="stt_one_right">
                    <div class="number wow lightSpeedIn center">4</div>
                    <div class="description">
                        <p>Liên hệ và xác nhận </p>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </section>


    <section id="stt_five">
        <div class="number wow flip">5</div>
        <h2>Let your home shine.</h2>
    </section>


    <footer>
        <div class="my_container">
            <div class="footer">
                <div class="footer_item">
                    <ul class="menu">
                        <li><a href="#">Help</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Press</a></li>
                        <li><a href="#">Be a Professional</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Money-Back Guarantee</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                    <div class="columns">
                        <a href="http://r.Canets.com/iosbadge"><img alt="App-store-badge" src="https://files.handy.com/assets/miscellaneous/app-store-badge-231469be108d5b87c206dd3ad4c43028.svg"></a>
                        <a href="http://r.Canets.com/androidbadge"><img alt="Play-store-badge" src="https://files.handy.com/assets/miscellaneous/play-store-badge-ef8e50389113795ce26d0ad4d3b3f131.svg"></a>
                    </div>
                    <ul class="link_icon">
                        <li><a href="#" class="icon-link" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="#" class="icon-link" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="#" class="icon-link" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a href="#" class="icon-link" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                    </ul>
                </div>

                <div class="footer_item">
                    <h4>LOCATIONS</h4>
                    <ul class="footer_item_23">
                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                        <li>
                            <form action="" method="post">
                                <select class="locale-dropdown" id="locale" name="locale" onchange="this.form.submit()">
                                    <option value="en-US" selected="selected">United States</option>
                                    <option value="en-CA">Canada</option>
                                    <option value="en-GB">United Kingdom</option>
                                </select>
                            </form>
                        </li>
                    </ul>
                </div>

                <div class="footer_item">
                    <h4>LOCATIONS</h4>
                    <ul class="footer_item_23">
                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                    </ul>
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
</body>
</html>
