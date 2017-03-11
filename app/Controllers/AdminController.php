<?php

namespace App\Controllers;

use App\Http\Controllers\BackendController;
use Input;
use Config;
use URL;
use Auth;
use Mail;
use App\User;
use App\Models\Users\Users;
use App\Models\Media\Media;
use App\Models\Users\Devices;
use App\Models\Users\Tokens;
use App\Models\Users\Permission;
use App\Models\Zenigata\Gift;

class AdminController extends BackendController {

    public function __construct() {
        parent::__construct();
        $id_idol = Input::get('id_idol', 0);
        if ($id_idol > 0) {
            $this->id_idol = $id_idol;
        }
    }

    /**
     *
     * @param type $page
     * @param type $cmd
     * @param type $action
     * @return method post
     */
    function getAction($page = '', $cmd = '', $action = '') {
        if (!$page) {
            return $this->indexAction();
        }
        $class_name = 'FormController';
        $class_file = dirname(__FILE__) . '/Admin/' . ucwords($page) . '/' . $class_name . '.php';
        if (!file_exists($class_file)) {
            die("The file <strong>$class_file</strong> does not exist, please send this error to admin");
        }
        $method = $this->getMethodByAction($cmd, $action);
        $page_class_name = 'App\\Controllers\\Admin\\' . ucwords($page) . '\\' . $class_name;
        $page_class = \App::make($page_class_name);
        if (!method_exists($page_class, $method)) {
            die('Method <strong>' . $method . '</strong> not active in class <strong>' . $page_class_name . '</strong>');
        }
        $this->current_page = $page;
        return $page_class->$method();
    }

    /**
     *
     * @param type $page
     * @param type $cmd
     * @param type $action
     * @return method get
     */
    function postAction($page = '', $cmd = '', $action = '') {
        if (!$page) {
            return $this->indexAction();
        }
        $class_name = 'SubmitController';
        $class_file = dirname(__FILE__) . '/Admin/' . ucwords($page) . '/' . $class_name . '.php';
        if (!file_exists($class_file)) {
            die("The file <strong>$class_file</strong> does not exist, please send this error to admin");
        }
        $method = $this->getMethodByAction($cmd, $action);
        $page_class_name = 'App\\Controllers\\Admin\\' . ucwords($page) . '\\' . $class_name;
        $page_class = \App::make($page_class_name);
        if (!method_exists($page_class, $method)) {
            die('Method <strong>' . $method . '</strong> not active in class <strong>' . $page_class_name . '</strong>');
        }
        return $page_class->$method();
    }

    /**
     *
     * @return index admin panel
     */
    function indexAction() {
        $this->website_info['title'] = 'アイドル一覧';
        $this->setData['list'] = Users::getAllIdolAdmin();
        $this->setData['table_id'] = 'list_idol';
        return $this->ShowTemplate('default.index');
    }

    public function newIdolAction() {
        $id = Input::get('id', 0);
        if ($id > 0) {
            $this->website_info['title'] = 'アイドル情報編集';
            $idol = Users::find($id);
            $this->setData['idol'] = $idol;
        } else {
            $this->website_info['title'] = '新規アイドル登録';
        }
        return $this->ShowTemplate('idols.add');
    }

    public function newIdolSubmitAction() {
        $data = Input::all();
        $hasUser = $data['id'] == '' ? Users::hasUserByEmail(trim($data['email'])) : Users::hasUserByEmailEdit(trim($data['email']), $data['id']);
        if ($hasUser) {
            return redirect()->to('admin/newidol')->with('message', 'email is exist.');
        }
        $dataSave = array(
            'id' => $data['id'],
            'email' => $data['email'],
            'nickname' => $data['nickname'],
            'clubname' => $data['clubname'],
            'zipcode' => $data['zipcode'],
            'address' => $data['address'],
            'leader' => $data['leader'],
            'phone' => $data['phone'],
            'leader_email' => $data['leader_email'],
            'status' => 0
        );
        if (isset($data['status'])) {
            $dataSave['status'] = 1;
        }
        if (isset($data['password'])) {
            $dataSave['password'] = Users::UserPassword($data['password']);
        }
        $idol = Users::SaveData($dataSave);
        if (!empty($idol)) {
            if ($data['id'] == '') {
                $permission = array(
                    'uid' => $idol,
                    'rid' => Config::get('services.role_idol')
                );
                $newPer = Permission::insertPermission($permission);
                //isert gift default
                $dataGift = array(
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_1.png',
                        'zeni' => 10,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_2.png',
                        'zeni' => 50,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_3.png',
                        'zeni' => 100,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_4.png',
                        'zeni' => 200,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_5.png',
                        'zeni' => 250,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_6.png',
                        'zeni' => 300,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_7.png',
                        'zeni' => 350,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_8.png',
                        'zeni' => 400,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_ge_9.png',
                        'zeni' => 450,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_10.png',
                        'zeni' => 500,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_11.png',
                        'zeni' => 600,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_12.png',
                        'zeni' => 700,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_13.png',
                        'zeni' => 800,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_14.png',
                        'zeni' => 850,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_15.png',
                        'zeni' => 900,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_16.png',
                        'zeni' => 950,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_17.png',
                        'zeni' => 1000,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_18.png',
                        'zeni' => 1300,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_19.png',
                        'zeni' => 1600,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_20.png',
                        'zeni' => 2000,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_21.png',
                        'zeni' => 2300,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_22.png',
                        'zeni' => 2600,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_23.png',
                        'zeni' => 3000,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_24.png',
                        'zeni' => 3300,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_25.png',
                        'zeni' => 3600,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_26.png',
                        'zeni' => 4000,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_27.png',
                        'zeni' => 4300,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_28.png',
                        'zeni' => 4600,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'title' => '05_003',
                        'image' => 'public/uploads/media/gift/gift_default_g_29.png',
                        'zeni' => 5000,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_ge_30.png',
                        'zeni' => 6000,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_31.png',
                        'zeni' => 7000,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_32.png',
                        'zeni' => 8000,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_33.png',
                        'zeni' => 9000,
                        'status' => 1,
                        'is_default' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 1,
                        'image' => 'public/uploads/media/gift/gift_default_g_34.png',
                        'zeni' => 10000,
                        'status' => 1,
                        'is_default' => 1
                    )
                );
                foreach ($dataGift AS $data_gift) {
                    Gift::SaveData($data_gift);
                }
                //isert item waiting default
                $dataItem = array(
                    array(
                        'id_user' => $idol,
                        'type' => 2,
                        'image' => 'public/uploads/media/item/item_default_1.png',
                        'zeni' => 100,
                        'status' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 2,
                        'image' => 'public/uploads/media/item/item_default_1.png',
                        'zeni' => 300,
                        'status' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 2,
                        'image' => 'public/uploads/media/item/item_default_1.png',
                        'zeni' => 500,
                        'status' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 2,
                        'image' => 'public/uploads/media/item/item_default_1.png',
                        'zeni' => 1000,
                        'status' => 1
                    ),
                    array(
                        'id_user' => $idol,
                        'type' => 2,
                        'image' => 'public/uploads/media/item/item_default_1.png',
                        'zeni' => 1300,
                        'status' => 1
                    )
                );
                foreach ($dataItem AS $data_item) {
                    Gift::SaveData($data_item);
                }
                $message = 'アイドル登録ができました。';
            } else {
                $message = 'アイドル編集が完了しました。';
            }
            return redirect()->to('admin')->with('message', $message);
        } else {
            Users::destroy($idol);
            return redirect()->to('admin/newidol')->with('error', 'アイドル登録が失敗しました。');
        }
    }

    /**
     *
     * @return Form login admin panel
     */
    function LoginFormAction() {
        $this->website_info['title'] = 'Admin Panel';
        $this->setData['url_previous'] = URL::to('admin');
        return $this->ShowTemplate('default.login');
    }

    /**
     *
     * @return Form login admin panel
     */
    function ReminderFormAction() {
        $this->website_info['title'] = 'パスワード忘れ - キメラ';
        return $this->ShowTemplate('default.reminder');
    }

    /**
     *
     * @return Action login
     */
    function LoginSubmitAction() {
        $email = Input::get('email', '');
        $password = Input::get('password', '');
        $remember = Input::get('remember', 0);
        $url_previous = Input::get('url_previous', '');
        $message = User::DoLoginAdmin($email, $password) ? 'success' : 'Login is not successfully';
        if ($message == 'success') {
            if ($url_previous) {
                return redirect($url_previous);
            } else {
                return redirect()->route('AminPost');
            }
        } else {
            return redirect()->route('AminLogin')->with('error', 'ログインに失敗しました。');
        }
    }

    /**
     *
     * @return Action login
     */
    function ForgotpasswordAction() {
        $email = Input::get('email_reset', '');
        $message = $this->forgotPassword($email);
        return redirect()->to('admin/login')->with($message['type'], $message['message']);
    }

    function forgotPassword($email) {
        $uinfo = Users::hasUserByEmail($email);
        if ($uinfo) {
            $token = Users::UserPassword(Media::randomString());
            $data = array(
                'id' => $uinfo->id,
                'token_reset' => $token
            );
            $link = URL::to('/') . '/forgotpass.html?id_user=' . $uinfo->id . '&token=' . $token;
            $userData = array('link' => $link, 'nickname' => $uinfo->nickname);
            //Send mail
            $send = Mail::send('frontend._pages.mail_forgot_password', $userData, function($message) use($email) {
                        $message->to($email, '');
                        $message->subject('<i-1グランプリ>パスワード再設定のご案内');
                    });
            if (count(Mail::failures()) > 0) {
                $message = 'Send mail error';
                $type = 'error';
            } else {
                Users::SaveData($data);
                $message = 'ご登録頂いたアドレスへ確認メールを送信いたしました。確認メールより手続きを完了してください。';
                $type = 'message';
            }
        } else {
            $message = 'アカウントが存在しません。';
            $type = 'error';
        }
        return array(
            'type' => $type,
            'message' => $message
        );
    }

    /**
     *
     * @return Logout user
     */
    function LogoutAction() {
        User::logout();
        return redirect()->route('AminPost');
    }

}
