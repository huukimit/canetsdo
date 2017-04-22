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
    public function laborers($id = null)
    {
        if ($id == null) {
            $laborers = Customer::where('type_customer', 1)->whereIn('status', [0, 1])
            ->orderBy('status')->orderBy('updated_at', 'desc')
            ->paginate(15);
            return view('admin.laborers', ['main_data' => $laborers]);
        } else {
            $laborer_detail = Customer::find($id);
            
            return view('admin.labor_edit', ['main_data' => $laborer_detail]);
        }
        
        
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
        $message = 'Đã cho phép lao động nhận giúp việc một lần';
        $customer = Customer::find(Input::get('customer_id'));
        if ($customer->allow_gv1lan == 0) {
            $customer->allow_gv1lan = 1;
        } else {
            $customer->allow_gv1lan = 0;
            $message = 'Đã tắt chức năng nhận công việc một lần của lao động';
        }

        if ($customer->save()) {
            return Response::json(['status' => true, 'message' => $message]);
        }

        return Response::json(['status' => false]);
    }

}
