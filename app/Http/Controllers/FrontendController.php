<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\QuestionAnswer;
use App\Customer;
use Input;

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
		$token = base64_decode($token);
		$explode = explode('-', $token);
		if ($explode[0]) {
			$a = Customer::SaveData(['id' => $explode[0], 'status' => 1]);
		}
		return view('frontend.confirm_success');
	}

	public function changepassword() {
		$get = Input::all();
		$message = '';
		if (Input::method() == 'POST') {
			$post = Input::all();
			$check = Customer::where('forgot_password', $post['token'])->where('email', $post['email'])->first();
			if (isset($check->id)) {
				$update = [
					'id' => $check->id,
					'password' => sha1($post['password']),
					'forgot_password' => '',
				];
				Customer::SaveData($update);
				$message = 'Thay đổi password thành công!';
			} else {
				echo '<h3 align="center" style="color:red">Có lỗi sảy ra, vui lòng liên hệ admin</h3>';die;
			}

		}
		return view('frontend.changepassword', ['data' => $get, 'message' => $message]);
	}

	

}
