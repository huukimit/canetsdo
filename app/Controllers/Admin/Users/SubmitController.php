<?php

namespace App\Controllers\Admin\Users;

use App\Models\Users\Users;
use Input,
    URL;
use App\Models\Media\Media;

class SubmitController {

    public function EditAction() {
        $data = Input::all();
        if (isset($data['birthday']) && $data['birthday'] != '') {
            $data['birthday'] = date("Y-m-d", strtotime(str_replace("/", "-", $data['birthday'])));
        }
        $data['avatar'] = '';
        if (isset($_FILES['avatar'])) {
            $_FILES['file'] = $_FILES['avatar'];
            $upImage = Media::uploadImage($_FILES, 'avatar');
            $data['avatar'] = $upImage['url'];
            $data['size_avatar'] = json_encode($upImage['size_image']);
        }
        if ($data['avatar'] == '') {
            unset($data['avatar']);
        }
        Users::SaveData($data);
        return redirect()->to('admin/users/edit?id=' . $data['id'])->with('message', 'ユーザーの情報が編集できました。');
    }

    public function changepasswordAction() {
        $id = Input::get('id', 0);
        $password = Input::get('password', '');
        $data = array(
            'id' => $id,
            'password' => Users::UserPassword($password)
        );
        Users::SaveData($data);
        return redirect()->to('admin/users/changepassword?id=' . $id)->with('message', 'ユーザーのパスワードが変更できました。');
    }

}
