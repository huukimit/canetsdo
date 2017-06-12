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
        $data = json_decode(json_encode($data), true);

        $latlong = [
            [20.982953, 105.862702],[20.982853, 105.864955],[20.983454, 105.867766],[20.986599, 105.861737],[20.982312, 105.862101],[20.987200, 105.859677],
            [20.984382, 105.860603],[20.985604, 105.862405],[20.986445, 105.858157],[20.988248, 105.866511],[20.981958, 105.864980],[20.987106, 105.864015],
            [20.995982, 105.809724],[20.995580, 105.807009],[20.994679, 105.804942],[20.994479, 105.808654],[20.993036, 105.811679],[20.998125, 105.803332],
            [20.993937, 105.806944],[20.993978, 105.806945],[20.993939, 105.806974],[20.993957, 105.806544],[20.993947, 105.806914],[20.993997, 105.806964],
            [21.034139, 105.796616],[21.034859, 105.794885],[21.034859, 105.794885],[21.033418, 105.798551],[21.032577, 105.799720],[21.033127, 105.796684],
            [21.032457, 105.799216],[21.034719, 105.799874],[21.034619, 105.793533],[21.034329, 105.794173],[21.032957, 105.801018],[21.035341, 105.796169],
            [21.061054, 105.897989],[21.062595, 105.901980],[21.061235, 105.900364],[21.060172, 105.895329],[21.059232, 105.894377],[21.064478, 105.890858],
            [21.064118, 105.894785],[21.060674, 105.890257],[21.064799, 105.890579],[21.058431, 105.894527],[21.064098, 105.888240],[21.062556, 105.882747],
            [20.996783, 105.844231],[20.995801, 105.843008],[20.994118, 105.843737],[20.996142, 105.847170],[20.998065, 105.843050],[20.997884, 105.839489],
            [20.999988, 105.837600],[21.000569, 105.843866],[21.000729, 105.834124],[20.997844, 105.837300],[20.995440, 105.839489],[20.998926, 105.831077],
            [21.001130, 105.846827],[20.997504, 105.849895],[21.002291, 105.845307],[21.001370, 105.847088],[21.000799, 105.848622],[21.002492, 105.841702],
            [21.000538, 105.841445],[21.033839, 105.815992],[21.030955, 105.814512],[21.036082, 105.811315],[21.034480, 105.810113],[21.033298, 105.816121],
            [21.033318, 105.820069],[21.018072, 105.829949],[21.020029, 105.827690],[21.020900, 105.829825],[21.020339, 105.830337],[21.020239, 105.831533],
            [21.021360, 105.828722],[21.020023, 105.828218],[21.019748, 105.832340],[21.019705, 105.832087],[21.020386, 105.830295],[21.020311, 105.830080],
            [21.027964, 105.851013],[21.027250, 105.848157],[21.026689, 105.856698],[21.029873, 105.848114],[21.030674, 105.856311],[21.031375, 105.846055],
            [21.081518, 105.816464],[21.081117, 105.819511],[21.079055, 105.817151],[21.081117, 105.813417],[21.079215, 105.815156],[21.084181, 105.811443],
            [21.082259, 105.825434],[21.080617, 105.808654],[21.077453, 105.825605],[21.084161, 105.815070],[21.087784, 105.818996],[21.086883, 105.820198],
            [21.039707, 105.762606],[21.037364, 105.769172],[21.035822, 105.774064],[21.035902, 105.775974],[21.042911, 105.764966],[21.041269, 105.758829],
            [21.008822, 105.950983],[21.007300, 105.954866],[21.008642, 105.947378],[21.005837, 105.943279],[21.005397, 105.948815],[21.004115, 105.959759],
        ];
        $fakeSv = [];
        foreach ($latlong as  $value) {
            $fakeSv[] = [
                'id' => 888,
                'fullname' => 'Do Tien Khai',
                'quequan' => 'NĐ',
                'lat' => $value[0],
                'long' => $value[1],
                'distance' => 2,
            ];
        }
        $data = array_merge($data, $fakeSv);
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

    static function getInfoPushNotiInArrayCustomers($phoneNumber, $dichvu)
    {
        $fielDichvu = ($dichvu == 'GV1L') ? 'viec_1_lan' : 'viec_thuongxuyen';
        $sql = "SELECT shp.id, type_customer,type_device, device_token
            FROM customers as shp JOIN customer_devices as cs_dv
            ON shp.id = cs_dv.customer_id JOIN devices
            ON cs_dv.device_id = devices.id
            WHERE type_customer = 1 AND $fielDichvu = 1 AND shp.phone_number IN($phoneNumber)";
        $data = DB::select($sql);
        return $data;
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
            ORDER BY distance ASC";
            // HAVING distance = null 
        $data = DB::select($sql);
        // Log::error(['sql' => $sql]);
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
