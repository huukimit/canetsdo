<?php

namespace App\Models\Notify;

use Cache,
    Config,
    Input,
    Validator;
use App\BaseModel;
use URL;

class Notify extends BaseModel {

    /**
     *
     * @param type $type 1 - ios | 2 - android
     * @param type $deviceToken
     * @param type $message
     * @param type $push_data
     * @return type
     */
    static function PushNotifyToUser($token = array(), $message = "", $push_data) {
        $notify = array();
        if (count($token) > 0) {
            foreach ($token AS $item) {
                if ($item->type == 1) {
                    $notify[] = self::Push2Ios($item->token, $message, $push_data);
                } else {
                    $notify[] = self::Push2Android($item->token, $message, $push_data);
                }
            }
        }
        return $notify;
    }

    /**
     *
     * @param type $deviceToken : token ios
     * @param type $message : message send to device
     * @param type $push_data : data send to device
     * @param type $badge
     * @param type $sound
     * @return Push notify for ios
     */
    static function Push2Ios($deviceToken = "", $message = "", $push_data = array(), $badge = -1, $sound = 'default', $app = 'laodong') {
        if (!$deviceToken || !$message) {
            return array("status" => -1, "message" => "No data", "data" => array());
        }
        // Create Data send to service
        $push_to_apns = array();
        $push_to_apns['alert'] = $message;
        $push_to_apns['sound'] = $sound;
        $push_to_apns['content-available'] = "1";
        if ($badge >= 0) {
            $push_to_apns['badge'] = $badge;
        }
        if ($push_data) {
            $push_to_apns['data'] = $push_data;
        }
        $payload = json_encode(array("aps" => $push_to_apns));
        if (strlen($deviceToken) == 64) {
            $msg = chr(0) . pack('n', 32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack('n', strlen($payload)) . $payload;
        } else {
            $msg = '';
        }
        $ctx = stream_context_create();
        $ios_server = Config::get('services.device.ios.ios_server');

        if ($app == 'laodong') {
            $filePem = Config::get('services.device.ios_laodong.pem_file_dir');
            $passwordPem = Config::get('services.device.ios_laodong.pem_pass');
        } else {
            $filePem = Config::get('services.device.ios.pem_file_dir');
            $passwordPem = Config::get('services.device.ios.pem_pass');
        }

        stream_context_set_option($ctx, 'ssl', 'local_cert', $filePem);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passwordPem);
        $err = "";
        $errstr = "";
        $fp = stream_socket_client($ios_server, $err, $errstr, 600, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp) {
            return array("status" => -2, "message" => "Failed to connect: $err $errstr" . PHP_EOL, "data" => array());
        }

        $result = fwrite($fp, $msg, strlen($msg));
        if (!$result) {
            $data["success"] = -3;
            $data["message"] = "Message not delivered" . PHP_EOL;
        } else {
            $data["success"] = 1;
            $data["message"] = "Message successfully delivered" . PHP_EOL;
        }
        fclose($fp);

        return $data;
    }

    /**
     * Push Notify for android Device
     *
     * @param string $deviceToken : Device Android
     * @param string $message : Show Message push notify
     * @param array $push_data :
     * @param string $badge
     * @param string $sound
     * @return content from CURL
     */
    static function Push2Android($deviceToken = "", $message = "", $push_data = array(), $badge = -1, $sound = 'default', $vibrate = 1) {
        $registrationIds = array($deviceToken); // push to list device
        $msg = array(
            'message' => $message,
            'data' => $push_data,
            'vibrate' => $vibrate,
            'sound' => $sound,
        );
        if ($badge >= 0) {
            $msg['badge'] = $badge;
        }

        $fields = array(
            'registration_ids' => $registrationIds,
            'data' => $msg,
        );
        $headers = array(
            'Authorization: key=' . Config::get('services.device.android.api_key'),
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, Config::get('services.device.android.api_url'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    static function pushAndroidFireBase($deviceToken = "", $message = "", $push_data = array(), $badge = -1, $sound = 'default', $vibrate = 1) {
        $registrationIds = array($deviceToken); // push to list device
        $msg = array(
            'message' => $message,
            'data' => $push_data,
            'vibrate' => $vibrate,
            'sound' => $sound,
        );
        if ($badge >= 0) {
            $msg['badge'] = $badge;
        }

        $fields = array(
            'registration_ids' => $registrationIds,
            'data' => $msg,
        );
        $headers = array(
            'Authorization: key=AIzaSyAsbWZHBZGzXOt-7-aNm0BZ_GntEvTenq8',
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    static function cloudMessaseAndroid($deviceToken = "", $message = "", $push_data = array(), $badge = -1, $sound = 'default', $vibrate = 1) {
        $url = Config::get('services.device.android_firebase.api_url');
        $server_key = Config::get('services.device.android_firebase.api_key');
        $msg = array(
            'message' => $message,
            'data' => $push_data
        );
        $fields = array();
        $fields['data'] = $msg;
        if(is_array($deviceToken)){
            $fields['registration_ids'] = $deviceToken;
        }else{
            $fields['to'] = $deviceToken;
        }
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    static function cloudMessaseAndroidToTopic($topic = "", $message = "", $push_data = array(), $badge = -1, $sound = 'default', $vibrate = 1) {
        $url = Config::get('services.device.android_firebase.api_url');
        $server_key = Config::get('services.device.android_firebase.api_key');
        $msg = array(
            'message' => $message,
            'data' => $push_data
        );
        $fields = array();
        $fields['data'] = $msg;
        $fields['to'] = "/topics/$topic";
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

}
