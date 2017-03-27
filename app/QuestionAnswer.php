<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use DB;

class QuestionAnswer extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'question_anwsers';
    }

    static function getListQA() {
    	return self::where('status', 1)
    	->orderBy('order')
    	->get();
    }
}
