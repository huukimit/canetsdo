<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Response;
use Illuminate\Http\Request;
use App\Customer;

class CustomersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function laborers()
    {
        $laborers = Customer::where('type_customer', 1)->whereIn('status', [0, 1])->orderBy('updated_at', 'desc')->paginate(15);
        
        return view('admin.laborers', ['main_data' => $laborers]);
    }
    public function customers()
    {
        $customers = Customer::where('type_customer', 2)->whereIn('status', [0, 1])->orderBy('updated_at', 'desc')->paginate(15);
        return view('admin.customers', ['main_data' => $customers]);
    }
    public function usersblocked()
    {
        $blocked = Customer::whereIn('status', [-1])->orderBy('updated_at', 'desc')->paginate(15);
        return view('admin.usersblocked', ['main_data' => $blocked]);
    }
    public function activeUser()
    {
        $customer = Customer::find(Input::get('active'));
        $customer->status = 1;
        if ($customer->save()) {
            return Response::json(['status' => true]);
        }
        return Response::json(['status' => false]);
    }

    
    public function onOffGvThuongxuyen()
    {
        $message = 'Đã cho phép lao động nhận giúp việc thường xuyên';
        $customer = Customer::find(Input::get('customer_id'));
        if ($customer->viec_thuongxuyen == 0) {
            $customer->viec_thuongxuyen = 1;
        } else {
            $customer->viec_thuongxuyen = 0;
            $message = 'Đã tắt chức năng nhận công việc thường xuyên của lao động';
        }
        if ($customer->save()) {
            return Response::json(['status' => true, 'message' => $message]);
        }

        return Response::json(['status' => false]);

    }

}
