<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class Notify_missed_booking extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'notify_missed_bookings';
    }

    static function getMissedNotifyBookings($customerId) {
    	return self::join('bookings', 'notify_missed_bookings.booking_id', '=', 'bookings.id')
    		->where('bookings.status', 0)->where('notify_missed_bookings.customer_id', $customerId)
    		->where('notify_missed_bookings.status', 0)
    		->orderBy('notify_missed_bookings.updated_at', 'DESC')->get();
    }

    static function getNotifyByCustomerId($customerId) {
        return self::join('bookings', 'notify_missed_bookings.booking_id', '=', 'bookings.id')
            ->where('notify_missed_bookings.customer_id', $customerId)
            ->orderBy('notify_missed_bookings.updated_at', 'DESC')->get();
    }

    static function deleteNotifyOfCustomerId($customerId, $bookingId)
    {
        return self::where('notify_missed_bookings.customer_id', $customerId)
        ->where('notify_missed_bookings.booking_id', $bookingId)->delete();
    }
}
