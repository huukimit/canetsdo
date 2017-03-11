<?php

namespace App\Libraries\Uploads;

class Picasa{

	protected $cookie;
	protected $loggedin = FALSE;
	protected $username;
	protected $password;
	protected $accountID;
	protected $session_timeout = 'picase_login_timeout';
	protected $session_gooogle;
	protected $albumId = 'default';

	protected $user_agent = 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:37.0) Gecko/20100101 Firefox/37.0';
	protected $cookie_file = 'cookie.txt';

	function __construct($username = '', $password = '' , $accountID = '' , $albumId = ''){
		$this->accountID = $accountID;
		$this->username = $username;
		$this->password = $password;
		$this->albumId = $albumId;
		$this->session_gooogle = 'upload_picasa_by_'.$this->username;
		$this->cookie = session($this->session_gooogle);
	}

	
	public function login(){
		if( ! session($this->session_gooogle) || session($this->session_timeout) + 60*5 < time()){
			$data = array(
			    'accountType'   => 'GOOGLE', 
			    'Email'         => $this->username,  // Email của bạn
			    'Passwd'        => $this->password,             // Mật khẩu của bạn
			    'source'        => __FILE__, 
			    'service'       =>'lh2'
			);
		 
		    $ch = curl_init(); 
		    curl_setopt($ch, CURLOPT_URL, "https://www.google.com/accounts/ClientLogin"); 
		    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
		    curl_setopt($ch, CURLOPT_POST, true); 
		    curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent );
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
		    $content = curl_exec($ch); 
		    var_dump($content);
		    
		    if (preg_match('#Auth=([a-z0-9_\-]+)#i', $content, $matches)){
		    	session([$this->session_gooogle => $matches[1] , $this->session_timeout => time() ]);
		    }			
		}
		$this->cookie = session($this->session_gooogle);
		return $this->cookie != '';
	}
	
	function upload($path_file , $title = 'upload by PhamCuongT2'){
		if(!$this->cookie) $this->login();
		var_dump($this->cookie);
	    if (!$this->cookie) return '';
 
	    // Đường dẫn tới Album cần đăng
    	$albumUrl = "https://picasaweb.google.com/data/feed/api/user/".$this->accountID."/albumid/".$this->albumId;
 	    // XML Upload được cung cấp bởi google
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
		    curl_setopt($ch_upload, CURLOPT_USERAGENT, $this->user_agent );    
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
	        'Authorization:  GoogleLogin auth="'.$this->cookie.'"',
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
	    curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent );    
 
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
