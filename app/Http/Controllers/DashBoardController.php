<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Booking;
use App\Customer;
use App\Setting;

class DashBoardController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $lastw = [12, 6, 28, 71, 12, 1, 5];//tu thu 2 den thu 7
        $thisw = [5, 20, 15, 41, 3, 90, 1];// same above
        $bookings_working = Booking::whereIn('status', [0, 1])->select('lat', 'long', 'type')->get();
        $markers = Booking::whereIn('status', [0, 1])->select('lat', 'long', 'type')->get();
        $data = [
            'laborersNumber' => Customer::where('type_customer', 1)->count(),
            'customerNumber' => Customer::where('type_customer', 2)->count(),
            'bookingNumber' => Booking::whereIN('status', [-2, 0, 1])->count(),
            'bookingDoneNumber' => Booking::whereIN('status', [2])->count(),
            'markers' => json_encode($markers),
            'lastw' => json_encode($lastw),
            'thisw' => json_encode($thisw),
        ];
        return view('admin.dashboard', $data);
    }

    public function systemConfig()
    {
        $setting = Setting::getConfig();
        
       
        return view('admin.systemConfig', ['mainData' => $setting]);
    }

}
