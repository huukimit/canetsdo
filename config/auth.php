<?php

return [

    /*
      |--------------------------------------------------------------------------
      | Default Authentication Driver
      |--------------------------------------------------------------------------
      |
      | This option controls the authentication driver that will be utilized.
      | This driver manages the retrieval and authentication of the users
      | attempting to get access to protected areas of your application.
      |
      | Supported: "database", "eloquent"
      |
     */

    'driver' => 'eloquent',
    /*
      |--------------------------------------------------------------------------
      | Authentication Model
      |--------------------------------------------------------------------------
      |
      | When using the "Eloquent" authentication driver, we need to know which
      | Eloquent model should be used to retrieve your users. Of course, it
      | is often just the "User" model but you may use whatever you like.
      |
     */
    'model' => 'App\User',
    /*
      |--------------------------------------------------------------------------
      | Authentication Table
      |--------------------------------------------------------------------------
      |
      | When using the "Database" authentication driver, we need to know which
      | table should be used to retrieve your users. We have chosen a basic
      | default value but you may easily change it to any table you like.
      |
     */
    'table' => 'users',
    /*
      |--------------------------------------------------------------------------
      | Password Reset Settings
      |--------------------------------------------------------------------------
      |
      | Here you may set the options for resetting passwords including the view
      | that is your password reset e-mail. You can also set the name of the
      | table that maintains all of the reset tokens for your application.
      |
      | The expire time is the number of minutes that the reset token should be
      | considered valid. This security feature keeps tokens short-lived so
      | they have less time to be guessed. You may change this as needed.
      |
     */
    'password' => [
        'email' => 'emails.password',
        'table' => 'password_resets',
        'expire' => 60,
    ],
    'no_csrf' => [
        'service/mobile/login',
        'service/mobile/registercustomer',
        'service/mobile/registerlaborer',
        'service/mobile/sendmail',
        'service/mobile/forgotpassword',
        'service/mobile/sendmailactive',
        'service/mobile/checkmakhuyenmai',
        'service/mobile/giupviecmotlan',
        'service/mobile/giupviecthuongxuyen',
        'service/mobile/updatelatlong',
        'service/mobile/changepassword',
        'service/mobile/testpushnotify',
        'service/mobile/screentopcustomer',
        'service/mobile/screentopnguoilaodong',
        'service/mobile/cancelbooking',
        'service/mobile/nhanviec',
        'service/mobile/dangkytaikhoanlaodong',
        'service/mobile/getlistbided',
        'service/mobile/getthongtinlaodong',
        'service/mobile/rate',
        'service/mobile/nhanlaodong',
        'service/mobile/onoffservice',
        'service/mobile/getdetailjob',
        'service/mobile/sinhvienganday',
        'service/mobile/naptien',
        'service/mobile/napthe',
        'service/mobile/lichsugiaodich',
        'service/mobile/getbookingmissednotify',
        'service/mobile/getCustomerbyLatLong',
        'service/mobile/getThongtinBookingAndLaodong',
        'service/mobile/baoDaLamXong',
        'service/mobile/checkParamsRequested',
        'service/mobile/test',
        'service/mobile/upAnh',
        'service/mobile/thongbaoSvhuy',
        'service/mobile/historybooking',
        'service/mobile/svCancel',
        'service/mobile/getDetailHistoryJob',
        'service/mobile/getDetailBooking',
        'service/mobile/khachhangnhanlaodong',
        'service/mobile/getContract',
        'service/mobile/feedBack',
        'service/mobile/getNotify',
        'service/mobile/feedBack',
        'service/mobile/deleteNotify',
        'service/mobile/readNotify',
        'service/mobile/testios',
        'service/mobile/logout',
        'service/mobile/getJobsByLaodongId',
        'service/mobile/getInfoCustomerById',
        'service/mobile/ignoreJob',
        'service/mobile/lichsucongviec',
        'service/mobile/lichsuvitien',
        'service/mobile/chitietLichsucongviec',
        'service/mobile/khachhangkhongnhan',
        'service/mobile/chuyenTienLenViTaiKhoan',
        'service/mobile/getQAndA',
        'service/mobile/report',
        'service/mobile/pushAndroid',
        'service/mobile/getLaodongByLatLong',
        'service/mobile/sinhvienCancelBid',
        'service/mobile/loginAccountKit',
    ],
];
