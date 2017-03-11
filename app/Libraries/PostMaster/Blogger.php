<?php

namespace App\Libraries\PostMaster;
use Image;

class Blogger {

    static function do_login(){
        if( ! session('blogger_session') || session('blogger_timeout') + 60*5 < time()){
            $data = array(
                'accountType'   => 'GOOGLE', 
                'Email'         => config('manager.uploads.username'),
                'Passwd'        => config('manager.uploads.password'),
                'source'        => __FILE__, 
                'service'       =>'blogger'
            );
         
            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, "https://www.google.com/accounts/ClientLogin"); 
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
            curl_setopt($ch, CURLOPT_POST, true); 
            curl_setopt($ch, CURLOPT_USERAGENT, config('manager.uploads.user_agent') );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
            $content = curl_exec($ch); 
            
            if (preg_match('#Auth=([a-z0-9_\-]+)#i', $content, $matches)){
                session(['blogger_session' => $matches[1] , 'blogger_timeout' => time() ]);
            }           
        }
    }

    static function testBlog(){
        if( !session('blogger_session') ) self::do_login();
        if ( !session('blogger_session') ) return '';

        $blogID = '1032906682920080136';
        $url = 'https://www.googleapis.com/blogger/v3/blogs/1032906682920080136/posts/';

        $entry = "<entry xmlns='http://www.w3.org/2005/Atom'>
            <title type='text'>Title of blog post </title>
            <content type='xhtml'>
                This is testing contnetto post in blog post.
            </content>
        </entry>";
        $len = strlen($entry);

        $headers = array("Content-type: application/atom+xml","Content-Length: {$len}","Authorization: GoogleLogin auth=".session('blogger_session'),"$entry");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.blogger.com/feeds/$blogID/posts/default");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        $result = curl_exec($ch);
        $ERROR_CODE = curl_getinfo($ch);
        curl_close($ch);

        echo '<pre>';
        print_r($headers);
        var_dump($result);
        print_r($ERROR_CODE);
        exit;

    }
    
}
