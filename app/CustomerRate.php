<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use DB;

class CustomerRate extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'customer_rates';
    }

    static function hasRate($bookingId) {
        return self::where('booking_id', $bookingId)->exists();
    }

    static function getNumAvg($laodongId) {

        $sql = "SELECT COUNT(id) as number_rate, AVG(stars) as stars FROM customer_rates WHERE laodong_id = $laodongId";
        return DB::select($sql);
    }
    static function listRateBy($laodongId, $limit = 30) {
        return self::join('customers', 'customers.id' , '=', 'customer_rates.customer_id')->where('laodong_id', $laodongId)->orderBy('created_at', 'DESC')->select('customer_rates.*', 'customers.fullname')->limit($limit)->get();
    }
}
