<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use App\CustomerDevice;

class Device extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'devices';
    }

    static function checkTokenDevice($data, $customerId) {
    	return self::join('customer_devices', 'customer_devices.device_id', '=', 'devices.id')
        ->where('customer_devices.customer_id', $customerId)
        ->where('device_token', $data['device_token'])->first();
    }

    static function getAllDeviceByUdId($data) {
    	return self::where('ui_id', $data['ui_id'])->get();
    }

    static function checkExistTokenByUiIdAndToken($params) {
        return self::where('ui_id', $params['ui_id'])->where('device_token', $params['device_token'])->first();
    }

    static function deleteDeviceByToken($tokenDevice) {
        $exist = self::where('device_token', $tokenDevice)->first();
        if (isset($exist->id)) {
            self::deleteBy($exist->id);
            CustomerDevice::deleteBy($exist->id, 'device_id');// tam comment
        }
    }

}
