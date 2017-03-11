<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class Setting extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'settings';
    }

    static function getConfig() {
    	$bonuses = self::first();
    	return $bonuses;
    }

}
