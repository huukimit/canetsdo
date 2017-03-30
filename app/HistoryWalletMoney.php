<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class HistoryWalletMoney extends BaseModel {
    function __construct() {
        parent::__construct();
        $this->table = 'history_wallet_money';
    }

    static function getHistoryViTien($ldId)
    {
        return self::where('customer_id', $ldId)->get();
    }

}
