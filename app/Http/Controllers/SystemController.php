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
