<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class Lichsugiaodich extends BaseModel {

    function __construct() {
        parent::__construct();
        $this->table = 'lichsugiaodich';
    }

    public function customer() {
        return $this->belongsTo('App\Customer');
    }

    public static function getLichSuGiaoDich($customerId) {
    	return self::where('customer_id', $customerId)->orderBy('created_at', 'desc')->get();
    }
}
