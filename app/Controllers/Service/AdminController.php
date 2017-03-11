<?php

namespace App\Controllers\Service;

use App\Http\Controllers\ServiceController;
use App\Models\Shop\Photo;
use Input;
use App\Libraries\S2Cms\Uploads;

class AdminController extends ServiceController {

    public function PhotoAction() {
        $act = Input::get('act', '');
        switch ($act) {
            case 'delete':
                $id = Input::get('id', 0);
                $this->status = Photo::UpdateStatus($id, -1);
                break;


            default:

                break;
        }
    }

}
