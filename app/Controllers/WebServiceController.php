<?php

namespace App\Controllers;

use App\Http\Controllers\Controller;

class WebServiceController extends Controller {

    function getAction($page = '', $cmd = '', $action = '') {
        if (!$page) {
            return $this->indexAction();
        }
        $class_name = ucwords($page) . 'Controller';
        $class_file = dirname(__FILE__) . '/Service/' . $class_name . '.php';
        if (!file_exists($class_file)) {
            die("The file <strong>$class_file</strong> does not exist, please send this error to admin");
        }
        $method = $this->getMethodByAction($cmd, $action);
        $page_class_name = 'App\\Controllers\\Service\\' . $class_name;
        $page_class = \App::make($page_class_name);
        if (!method_exists($page_class, $method)) {
            die('Method <strong>' . $method . '</strong> not active in class <strong>' . $page_class_name . '</strong>');
        }
        return $page_class->$method();
    }

}
