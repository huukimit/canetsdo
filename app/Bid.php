<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class Bid extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'bids';
    }

    static function countBidBuBookingId($bookingId) {
        $count = self::where('booking_id', $bookingId)->count();
        return $count;
    }

    static function checkBided($data) {
        $bided = self::where('booking_id', $data['booking_id'])
            ->where('status', 1)->first();
        if (empty($bided)) {
            $selfBided = self::where('booking_id', $data['booking_id'])
            ->where('laodong_id', $data['laodong_id'])->first();
            return $selfBided;
        }
        return $bided;
    }

    static function getUsersBided($bookingId) {
        $bids = self::join('customers', 'bids.laodong_id', '=', 'customers.id')
            ->where('booking_id', $bookingId)
            ->where('customers.status', 1)
            ->select('customers.id', 'customers.fullname', 'customers.avatar','customers.quequan', 'bids.id as bid_id')
            ->get();
        return $bids;
    }

    static function getBidByBookAndLaodongId($bookingId, $ldId) {
        return self::join('bookings', 'bids.booking_id', '=', 'bookings.id')
        ->where('booking_id', $bookingId)->where('laodong_id', $ldId)
        ->select('bids.*', 'bookings.customer_id')
        ->first();
    }

    static function checkBidByBookingAndBid($bookingId, $bidId) {
        return self::where('booking_id', $bookingId)->where('id', $bidId)->first();
    }

    static function congviecdangnhan($ldId) {
        $danglam = self::join('bookings', 'bids.booking_id', '=', 'bookings.id')
        ->join('customers', 'customers.id', '=', 'bookings.customer_id')
        ->whereIn('bids.status', [0, 1])->where('laodong_id', $ldId)->whereIn('bookings.status', [0, 1, 3])
        ->select('bids.id as bid_id', 'address', 'bids.status', 'customers.phone_number', 'bids.booking_id', 'bookings.type')
        ->get();
        return $danglam;
    }

    static function getAllLdByBookingId($bookingId) {
        $laodong = self::join('customers', 'bids.laodong_id', '=', 'customers.id')
            ->where('booking_id', $bookingId)->select('customers.*')->get();
        return $laodong;
    }

    static function getLaborDoneJob($bookingId) {
        return self::whereIn('status', [1, 2])
            ->where('booking_id', $bookingId)->first();
    }

    static function getHistoryWorkedOfCustomer($ldId)
    {
        $historyWorked = self::join('bookings', 'bids.booking_id', '=', 'bookings.id')
        ->whereIn('bids.status', [1])->where('laodong_id', $ldId)->where('bookings.status', 2)
        ->select('booking_id', 'address','bookings.type', 'time_start', 'time_end', 'ngaylamtrongtuan',  'bookings.created_at', 'bookings.updated_at')
        ->get();
        return $historyWorked;
    }

    static function getLaodongDaDuocChon($bookingId) {
        return self::where('booking_id', $bookingId)->where('status', 1)->first();
    }

    static function getBookingByBidId($bidId) {
        return self::join('bookings', 'bids.booking_id', '=', 'bookings.id')
        ->where('bids.id', $bidId)
        ->select('bookings.*', 'bids.laodong_id')->first();
    }

}
