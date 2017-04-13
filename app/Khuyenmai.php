<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class Khuyenmai extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'khuyenmais';
    }

    static function checkKhuyenMai($maKM, $customer_id) {
        return self::where('makhuyenmai', $maKM)
        ->where('expiry_date', '>', date('Y-m-d'))
        ->where('status', 1)
        ->first();
    }

    static function usedKhuyenmai($makhuyenmai) {
        $exist = self::where('makhuyenmai', $makhuyenmai)->where('status', 1)->first();
        if (!empty($exist)) {
            return $exist->id;
        }
        return 0;
    }

}
