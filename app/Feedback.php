<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class Feedback extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'feedbacks';
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
