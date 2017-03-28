@extends('layouts.frontend')

@section('title', 'Canets - Sinh Viên Giúp Việc, Gia  Sư nhé')

@section('content')
	<section id="dangkythanhvien">
	</section>
	<hr/>
	<section id="benefit">
        <div class="my_container">
            <div class="benefit">
                <div class="benefit_item">
                    <div class="benefit_item_img">
                        <a href="#"><img src="{{ asset('public/frontend/img/dky-1.png') }}" class="img img-responsive" alt=""></a>
                    </div>
                    <div class="benefit_item_des">
                        <b><big>Mức lương tốt</big></b><br/><br/>
                       Tham gia Canets, bạn sẽ được kết nối tới các gia đình trẻ và phụ giúp công việc nhà : dọn dẹp, phụ nấu ăn, chơi với trẻ với mức lương từ 25k-40k/1h. Nhận lương trực tiếp từ gia đình. Đây là mức lương rất hấp dẫn và cạnh tranh với các công việc part time khác
                    </div>
                </div>

                <div class="benefit_item">
                    <div class="benefit_item_img">
                        <a href="#"><img src="{{ asset('public/frontend/img/dky-2.png') }}" class="img img-responsive" alt=""></a>
                    </div>
                    <div class="benefit_item_des">
                        <b><big>Luôn chủ động</big></b><br/><br/>
                       	Bất cứ khi nào bạn có thời gian rảnh rỗi, bạn có thể vào Canets để tìm cho mình công việc phù hợp xung quanh. Bao gồm ngắn hạn, dài hạn, một lần,... mà không cần phải mất nhiều thời gian tìm kiếm công việc trên mạng xã hội hay internet.
                        
                    </div>
                </div>

                <div class="benefit_item">
                    <div class="benefit_item_img">
                        <a href="#"><img src="{{ asset('public/frontend/img/dky-3.png') }}" class="img img-responsive" alt=""></a>
                    </div>
                    <div class="benefit_item_des">
                        <b><big>Thông tin chi tiết</big></b><br/><br/>
                       	Canets sẽ cung cấp tới bạn thông tin về công việc như lịch làm, công việc, yêu cầu, hình ảnh nơi làm việc,... Giúp sinh viên lựa chọn công việc phù hợp cho mình hơn
                        
                    </div>
                </div>

                <div class="clear"></div>
            </div>
        </div>
    </section>
    <hr/>

    <section id="section_two">
	    <div class="my_container">
            <div class="question-anwser">
	    		<h2>Yêu cầu tham gia mạng lưới Canets</h2>
                <ol id="requires">
                	<li>Có điện thoại thông minh</li>
                	<li>Có đầy đủ giấy tờ: Chứng minh thư, thẻ sinh viên ( còn hạn sử dụng )</li>
                	<li>Có các kỹ năng cơ bản trong việc nhà như : Nấu ăn cơ bản, dọn dẹp, chơi với trẻ,...</li>
                	<li>Sẵn sàng học hỏi và thân thiện với gia đình </li>
                	<li>Luôn chủ động trong công việc và đến đúng giờ</li>
                </ol>
            </div>
	    </div>
	</section>
@stop
