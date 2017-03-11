<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Third Party Services
      |--------------------------------------------------------------------------
      |
      | This file is for storing the credentials for third party services such
      | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
      | default location for this type of information, allowing packages
      | to have a conventional place to find your various credentials.
      |
     */
    'role_user' => 3,
    'role_idol' => 2,
    'role_admin' => 1,
    'zeni_action' => 1,
    'point_action' => 1,
    'type_gift' => 1,
    'type_item_waiting' => 2,
    'type_purchase_point' => 1,
    'mailgun' => [
        'domain' => '',
        'secret' => '',
    ],
    'mandrill' => [
        'secret' => '',
    ],
    'ses' => [
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],
    'stripe' => [
        'model' => 'App\User',
        'secret' => '',
    ],
    'device' => array(
        'android' => array(
            // 'api_key' => 'AIzaSyAbHWxmY85hjfsEsVj61VnD97PMXjmTGHc',
            // 'api_url' => 'https://gcm-http.googleapis.com/gcm/send',
            'api_key' => 'AIzaSyCUw5lhaP21rPTBGkm8xoPrjHEni-rGguc',
            'api_url' => 'https://android.googleapis.com/gcm/send',
        ),
        'android_firebase' => array(
            // 'api_key' => 'AIzaSyAbHWxmY85hjfsEsVj61VnD97PMXjmTGHc',
            // 'api_url' => 'https://gcm-http.googleapis.com/gcm/send',
            'api_key' => 'AIzaSyAdLPj-577PQOQyLeN7_vb4jGWB7tvHNHs',
            'api_url' => 'https://fcm.googleapis.com/fcm/send',
        ),
        'ios' => array(
            /**
             * Create file pem from p12 file and password
             * openssl pkcs12 -clcerts -nokeys -out aps-dev-cert.pem -in key-ios.p12
             * openssl pkcs12 -nocerts -out aps-dev-key.pem -in key-ios.p12
             * openssl rsa -in aps-dev-key.pem -out aps-dev-key.unencrypted.pem
             * cat aps-dev-cert.pem aps-dev-key.unencrypted.pem > key-ios.pem
             *
             * Save file to folder notify in storage path of laravel
             */
            'pem_file_dir' => storage_path('notify/ios.pem'),
            'pem_pass' => '123',
            'ios_server' => 'ssl://gateway.sandbox.push.apple.com:2195', // Developer Mode
            //'ios_server' => 'ssl://gateway.push.apple.com:2195', // Go Live
        ),
    ),
    'notify' => [
        'no_param' => 'No param',
        'user_exist' => 'Số điện thoại hoặc email đã tồn tại, vui lòng sử dụng email hoặc số điện thoại khác',
        'register_successfull' => 'Register successfully',
        'register_fail' => 'Register fail',
        'login_successfull' => 'Login successfully',
        'login_fail' => 'Login fail',
        'logout_successfull' => 'Logout successfully',
        'logout_fail' => 'Email or password invalid',
        'not_exits_user' => 'User is not exits',
        'send_mail_fail' => 'Send email fail',
        'send_mail_successfull' => 'Send email successfully',
        'email_not_exits' => 'Email is not exits',
        'token_reset_invalid' => '既にパスワードを再発行しております。i-1グランプリからのメールをご確認ください。',
        'register_device_successfull' => 'Register device successfully',
        'register_device_fail' => 'Register device fail',
        'get_profile_succesfull' => 'Get profile is successfully',
        'user_invalid' => 'User is invalid',
        'update_profile_successfull' => 'Update profile is successfully',
        'change_password_successfull' => 'Change password is successfully',
        'old_password_invalid' => 'Old password invalid',
        'thanks_activeuser' => "ユーザー登録が完了いたしました。アプリよりログインできることを確認してください。",
        'missing_point' => 'missing point',
        'get_item_waiting_complete' => 'get item waiting complete',
        'read_item_waiting_complate' => 'read item waiting complete',
        'user_not_active' => 'User not active',
        'user_is_block' => 'User is block',
        'sync_customer_ss' => 'Sync customers success',
        'duplicate_id' => 'Có lỗi do việc đồng bộ bị trùng giữa e user nên sảy ra việc trùng id, vui lòng đồng bộ lại',
    ],
    'query_limit' => 15
];
