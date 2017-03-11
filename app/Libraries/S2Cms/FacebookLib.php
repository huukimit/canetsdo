<?php

namespace App\Libraries\S2Cms;

class FacebookLib {

	static function getUser(){
		$facebook = self::connect();
		$user = $facebook->getUser();
		if ($user) {
			try {
				$user_profile = $facebook->api('/me');
				dd($user_profile);
			} catch (\FacebookApiException $e) {
				error_log($e);
				$user = null;
			}
		}
	}

	static function sendComment($token = '' , $id = ''){
		$facebook = self::connect();
		$facebook->setAccessToken($token);


		$taz = array("Awesome dude :* ",
		"nice pic :) ",
		"love you <3 ",
		"great bro!! ",
		"no words!!",
		"hehe good :)",
		":O fuckin awesome ",
		";) perfect",
		"END 3:)",
		"please accept!! ",
		"love u :)",
		"awesome <3 ",
		" ^_^ ",
		"hehe :P",
		"A-CLASS :D",
		"Bitch!! ",
		":( Inbox Plz",
		"You are Great :D",
		"Please Help me :( ",
		"awesome :3",
		"best :)",
		"<3 <3",
		"good good ",
		"cutest ever :* ",
		"no reply???",
		"Rockstar :D",
		"ENDDDD",
		"good one :)",
		"nice pic dude",
		"we support you <3 ",
		" :D ",
		"smart :3 :) ",
		"oops!! you are awesome :D ",
		"lots of likes",
		"real beauty :3 ",
		"you are great man..",
		"plxxxxxx accept my request :( ",
		"fuckin awesome bro :O ");
		$sinta = $taz[array_rand($taz)];

		$facebook->api("/".$id."/comments",'post',array('message' => $sinta));


	}

	static function connect(){
		require base_path('third_party/facebook-sdk/facebook.php');
		return new \Facebook([
			'appId'  => config('services.facebook.client_id') ,
			'secret' => config('services.facebook.client_secret'),
		]);
	}
    


}
