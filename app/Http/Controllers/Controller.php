<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

    use DispatchesCommands,
        ValidatesRequests;

    public function getMethodByAction($cmd, $action) {
        if (!$cmd) {
            return 'indexAction';
        } else {
            return text2method($cmd) . text2method($action);
        }
    }

    public function indexAction() {

    }

}
