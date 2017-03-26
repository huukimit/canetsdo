<?php
namespace App\Controllers\Service;
require_once(app_path().'/Libraries/Napthe/VMS_Soap_Client.php');

use App\Http\Controllers\ServiceController;
use Input, Config;
use App\Customer;
use App\Device;
use App\Service;
use App\Models\Media\Media;
use App\Models\Notify\Notify;
use App\CustomerDevice;
use App\Khuyenmai;
use App\Booking;
use App\Setting;
use App\CustomerRate;
use App\Bid;
use App\Feedback;
use App\Lichsugiaodich;
use App\Requires;
use App\Notify_missed_booking;
use App\Thongbao;
use DB, URL;
use Mail;
use Illuminate\Support\Facades\Log;
use VMS_Soap_Client;
use App\Commands\PushNotifyToDevices;
use Illuminate\Support\Facades\Queue;

class MobileController extends ServiceController {

	public function __construct() {
		parent::__construct();
		// Log::info(json_encode(Input::all()));
		// if (!empty($_FILES)) {
		//     Log::info(json_encode($_FILES));
		// }
	}

	function testios(){
		$this->checkNullData(Input::get('device_token', null));
		$res = Notify::Push2Ios(Input::get('device_token'), "Test push notify" , ['Khai','Thanh*2']);
		if ($res['success'] == 1) {
			$this->status = 200;
			$this->message = 'Push to IOS success!';
		}
	}

	public function getContract(){
		$this->checkNullData(Input::get('email', null));
		$this->checkNullData(Input::get('customer_id', null));
		$postData = Input::all();
		$check = Customer::getById(Input::get('customer_id'));
		if ($check /*&& $check->email == Input::get('email')*/) {
			// Send mail
			$this->sendContract('Contract' , 'emails.contract', $postData);
			$this->status = 200;
			$this->message = 'We sent a contract to your email';
		} else {
			$this->status = 401;
			$this->message = 'Not found user by customer_id and email, please check again';
		}

	}

	public function feedBack(){
		$this->checkNullData(Input::get('customer_id', null));
		$this->checkNullData(Input::get('feedback', null));
		$check = Customer::getById(Input::get('customer_id'));
		if ($check) {
			Feedback::SaveData(Input::all());
			$this->status = 200;
			$this->message = 'Thank for your feedback';
		} else {
			$this->status = 401;
			$this->message = 'Not found user by customer_id and email, please check again';
		}

	}

	public function getNotify() {
		$customerId = Input::get('customer_id', null);
		$this->checkNullData($customerId);
		$notifies = Thongbao::getnewsbyCustomerId($customerId);
		$this->data = $notifies;
		$this->status = 200;
		$this->message = 'Success';
	}

	public function readNotify() {
		$notifyId = Input::get('notify_id', null);
		$notify = Thongbao::getById($notifyId);
		if ($notify) {
			Thongbao::SaveData(['id' => $notifyId, 'is_read' => 1]);
			$this->status = 200;
			$this->message = 'Success';
		} else {
			$this->status = 401;
			$this->message = 'Update status success';
		}
	}


	public function deleteNotify() {
		$notifyId = Input::get('notify_id', null);
		$this->checkNullData($notifyId);
		$notify = Thongbao::find($notifyId);
		if ($notify) {
			$notify->delete();
			$this->status = 200;
			$this->message = 'Success';
		} else {
			$this->status = 401;
			$this->message = 'Can not found notify by notify_id';
		}
	}

	public function napthe() {
		$postData = Input::all();
		$this->checkNullDataInArray($postData);
		$postData['pin'] = base64_decode($postData['pin']);
		$config = Setting::getConfig();
		$postData['pin'] = rtrim($postData['pin'], $config->suffix);
		$postData['pin'] = ltrim($postData['pin'], $config->prefix);
		$status='';
		if(isset($postData['customer_id'])) {
			$customer = Customer::getById($postData['customer_id']);
			if (empty($customer)) {
				$this->status = 401;
				$this->message = 'User not exist';
				die();
			} elseif ($customer->number_transfail >= $config->max_transfail) {
				$this->status = 101;
				$this->message = 'Ban da nhap sai qua so lan cho phep la ' . $config->max_transfail;
			}
			$TxtCard = intval($postData['card_type_id']);
			$TxtMaThe = addslashes($postData['pin']);
			$TxtSeri= addslashes($postData['seri']);
			switch ($TxtCard) {
				case 1:
					$TxtType = 'VTT';
					break;
				case 2:
					$TxtType = 'VMS';
					break;
				case 3:
					$TxtType = 'VNP';
					break;
				case 4:
					$TxtType = 'FPT';
					break;
				case 5:
					$TxtType = 'VTC';
					break;
			}

			$username = "canets2016";
			$password = "canets2016@12354";
			$partnerId = 154;
			$mpin="canet.vn.mpin";
			$TxtTransID = $username. rand() . rand();
			$Client = new VMS_Soap_Client('http://telco.paycard999.com:8080/webservice/TelcoAPI?wsdl', $username, $password, $partnerId, $mpin);
			//$target ten member nap card cua doi tac
			$target = $username.'_'. rand() . rand();
			//$email cua member cua doi tac
			$email = "canets2016@gmail.com";
			//phone
			$phone = '01673713098';
			// serial:mathe:nhamangLog request transId: 201603160700_MB50_50 - telco: VMS - Amount: 50000 - quantity: 10- source: IOM- pass: AB5B0COY53AZ3AP
			$dataCard = $TxtSeri.':'.$TxtMaThe.'::'.$TxtType;
			$return = $Client->doCardCharge($target, $dataCard, $email, $phone);
			$status_paycard = intval($return['status']);
			if ($status_paycard == 1) {
				$transaction = [
					'customer_id' => $postData['customer_id'],
					'transid' => $return['transid'],
					'amount_moneys' => $return['DRemainAmount'],
					'reason' => $TxtType,
					'masothecao' => $TxtMaThe,
					'seri' => $TxtSeri,
				];

				$updateCustomer = [
					'id' =>$postData['customer_id'],
					'vi_taikhoan' => ($customer->vi_taikhoan + $return['DRemainAmount']),
					'number_transfail' => 0
				];

				Customer::SaveData($updateCustomer);
				Lichsugiaodich::SaveData($transaction);
				$this->data = ['amount' => (int) $return['DRemainAmount']];
			} else {

				$updateCustomer = ['id' => $postData['customer_id'], 'number_transfail' => ($customer->number_transfail + 1)];
				Customer::SaveData($updateCustomer);
			}
			$this->status = $status_paycard;
			$this->message = $return['message'];

		}else{
			$this->status = '404';
			$this->message = 'Errors';

		}
	}

	public function getDetailBooking() {
		$this->checkNullData(Input::get('booking_id', null));
		$this->status = 200;
		$this->message = 'success';
		$this->data = Booking::getById(Input::get('booking_id'));
	}

	public function thongbaoSvhuy() {
		$post = Input::all();
		$this->checkNullData($post['booking_id']);
		$this->checkNullData($post['laodong_id']);
		$bid = Bid::getBidByBookAndLaodongId($post['booking_id'], $post['laodong_id']);
		if (!empty($bid)) {
			Booking::SaveData(['id' => $post['booking_id'], 'status' => -1]);
			Bid::SaveData(['id' => $bid->id, 'is_sv_canceled' => 1]);
			$this->status = 200;
			$this->message = 'success';
		} else {
			$this->status = 401;
			$this->message = 'Fail';
		}
	}

	function svCancel() {
		$bidId = Input::get('bid_id', null);
		$this->checkNullData($bidId);
		$bidData = Bid::getById($bidId);
		if ($bidData->status == 0) {
			$bid = Bid::find($bidId);
			$bid->delete();
		} else {
			Bid::SaveData(['id' => $bidId, 'is_sv_canceled' => 1]);
		}
		$this->status = 200;
		$this->message = 'success';
	}

	function getDetailHistoryJob() {
		$bookingId = Input::get('booking_id', null);
		$this->checkNullData($bookingId);
		$booking = Booking::getById($bookingId);
		$customer = Customer::getById($booking->customer_id);

		$saleoff = 0;
		if ($booking->khuyenmai_id != 0) {
			$km = Khuyenmai::getById($booking->khuyenmai_id);
			$saleoff = $km->phantram;
		}
		$bidDone = Bid::getLaborDoneJob($bookingId);
		$labor = array();

		if (!empty($bidDone)) {
			$labor = Customer::getById($bidDone->laodong_id);
		}

		if ($booking->type == 1) {
			$response = [
				"address" => $booking->address,
				"manv_kh" => $customer->manv_kh,
				"time_start" => $booking->time_start,
				"time_end" => $booking->time_end,
				"luong" => $booking->luong,
				"thuong" => $booking->thuong,
				"tongchiphi" => $booking->tongchiphi,
				"khuyenmai" => "{$saleoff}%",
			];
			if (!empty($labor)) {
				$response['info_laodong'] = array(
					"id" => $labor->id,
					"manv_kh" => $labor->manv_kh,
					"phone_number" => $labor->phone_number,
					"fullname" => $labor->fullname,
					"birthday" => $labor->birthday,
					"quequan" => $labor->quequan,
					"school" => $labor->school,
					"month_exp" => $labor->month_exp,
					'avatar' =>  ($labor->avatar != '') ? URL::to('/') . '/' . $labor->avatar : '',
				);
			} else {
				$response['info_laodong'] = [];
			}

		} else {

			$response = [
				"address" => $booking->address,
				"manv_kh" => $customer->manv_kh,
				"time_start" => $booking->time_start,
				"time_end" => $booking->time_end,
				"luong" => $booking->luong,
				"thuong" => $booking->thuong,
				"tongchiphi" => $booking->tongchiphi,
				"khuyenmai" => "{$saleoff}%",
				"viecphailam" => $booking->viecphailam,
				"has_chungcu" => $booking->has_chungcu,
				"has_phuongtien" => $booking->has_phuongtien,
				"has_ancunggd" => $booking->has_ancunggd,
				"ngaylamtrongtuan" => $booking->ngaylamtrongtuan,
				"thoigianlam" => $booking->thoigianlam,
				"thoigian_cothelam" => $booking->thoigian_cothelam,
			];
			if (!empty($labor)) {
				$response['info_laodong'] = array(
					"manv_kh" => $labor->manv_kh,
					"fullname" => $labor->fullname,
					"phone_number" => $labor->phone_number,
					"birthday" => $labor->birthday,
					"quequan" => $labor->quequan,
					"school" => $labor->school,
					"cando" => $labor->cando,
					"month_exp" => $labor->month_exp,
					"thoigian_cothelam" => $bidDone->thoigian_cothelam,
					'avatar' =>  ($labor->avatar != '') ? URL::to('/') . '/' . $labor->avatar : '',
				);
			} else {
				$response['info_laodong'] = [];
			}

		}
		$this->data = $response;
		$this->status = 200;
		$this->message = 'success';
	}
	public function login()
	{
	   $postData = Input::all();
	   $this->checkNullDataInArray($postData);
	   $existUser = Customer::DoLogin($postData);
	   if ($existUser) {
		   $checkDevice = Device::checkTokenDevice($postData);
		   if (empty($checkDevice)) {
				$deviceId = Device::SaveData($postData);
				CustomerDevice::SaveData(['customer_id' => $existUser->id, 'device_id' => $deviceId]);
		   }
		   $existUser->avatar = ($existUser->avatar != '') ? URL::to('/') . '/' . $existUser->avatar : '';
		   $this->status = 200;
		   $this->message = Config::get('services.notify.login_successfull');
		   $this->data = [$existUser];
	   } else {
		   $hasRegister = Customer::hasRegister($postData);
		   if (!empty($hasRegister)) {
				$this->status = 400;
				$this->message = Config::get('services.notify.user_not_active');
		   } else {
				$this->status = 300;
				$this->message = Config::get('services.notify.login_fail');
		   }
		}
	}

	public function registerCustomer() {
		$postData = Input::all();
		$this->checkNullDataInArray($postData);
		$postData['type_customer'] = 2;
		$postData['password'] = sha1($postData['password']);
		$exists = Customer::checkExistByEmailPhonenumber($postData);
		if (!empty($exists)) {
			$this->status = 402;
			$this->message = Config::get('services.notify.user_exist');exit;
		}
		$postData['manv_kh'] = 'KH ' . time();
		$status = DB::transaction(function () use($postData) {
			$id = Customer::SaveData($postData);
			$deviceId = Device::SaveData($postData);
			$postData['customer_id'] = $id;
			$postData['device_id'] = $deviceId;
			CustomerDevice::SaveData($postData);
		});
		if (is_null($status)) {
			$this->status = 200;
			$this->sendMail('Active account' , 'emails.active', $postData);
			$this->message =  Config::get('services.notify.register_successfull');
		} else {
			$this->status = 404;
			$this->message =  Config::get('services.notify.register_fail');
		}
	}

	//fullname,quequan,birthday,school,has_experience,year_exp,cando,avatar,anhsv_truoc,anhsv_sau,anhcmtnd_truoc,anhcmtnd_sau,email,phone_number,password,device_token,type_device,lat,long

	// Dang ky tai khoan nguoi lao dong
	public function upAnh() {
		$data = [];
		if (isset($_FILES['avatar'])) {
			$_FILES['file'] = $_FILES ['avatar'];
			$upImage = Media::uploadImage($_FILES, 'avatar');
			$linkImg = $upImage['url'];
			$data['avatar'] = $linkImg;

		}
		if (isset($_FILES['anhsv_truoc'])) {
			$_FILES['file'] = $_FILES ['anhsv_truoc'];
			$upImage = Media::uploadImage($_FILES, 'anhsv');
			$linkImg = $upImage['url'];
			$data['anhsv_truoc'] = $linkImg;
		}
		$this->status = 200;
		$this->data = $data;
		$this->message = Config::get('services.notify.register_successfull');
	}

	public function dangkytaikhoanlaodong() {
		Log::info(json_encode($_FILES));
		$data = Input::all();
		Log::info($data);
		$this->checkNullDataInArray($data);
		$data['type_customer'] = 1;
		$data['password'] = sha1($data['password']);
		$exists = Customer::checkExistByEmailPhonenumber($data);
		if (!empty($exists)) {
			$this->status = 402;
			$this->message = Config::get('services.notify.user_exist');exit;
		}
		$data['manv_kh'] = 'NV ' . time();
		if (isset($data['cando'])) {
			$data['cando'] = json_encode(explode(',', $data['cando']));
		}
		if (isset($_FILES['avatar'])) {
			$_FILES['file'] = $_FILES ['avatar'];
			$upImage = Media::uploadImage($_FILES, 'avatar');
			$data['avatar'] = $upImage['url'];
		}
		if (isset($_FILES['anhsv_truoc'])) {
			$_FILES['file'] = $_FILES ['anhsv_truoc'];
			$upImage = Media::uploadImage($_FILES, 'anhsv');
			$data['anhsv_truoc'] = $upImage['url'];
		}
		if (isset($_FILES['anhsv_sau'])) {
			$_FILES['file'] = $_FILES ['anhsv_sau'];
			$upImage = Media::uploadImage($_FILES, 'anhsv');
			$data['anhsv_sau'] = $upImage['url'];
		}
		if (isset($_FILES['anhcmtnd_truoc'])) {
			$_FILES['file'] = $_FILES ['anhcmtnd_truoc'];
			$upImage = Media::uploadImage($_FILES, 'cmtnd');
			$data['anhcmtnd_truoc'] = $upImage['url'];
		}
		if (isset($_FILES['anhcmtnd_sau'])) {
			$_FILES['file'] = $_FILES ['anhcmtnd_sau'];
			$upImage = Media::uploadImage($_FILES, 'cmtnd');
			$data['anhcmtnd_sau'] = $upImage['url'];
		}
		$status = DB::transaction(function () use($data) {
			if (isset($data['birthday'])) {
				$data['birthday'] = date('Y-m-d', strtotime($data['birthday']));
			}
			$id = Customer::SaveData($data);
			$deviceId = Device::SaveData($data);
			$data['customer_id'] = $id;
			$data['device_id'] = $deviceId;
			CustomerDevice::SaveData($data);
		});
		if (is_null($status)) {
			$this->status = 200;
			//$this->sendMail('Active account' , 'emails.active', $data);
			$this->message =  Config::get('services.notify.register_successfull');
		} else {
			$this->status = 404;
			$this->message =  Config::get('services.notify.register_fail');
		}

	}

	function forgotpassword(){
		$email = Input::get('email');
		$this->checkNullData($email);
		$customer = Customer::getCustomerByEmail($email);
		if (!empty($customer)) {
			if ($customer->status == 0){
				$this->status = 400;
				$this->message = Config::get('services.notify.user_not_active');
				die;
			}
			$update = ['id' => $customer->id, 'forgot_password' => $this->randomString()];
			Customer::SaveData($update);
			$dataSend = [
				'fullname' => $customer->fullname,
				'link' => URL::to('/') . '/changepassword?token=' . $update['forgot_password'],
				'email' => $customer->email,
			];
			$this->sendMail('Quen mat khau', 'emails.reset_password', $dataSend);
			$this->status = 200;
			$this->message = 'Please check mail to reset password';
		} else {
			$this->status = 402;
			$this->message = Config::get('services.notify.user_exist');exit;
		}
	}

	function changePassword() {
		$postData = Input::all();
		$this->checkNullDataInArray($postData);
		$customer = Customer::checkCustomerByUserIdAndPassword($postData);
		if (empty($customer)) {
			$this->status = 300;
			$this->message = 'Password not match in database';
		} else {
			Customer::SaveData(['id' => $postData['customer_id'], 'password' => sha1($postData['new_password'])]);
			$this->status = 200;
			$this->message = 'Update password is success';
		}

	}

	function sendmailactive() {
		$email = Input::get('email');
		$this->checkNullData($email);
		$customer = Customer::getCustomerByEmail($email);
		if (!empty($customer)) {
			if ($customer->status == 1) {
				$this->status = 100;
				$this->message = 'Account already actived';
				die;
			}
			if ($customer->status == -1) {
				$this->status = 101;
				$this->message = 'Account blocked, please contact to admin';
				die;
			}
			if ($customer->status == 0) {
				$update = ['id' => $customer->id, 'forgot_password' => $this->randomString()];
				Customer::SaveData($update);
				$dataSend = [
					'fullname' => $customer->fullname,
					'link' => URL::to('/') . '/changepassword?email=' . $email . '&active=' . $update['forgot_password'],
					'email' => $customer->email,
				];
				$this->sendMail('Quen mat khau', 'emails.active_account', $dataSend);
				$this->status = 200;
				$this->message = 'Please check mail to active account';
			}
		} else {
			$this->status = 402;
			$this->message = Config::get('services.notify.user_exist');exit;
		}
	}

	function checkmakhuyenmai() {
		$this->checkNullData(Input::get('makhuyenmai'));
		$this->checkNullData(Input::get('customer_id'));
		$exist = Khuyenmai::checkKhuyenMai(Input::get('makhuyenmai'), Input::get('customer_id'));
		if ($exist) {
			$this->status = 200;
			$this->data = [$exist];
			$this->message = 'Success';
		} else {
			$this->status = 300;
			$this->message = 'Mã khuyến mại không tồn tại';
		}

	}

	function giupviecmotlan()
	{
		$postData = Input::all();
		$this->checkNullDataInArray($postData);
		if (isset($postData['makhuyenmai'])) {
			$postData['khuyenmai_id'] = Khuyenmai::usedKhuyenmai($postData['makhuyenmai'], $postData['customer_id']);
		}

		$postData['type'] = 1;
		$booking_id = Booking::SaveData($postData);
		$this->data = ['booking_id' => $booking_id];
		$this->status = 200;
		$this->message = "Success";
		$this->notifyToLaborer($postData['lat'], $postData['long'], $booking_id, 1000, 'GV 1 lần: ' . $postData['address']);

	}

	function giupviecthuongxuyen() {
		Log::info(json_encode(Input::all()));
		if (!empty($_FILES)) {
			Log::info(json_encode($_FILES));
		}
		$data = Input::all();
		$this->checkNullDataInArray($data);
		if (isset($postData['makhuyenmai'])) {
			$status = Khuyenmai::usedKhuyenmai($postData['makhuyenmai'], $postData['customer_id']);
			// if (!$status) {
			//     $this->status = 300;
			//     $this->message = "Mã khuyến mại chưa tồn tại hoặc đã được sử dụng";
			//     die;
			// }
		}
		if (isset($_FILES['anh1'])) {
			$_FILES['file'] = $_FILES ['anh1'];
			$upImage = Media::uploadImage($_FILES, 'anhcanho');
			$data['anh1'] = $upImage['url'];
		}
		if (isset($_FILES['anh2'])) {
			$_FILES['file'] = $_FILES ['anh2'];
			$upImage = Media::uploadImage($_FILES, 'anhcanho');
			$data['anh2'] = $upImage['url'];
		}
		if (isset($_FILES['anh3'])) {
			$_FILES['file'] = $_FILES ['anh3'];
			$upImage = Media::uploadImage($_FILES, 'anhcanho');
			$data['anh3'] = $upImage['url'];
		}

		$data['type'] = 2;
		$booking_id = Booking::SaveData($data);
		$this->status = 200;
		$this->data = ['booking_id' => $booking_id];
		$this->message = "Success";
		$this->notifyToLaborer($data['lat'], $data['long'], $booking_id, 1000, 'GV thường xuyên: ' . $data['address']);
	}

	function notifyToLaborer($lat, $long, $booking_id, $distance, $loaidichvu = 'test') {
		Log::info([$lat, $long, $booking_id, $distance, $loaidichvu]);
		$customers = Customer::getLaborsArround($lat, $long, $distance);
		$missed = [];
		$push_data = Booking::getById($booking_id);

		if ($push_data) {
		   $push_data = json_decode(json_encode($push_data), true);
		   $infoCustomer = Customer::getFullInfoCustomerById($push_data['customer_id']);
		   $push_data['customer_info'] = $infoCustomer;
		}

		$dataPushed = json_encode($push_data);
		Queue::later(5, new PushNotifyToDevices($customers, $loaidichvu, $dataPushed, $booking_id));

	}

	function updateLatLong() {
		$postData = Input::all();
		$this->checkNullDataInArray($postData);
		$customer = Customer::checkCustomerById($postData['customer_id'], $postData['type_customer']);
		if(empty($customer)) {
			$this->status = 401;
			$this->message = 'Customer not exist';
			die;
		}
		$update = [
			'id' => $postData['customer_id'],
			'lat' => $postData['lat'],
			'long' => $postData['long'],
		];
		Customer::SaveData($update);
		$this->status = 200;
		$this->message = "Success";
	}

	function allservices () {
		$service = [];
		$services = Service::getServices();
		$this->status = 200;
		$this->message = "Success";
		foreach($services as $value) {
			$service[] = ['id' => $value->id, 'name' =>$value->name, 'icon' => URL::to('/') . '/' . $value->icon];
		}
		$this->data =  $service;
	}

	function systemsetting() {
		$this->status = 200;
		$this->message = "Success";
		$config = Setting::getConfig();
		$result = [
			'thoigiancholienlac' => json_decode($config->thoigiancholienlac, true),
			'solanhuytoida' => json_decode($config->solanhuytoida, true),
			'policy_worker' => $config->policy_worker,
			'policy_customer' => $config->policy_customer,
			'phone_admin' => $config->phone_admin,
			'yeucau' => Requires::getRequires(),
			'thuonggvmotlan' => json_decode($config->thuonggvmotlan, true),
			'thuonggvthuongxuyen' => json_decode($config->thuonggvthuongxuyen, true),
			'luonggiupviec1lan' => json_decode($config->luonggiupviec1lan, true),
			'luonggiupviecthuongxuyen' => json_decode($config->luonggiupviecthuongxuyen, true),
			'luong1h_thuongxuyen' => json_decode($config->luong1h_thuongxuyen, true),
			'thongtinchuyenkhoan' => json_decode($config->thongtinchuyenkhoan, true),
		];
		$this->data = [$result];
	}

	function sendMail($subject, $template, $data) {
		$status = Mail::send($template, $data, function($message) use ($subject, $data) {
			$message->to($data['email'], 'CANETS')->subject($subject);
		});
	}

	private function sendContract($subject, $template, $data){
		$status = Mail::send($template, $data, function($message) use ($subject, $data) {
			$message->to($data['email'], 'CANETS')->subject($subject);
			$message->attach(public_path() . '/files/samplecontract.pdf');
		});
	}

	function historybooking() {
		$customerId = Input::get('customer_id', null);
		$this->checkNullData($customerId);
		$bookings = Booking::getHistoryBookingByCustomerId($customerId);
		foreach ($bookings as $key => $booking) {
			if ($booking->is_sv_canceled == null) {
				$bookings[$key]['is_sv_canceled'] = 0;
			}
		}
		$this->status = 200;
		$this->message = "Success";
		$this->data = $bookings;
	}

	function screentopcustomer() {
		$customerId = Input::get('customer_id', null);
		$lat = Input::get('lat', null);
		$long = Input::get('long', null);
		$this->checkNullData($customerId);
		$this->checkNullData($lat);
		$this->checkNullData($long);
		$bookings = Booking::getBookingByCustomerId($customerId);
		$result = [];
		foreach($bookings as $booking) {
			$result[] = [
				'booking_id' => $booking->id,
				'address' => $booking->address,
				'type' => $booking->type,
				'status' => $booking->status,
		'chonnguoi' => $booking->chonnguoi,
				'created_at' => date('Y-m-d H:i:s',strtotime($booking->created_at)),
				'updated_at' => date('Y-m-d H:i:s',strtotime($booking->updated_at)),
				'number_bid' => Bid::countBidBuBookingId($booking->id),
				'note_status' => '-2 het han, -1 cancel, 0. khoi tao, 1 Da co lao dong nhan viec, 2 Done, 3 Da chon lao dong',
			];
		}
		// if (empty($result)) {
			// if ($lat != null && $long != null) {
				// $this->status = 200;
		$near5Km = Customer::getSinhvienNearly($lat, $long, 5);
		$numberNear = (int) count($near5Km);
				// $this->data = ['svxungquanh' => $near5Km, 'numbersvien5km' => $numberNear, 'bookings' => []];
				// $this->message = "Hiện có $numberNear sinh viên nào xung quanh bạn";
				// die;
			// } else {
				// $this->status = 300;
				// $this->message = "Vui long truyen them lat long de xac dinh so sinh vien xung quanh";
				// die;
			// }
		// }
		$this->status = 200;
		$this->message = "Success";
		$this->data = [
				'svxungquanh' => $near5Km,
				'numbersvien5km' => $numberNear,
				'bookings' => $result
		];
	}

	function sinhvienganday() {
		$lat = Input::get('lat', null);
		$long = Input::get('long', null);
		$this->status = 200;
		$this->message = "Success";
		$this->data = Customer::getSinhvienNearly($lat, $long, 5);
	}

	function screentopnguoilaodong() {
		$customerId = Input::get('laodong_id');
		$this->checkNullData($customerId);
		$customer = Customer::checkCustomerById(Input::get('laodong_id'));
		$customer = json_decode(json_encode($customer), true);
		$rates = CustomerRate::getNumAvg(Input::get('laodong_id'));
		if (!empty($rates)) {
			$rates = $rates[0];
		}

		if (!empty($customer)) {
			$customer['number_rated'] = (int)$rates->number_rate;
			$customer['stars'] = (int)$rates->stars;
			$customer['congvieccothelam'] = ($customer['cando'] != '') ? explode(',', $customer['cando']) : [];
			$customer['thoigian_cothelam'] = (!empty($bid)) ? $bid->thoigian_cothelam : 0;
			$customer['avatar'] = ($customer['avatar'] != '') ? URL::to('/') . '/' . $customer['avatar'] : '';
			$customer['cv1lan_da_nhan'] = Booking::getNumberNhanByTypeAndStatus($customer['id'], 1, [0,1]);
			$customer['cv1lan_duoc_nhan'] = Booking::getNumberNhanByTypeAndStatus($customer['id'], 1, [1]);
			$customer['cvthuongxuyen_da_nhan'] = Booking::getNumberNhanByTypeAndStatus($customer['id'], 2, [0,1]);
			$customer['cvthuongxuyen_duoc_nhan'] = Booking::getNumberNhanByTypeAndStatus($customer['id'], 2, [1]);
			$dangnhan = Bid::congviecdangnhan($customerId);
			$customer['dangnhan'] = $dangnhan;
		}
		$this->status = 200;
		$this->message = "Success";
		$this->data = $customer;
	}

	function getJobsByLaodongId() { // use in top screen
		$customerId = Input::get('laodong_id', null);
		$this->checkNullData($customerId);
		$result['list_gvmotlan'] = Booking::getJobsWaitingReceivedFromNotify(1, $customerId); 
		$result['list_gvthuongxuyen'] = Booking::getJobsWaitingReceivedFromNotify(2, $customerId); 
		$this->status = 200;
		$this->message = "Success";
		$this->data = $result;
	}

	function getdetailjob() {
		$this->checkNullData(Input::get('booking_id'));
		$booking = json_decode(json_encode(Booking::getById(Input::get('booking_id'))), true);
		// $list_bided = Bid::getAllLdByBookingId(Input::get('booking_id'));
		// foreach ($list_bided as $value) {
		// 	if ($value->avatar != '') {
		// 		$value->avatar = URL::to('/') . '/' . $value->avatar;
		// 	}
		// }
		// $booking['list_user_bided'] = $list_bided;
		$this->status = 200;
		$this->message = "Success";
		$this->data = $booking;
	}


	function cancelbooking() {
		$postData = Input::all();
		$this->checkNullDataInArray($postData);
		$allow = Customer::allowCancel($postData['customer_id']);
		if (!$allow) {
			$this->status = 101;
			$this->message = 'Khach hang da huy qua so lan cho phep';
			die;
		}
		if ($allow) {
			$exist = Booking::checkBookingToCancel($postData);
			if (empty($exist)) {
				$this->status = 402;
				$this->message = 'This work not in status to cancel';
			} else {
				Booking::SaveData(['id' => $postData['booking_id'], 'status' => -1]);
				$this->status = 200;
				$this->message = 'Success';
			}
		}
	}

	function getbookingfinding(){
		$finding = Booking::getBookingFinding();
		$this->data = $finding;
		$this->status = 200;
		$this->message = 'Success';
	}

	function logout() {
		$this->checkNullData(Input::get('device_token', null));
		$this->checkNullData(Input::get('customer_id', null));
		$device = Device::checkTokenDevice(Input::get('device_token'));
		if ($device) {
		   $exist = CustomerDevice::getCustomerDeviceByCustomerIdDeviceId(Input::get('customer_id'), $device->id);
		   if ($exist) {
				CustomerDevice::deleteBy($exist->id);
				Device::deleteBy($device->id);
		   }
		}
		$this->status = 200;
		$this->message = 'Logout success';
	}



	function nhanviec() {
		$postData = Input::all();
		$this->checkNullData(Input::get('booking_id'));
		$this->checkNullDataInArray($postData);
		$bided = Bid::checkBided($postData);
		if (empty($bided)) {
			if (Booking::isGiupviec1lan($postData)) {
				$postData['status'] = 1;
			} else{
				$checkNhanviec = Booking::useChonnguoi($postData);
				if (empty($checkNhanviec)) {
					$postData['status'] = 1;
				}
			}

			if (Bid::SaveData($postData)) {
				$this->status = 200;
				$this->message = 'Success';
				Booking::SaveData(['id' => $postData['booking_id'], 'status' => 1]);
				$push_data = Customer::getById($postData['laodong_id']);
				$customers = Customer::getFullInfoCustomerByIdToNotify($postData['customer_id']);
				foreach($customers as $customer) {
					if ($customer->type_device == 1) {
						$res = Notify::cloudMessaseAndroid($customer->device_token, $push_data->fullname . ' đã nhận việc, mở để xem chi tiết', $push_data);
						Log::warning($res);
					} else {
						$res = Notify::Push2Ios($customer->device_token, $push_data->fullname . ' đã nhận việc, mở để xem chi tiết', $push_data, 'customer');
						Log::warning($res);
					}
				}
			}
		} else {
			$this->status = 402;
			$this->message = 'Nguoi lao dong da nhan viec nay';
		}
	}


	function getlistbided() {
		$this->checkNullData(Input::get('booking_id', null));
		$bids = Bid::getUsersBided(Input::get('booking_id'));
		foreach($bids as $bid) {
			$bid->avatar = ($bid->avatar != '') ? URL::to('/') . '/' . $bid->avatar : '';
		}
		$this->data = $bids;
		$this->status = 200;
		$this->message = 'Success';
	}

	function nhanlaodong() {
		$this->checkNullData(Input::get('bid_id', null));
		$this->checkNullData(Input::get('booking_id', null));
		$checkExist = Bid::checkBidByBookingAndBid(Input::get('booking_id'), Input::get('bid_id'));
		if (!empty($checkExist)) {
			Bid::SaveData(['id' => Input::get('bid_id'), 'status' => 1]);
			Booking::SaveData(['id' => Input::get('booking_id'), 'status' => 3]);
			$this->status = 200;
			$this->message = 'Success';
			$bid = Bid::getById(Input::get('bid_id'));
			$laodong = Customer::getById($bid->laodong_id);
			$customers = Customer::getFullInfoCustomerByIdToNotify($bid->laodong_id);
			$push_data = [
				'message' => 'Chúng tôi đã khấu trừ % từ tài khoản của bạn',
				'bid_id' => Input::get('bid_id'),
				'message' => Input::get('booking_id'),
			];
			$this->checkTrutien($request['bid_id']);
			foreach($customers as $customer) {
				Notify::cloudMessaseAndroid($customer->device_token, 'Bạn đã được khách hàng lựa chọn để đi làm', []);
				if ($customer->type_device == 1) {
					Notify::cloudMessaseAndroid($customer->device_token, 'Bạn đã được khách hàng lựa chọn để đi làm', $push_data);
				} else {
					Notify::Push2Ios($customer->device_token, 'Bạn đã được khách hàng lựa chọn để đi làm', $push_data);
				}
			}
		} else {
			$this->status = 300;
			$this->message = 'Can not find data by bid and booking_id requested';
		}
	}

	private function checkTrutien($bidId) {

	}

	function rate() {
		$this->checkNullData(Input::get('laodong_id', null));
		$this->checkNullData(Input::get('customer_id', null));
		$this->checkNullData(Input::get('booking_id', null));
		$this->checkNullData(Input::get('stars', null));
		$hasRate = CustomerRate::hasRate(Input::get('booking_id'));
		if ($hasRate) {
			$this->status = 100;
			$this->message = 'Worker rated in this work';
			die;
		}
		if (CustomerRate::SaveData(Input::all())) {
			$this->status = 200;
			$this->message = 'Success';
		}
	}

	function getthongtinlaodong() {
		$this->checkNullData(Input::get('laodong_id', null));
		$this->checkNullData(Input::get('booking_id', null));
		$customer = Customer::checkCustomerById(Input::get('laodong_id'));
		$customer = json_decode(json_encode($customer), true);
		$rates = CustomerRate::getNumAvg(Input::get('laodong_id'));
		if (!empty($rates)) {
			$rates = $rates[0];
		}
		if (!empty($customer)) {
			$bid = Bid::getBidByBookAndLaodongId(Input::get('booking_id'), Input::get('laodong_id'));
			$customer['number_rated'] = (int)$rates->number_rate;
			$customer['list_rated'] = CustomerRate::listRateBy(Input::get('laodong_id'));
			$customer['stars'] = (float)$rates->stars;
			$customer['congvieccothelam'] = ($customer['cando'] != '') ? explode(',', $customer['cando']) : [];
			$customer['thoigian_cothelam'] = (!empty($bid)) ? $bid->thoigian_cothelam : 0;
			$customer['avatar'] = ($customer['avatar'] != '') ? URL::to('/') . '/' . $customer['avatar'] : '';
		}
		$this->data = $customer;
		$this->status = 200;
		$this->message = 'Success';
	}

	function getThongtinBookingAndLaodong() {// su dung trong man hinh confirm da lam xong Khai request
		$this->checkNullData(Input::get('laodong_id', null));
		$this->checkNullData(Input::get('booking_id', null));
		$booking = Booking::getById(Input::get('booking_id'));
		$booking = json_decode(json_encode($booking), true);
		$customer = Customer::checkCustomerById(Input::get('laodong_id'));
		$info_laodong = [];
		if (!empty($booking)) {
			$bid = Bid::getBidByBookAndLaodongId(Input::get('booking_id'), Input::get('laodong_id'));
			if (!empty($customer)) {
				$info_laodong['fullname'] = $customer->fullname;
				$info_laodong['manv_kh'] = $customer->manv_kh;
				$info_laodong['phone_number'] = $customer->phone_number;
			}
			$booking['info_laodong'] = $info_laodong;
		}
		$this->data = $booking;
		$this->status = 200;
		$this->message = 'Success';
	}

	function baoDaLamXong() {
		Log::info(json_encode(Input::all()));
		$this->checkNullData(Input::get('booking_id', null));
		$this->checkNullData(Input::get('laodong_id', null));
		$bid = Bid::getBidByBookAndLaodongId(Input::get('booking_id'), Input::get('laodong_id'));
		if(!empty($bid)) {
			$doneBk = ['id' => Input::get('booking_id'), 'status' => 2];
			Booking::SaveData($doneBk);
			$this->status = 200;
			$this->message = 'Success';
			$customers = Customer::getFullInfoCustomerByIdToNotify($bid->khachhang_id);
			$laodong = Customer::getById(Input::get('laodong_id'));
			foreach($customers as $customer) {
				$data_push = $laodong;
				Notify::cloudMessaseAndroid($customer->device_token, "NV " . (!empty($laodong)) ? $laodong->fullname : Input::get('laodong_id') . " bao da lam xong cong viec cua ban", $data_push);
			}
		} else {
			$this->status = 401;
			$this->message = 'Not match in bids table';
		}

	}

	function khachhangnhanlaodong() {
		Log::info(json_encode(Input::all()));
		$this->checkNullData(Input::get('booking_id', null));
		$this->checkNullData(Input::get('laodong_id', null));
		$bid = Bid::getBidByBookAndLaodongId(Input::get('booking_id'), Input::get('laodong_id'));
		if(!empty($bid)) {
			$doneBk = ['id' => Input::get('booking_id'), 'status' => 2];
			Booking::SaveData($doneBk);
			$this->status = 200;
			$this->message = 'Success';
		} else {
			$this->status = 401;
			$this->message = 'Not match in bids table';
		}

	}

	function onoffservice() {
		$request = $this->checkNullDataInArray(Input::all());
		$update = [
			'id' => 'laodong_id',
			$request['dichvu'] => $request['status']
		];
		if (Customer::SaveData($update)) {
			$this->status = 200;
			$this->message = 'Success';
		}

	}

	function getbookingmissednotify() {
		$customerId = Input::get('customer_id');
		$this->checkNullData($laodongId);
		$misseds = Notify_missed_booking::getMissedNotifyBookings($customerId);
		$this->data = $misseds;
		$this->status = 200;
		$this->message = 'Success';
	}

	function checkParamsRequested() {
		echo '<pre>';
		print_r(Input::all());die;
	}

	// /**
	//  *
	//  * @param type $info
	//  * @return user infomation
	//  */
	private function resultIdolInfo($info) {
		$listMember = Members::getListMemberOfTeamByUserID($info->id);
		$idol = array(
			'id' => $info->id,
			'email' => $info->email,
			'nickname' => $info->nickname,
			'members' => count($listMember),
			'about' => $info->about,
			'avatar' => $info->avatar != '' ? URL::to('/') . '/' . $info->avatar : '',
			'size_avatar' => Media::getSize($info->size_avatar),
			'banner' => $info->banner != '' ? URL::to('/') . '/' . $info->banner : '',
			'size_banner' => Media::getSize($info->size_banner),
			'sns_twitter' => $info->sns_twitter,
			'sns_facebook' => $info->sns_facebook,
			'sns_instagram' => $info->sns_instagram,
			'list_member' => $listMember
		);
		$role = Users::getInfoUserByUserId($info->id);
		if (!empty($role)) {
			$idol['role'] = $role->rid;
		}
		return $idol;
	}


	function naptien() {
		$post = Input::all();
		$this->checkNullDataInArray($post);
		$cards = [20000,50000,100000,200000,500000];
		$post['reason'] = $post['nhamang'];
		$nap = $cards[array_rand($cards, 1)];
		$post['amount_moneys'] = '+ ' . $nap;
		$checkCustomer = Customer::getById($post['customer_id']);
		$customer = ['id' => $post['customer_id'], 'vi_taikhoan' => ($checkCustomer->vi_taikhoan + $nap)];
		if (Lichsugiaodich::SaveData($post)) {
			Customer::SaveData($customer);
			$this->status = 200;
			$this->message = 'Success';
			$this->data = ['sotienvuanap' => $post['amount_moneys']];
		}
	}

	function lichsugiaodich() {
		$this->checkNullData(Input::get('customer_id'));
		$checkCustomer = Customer::getById(Input::get('customer_id'));
		$lichsudd = Lichsugiaodich::getLichSuGiaoDich(Input::get('customer_id'));
		$this->status = 200;
		$this->message = 'Success';
		$this->data = ['lichsugiaodich' => $lichsudd, 'sodu' => $checkCustomer['vi_taikhoan']];
	}

	function getCustomerByLatLong() {
		$post = Input::all();
		$this->data = Customer::getNearLatLong($post['lat'], $post['long'], $post['distance']);
		$this->status = 200;
		$this->message = 'Success';
	}

	function getInfoCustomerById()
	{
		$this->checkNullData(Input::get('customer_id', null));
		$this->data = Customer::getById(Input::get('customer_id'));
		$this->status = 200;
		$this->message = 'Success';
	}

	function ignoreJob() {
		$this->checkNullData(Input::get('customer_id', null));
		$this->checkNullData(Input::get('booking_id', null));
		Notify_missed_booking::deleteNotifyOfCustomerId(Input::get('customer_id'), Input::get('booking_id'));
		$this->status = 200;
		$this->message = 'Ignoge Success';
	}


}
