<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Response;
use Illuminate\Http\Request;
use App\Setting;

class SystemController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function updateluonggv1lan()
    {
        $req = Input::get('info');
        $setting = Setting::find(1);
        if ($setting) {
            $setting->luonggiupviec1lan = json_encode($req);
            if ($setting->save()) {
                return Response::json(['status' => true]);
            }
        }
        return Response::json(['status' => false]);
    }
    
    public function updateluonggvthuongxuyen()
    {
        if(is_numeric(Input::get('info')) && Input::get('info') > 0) {
            $setting = Setting::find(1);
            if ($setting) {
                $setting->luong1h_thuongxuyen= Input::get('info');
                if ($setting->save()) {
                    return Response::json(['status' => true]);
                }
            }
            return Response::json(['status' => false]);
        } else {
            return Response::json(['status' => false]);
        }
    }
    
    public function updateversionapp()
    {
        $setting = Setting::find(1);
        if ($setting) {
            $setting->canets_android= Input::get('canets_android');
            $setting->canets_do_android= Input::get('canets_do_android');
            $setting->canets_ios= Input::get('canets_ios');
            $setting->canets_do_ios= Input::get('canets_do_ios');
            if ($setting->save()) {
                return Response::json(['status' => true]);
            }
        }
        return Response::json(['status' => false]);
    }

    public function updatepolicy()
    {
        $setting = Setting::find(1);
        if ($setting) {
            $setting->policy_customer= Input::get('policy_customer');
            $setting->policy_worker= Input::get('policy_worker');
            if ($setting->save()) {
                return Response::json(['status' => true]);
            }
        }
        return Response::json(['status' => false]);
    }
        
    
    public function updatethongtinchuyenkhoan()
    {
        $req = Input::get('info');
        $setting = Setting::find(1);
        if ($setting) {
            $setting->thongtinchuyenkhoan= json_encode($req);
            if ($setting->save()) {
                return Response::json(['status' => true]);
            }
        }
        return Response::json(['status' => false]);
    }
}
