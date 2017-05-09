<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use DB, URL;
use Illuminate\Support\Facades\Log;

class Customer extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'customers';
    }

	static function DoLogin($data) {
        $user = DB::table('customers')->where('phone_number', trim($data['phone_number']))
                ->where('password', sha1($data['password']))
                ->where('status', 1)->where('type_customer', $data['type_user'])->first();
        if ($user) {
            if (isset($data['lat']) && isset($data['long'])) {
                $user->lat = $data['lat'];
                $user->long = $data['long'];
                DB::table('customers')->where('id', trim($user->id))
                ->update(['lat' => $data['lat'], 'long' => $data['long']]);
            }
            return $user;
        } else {
            return false;
        }
    }

    static function checkCustomerByUserIdAndPassword($data) {
        $user = DB::table('customers')->where('id', trim($data['customer_id']))
                ->where('password', sha1($data['password']))
                ->where('status', 1)->first();
        return $user;
    }

    static function checkExistByEmailPhonenumber($data) {
        $exist = self::where('phone_number', $data['phone_number'])->orWhere('email', $data['email'])->first();
        return $exist;
    }

    static function hasRegister($data) {
        $user = DB::table('customers')->where('phone_number', trim($data['phone_number']))
                ->where('password', sha1($data['password']))
                ->where('type_customer', $data['type_user'])->first();
        return $user;
    }

    static function getCustomerByEmail($email) {
        $exist = self::where('email', $email)->first();
        return $exist;
    }
    static function checkCustomerById($customerId, $type = 1) {
        $exist = self::where('id', $customerId)->where('type_customer', $type)->first();
        return $exist;
    }

    static function allowCancel($customerId) {
        $cancel = self::where('id', $customerId)->where('number_cancel', '<', 3)->first();
        if (empty($cancel)) {
            return false;
        } else {
            return true;
        }
    }
    static function getSinhvienNearly($lat, $long, $distance) {
        $sql = "SELECT id, fullname, quequan, lat, shp.long, (3956 * 2 * ASIN(SQRT(POWER(SIN(($lat -abs(shp.lat)) * pi()/180 / 2),2)
        + COS($lat * pi()/180 ) * COS(abs(shp.long) *  pi()/180) * POWER(SIN(($long - abs(shp.long))
         *  pi()/180 / 2), 2)))) *1.6 as distance
        FROM customers as shp Where type_customer = 1
        HAVING distance < $distance
        ORDER BY distance ASC";
        $data = DB::select($sql);
        return $data;
    }

    static function getById($id) {
        $exist = self::where('id', $id)->first();
        $exist->avatar =  (($exist->avatar != '') ? URL::to('/') . '/' . $exist->avatar : '');
        $exist->anhsv_truoc =  (($exist->anhsv_truoc != '') ? URL::to('/') . '/' . $exist->anhsv_truoc : '');
        $exist->anhsv_sau =  (($exist->anhsv_sau != '') ? URL::to('/') . '/' . $exist->anhsv_sau : '');
        $exist->anhcmtnd_truoc =  (($exist->anhcmtnd_truoc != '') ? URL::to('/') . '/' . $exist->anhcmtnd_truoc : '');
        $exist->anhcmtnd_sau =  (($exist->anhcmtnd_sau != '') ? URL::to('/') . '/' . $exist->anhcmtnd_sau : '');
        return $exist;
    }



    static function getLaborsArround($lat, $long, $distance, $dichvu)
    {
        $fielDichvu = ($dichvu == 'GV1L') ? 'viec_1_lan' : 'viec_thuongxuyen';
        $sql = "SELECT shp.id, type_customer,type_device, device_token, (3956 * 2 * ASIN(SQRT(POWER(SIN(($lat -abs(shp.lat)) * pi()/180 / 2),2)
            + COS($lat * pi()/180 ) * COS(abs(shp.long) *  pi()/180) * POWER(SIN(($long - abs(shp.long))
            *  pi()/180 / 2), 2)))) *1.6 as distance
            FROM customers as shp JOIN customer_devices as cs_dv
            ON shp.id = cs_dv.customer_id JOIN devices
            ON cs_dv.device_id = devices.id
            WHERE type_customer = 1 AND $fielDichvu = 1
            -- AND vi_taikhoan >= 100000

            ORDER BY distance ASC";
            //HAVING distance < $distance
        $data = DB::select($sql);
        return $data;
    }
    // static function getLaborsArround($lat, $long, $distance, $dichvu)
    // {
    //     $fielDichvu = ($dichvu == 'GV1L') ? 'viec_1_lan' : 'viec_thuongxuyen';
    //     $sql = "SELECT shp.id, fullname, type_customer, quequan, lat, shp.long,type_device, device_token, (3956 * 2 * ASIN(SQRT(POWER(SIN(($lat -abs(shp.lat)) * pi()/180 / 2),2)
    //         + COS($lat * pi()/180 ) * COS(abs(shp.long) *  pi()/180) * POWER(SIN(($long - abs(shp.long))
    //         *  pi()/180 / 2), 2)))) *1.6 as distance
    //         FROM customers as shp JOIN customer_devices as cs_dv
    //         ON shp.id = cs_dv.customer_id JOIN devices
    //         ON cs_dv.device_id = devices.id
    //         WHERE type_customer = 1 AND $fielDichvu = 1
    //         -- AND vi_taikhoan >= 100000

    //         ORDER BY distance ASC";
    //         //HAVING distance < $distance
    //     $data = DB::select($sql);
    //     return $data;
    // }


    static function getFullInfoCustomerById($id) {
        $info = DB::table('customers')
            ->join('customer_devices', 'customers.id', '=', 'customer_devices.customer_id')
            ->join('devices', 'customer_devices.device_id', '=', 'devices.id')
            ->where('customers.id', $id)->first();
        return $info;
    }
    static function getFullInfoCustomerByIdToNotify($id) {
        $info = DB::table('customers')
            ->join('customer_devices', 'customers.id', '=', 'customer_devices.customer_id')
            ->join('devices', 'customer_devices.device_id', '=', 'devices.id')
            ->where('customers.id', $id)->get();
        return $info;
    }

    static function getNearLatLong($lat, $long, $distance) {
        $sql = "SELECT customers.id, fullname, quequan, lat, customers.long,type_device, device_token, ( 3959 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( customers.long ) - radians($long) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) ) AS distance
        FROM customers
        JOIN customer_devices as cs_dv ON customers.id = cs_dv.customer_id
        JOIN devices ON cs_dv.device_id = devices.id
        WHERE type_customer = 1
        HAVING distance < $distance ORDER BY distance";
        $data = DB::select($sql);
        return $data;
    }

    static function getTokenAllUserToPushNotify($typeCustomer = 0)
    {
        $sql = "SELECT customers.id, type_customer, device_token, type_device
            FROM customers JOIN customer_devices
            ON customers.id = customer_devices.customer_id JOIN devices
            ON customer_devices.device_id = devices.id";
        ($typeCustomer != 0) ? $sql .= " WHERE type_customer = $typeCustomer" : '';
        $data = DB::select($sql);
        return $data;
    }

}
