<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use DB;

class QuestionAnswer extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'question_anwsers';
    }

    static function getListQAForCustomer() {
    	return self::where('status', 1)
    	->where('type', 2)
    	->orderBy('order')
    	->get();
    }

    static function getListQAForLaodong() {
    	return self::where('status', 1)
    	->where('type', 1)
    	->orderBy('order')
    	->get();
    }
}
