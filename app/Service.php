<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class Service extends BaseModel {

    function __construct() {
        parent::__construct();
        $this->table = 'services';
    }

    static function getServices(){
    	return self::where('status', 1 )->get();
    }

}
