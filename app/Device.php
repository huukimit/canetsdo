<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

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

    static function getAllDeviceByToken($data) {
    	return self::where('device_token', $data['device_token'])->get();
    }

}
