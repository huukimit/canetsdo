<?php

namespace App\Controllers\Admin\Users;

use App\Http\Controllers\BackendController;
use App\User;
use Input;
use App\Models\Users\Users;
use App\Models\Idol\Location;
use App\Models\Zenigata\HistoryUserPoint;

class FormController extends BackendController {

    function __construct() {
        parent::__construct();
    }

    public function ListAction() {
        $this->website_info['title'] = 'ユーザー情報';
        $lstUser = Users::getAllUser();
        foreach ($lstUser AS $key => $user) {
            $zeniUse = HistoryUserPoint::getZeniUseByUserID($user->id);
            $use_zeni = !empty($zeniUse) ? $zeniUse->zeni : 0;
            $point = $user->point;
            $lstUser[$key]->use_zeni = !empty($zeniUse) ? number_format($zeniUse->zeni, 0, '.', ',') : 0;
            $lstUser[$key]->point = number_format($lstUser[$key]->point, 0, '.', ',');
            $lstUser[$key]->all_zeni = number_format(($point + $use_zeni), 0, '.', ',');
        }
        $this->setData['list'] = $lstUser;
        $this->setData['table_id'] = 'list_user';
        return $this->ShowTemplate('users.list');
    }

    public function detailAction() {
        $this->website_info['title'] = 'ユーザー詳細';
        $id = Input::get('id', 0);
        $uinfo = Users::getUserByUserId($id);
        $point = $uinfo->point;
        $uinfo->point = number_format($uinfo->point, 0, '.', ',');
        $zeniUse = HistoryUserPoint::getZeniUseByUserID($uinfo->id);
        $use_zeni = !empty($zeniUse) ? $zeniUse->zeni : 0;
        $uinfo->use_zeni = !empty($zeniUse) ? number_format($zeniUse->zeni, 0, '.', ',') : 0;
        $uinfo->all_zeni = number_format(($use_zeni + $point), 0, '.', ',');
        $this->setData['uinfo'] = $uinfo;
        return $this->ShowTemplate('users.detail');
    }

    public function EditAction() {
        $this->website_info['title'] = 'ユーザー情報の編集';
        $id = Input::get('id', 0);
        $uinfo = Users::getInfoUserByUserId($id);
        $this->setData['uinfo'] = $uinfo;
        return $this->ShowTemplate('users.edit');
    }

    public function ChangepasswordAction() {
        $id = Input::get('id', 0);
        $uinfo = Users::getInfoUserByUserId($id);
        $this->website_info['title'] = $uinfo->nickname . 'にパスワード変更を実行する';
        $this->setData['id'] = $id;
        return $this->ShowTemplate('users.changepassword');
    }

    public function DeleteAction() {
        $id = (int) Input::get('id', 0);
        $delete = Users::destroy($id);
        return redirect()->to('admin/users/list');
    }

    public function StatusAction() {
        $id = (int) Input::get('id', 0);
        $status = (int) Input::get('status', 0);
        $is_block = $status == 0 ? 1 : 0;
        $data = array(
            'id' => $id,
            'status' => $status,
            'is_block' => $is_block
        );
        $message = $status == 1 ? 'ユーザーのアカウントがアクティブになりました。' : 'ユーザーのアカウントがブロックされました。';
        Users::SaveData($data);
        return redirect()->to('admin/users/detail?id=' . $id)->with('message', $message);
    }

    public function remoteEmailAction() {
        $email = Input::get('email', '');
        $id = Input::get('id', 0);
        $uinfo = $id == 0 ? Users::hasUserByEmail(trim($email)) : Users::hasUserByEmailEdit(trim($email), $id);
        if (empty($uinfo)) {
            echo 'true';
        } else {
            echo 'false';
        }
        die();
    }

    public function remoteNicknameAction() {
        $nickname = Input::get('nickname', '');
        $id = Input::get('id', 0);
        $uinfo = $id == 0 ? Users::hasUserByNickname(trim($nickname)) : Users::hasUserByNicknameEdit(trim($nickname), $id);
        if (empty($uinfo)) {
            echo 'true';
        } else {
            echo 'false';
        }
        die();
    }

    public function remoteUsernameAction() {
        $username = Input::get('username', '');
        $id = Input::get('id', 0);
        $uinfo = $id == 0 ? Users::hasUserByUsername(trim($username)) : Users::hasUserByUsernameEdit(trim($username), $id);
        if (empty($uinfo)) {
            echo 'true';
        } else {
            echo 'false';
        }
        die();
    }

}
