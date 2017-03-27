<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\QuestionAnswer;

use Illuminate\Http\Request;

class FrontendController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$main_data = [];
		return view('frontend.index', ['main_data' => $main_data]);
	}

	public function trogiup()
	{
		$qAndA = QuestionAnswer::getListQA();
		$data = [
			'qAndA' => $qAndA,
		];
		return view('frontend.trogiup', $data);
	}

	public function dangkydilam()
	{
		$data = [
		];
		return view('frontend.dangkydilam', $data);
	}

}
