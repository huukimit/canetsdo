@extends('layouts.frontend')

@section('title', 'Canets - Sinh Viên Giúp Việc, Gia  Sư nhé')

@section('content')
    <section id="video">
        <div class="my_container">
            <div class="video">
                <div class="v_video">
                    <div class="video_text">
                        <h1>Ứng dụng tìm sinh viên giúp việc, gia sư đầu tiên</h1>
                        <p>Sinh viên trong mạng lưới Canets được đảm bảo</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="section_two">
        <div class="my_container">
            <div class="section_two">
                <div class="section_two_item">
                    <div class="section_two_item_img">
                        <a href="#"><img src="{{ asset('public/frontend/img/furture_1.png') }}" class="img img-responsive" alt=""></a>
                    </div>
                    <div class="section_two_item_des">
                        <b><big>Sinh viên đã được <br/>
                        kiểm duyệt<br/></big></b><br/>
                       Toàn bộ sinh viên trên hệ thống đã được <b>Canets</b> xác nhận thông tin, có kinh nghiệm làm việc và độ tin tưởng cao
                        
                    </div>
                </div>

                <div class="section_two_item">
                    <div class="section_two_item_img">
                        <a href="#"><img src="{{ asset('public/frontend/img/furture_2.png') }}" class="img img-responsive" alt=""></a>
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
                        <a href="#"><img src="{{ asset('public/frontend/img/furture_3.png') }}" class="img img-responsive" alt=""></a>
                    </div>
                    <div class="section_two_item_des">
                        <b><big> Lựa chọn ứng viên <br/>
                        phù hợp<br/></big></b><br/>
                       Dự trên thông tin của sinh viên ứng tuyển, bạn có thể lựa chọn cho gia đình sinh viên phù hợp nhất theo nhiều tiêu chí
                        
                    </div>
                </div>

                <div class="section_two_item">
                    <div class="section_two_item_img">
                        <a href="#"><img src="{{ asset('public/frontend/img/furture_4.png') }}" class="img img-responsive" alt=""></a>
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
                <h3></h3>
            </div>
            <div class="stt_one" id="step_1">
                <div class="stt_one_left">
                    <img src="{{ asset('public/frontend/img/step1.png') }}" class="img img-responsive steps wow bounceInLeft center" alt="">
                </div>
                <div class="stt_one_right">
                    <div class="number wow bounce">1</div>
                    <div class="description">
                        <p>
                        <b>Cài đặt ứng dụng<br/></b>
                        Tìm ứng dụng Canets trên Appstore hay Google và tải xuống miễn phí</p>
                    </div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="stt_one" id="step_2">
                <div class="stt_one_left">
                    <img src="{{ asset('public/frontend/img/step2.png') }}" class="img img-responsive steps wow bounceInRight left" alt="">
                </div>
                <div class="stt_one_right">
                    <div class="number wow bounce center">2</div>
                    <div class="description">
                        <p><b>Nhập thông tin yêu cầu <br/></b>
                        Thời gian, địa điểm làm việc, yêu cầu đặc biệt,.... Thông tin càng chi tiết thì càng dễ tìm một bạn sinh viên phù hợp</p>
                    </div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="stt_one" id="step_3">
                <div class="stt_one_left">
                    <img src="{{ asset('public/frontend/img/step3.png') }}" class="img img-responsive steps wow bounceInLeft center" alt="">
                </div>
                <div class="stt_one_right">
                    <div class="number wow bounce">3</div>
                    <div class="description">
                        <p><b> Lựa chọn ứng viên<br/></b>
                        Dựa trên hình ảnh, thông tin chung hay đánh giá từ những gia đình khác. Hãy lựa chọn 1 ứng viên phù hợp nhất !</p>
                    </div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="stt_one" id="step_4">
                <div class="stt_one_left">
                    <img src="{{ asset('public/frontend/img/step4.png') }}" class="img img-responsive steps wow bounceInRight center" alt="">
                </div>
                <div class="stt_one_right">
                    <div class="number wow bounce center">4</div>
                    <div class="description">
                        <p><b>Liên hệ và xác nhận<br/></b> Xác nhận và sắp xếp lịch làm với sinh viên qua số điện thoại được cung cấp... </p>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </section>


    <section id="stt_five">
        <div class="number wow bounce">5</div>
        <h2></h2>
    </section>
@stop