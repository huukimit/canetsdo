<?php

namespace App\Controllers;

use Input,
    Config,
    Response,
    URL,
    Mail;
use App\Http\Controllers\FrontendController;
use App\Models\Users\Users;
use App\Models\Media\Media;
use Detection\MobileDetect;

class HomeController extends FrontendController {

    function __construct() {
        parent::__construct();
    }

    /**
     *
     * @return Topscreen web app
     */
    public function indexAction() {
phpinfo();
        echo 'welcome to front end';
    }

    /**
     * Change password user
     */
    public function changePasswordAction() {
        $this->website_info['title'] = 'Change password Idol';
        $id_user = Input::get('id_user', 0);
        $token = Input::get('token', 0);
        $username = '';
        $uinfo = Users::getUserByUserId($id_user);
        if ($uinfo) {
            if ($token == $uinfo->token_reset) {
                $newpass = Media::randomString();
                $data = array(
                    'id' => $uinfo->id,
                    'is_login' => 0,
                    'token_reset' => '',
                    'password' => Users::UserPassword($newpass),
                    'status' => 1
                );
                $email = $uinfo->email;
                $userData = array('password' => $newpass, 'nickname' => $uinfo->nickname);
                //Send mail
                $send = Mail::send('frontend._pages.mail_change_forgot_password', $userData, function($message) use($email) {
                            $message->to($email, '');
                            $message->subject('★prize candy★パスワード再発行完了のご連絡');
                        });
                if (count(Mail::failures()) > 0) {
                    $message = Config::get('services.notify.send_mail_fail');
                } else {
                    Users::SaveData($data);
                    $nickname = $uinfo->nickname;
                    $message = Config::get('services.notify.send_mail_successfull');
                }
            } else {
                $message = Config::get('services.notify.token_reset_invalid');
            }
        } else {
            $message = Config::get('services.notify.email_not_exits');
        }
        $this->setData['message'] = $message;
        $this->setData['nickname'] = isset($nickname) ? $nickname : '';
        return $this->ShowTemplate('forgotpass');
    }

    /**
     * Change password user
     */
    public function ActiveUserAction() {
        $this->website_info['title'] = 'Active user Idol';
        $id_user = Input::get('id_user', 0);
        $token = Input::get('token', '');
        $username = '';
        $uinfo = Users::getUserByUserId($id_user);
        if ($uinfo) {
            if ($token == $uinfo->token_reset) {
                $newpass = Media::randomString();
                $data = array(
                    'id' => $uinfo->id,
                    'token_reset' => '',
                    'status' => 1
                );
                Users::SaveData($data);
                $message = Config::get('services.notify.thanks_activeuser');
            } else {
                $message = Config::get('services.notify.thanks_activeuser');
            }
        } else {
            $message = Config::get('services.notify.email_not_exits');
        }
        $this->setData['message'] = $message;
        return $this->ShowTemplate('activeuser');
    }

}
