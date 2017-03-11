<?php

if( !function_exists('upload_path') ) {

    /**
     * Get the path to the uploads folder.
     *
     * @param  string  $path
     * @return string
     */
    function upload_path($path = '') {
        $directory = realpath(app()->make('path.base') . '/../') . '/uploads' . ($path ? '/' . $path : $path);
        if( !file_exists($directory) ) {
            File::makeDirectory($directory, 0775, true);
        }
        return $directory;
    }

}

if(!function_exists('randChar')){
    function randChar($length = 8) {
         $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
         $string = '';
         for ($p = 0; $p < $length; $p++) {
             $string .= $characters[mt_rand(0, strlen($characters)-1)];
         }
         return $string;
    }
}

if(!function_exists('text2method')){
    function text2method($str = ''){
        $str = preg_replace('/-/', ' ', $str);
        return trim(preg_replace('/ /', '', ucwords($str)));
    }
}

if(!function_exists('priceToFloat')){
    function priceToFloat($s){
        $s = str_replace(',', '.', $s);// convert "," to "."
        $s = preg_replace("/[^0-9\.]/", "", $s);// remove all but numbers "."
        $hasCents = (substr($s, -3, 1) == '.');// check for cents
        $s = str_replace('.', '', $s);// remove all seperators
        if ($hasCents){
            $s = substr($s, 0, -2) . '.' . substr($s, -2);// insert cent seperator
        }
        return (float) $s;// return float
    }
}


if(! function_exists('get_client_ip')){
    function get_client_ip() {
        $ipaddress = '127.0.0.1';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}

if(! function_exists('splitAtUpperCase')){
    // $string = 'setIfUnmodifiedSince';
    // echo splitAtUpperCase($string);
    function splitAtUpperCase($string){
        $new_str = preg_replace('/([a-z0-9])?([A-Z])/','$1____$2',$string);
        return explode('____',$new_str);
    }
}


if(! function_exists('get_file_in_dir')){
    function get_file_in_dir($dir_backup = ''){
        $results = array();$dem = 1;
        $handler = opendir($dir_backup);
        while ($file = readdir($handler)) {
            if ($file != "." && $file != ".." && $file != ".htaccess") {
                $data = array();
                $data['filename'] = $file;
                $size = filesize($dir_backup.$file);
                if($size < 1024){
                    $read_size = $size.' B';
                }else{
                    if($size < 1024*1024){
                        $read_size = $size / 1024 .' Kb';
                    }else{
                        if($size < 1024*1042*1024){
                            $read_size = $size / 1024 / 1024 .' Mb';
                        }
                    }
                }

                $data['size'] = $read_size;
                $data['created'] = filemtime($dir_backup.$file);
                $results[$dem] = $data;
                $dem ++;
            }
        }
        closedir($handler);
        return $results;
    }
}

if( !function_exists('cw') ) {

    /**
     * Show HTML Debug
     *
     * @param  string  $html
     * @return string
     */
    function cw($html = '') {
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" lang="vi" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#"><head><title>Debug HTML</title><META http-equiv="Content-Language" CONTENT="vi"><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /></head><body>';
        echo $html;
        echo '</body></html>';
        die;
    }

}

if( !function_exists('upload_url') ) {

    /**
     * Get the url to the uploads folder.
     *
     * @param  string  $file
     * @return string
     */
    function upload_url($file = '') {
        return url('uploads' . ($file ? '/' . $file : $file));
    }

}

if( !function_exists('minify_output') ) {

    /**
     * Minify output HTML.
     *
     * @param  string  $buffer
     * @return string
     */
    function minify_output($buffer) {
        $search = array( '/\>[^\S]+/s', '/[^\S]+\</s', '/(\s)+/s' );
        $replace = array( '>', '<', '\\1' );
        if( preg_match("/\<html/i", $buffer) == 1 && preg_match("/\<\/html\>/i", $buffer) == 1 ) {
            $buffer = preg_replace($search, $replace, $buffer);
        }
        return $buffer;
    }

}



if( !function_exists('encrypt_passwd') ) {

    function encrypt_passwd($str) {
        return md5(md5($str) . '-cuongpham90');
    }

}
if( !function_exists('safe_title') ) {

    /**
     * Minify output HTML.
     *
     * @param  string  $str
     * @return string
     */
    function safe_title($str = '') {
        $str = html_entity_decode($str, ENT_QUOTES, "UTF-8");
        $filter_in = array( '#(a|à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#', '#(A|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#', '#(e|è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#', '#(E|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#', '#(i|ì|í|ị|ỉ)#', '#(I|ĩ|Ì|Í|Ị|Ỉ|Ĩ)#', '#(o|ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#', '#(O|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#', '#(u|ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#', '#(U|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#', '#(y|ỳ|ý|ỵ|ỷ|ỹ)#', '#(Y|Ỳ|Ý|Ỵ|Ỷ|Ỹ)#', '#(d|đ)#', '#(D|Đ)#' );
        $filter_out = array( 'a', 'A', 'e', 'E', 'i', 'I', 'o', 'O', 'u', 'U', 'y', 'Y', 'd', 'D' );
        $text = preg_replace($filter_in, $filter_out, $str);
        $text = preg_replace('/[^a-zA-Z0-9]/', ' ', $text);
        $text = trim(preg_replace('/ /', '-', trim(strtolower($text))));
        $text = preg_replace('/--/', '-', $text);
        return preg_replace('/--/', '-', $text);
    }

}



if(!function_exists('random_item_arr')){
    function random_item_arr($arr){
        return $arr[rand(0 , count($arr) - 1)];
    }
}

if(!function_exists('remove_format_html')){
	function remove_format_html($content) {
        return strip_tags($content , '<p><a><img><strong><br><b><i><em><div><ul><li><ol><table><tr><th><td>');
    }

}