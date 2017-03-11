<?php

namespace App\Libraries\Feeds;

require base_path() . '/third_party/simplehtmldom/htmldom.php';

use HtmlDom;
use DB;

class FeedsBase extends HtmlDom {

    protected $base_url = '';
    protected $table_name = 's2_news';

    public function read_url($url) {
        if( !($dom = $this->Connect($url)) ) {
            if( $this->get_http_response_code($url) == "200" ) {
                $read_url_content = file_get_contents($url);
                $dom = str_get_html($read_url_content);
            } else {
                return false;
            }
        }
        return $dom;
    }

    public function get_html($url) {
        if( !($html = $this->Exec($url)) ) {
            if( $this->get_http_response_code($url) == "200" ) {
                $html = file_get_contents($url);
            } else {
                return false;
            }
        }
        return $html;
    }

    public function get_http_response_code($url) {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }

    public function SaveContent($content) {
        $check_in_store = DB::table($this->table_name)->where('source', $content['source'])->first();
        if( !$check_in_store ) {
            DB::table($this->table_name)->insert($content);
        }
    }

}
