<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use DB;

class QuestionAnswer extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'question_anwsers';
    }

    static function getListQA($type = 2) {
    	return self::where('status', 1)
    	->where('type', $type)
    	->orderBy('order')
    	->get();
    }
}
