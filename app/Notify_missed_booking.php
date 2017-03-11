<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class Notify_missed_booking extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'notify_missed_bookings';
    }

    static function getMissedNotifyBookings($laodongId) {
    	return self::join('bookings', 'notify_missed_bookings.booking_id', '=', 'bookings.id')
    		->where('bookings.status', 0)->where('notify_missed_bookings.laodong_id', $laodongId)
    		->where('notify_missed_bookings.status', 0)
    		->orderBy('notify_missed_bookings.updated_at', 'DESC')->get();
    }
}
