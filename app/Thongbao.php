<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class Thongbao extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'thongbaos';
    }

   
    static function getnewsbyCustomerId($except, $type_customer, $createdAtOfUser) {
    	$type = [0, $type_customer];
        return self::whereNotIn('id', $except)
        	->whereIn('type', $type)
        	->where('status', 1)
            ->whereDate('created_at', '>=', $createdAtOfUser)
            ->orderBy('updated_at', 'DESC')->get();
    }
}
