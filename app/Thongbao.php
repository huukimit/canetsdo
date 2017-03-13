<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class Thongbao extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'thongbaos';
    }

   
    static function getnewsbyCustomerId($customerId) {
        return self::where('customer_id', $customerId)
            ->orderBy('updated_at', 'DESC')->get();
    }
}
