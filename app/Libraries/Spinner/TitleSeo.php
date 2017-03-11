<?php

namespace App\Libraries\Spinner;

class TitleSeo {

	protected $title_one_seo = '';
	protected $title_two_seo = '';

	function __construct(){
		$this->title_one_seo = base_path('phamcuongt2/title/title_one.txt');
		$this->title_two_seo = base_path('phamcuongt2/title/title_two.txt');
	}



}