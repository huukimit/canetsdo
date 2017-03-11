<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use Illuminate\Support\Facades\Log;

class Booking extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'bookings';
    }

    public function customer() {
        return $this->belongsTo('App\Customer');
    }

    static function getBookingByCustomerId($customerId) {
        $data = self::whereIn('status', [0, 1, -2, 3])->where('customer_id', $customerId)
        ->select('id','address','status','type','created_at', 'updated_at', 'chonnguoi')->get();
        return $data;
    }
    static function getHistoryBookingByCustomerId($customerId) {
        $data = self::where('bookings.customer_id', $customerId)
        ->leftJoin('bids', 'bids.booking_id', '=', 'bookings.id')
        ->select(
            'bookings.id','bookings.address','bookings.status',
            'bids.is_sv_canceled', 'bookings.type','bookings.created_at',
            'bookings.updated_at'
        )->get();
        return $data;
    }
    static function checkBookingToCancel($data) {
        return self::whereIn('status', [-2, 0, 1])->where('customer_id', $data['customer_id'])
            ->where('id', $data['booking_id'])->first();
    }
    static function useChonnguoi($bookingId) {
        return self::where('chonnguoi', 1)->where('id', $data['booking_id'])->first();
    }

    static function isGiupviec1lan($data) {
        return self::where('type', 1)->where('id', $data['booking_id'])->exists();
    }

    static function getBookingExpiry() {
        $timeExpiry = date('Y-m-d H:i:s', strtotime('- 15 minutes'));
        return self::where('status', 0)
            ->where('updated_at', '<', $timeExpiry)
            ->select('id')->get();
    }

    static function getBookingFinding() {
        return self::where('status', 0)->get();
    }

}
