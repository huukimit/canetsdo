<?php

namespace App\Http\Controllers;

use Request, Input, Config;

class ServiceController extends S2Controller {

    protected $status = 500;
    protected $message = 'Server error';
    protected $data = array('no-data' => null);
    protected $action = '';
    protected $html = '';
    protected $type = 'json';

    public function __destruct() {
        $this->ReturnData();
    }

    protected function ReturnData() {
        $output_type = Input::get('output', 'json');
        switch ($output_type) {
            case 'data':
                echo json_encode($this->data);
                break;
            case 'html':
                echo $this->message;
                break;
            default :
                echo json_encode($this->return_json());
        }
        exit();
    }

    protected function return_json() {
        if (Request::segment(3)) {
            $this->action = Request::segment(2) . '-' . Request::segment(3);
        } else {
            $this->action = Request::segment(2);
        }
        return [
            'action' => $this->action,
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data,
        ];
    }

    /**
     *
     *
     * @param type $data
     * @return Check data null
     */
    protected function checkNullData($data) {
        if ($data == null) {
            $this->status = 404;
            $this->message = Config::get('services.notify.no_param');
            die();
        } else {
            return TRUE;
        }
    }

    /**
     *
     * @param type $data
     * @return Check data array null
     */
    protected function checkNullDataInArray($data) {
        foreach ($data as $key => $value) {
            $this->checkNullData($data[$key]);
        }
    }
    public function randomString($length = 30) {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
    return $str;
    }

}
