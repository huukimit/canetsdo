<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class Khuyenmai extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'khuyenmais';
    }

    static function checkKhuyenMai($maKM, $customer_id) {
        return self::where('makhuyenmai', $maKM)->where('customer_id', $customer_id)->first();
    }

    static function usedKhuyenmai($makhuyenmai, $customer_id) {
        $exist = self::where('makhuyenmai', $makhuyenmai)
        ->where('customer_id', $customer_id)->where('status', 1)->first();
        if (!empty($exist)) {
            self::where('makhuyenmai', $makhuyenmai)->where('customer_id', $customer_id)->update(['status' => 2]);
            return $exist->id;
        }
        return 0;
    }

}
