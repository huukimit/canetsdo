<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB,
    Cache,
    Input,
    Validator,
    Schema;

class BaseModel extends Model {

    protected $primaryKey = 'id';

    /*
     * Lấy toàn bộ bản ghi của bảng
     */

    static function fetchAll($update = true) {
        $cache_key = 'table_cache_' . with(new static)->table;
        $getConfig = Cache::get($cache_key);
        if (!$getConfig || $update) {
            $getConfig = self::where('status', '>', 0)->get();
            if ($getConfig) {
                Cache::put($cache_key, $getConfig, 86400);
            }
        }
        return $getConfig;
    }

    static function getById($id) {
        return self::where('id', $id)->first();
    }

    /*
     * Lấy thông tin chi tiết 1 bản ghi
     */

    static function getInfo($id, $update = true) {
        $cache_key = 'table_cache_' . with(new static)->table . '_with_id_' . $id;
        $getConfig = Cache::get($cache_key);
        if (!$getConfig || $update) {
            $getConfig = self::where(with(new static)->primaryKey, $id)->first();
            if ($getConfig) {
                Cache::put($cache_key, $getConfig, 86400);
            }
        }
        return $getConfig;
    }

    /*
     * Lấy dữ liệu và phân trang
     */

    static function getList($order_by = 'created_at', $limit = 15) {
        $data = self::where('status', '>', '0')
                ->orderBy($order_by, 'desc')
                ->paginate($limit);
        return $data;
    }

    /**
     * Cập nhật dữ liệu vào trong CSDL
     * Kiểm tra thông tin của mảng:
     *  - Dữ liệu đã tồn tại -> Update
     *  - Dữ liệu mới -> Tạo mới bản ghi
     */
    public static function SaveData($data_update = [], $table_name = false, $table_key = false) {
        if (!$data_update) {
            return false;
        }
        if (!$table_name) {
            $model = with(new static);
            $table_name = $model->table;
            $table_key = $model->primaryKey;
        }
        $primary_key = 0;
        $columns = Schema::getColumnListing($table_name);
        $data = array();
        foreach ($columns as $column) {
            if ($column == $table_key) {
                if (isset($data_update[$table_key])) {
                    $primary_key = $data_update[$table_key];
                }
            } else {
                if (isset($data_update[$column])) {
                    // Xử lý dữ liệu Number
                    if (in_array($column, ['price', 'price_promte'])) {
                        $data_update[$column] = priceToFloat($data_update[$column]);
                    }

                    $data[$column] = trim($data_update[$column]);
                }
            }
        }
        $has_record = self::where($table_key, $primary_key)->first();
        if (is_null($has_record)) {
            /* Insert here */
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['updated_at'] = $data['created_at'];
            return DB::table($table_name)->insertGetId($data);
        } else {
            /* Update here */
            $data['updated_at'] = date("Y-m-d H:i:s");
            DB::table($table_name)->where($table_key, $primary_key)->update($data);
            return $primary_key;
        }
    }

    /**
     * Cập nhật trạng thái bản ghi
     */
    static function UpdateStatus($id = 0, $status = 1) {
        if (!$id) {
            return false;
        }
        $model = with(new static);
        return DB::table($model->table)->where($model->primaryKey, $id)->update(['status' => $status]);
    }

    /* Xử lý FORM ***************************************************************************** */

    static function getOption() {
        return [];
    }

    static function getRules() {
        return [];
//        $list = parent::getRules();
////        $list['keyword'] = 'required';
//        return $list;
    }

    static function getForm($id = 0) {
        $model = with(new static);
        $table_name = $model->table;
        $id = $id ? $id : Input::get('id', 0);
        $info = self::getInfo($id);
        $columns = Schema::getColumnListing($table_name);
        $form = array();
        $getOption = static::getOption();
        foreach ($columns as $column) {
            $item = isset($getOption[$column]) ? $getOption[$column] : [];
            $item['value'] = isset($info[$column]) ? $info[$column] : (isset($getOption[$column]['value']) ? $getOption[$column]['value'] : '');
            if (!isset($item['type'])) {
                $item['type'] = 'text'; // Nếu chưa gán kiểu từ phần lựa chọn thì ép kiểu mặc định
                if (in_array($column, ['id', 'created', 'status', 'last_update', 'count_view', 'updated_at', 'created_at', 'remember_token'])) {
                    $item['type'] = 'hidden';
                }
                if (in_array($column, ['description', 'text_sort', 'promotion', 'warranty'])) {
                    $item['type'] = 'textarea';
                }
                if (in_array($column, ['body', 'content', 'text_long', 'infomation', 'info_detail', 'vitri', 'tienich', 'matbang', 'tintuc', 'hinhanh'])) {
                    $item['type'] = 'editer';
                }
                if (in_array($column, ['keyword', 'keyword'])) {
                    $item['type'] = 'keyword';
                }
                // if( in_array($column, ['code' ]) ) {
                //     $item['type'] = 'readonly';
                // }
                if (in_array($column, ['photo', 'image', 'images', 'avatar', 'thumb'])) {
                    $item['type'] = 'file';
                }
                if (in_array($column, ['price', 'price_promte'])) {
                    $item['type'] = 'number';
                }
            }
            $form[$column] = $item;
        }

        return FormManager::Build($form);
    }

    static function getSubmit() {
        $getInput = Input::all();
        $id = self::SaveData($getInput);
        return redirect($getInput['cform_url'] . '?id=' . $id)->with('message', 'Updated!');
    }

}
