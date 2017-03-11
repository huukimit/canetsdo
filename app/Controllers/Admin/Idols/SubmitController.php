<?php

namespace App\Controllers\Admin\Idols;

use App\Models\Users\Users;
use Input,
    URL,
    Config;
use App\Models\Media\Media;
use App\Models\Zenigata\Members;
use App\Models\Users\Permission;
use App\Models\Zenigata\Gift;

class SubmitController {

    /**
     *
     * @return Edit profile
     */
    public function EditProfileAction() {
        $data = Input::all();
        if ($data['id'] == '') {
            return redirect()->to('admin')->with('message', 'アカウントが存在しません。');
        }
        // tao mang bien de insert vao table users
        $dataSave = array(
            'id' => $data['id'],
            'nickname' => $data['nickname'],
            'about' => $data['about'],
            'sns_facebook' => $data['sns_facebook'],
            'sns_twitter' => $data['sns_twitter'],
            'sns_instagram' => $data['sns_instagram']
        );
        $dataSave['avatar'] = '';
        if (isset($data['image_crop_avatar']) && $data['image_crop_avatar'] != '') {
            $upImage = Media::uploadImageBase64($data['image_crop_avatar'], 'avatar');
            $dataSave['avatar'] = $upImage['url'];
        }
        if ($dataSave['avatar'] == '') {
            unset($dataSave['avatar']);
        }
        $dataSave['banner'] = '';
        if (isset($data['image_crop_banner']) && $data['image_crop_banner'] != '') {
            $upImage = Media::uploadImageBase64($data['image_crop_banner'], 'banner');
            $dataSave['banner'] = $upImage['url'];
        }
        if ($dataSave['banner'] == '') {
            unset($dataSave['banner']);
        }
        //update idol
        $idol = Users::SaveData($dataSave);
        if ($idol) {
            return redirect()->to('admin/idols/editprofile?id_idol=' . $data['id'])->with('message', 'アイドルの情報が編集できました。');
        } else {
            return redirect()->to('admin/idols/editprofile?id_idol=' . $data['id'])->with('error', '新規アイドル登録が失敗しました。');
        }
    }

    /**
     *
     * @return Edit member idol
     */
    public function EditmemberAction() {
        $data = Input::all();
        if ($data['number_member'] > 0) {
            for ($i = 0; $i < $data['number_member']; $i++) {
                $dataSave = array(
                    'id' => $data['member_id_' . $i],
                    'fullname' => $data['member_fullname_' . $i],
                    'birthday' => date('Y-m-d', strtotime(str_replace('/', '-', $data['member_birthday_' . $i]))),
                    'height' => $data['member_height_' . $i],
                    'weight' => $data['member_weight_' . $i],
                    'interest' => $data['member_interest_' . $i],
                    'comment' => $data['member_comment_' . $i],
                    'sns_facebook' => $data['member_sns_facebook_' . $i],
                    'sns_twitter' => $data['member_sns_twitter_' . $i],
                    'sns_instagram' => $data['member_sns_instagram_' . $i],
                );
                $dataSave['avatar'] = '';
                if (isset($data['image_crop_member_' . $i]) && $data['image_crop_member_' . $i] != '') {
                    $upImage = Media::uploadImageBase64($data['image_crop_member_' . $i], 'avatar');
                    $dataSave['avatar'] = $upImage['url'];
                }
                if ($dataSave['avatar'] == '') {
                    unset($dataSave['avatar']);
                }
                Members::SaveData($dataSave);
            }
            return redirect()->to('admin/idols/deletemember?id_idol=' . $data['id_idol'])->with('message', 'メンバーが編集されました。');
        }
    }

    /**
     *
     * @return Add new member idol
     */
    public function AddmemberAction() {
        $data = Input::all();
        $dataSave = array(
            'id_user' => $data['id_idol'],
            'fullname' => $data['member_fullname'],
            'birthday' => $data['member_birthday'] != '' ? date('Y-m-d', strtotime(str_replace('/', '-', $data['member_birthday']))) : '',
            'height' => $data['member_height'],
            'weight' => $data['member_weight'],
            'interest' => $data['member_interest'],
            'comment' => $data['member_comment'],
            'sns_facebook' => $data['member_sns_facebook'],
            'sns_twitter' => $data['member_sns_twitter'],
            'sns_instagram' => $data['member_sns_instagram'],
        );
        $dataSave['avatar'] = '';
        if (isset($data['image_crop_member']) && $data['image_crop_member'] != '') {
            $upImage = Media::uploadImageBase64($data['image_crop_member'], 'avatar');
            $dataSave['avatar'] = $upImage['url'];
        }
        if ($dataSave['avatar'] == '') {
            unset($dataSave['avatar']);
        }
        Members::SaveData($dataSave);
        return redirect()->to('admin/idols/idolmember?id_idol=' . $data['id_idol'])->with('message', 'メンバーが追加されました。');
    }

    /**
     *
     * @return Add or Edit item waiting
     */
    public function EdititemwaitingAction() {
        $data = Input::all();
        $dataGift = array(
            'id' => $data['id'],
            'id_user' => $data['id_idol'],
            'zeni' => $data['zeni'],
            'type' => 2
        );
        $dataGift['image'] = '';
        if (isset($data['image_crop']) && $data['image_crop'] != '') {
            $upImage = Media::uploadImageBase64($data['image_crop'], 'item');
            $dataGift['image'] = $upImage['url'];
        }
        if ($dataGift['image'] == '') {
            unset($dataGift['image']);
        }
        $gift = Gift::SaveData($dataGift);
        if (empty($gift)) {
            $type = 'error';
            $message = $data['id'] != '' ? '待ち受けの編集が失敗しました。' : '待ち受けの追加が失敗しました。';
        } else {
            $type = 'message';
            $message = $data['id'] != '' ? '待ち受けが編集できました。' : '待ち受けが追加されました。';
        }

        return redirect()->to('admin/idols/itemwaitinglist?id_idol=' . $data['id_idol'])->with($type, $message);
    }

    /**
     *
     * @return Add or edit gift
     */
    public function EditGiftAction() {
        $data = Input::all();
        $dataGift = array(
            'id' => $data['id'],
            'id_user' => $data['id_idol'],
            'zeni' => $data['zeni'],
            'type' => 1
        );
        if ($data['id'] == '') {
            $dataGift['is_default'] = 0;
        }
        if (isset($data['image_crop']) && $data['image_crop'] != '') {
            $upImage = Media::uploadImageBase64($data['image_crop'], 'item');
            $dataGift['image'] = $upImage['url'];
            if ($data['id'] == '') {
                $dataGift['image'] = $upImage['url'];
            } else {
                $gift = Gift::find($data['id']);
                if ($gift->is_default == 1) {
                    $dataGift['image_overwirte'] = $upImage['url'];
                } else {
                    $dataGift['image'] = $upImage['url'];
                }
            }
        }
        $gift = Gift::SaveData($dataGift);
        if (empty($gift)) {
            $type = 'error';
            $message = $data['id'] != '' ? 'バッジーの編集が失敗しました。' : 'バッジーの追加が失敗しました。';
        } else {
            $type = 'message';
            $message = $data['id'] != '' ? 'バージーが編集されました。' : 'バージーが追加されました。';
        }

        return redirect()->to('admin/idols/giftlist?id_idol=' . $data['id_idol'])->with($type, $message);
    }

}
