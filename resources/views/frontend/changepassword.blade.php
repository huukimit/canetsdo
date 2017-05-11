@extends('layouts.frontend')

@section('title', 'Canets - Đổi mật khẩu')
@section('content')
<script type="text/javascript">
    
    var password = document.getElementById("password"),
    confirm_password = document.getElementById("confirm_password");

    function validatePassword(){
      if(password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Password không khớp, vui lòng nhập lại");
      } else {
        confirm_password.setCustomValidity('');
      }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>
<section id="section_two">
    <div class="my_container" style="margin-left: 50px;">
        <h3  style="">Đổi mật khẩu</h3>
        <form action="" method="post">
        	<label for="" style="color: green">{{ $message }}</label><br/>
        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="email" value="{{ $data['email'] }}">
            <input type="hidden" name="token" value="{{ $data['token'] }}">
            <label for="">Nhập mật khẩu mới</label>
            <input type="password" placeholder="*************" name="password">
            <label for="">Nhập lại mật khẩu</label>
            <input type="password" placeholder="*************" name="confirm_password">
            <input type="submit" value="Xác nhận">
        </form>
    </div>
</section>
@stop