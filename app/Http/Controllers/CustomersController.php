<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Response;
use Illuminate\Http\Request;
use App\Customer;
use App\Requires;
use App\Setting;
use App\Models\Media\Media;

class CustomersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function laborers($id = null)
    {
        if (Input::method() == 'POST') {
            $data = Input::all();
            $data['cando'] = json_encode($data['cando']);
            if ($data['birthday'] != '') {
                $data['birthday'] = date('Y-m-d', strtotime(str_replace('/', '-', $data['birthday'])));
            }
            unset($data['avatar']);
            unset($data['anhsv_truoc']);
            unset($data['anhsv_sau']);
            unset($data['anhcmtnd_truoc']);
            unset($data['anhcmtnd_sau']);

            if ($_FILES['avatar']['size']) {
                $_FILES['file'] = $_FILES ['avatar'];
                $upImage = Media::uploadImage($_FILES, 'avatar');
                $data['avatar'] = $upImage['url'];
            }

            if ($_FILES['anhsv_truoc']['size']) {
                $_FILES['file'] = $_FILES ['anhsv_truoc'];
                $upImage = Media::uploadImage($_FILES, 'anhsv');
                $data['anhsv_truoc'] = $upImage['url'];
            }

            if ($_FILES['anhsv_sau']['size']) {
                $_FILES['file'] = $_FILES ['anhsv_sau'];
                $upImage = Media::uploadImage($_FILES, 'anhsv');
                $data['anhsv_sau'] = $upImage['url'];
            }

            if ($_FILES['anhcmtnd_truoc']['size']) {
                $_FILES['file'] = $_FILES ['anhcmtnd_truoc'];
                $upImage = Media::uploadImage($_FILES, 'cmtnd');
                $data['anhcmtnd_truoc'] = $upImage['url'];
            }

            if ($_FILES['anhcmtnd_sau']['size']) {
                $_FILES['file'] = $_FILES ['anhcmtnd_sau'];
                $upImage = Media::uploadImage($_FILES, 'cmtnd');
                $data['anhcmtnd_sau'] = $upImage['url'];
            }
            $updateStatus = Customer::SaveData($data);
        }

        if ($id == null) {
            $search = Input::query('search');
            $laborers = Customer::where('type_customer', 1)->whereIn('status', [0, 1]);
            if ($search) {
                $laborers = $laborers->where(function($orConditions) use ($search) {
                    $orConditions->where('email', 'like', "%$search%")
                    ->orWhere('fullname', 'like', "%$search%")
                    ->orWhere('phone_number', 'like', "%$search%")
                    ->orWhere('manv_kh', 'like', "%$search%");

                });
            };
            $laborers = $laborers->orderBy('status')->orderBy('created_at', 'desc')
            ->paginate(15);
            return view('admin.laborers', ['main_data' => $laborers]);
        } else {
            $laborer = Customer::find($id);
            $settingKn = Setting::select('options_kinhnghiem')->first();
            return view('admin.labor_edit', [
                'month_exps' => json_decode($settingKn->options_kinhnghiem, true),
                'data' => $laborer,
                'requires' => Requires::where('status', 1)->orderBy('stt')->get(),
            ]);
        }
        
    }

    
    public function customers()
    {
        $search = Input::query('search');
        $customers = Customer::where('type_customer', 2)->whereIn('status', [0, 1]);
            if ($search) {
                $customers = $customers->where(function($orConditions) use ($search) {
                    $orConditions->where('email', 'like', "%$search%")
                    ->orWhere('fullname', 'like', "%$search%")
                    ->orWhere('phone_number', 'like', "%$search%")
                    ->orWhere('manv_kh', 'like', "%$search%");
                });
            };
        $customers = $customers->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.customers', ['main_data' => $customers]);
    }
    public function usersblocked()
    {
        $blocked = Customer::whereIn('status', [-1])->orderBy('created_at', 'desc')->paginate(15);
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
