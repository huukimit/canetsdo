<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use Illuminate\Support\Facades\Log;
use URL;

class Booking extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'bookings';
    }

    public function customer() {
        return $this->belongsTo('App\Customer');
    }

    public function bids()
    {
        return $this->hasMany('App\Bid');
    }

    static function getBookingByCustomerId($customerId) {
        $data = self::whereIn('status', [0, 1, -2, 3])->where('customer_id', $customerId)
        ->select('id','address','status','type','created_at', 'updated_at', 'chonnguoi')->get();
        return $data;
    }
    static function getHistoryBookingByCustomerId($customerId) {
        $data = self::where('bookings.customer_id', $customerId)
        ->select('id', 'address', 'status', 'type', 'created_at', 'updated_at')
        ->get();
        return $data;
    }
    static function checkBookingToCancel($data) {
        return self::whereIn('status', [-2, 0, 1, 3])->where('customer_id', $data['customer_id'])
            ->where('id', $data['booking_id'])->first();
    }
    static function useChonnguoi($data) {
        return self::where('chonnguoi', 1)->where('id', $data['booking_id'])->first();
    }

    static function isGiupviec1lan($data) {
        return self::where('type', 1)->where('id', $data['booking_id'])->exists();
    }

    static function getBookingExpiry() {
        $timeExpiry = date('Y-m-d H:i:s', strtotime('- 2 days'));
        return self::where('status', 0)
            ->where('updated_at', '<', $timeExpiry)
            ->select('id')->get();
    }

    static function getBookingFinding() {
        return self::where('status', 0)->get();
    }

    static function getNumberNhanByTypeAndStatus($customerId, $bookingType, $bidStatus) {
        $result = self::join('bids', 'bids.booking_id', '=', 'bookings.id')
        ->where('bids.laodong_id', $customerId)
        ->where('bookings.type', $bookingType)
        ->whereIn('bids.status', $bidStatus)->count();
        return $result;
    }

    static function getJobsWaitingReceivedFromNotify($except, $typeJob, $customerId, $status = [0, 1]) {
        return self::join('notify_missed_bookings', 'bookings.id', '=', 'notify_missed_bookings.booking_id')
        ->whereNotIn('bookings.id', $except)
        ->whereIn('bookings.status', $status)
        ->where('bookings.type', $typeJob)
        ->where('notify_missed_bookings.customer_id', $customerId)
        ->select('bookings.id', 'address', 'bookings.created_at')
        ->groupBy('bookings.id')
        ->orderBy('bookings.created_at', 'DESC')
        ->get();
    }

    static function getById($id) {
        $exist = self::leftJoin('khuyenmais', 'bookings.makhuyenmai', '=', 'khuyenmais.id')
        ->where('bookings.id', $id)
        ->select('bookings.*', 'khuyenmais.phantram')
        ->first();
        $exist->anh1 =  (($exist->anh1 != '') ? URL::to('/') . '/' . $exist->anh1 : '');
        $exist->anh2 =  (($exist->anh2 != '') ? URL::to('/') . '/' . $exist->anh2 : '');
        $exist->anh3 =  (($exist->anh3 != '') ? URL::to('/') . '/' . $exist->anh3 : '');
        return $exist;
    }

    static function getDetailLichsucongviec($bookingId)
    {
        $res =  self::join('bids', 'bids.booking_id', '=', 'bookings.id')
        ->join('customers', 'customers.id', '=', 'bookings.customer_id')
        ->leftJoin('khuyenmais', 'bookings.makhuyenmai', '=', 'khuyenmais.id')
        ->where('bookings.id', $bookingId)
        ->whereIn('bids.status', [1])
        ->select('fullname', 'manv_kh', 'address', 'time_start', 'time_end', 'ngaylamtrongtuan', 'viecphailam', 'has_phuongtien', 'has_ancunggd', 'thoigianlam', 'phantram', 'thuong', 'tongchiphi', 'is_sv_canceled', 'bookings.status', 'note')
        ->first()->toArray();
        $res['phantram'] = (float)$res['phantram'];
        return $res;
    }

}
