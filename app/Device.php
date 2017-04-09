<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class Device extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'devices';
    }

    static function checkTokenDevice($data) {
    	return self::where('device_token', $data['device_token'])->first();
    }

    static function getAllDeviceByToken($data) {
    	return self::where('device_token', $data['device_token'])->get();
    }

}
