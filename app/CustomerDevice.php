<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class CustomerDevice extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'customer_devices';
    }

    public static function getCustomerDeviceByCustomerIdDeviceId($customerId, $deviceId)
    {
    	return self::where('customer_id', $customerId)->where('device_id', $deviceId)->first();
    }
}
