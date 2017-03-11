<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class Requires extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'requires';
    }

    static function getRequires(){
    	return self::where('status', 1)->orderBy('stt')->select('id', 'name')->get();
    }

}
