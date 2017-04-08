<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\QuestionAnswer;
use App\Customer;

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

	public function confirmemail($token) {
		$explode = explode('-', $token);
		if ($explode[0]) {
			$a = Customer::SaveData(['id' => $explode[0], 'status' => 1]);
		}
		return view('frontend.confirm_success');
	}

}
