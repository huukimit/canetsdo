<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class CustomerDevice extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'customer_devices';
    }
}
