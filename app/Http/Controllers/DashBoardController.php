<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Booking;
use App\Customer;
use App\Setting;
use App\Thongbao;
use App\Feedback;
use App\Lichsugiaodich;
use Input;
use App\Commands\PushNotifyToDevices;
use Illuminate\Support\Facades\Queue;

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

    public function createThongbao()
    {
        if (Input::method() == 'POST') {
            $data = Input::all();
            $data['status'] = 1;
            if (Thongbao::SaveData($data)) {
                $pushData = ['key' => 'Thongbao', 'content' => $data['content']];
                $customers = Customer::getTokenAllUserToPushNotify($data['type']);
                $missed = [];
                Queue::later(5, new PushNotifyToDevices($customers, $data['title'], $pushData, 'Admin create notify'));
                    }
        }
        return view('admin.createnotify',[
            'thongbaos' => Thongbao::orderBy('created_at', 'DESC')->paginate(10),
        ]);
    }

    public function votes()
    {
        if (Input::method() == 'POST') {
            $data = Input::all();
            if (Thongbao::SaveData($data)) {
                $pushData = ['key' => 'Thongbao', 'content' => $data['content']];
                $customers = Customer::getTokenAllUserToPushNotify($data['type']);
                $missed = [];
                Queue::later(5, new PushNotifyToDevices($customers, $data['title'], $pushData, 'Admin create notify'));
                    }
        }
        return view('admin.createnotify',[
            'thongbaos' => Thongbao::orderBy('created_at', 'DESC')->paginate(10),
        ]);
    }

    public function congTruTien()
    {
        if (Input::method() == 'POST') {
            $post = Input::all();
            $customer = Customer::find($post['id']);
            if (isset($customer->id)) {
                ($post['sotien'] < 0) ? $post['sotien'] = ((int)$post['sotien'] * -1) : '';
                $upDownmoney = ($post['type'] * $post['sotien']);
                $updateCustomer = [
                    'id' => $customer->id,
                    $post['vi'] => $customer->$post['vi'] + $upDownmoney,
                ];
                $transaction = [
                    'customer_id' => $customer->id,
                    'amount_moneys' => $upDownmoney,
                    'reason' => $post['reason'],
                    'type' => 4,
                ];
                
                if (Customer::SaveData($updateCustomer)) {
                    Lichsugiaodich::SaveData($transaction);
                }

            } else {
                echo 'Có lỗi sảy ra, vui lòng liên hệ Admin';die;
            }
        }
        return view('admin.congtrutien',[
            'customers' => Customer::where('status', '1')->where('manv_kh', '!=', '')
                ->select('id','fullname', 'manv_kh')->get(),
            'lichsucongtrus' => Lichsugiaodich::where('type', 4)->orderBy('created_at', 'DESC')->paginate(10),
        ]);
    }

    public function feedbacks() {
        // $fb = Feedback::orderBy('created_at', 'DESC')->paginate(10);
        // dd($fb);
        return view('admin.feedbacks',[
            'feedbacks' => Feedback::orderBy('created_at', 'DESC')->paginate(10),
        ]);
    }
    

}
