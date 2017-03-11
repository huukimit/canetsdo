<?php


namespace App\Libraries\S2Cms;
use Image;

class Uploads {

    static function upload_photo( $photo , $name , $path , $option = ['resize' => false ] ){
    	$path = rtrim($path , '/').'/'.date('Y/m/d/', time());
     	$dir_upload = public_path($path);
     	if (!file_exists($dir_upload)) {
            mkdir($dir_upload, 0777, true);
        }
		$file_upload = safe_title($name).'-'.rand(10,99).time().rand(10,99).'.'.$photo->getClientOriginalExtension();

		$img = Image::make($photo);
		// Resize
    	if($option['resize']){
    		$size_width = isset($option['size']['width']) ? (int) $option['size']['width'] : 640;
    		$size_heigth = isset($option['size']['height']) ? (int) $option['size']['height'] : $size_width * 3/4;
    		$widen = (int) $size_width * 3/2;
    		$img->widen($widen)->fit($size_width , $size_heigth);
    	
	    	if(isset($option['text'])){
		    	$img->text($option['text'] , $size_width - 10 , $size_heigth - 10 , function($font) {
		            $font->file( base_path('phamcuongt2/watermask_font.ttf'));
		            $font->size(24);
		            $font->color(array(255, 255, 255, 0.5));
		            $font->align('right');
		        });
	    	}
    	}
        $img->save( $dir_upload.$file_upload);
		return url($path.$file_upload);
    }


    static function do_login(){
        if( ! session('upload_session') || session('upload_timeout') + 60*5 < time()){
            $data = array(
                'accountType'   => 'GOOGLE', 
                'Email'         => config('manager.uploads.username'),
                'Passwd'        => config('manager.uploads.password'),
                'source'        => __FILE__, 
                'service'       =>'lh2'
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
                session(['upload_session' => $matches[1] , 'upload_timeout' => time() ]);
            }           
        }
    }

    static function testBlog(){
        if( !session('upload_session') ) self::do_login();
        if ( !session('upload_session') ) return '';

        $blog_id = '1032906682920080136';
        $url = 'https://www.googleapis.com/blogger/v3/blogs/1032906682920080136/posts/';

       $data = '
        {
          "kind": "blogger#post",
          "blog": {
            "id": "1032906682920080136"
          },
          "title": "A new post",
          "content": "With <b>exciting</b> content..."
        }

       ';

        $header = array(
            'GData-Version:  2',
            'Authorization:  GoogleLogin auth="'. session('upload_session') .'"',
            'Content-Length: ' . strlen($data), 'MIME-version: 1.0'
        );


        // Upload
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt($ch, CURLOPT_POST, true); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
        curl_setopt($ch, CURLOPT_HEADER, true); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, config('manager.uploads.user_agent') );    
 
        $ret = curl_exec($ch);
        curl_close($ch);

        var_dump($ret);
    }
    
    static function upload_picasa($path_file , $title = 'upload by PhamCuongT2'){
        if( !session('upload_session') ) self::do_login();
        if ( !session('upload_session') ) return '';
        $albumUrl = "https://picasaweb.google.com/data/feed/api/user/".config('manager.uploads.account_id')."/albumid/". random_item_arr(config('manager.uploads.album_id'));
        $rawImgXml = "
        <entry xmlns='http://www.w3.org/2005/Atom'>
            <title>". safe_title($title) ."</title>
            <summary>".$title."</summary>
            <category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/photos/2007#photo' />
        </entry>
        ";
        // Lấy thông tin File
        if( preg_match('/http:/', $path_file) ){
            $ch_upload = curl_init();
            curl_setopt($ch_upload, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch_upload, CURLOPT_HEADER, 0);
            curl_setopt($ch_upload, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch_upload, CURLOPT_URL, $path_file);
            curl_setopt($ch_upload, CURLOPT_FOLLOWLOCATION, TRUE);   
            curl_setopt($ch_upload, CURLOPT_USERAGENT, config('manager.uploads.user_agent') );    
            $imgData = curl_exec($ch_upload);
            curl_close($ch_upload);
        }else{
            $fileSize = filesize($path_file);
            $fh = fopen($path, 'rb');
            $imgData = fread($fh, $fileSize);
            fclose($fh);            
        }

        $data = "";
        $data .= "\nMedia multipart posting\n";
        $data .= "--IDW0562028BN9JGPFON6OYOMZ4MP\n";
        $data .= "Content-Type: application/atom+xml\n\n";
        $data .= $rawImgXml . "\n";
        $data .= "--IDW0562028BN9JGPFON6OYOMZ4MP\n";
        $data .= "Content-Type: image/jpeg\n\n";
        $data .= $imgData . "\n";
        $data .= "--IDW0562028BN9JGPFON6OYOMZ4MP--";

        $header = array(
            'GData-Version:  2',
            'Authorization:  GoogleLogin auth="'. session('upload_session') .'"',
            'Content-Type: multipart/related; boundary=IDW0562028BN9JGPFON6OYOMZ4MP;',
            'Content-Length: ' . strlen($data), 'MIME-version: 1.0'
        );
 
        // Upload
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $albumUrl); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt($ch, CURLOPT_POST, true); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
        curl_setopt($ch, CURLOPT_HEADER, true); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, config('manager.uploads.user_agent') );    
 
        $ret = curl_exec($ch);
        curl_close($ch);
         
        // Xử lý kết quả trả về để lấy đường dẫn
        preg_match('#<gphoto:width>(\d+)</gphoto:width>#', $ret, $match);
        $width = $match[1];
        preg_match('#<gphoto:height>(\d+)</gphoto:height>#', $ret, $match);
        $height = $match[1];
        preg_match('#src=\'([^\'"]+)\'#', $ret, $match);
        $url = $match[1];
     
        $size = max($width, $height);
        $url = str_replace(basename($url), 's' . $size . '/' . basename($url), $url);
         
        return $url;
    }
}
