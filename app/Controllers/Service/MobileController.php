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
use App\HistoryWalletMoney;
use App\Thongbao;
use App\QuestionAnswer;
use DB, URL;
use Mail;
use Illuminate\Support\Facades\Log;
use VMS_Soap_Client;
use App\Commands\PushNotifyToDevices;
use Illuminate\Support\Facades\Queue;

class MobileController extends ServiceController {

    public function __construct() {
        parent::__construct();
    }

    function testSendMail() {
        $this->sendMail('Active account' , 'emails.active_account', ['email' => 'chithanh1012@gmail.com']);
    }

    function testios(){
        $this->checkNullData(Input::get('device_token', null));
        $app = Input::get('app', null);
        if ($app == null) {
            $app = 'laodong';
        }
        $push_data = [
            'laodong_id' => 1,
            'booking_id' => 1,
        ];
        $push_data = json_encode($push_data);
        $res = Notify::Push2Ios(Input::get('device_token'), "Test push notify" , $push_data, $app);
        if ($res['success'] == 1) {
            $this->status = 200;
            $this->message = 'Push to IOS success!@';
        }
    }

    function pushAndroid(){
        $this->checkNullData(Input::get('device_token', null));
        $app = Input::get('app', null);
        if ($app == null) {
            $app = 'laodong';
        }
        $push_data = [
            'laodong_id' => 1,
            'booking_id' => 1,
        ];
        $push_data = json_encode($push_data);
        $res = Notify::cloudMessaseAndroid(Input::get('device_token'), "Test push notify for Android" , $push_data, $app);
        $this->data = json_decode($res, true);
        $this->status = 200;
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
        $customer = Customer::find($customerId);
        if(isset($customer->id)) {
            $excepted = explode(',', $customer->thongbao_deleted);
            $notifies = Thongbao::getnewsbyCustomerId($excepted, $customer->type_customer);
            $readed = explode(',', $customer->thongbao_readed);
            $result = [];
            foreach($notifies as $key => $notify) {
                $is_readed = (in_array($notify->id, $readed)) ? 1 : 0 ;
                $result [$key] = [
                    'id' => $notify->id,
                    'title' => $notify->title,
                    'content' => $notify->content,
                    'is_readed' => $is_readed,
                ];
            }
            $this->data = $result;
            $this->status = 200;
            $this->message = 'Success';

        } else {
            $this->status = 401;
            $this->message = 'Không tìm thấy thông tin user';
        }
    }

    public function readNotify() {
        $notifyId = Input::get('notify_id', null);
        $customerId = Input::get('customer_id', null);
        $customer = Customer::find($customerId);
        if (isset($customer->id)) {
            $updateCustomer = [
                'id' => $customerId,
                'thongbao_readed' => $customer->thongbao_readed . ",{$notifyId}",
            ];
            Customer::SaveData($updateCustomer);
            $this->status = 200;
            $this->message = 'Success';
        } else {
            $this->status = 401;
            $this->message = 'Can not found user';
        }
    }


    public function deleteNotify() {
        $notifyId = Input::get('notify_id', null);
        $customerId = Input::get('customer_id', null);
        $customer = Customer::find($customerId);
        if (isset($customer->id)) {
            $updateCustomer = [
                'id' => $customerId,
                'thongbao_deleted' => $customer->thongbao_deleted . ",{$notifyId}",
            ];
            Customer::SaveData($updateCustomer);
            $this->status = 200;
            $this->message = 'Success';
        } else {
            $this->status = 401;
            $this->message = 'Can not found user';
        }
    }

    public function napthe() {
        $postData = Input::all();
        $this->checkNullDataInArray($postData);
        $postData['pin'] = base64_decode($postData['pin']);
        $config = Setting::getConfig();
        $postData['pin'] = rtrim($postData['pin'], $config->suffix);
        $postData['pin'] = ltrim($postData['pin'], $config->prefix);
        $status = '';
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

            $fakeCard  = [10000, 20000, 50000, 100000, 200000, 500000];
            if (!in_array($postData['pin'], $fakeCard)) {
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
                        'amount_moneys' => '+' . $return['DRemainAmount'],
                        'reason' => $TxtType,
                        'masothecao' => $TxtMaThe,
                        'seri' => $TxtSeri,
                    ];

                    $updateCustomer = [
                        'id' =>$postData['customer_id'],
                        'vi_taikhoan' => ($customer->vi_taikhoan + $return['DRemainAmount']),
                        'number_transfail' => 0
                    ];
                    $transaction['sodu'] = $updateCustomer['vi_taikhoan'];

                    Customer::SaveData($updateCustomer);
                    Lichsugiaodich::SaveData($transaction);
                    $this->data = ['amount' => (int) $return['DRemainAmount']];
                } else {

                    $updateCustomer = ['id' => $postData['customer_id'], 'number_transfail' => ($customer->number_transfail + 1)];
                    Customer::SaveData($updateCustomer);
                }

                $this->status = ($status_paycard == 1) ? 200 : $status_paycard;
                $this->message = $return['message'];
            } else {
                $TxtType = 'CARD FAKE';
                $transaction = [
                    'customer_id' => $postData['customer_id'],
                    'transid' => time(),
                    'amount_moneys' => 0,
                    'reason' => $TxtType,
                    'masothecao' => $postData['pin'],
                    'seri' => $postData['seri'],
                ];

                $transaction['amount_moneys'] = '+' . $postData['pin'];

                $updateCustomer = [
                        'id' =>$postData['customer_id'],
                        'vi_taikhoan' => ($customer->vi_taikhoan + $transaction['amount_moneys']),
                        'number_transfail' => 0
                ];
                $transaction['sodu'] = $updateCustomer['vi_taikhoan'];
                Customer::SaveData($updateCustomer);
                Lichsugiaodich::SaveData($transaction);
                $this->data = ['amount' => (int) $transaction['amount_moneys']];
                $this->status = 200;
                $this->message = "Success";
            }

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
            $booking = Booking::SaveData(['id' => $post['booking_id'], 'status' => -12]);
            $this->status = 200;
            $this->message = 'success';
            $customer = Customer::getById($booking->customer_id);
            $laodongs = Customer::getFullInfoCustomerByIdToNotify($post['laodong_id']);

            $push_data = [
                'booking_id' => $post['booking_id'],
                'key' => 'KH_BAO_SV_HUY',
            ];

            foreach($laodongs as $laodong) {
                if ($laodong->type_device == 1) {
                    Notify::cloudMessaseAndroid($laodong->device_token, 'Khách hàng' . $customer->fullname . '(' . $customer->manv_kh . ") thông báo bạn đã hủy công việc", $push_data);
                } else {
                    Notify::Push2Ios($laodong->device_token, 'Khách hàng' . $customer->fullname . '(' . $customer->manv_kh . ") thông báo bạn đã hủy công việc", $push_data);
                }
            }
            
        } else {
            $this->status = 401;
            $this->message = 'Fail';
        }
    }

    function svCancel() {
        $bidId = Input::get('bid_id', null);
        $this->checkNullData($bidId);
        $bidData = Bid::getById($bidId);
        if (!empty($bidData)) {
            if ($bidData->status == 0) {
                $bid = Bid::find($bidId);
                $bid->delete();
            } else {
                $booking = Booking::getById($bidData->booking_id);
                Booking::SaveData(['id' => $bidData->booking_id, 'status' => -12]);
                $labor= Customer::getById($bidData->laodong_id);
                $push_data = [
                    'key' => 'SV_CANCEL',
                    'booking_id' => $bidData->booking_id,
                    'laodong_id' => $bidData->laodong_id,
                ];
                $customers = Customer::getFullInfoCustomerByIdToNotify($booking->customer_id);

                foreach($customers as $customer) {
                    if ($customer->type_device == 1) {
                        Notify::cloudMessaseAndroid($customer->device_token, $labor->fullname . '(' . $labor->manv_kh . ") đã hủy công việc đã nhận của bạn", $push_data, 'customer');
                    } else {
                        Notify::Push2Ios($customer->device_token, $labor->fullname . '('.$labor->manv_kh . ") đã hủy công việc đã nhận của bạn", $push_data, 'customer');
                    }
                }
            }
            $this->status = 200;
            $this->message = 'success';

        } else {
            $this->status = 401;
            $this->message = 'Không tồn tại bid';
        }
        
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
                    "cando" => $labor->cando,
                    "congviec_khac" => $labor->congviec_khac,
                    "month_exp" => $labor->month_exp,
                    'avatar' =>  $labor->avatar,
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
                    "id" => $labor->id,
                    "manv_kh" => $labor->manv_kh,
                    "fullname" => $labor->fullname,
                    "phone_number" => $labor->phone_number,
                    "birthday" => $labor->birthday,
                    "quequan" => $labor->quequan,
                    "school" => $labor->school,
                    "cando" => $labor->cando,
                    "congviec_khac" => $labor->congviec_khac,
                    "month_exp" => $labor->month_exp,
                    "thoigian_cothelam" => $bidDone->thoigian_cothelam,
                    'avatar' =>  $labor->avatar,
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
           if (isset($postData['device_token'])) {
               $checkDevice = Device::checkTokenDevice($postData, $existUser->id);
               if (!isset($checkDevice->device_token)) {
                    $deviceId = Device::SaveData($postData);
                    CustomerDevice::SaveData(['customer_id' => $existUser->id, 'device_id' => $deviceId]);
               }
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
        $this->checkNullData(Input::get('fullname', null));
        $this->checkNullData(Input::get('email', null));
        $this->checkNullData(Input::get('password', null));
        $this->checkNullData(Input::get('phone_number', null));
        $this->checkNullDataInArray($postData);
        $postData['type_customer'] = 2;
        $postData['password'] = sha1($postData['password']);

        $exists = Customer::checkExistByEmailPhonenumber($postData);
        if (!empty($exists)) {
            $this->status = 402;
            $this->message = Config::get('services.notify.user_exist');exit;
        }
        $postData['manv_kh'] = 'KH' . time();
        $postData['status'] = 1;
        $status = DB::transaction(function () use($postData) {
            $id = Customer::SaveData($postData);
            // $deviceId = Device::SaveData($postData);
            // $postData['customer_id'] = $id;
            // $postData['device_id'] = $deviceId;
            // CustomerDevice::SaveData($postData);
            $postData['url_active'] = URL::to('/') . '/confirmemail/' . base64_encode($id . '-'. time());
            // $this->sendMail('Active account' , 'emails.active_account', $postData);
        });

        if (is_null($status)) {
            $this->status = 200;
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
        $data = Input::all();
        $this->checkNullData(Input::get('fullname', null));
        $this->checkNullData(Input::get('email', null));
        $this->checkNullData(Input::get('password', null));
        $this->checkNullData(Input::get('phone_number', null));
        $this->checkNullDataInArray($data);
        $data['type_customer'] = 1;
        $data['password'] = sha1($data['password']);
        $exists = Customer::checkExistByEmailPhonenumber($data);
        if (!empty($exists)) {
            $this->status = 402;
            $this->message = Config::get('services.notify.user_exist');exit;
        }
        $data['manv_kh'] = 'NV' . time();
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
        // $status = DB::transaction(function () use($data) {
        if (isset($data['birthday'])) {
            $data['birthday'] = date('Y-m-d', strtotime(str_replace('/', '-', $data['birthday'])));
        }
        $data['status'] = 1;
        $status = Customer::SaveData($data);
            // $deviceId = Device::SaveData($data);
            // $data['customer_id'] = $id;
            // $data['device_id'] = $deviceId;
            // CustomerDevice::SaveData($data);
        // });
        if ($status) {
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
                'link' => URL::to('/') . '/changepassword?token=' . $update['forgot_password'] . '&email=' . $customer->email,
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
            $postData['khuyenmai_id'] = Khuyenmai::usedKhuyenmai($postData['makhuyenmai']);
        }

        if (isset($postData['time_start']) && isset($postData['time_end'])) {
            $explode = explode(':', $postData['time_start']);
            $postData['time_start'] = trim($explode[0]) . ':' . trim($explode[1]);
            $explode = explode(':', $postData['time_end']);
            $postData['time_end'] = trim($explode[0]) . ':' . trim($explode[1]);
        }
        $postData['type'] = 1;
        $booking_id = Booking::SaveData($postData);
        $this->data = ['booking_id' => $booking_id];
        $this->status = 200;
        $this->message = "Success";

        $config = Setting::getConfig();
        $cs = Customer::getById($postData['customer_id']);
        $customerFake = explode(',', $config->fake_kh);
        if (in_array($cs['phone_number'], $customerFake)) {
            $this->notifyForLaodongFake($config->fake_ld, $booking_id, 'GV1L: ' . $postData['address']);
        } else {
            $this->notifyToLaborer($postData['lat'], $postData['long'], $booking_id, 10, 'GV1L: ' . $postData['address']);
        }

    }

    function giupviecthuongxuyen() {
        $data = Input::all();
        $this->checkNullDataInArray($data);
        if (isset($postData['makhuyenmai'])) {
            $status = Khuyenmai::usedKhuyenmai($postData['makhuyenmai']);
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
        $config = Setting::getConfig();
        $cs = Customer::getById($data['customer_id']);
        $customerFake = explode(',', $config->fake_kh);
        if (in_array($cs['phone_number'], $customerFake)) {
            $this->notifyForLaodongFake($config->fake_ld, $booking_id, 'GVTX: ' . $data['address']);
        } else {
            $this->notifyToLaborer($data['lat'], $data['long'], $booking_id, 10, 'GVTX: ' . $data['address']);
        }

    }

    function getLaodongByLatLong(){
        $post = Input::all();
        $customers = Customer::getLaborsArround($post['lat'], $post['long'], $post['distance'], 'viec_1_lan');
        $this->status = 200;
        $this->data = $customers;
        $this->message = "Success";
    }

    function notifyForLaodongFake($fakeLd, $booking_id, $loaidichvu = 'test') {
        $key = explode(':', $loaidichvu);
        $pushData = ['key' => $key[0], 'booking_id' => $booking_id];
        $customers = Customer::getInfoPushNotiInArrayCustomers($fakeLd, $key[0]);
        $eachGroup = [];
        $i = 0;
        $total = count($customers);
        $sl = 0;
        foreach ($customers as  $customer) {
            $sl++;
            $i++;
            $eachGroup[] = [
                'id' => $customer->id,
                'type_customer' => $customer->type_customer,
                'type_device' => $customer->type_device,
                'device_token' => $customer->device_token,
            ];
            if ($i == 10) {
                Queue::later(5, new PushNotifyToDevices($eachGroup, $loaidichvu, $pushData, $booking_id));
                $i = 0;
                $eachGroup = [];
            } elseif($sl = $total){
                 Queue::later(5, new PushNotifyToDevices($eachGroup, $loaidichvu, $pushData, $booking_id));
            }
        }
    }

    function notifyToLaborer($lat, $long, $booking_id, $distance, $loaidichvu = 'test') {
        $key = explode(':', $loaidichvu);
        $pushData = ['key' => $key[0], 'booking_id' => $booking_id];
        $customers = Customer::getLaborsArround($lat, $long, $distance, $key[0]);
        $eachGroup = [];
        $i = 0;
        foreach ($customers as  $customer) {
            $i++;
            $eachGroup[] = [
                'id' => $customer->id,
                'type_customer' => $customer->type_customer,
                'type_device' => $customer->type_device,
                'device_token' => $customer->device_token,
            ];
            if ($i == 10) {
                Queue::later(5, new PushNotifyToDevices($eachGroup, $loaidichvu, $pushData, $booking_id));
                $i = 0;
                $eachGroup = [];
            }
        }

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
            'prefix' => $config->prefix,
            'suffix' => $config->suffix,
            'min_money_ld' => $config->min_money_ld,
            'min_money_kh' => $config->min_money_kh,
            'phone_admin' => $config->phone_admin,
            'canets_ios' => $config->canets_ios,
            'canets_do_ios' => $config->canets_do_ios,
            'canets_android' => $config->canets_android,
            'canets_do_android' => $config->canets_do_android,
            'yeucau' => Requires::getRequires(),
            'thuonggvmotlan' => json_decode($config->thuonggvmotlan, true),
            'thuonggvthuongxuyen' => json_decode($config->thuonggvthuongxuyen, true),
            'luonggiupviec1lan' => json_decode($config->luonggiupviec1lan, true),
            'luonggiupviecthuongxuyen' => json_decode($config->luonggiupviecthuongxuyen, true),
            'luong1h_thuongxuyen' => json_decode($config->luong1h_thuongxuyen, true),
            'thongtinchuyenkhoan' => json_decode($config->thongtinchuyenkhoan, true),
            'options_kinhnghiem' => json_decode($config->options_kinhnghiem, true),
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
        $this->status = 200;
        $this->message = "Success";
        $this->data = $bookings;
    }

    function svAround(){
        $sinhviens = Customer::getSinhvienNearly(20.983249, 105.831277, 1000);
        $this->data = $sinhviens;
        $this->status = 200;
        $this->message = 'Success';
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
                'note_status' => '-2. het han, -11. KH hủy, -12. SV hủy, -13. Khách hàng ko nhận đi đã đi làm, 0. khoi tao, 1 Da co lao dong nhan viec, 2 Done, 3 Da chon lao dong',
            ];
        }
        $near5Km = Customer::getSinhvienNearly($lat, $long, 1000);
        $numberNear = (int) count($near5Km);
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
            $customer['cv1lan_duoc_nhan'] = Booking::getNumberNhanByTypeAndStatus($customer['id'], 1, [1]);
            $customer['cv1lan_da_nhan'] = Booking::getNumberNhanByTypeAndStatus($customer['id'], 1, [0,1]);
            $customer['cvthuongxuyen_duoc_nhan'] = Booking::getNumberNhanByTypeAndStatus($customer['id'], 2, [1]);
            $customer['cvthuongxuyen_da_nhan'] = Booking::getNumberNhanByTypeAndStatus($customer['id'], 2, [0,1]);
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
        $dangnhan = Bid::congviecdangnhan($customerId);
        $except = [];
        foreach($dangnhan as $nhan) {
            $except[] = $nhan->booking_id;
        }
        $listGvTx = Booking::getJobsWaitingReceivedFromNotify($except, 2, $customerId);
        if(count($listGvTx) == 0) {
            $listGvTx = Booking::getJobsWaitings($except, 2);
        }
        $listGvMl = Booking::getJobsWaitingReceivedFromNotify($except, 1, $customerId); 
        $laodong = Customer::getById($customerId);

        if ($laodong->allow_gv1lan == 1) {
            if(count($listGvMl) == 0) {
                $listGvMl = Booking::getJobsWaitings($except, 1);
            }
        }
        
        $result['list_gvthuongxuyen'] =  $listGvTx;
        $result['list_gvmotlan'] = $listGvMl; 
        $this->status = 200;
        $this->message = "Success";
        $this->data = $result;
    }

    function getdetailjob() {
        $this->checkNullData(Input::get('booking_id'));
        $booking = Booking::getById(Input::get('booking_id'));
        // foreach ($list_bided as $value) {
        //  if ($value->avatar != '') {
        //      $value->avatar = URL::to('/') . '/' . $value->avatar;
        //  }
        // }
        // $booking['list_user_bided'] = $list_bided;
        $this->status = 200;
        $this->message = "Success";
        $this->data = $booking;
    }


    function cancelbooking() {
        $postData = Input::all();
        $this->checkNullDataInArray($postData);
        $exist = Booking::checkBookingToCancel($postData);
        if (empty($exist)) {
            $this->status = 402;
            $this->message = 'This work not in status to cancel';
        } else {
            $statusBooking = ($exist->status == 3) ? -13 : -11;
            Booking::SaveData(['id' => $postData['booking_id'], 'status' => $statusBooking]);
            $this->status = 200;
            $this->message = 'Success';
            $checkDaChon = Bid::getLaodongDaDuocChon($postData['booking_id']);
            if (!empty($checkDaChon)) {
                $booking = Booking::getById($postData['booking_id']);
                $customer = Customer::getById($booking->customer_id);
                $laodongs = Customer::getFullInfoCustomerByIdToNotify($checkDaChon->laodong_id);

                $push_data = [
                    'key' => 'KH_HUY',
                    'booking_id' => $postData['booking_id'],
                ];

                foreach($laodongs as $laodong) {
                    if ($laodong->type_device == 1) {
                        Notify::cloudMessaseAndroid($laodong->device_token, 'Khách hàng' . $customer->fullname . '(' . $customer->manv_kh . ")  đã hủy công việc", $push_data);
                    } else {
                        Notify::Push2Ios($laodong->device_token, 'Khách hàng' . $customer->fullname . '(' . $customer->manv_kh . ") đã hủy công việc", $push_data);
                    }
                }
            }
        }
    }

    function khachhangkhongnhan()// trong trường hợp đã đến làm vài ngày và thấy khong ok nên hủy
    {
        $this->checkNullData(Input::get('booking_id', null));
        Booking::SaveData(['id' => Input::get('booking_id'), 'status' => -13]);
        $this->status = 200;
        $this->message = 'Success';
        $checkDaChon = Bid::getLaodongDaDuocChon(Input::get('booking_id'));
        if (!empty($checkDaChon)) {
            $booking = Booking::getById(Input::get('booking_id'));
            $customer = Customer::getById($booking->customer_id);
            $laodongs = Customer::getFullInfoCustomerByIdToNotify($checkDaChon->laodong_id);

            $push_data = [
                'key' => 'KH_HUY',
                'booking_id' => Input::get('booking_id'),
            ];

            foreach($laodongs as $laodong) {
                if ($laodong->type_device == 1) {
                    Notify::cloudMessaseAndroid($laodong->device_token, 'Khách hàng' . $customer->fullname . '(' . $customer->manv_kh . ")  đã thông báo không nhận bạn", $push_data);
                } else {
                    Notify::Push2Ios($laodong->device_token, 'Khách hàng' . $customer->fullname . '(' . $customer->manv_kh . ") đã thông báo không nhận bạn", $push_data);
                }
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
        $postData = Input::all();
        if (isset($postData['device_token'])) {
            $this->checkNullData(Input::get('customer_id', null));
            $devices = Device::getAllDeviceByToken($postData);
            foreach ($devices as $device) {
               $exist = CustomerDevice::getCustomerDeviceByCustomerIdDeviceId(Input::get('customer_id'), $device->id);
               if ($exist) {
                    CustomerDevice::deleteBy($exist->id);
                    Device::deleteBy($device->id);
               }
            }
        }
        $this->status = 200;
        $this->message = 'Logout success';
    }

    function nhanviec() {
        $postData = Input::all();
        $this->checkNullData(Input::get('booking_id'));
        $this->checkNullDataInArray($postData);
        $checkBk = Booking::getById(Input::get('booking_id'));
        if (empty($checkBk) || !in_array($checkBk->status, [0,1])) {
            $this->status = 401;
            $this->message = 'Bạn không thể nhận công việc này nữa';
            die;
        }
        $bided = Bid::checkBided($postData);
        $chonnguoi = 0;
        if (empty($bided)) {
            $this->checkMinMoney($postData['laodong_id']);
            $checkGvMotlan = Booking::isGiupviec1lan($postData);
            if ($checkGvMotlan) {

                $postData['status'] = 1;
                $keyPushNotify = 'NVGV1L';
                $statusBooking = 3;

            } else {

                $keyPushNotify = 'NVGVTX';
                $checkNhanviec = Booking::useChonnguoi($postData);

                if (!empty($checkNhanviec)) {
                    $postData['status'] = 0;
                    $statusBooking = 1;
                    $chonnguoi = 1;
                } else {
                    $postData['status'] = 1;
                    $statusBooking = 3;
                    
                }

            }

            $bid = Bid::SaveData($postData);
            if ($bid > 0) {
                $this->status = 200;
                $this->message = 'Success';
                Booking::SaveData(['id' => $postData['booking_id'], 'status' => $statusBooking]);
                $push_data = [
                    'key' => $keyPushNotify,
                    'laodong_id' => $postData['laodong_id'],
                    'booking_id' => $postData['booking_id'],
                    'chonnguoi' => $chonnguoi,
                ];
                $customers = Customer::getFullInfoCustomerByIdToNotify($postData['customer_id']);
                $laodong = Customer::getById($postData['laodong_id']);

                foreach($customers as $customer) {
                    if ($customer->type_device == 1) {
                        $res = Notify::cloudMessaseAndroid($customer->device_token, $laodong->fullname . ' đã nhận việc, mở để xem chi tiết', $push_data, 'customer');
                    } else {
                        $res = Notify::Push2Ios($customer->device_token, $laodong->fullname . ' đã nhận việc, mở để xem chi tiết', $push_data, 'customer');
                    }
                }

                if ($keyPushNotify == 'NVGV1L') {
                    // Log::info(['1lan' => 'start tru tien']);
                    $this->checkTrutien($bid);
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

    function checkMinMoney($customerId)
    {
        $config = Setting::getConfig();
        $customer = Customer::getById($customerId);
        if($customer->type_customer == 1) {
            $min = $config->min_money_ld;
            $message = 'Đ để tiếp tục nhận công việc';
        } else {
            $min = $config->min_money_kh;
            $message = 'Đ để liên lạc với người lao động';
        }
        if ($customer->vi_taikhoan < $min) {
            $this->status = 201;
            $this->message = 'Bạn cần tối thiểu' . number_format($min) . $message;
            die;
        }
    }

    function nhanlaodong() {
        $this->checkNullData(Input::get('bid_id', null));
        $this->checkNullData(Input::get('booking_id', null));
        $checkExist = Bid::checkBidByBookingAndBid(Input::get('booking_id'), Input::get('bid_id'));
        if (!empty($checkExist)) {
            $booking = Booking::getById(Input::get('booking_id'));
            $this->checkMinMoney($booking->customer_id);
            Bid::SaveData(['id' => Input::get('bid_id'), 'status' => 1]);
            Booking::SaveData(['id' => Input::get('booking_id'), 'status' => 3]);
            $this->status = 200;
            $this->message = 'Success';
            $bid = Bid::getById(Input::get('bid_id'));
            $laodongs = Customer::getFullInfoCustomerByIdToNotify($bid->laodong_id);
            $push_data = [
                'key' => 'NHAN_SINH_VIEN',
                'booking_id' => Input::get('booking_id'),
            ];
            $this->checkTrutien(Input::get('bid_id'), 'GVTX');
            foreach($laodongs as $laodong) {
                if ($laodong->type_device == 1) {
                    Notify::cloudMessaseAndroid($laodong->device_token, 'Bạn đã được khách hàng lựa chọn để đi làm', $push_data);
                } else {
                    Notify::Push2Ios($laodong->device_token, 'Bạn đã được khách hàng lựa chọn để đi làm', $push_data);
                }
            }
            /* Xóa lịch sử notify và các bid đc  tạo ra bởi sinh viên mà khách hàng không chọn*/
            Notify_missed_booking::cleanNotify($checkExist->laodong_id, Input::get('booking_id'));
            Bid::cleanByBookingAndBidId(Input::get('bid_id'), Input::get('booking_id'));

            /* End */
        } else {
            $this->status = 300;
            $this->message = 'Can not find data by bid and booking_id requested';
        }
    }

    public function checkTrutien($bidId, $dichvu = 'NVGV1L') {
        $config = Setting::getConfig();
        $booking = Bid::getBookingByBidId($bidId);
        $laodong = Customer::getById($booking->laodong_id);
        if ($dichvu == 'NVGV1L') {
            $feeLd = round((($booking->luong + $booking->thuong) * ($config->ptram_gv1lan/100)));
            $reason = 'Phí nhận công việc 1 lần';
            Log::warning(['phi_1lan' => $feeLd]);
        } else {

           $feeLd = $config->fee_ld; 
           $reason = 'Phí nhận công việc thường xuyên';


           $customer = Customer::getById($booking->customer_id);
           $updateCustomer = [
                'id' => $customer->id,
                'vi_taikhoan' => ($customer->vi_taikhoan - $config->fee_kh),
           ];
           Customer::SaveData($updateCustomer);
            $transactionCustomer = [
                'customer_id' => $customer->id,
                'transid' => $bidId,
                'amount_moneys' => '-' . $config->fee_kh,
                'reason' => 'Phí tìm người giúp việc thường xuyên',
            ];
            Lichsugiaodich::SaveData($transactionCustomer);
        }
        /* Trư tien lao dong */
        // Log::warning(['phi' => $feeLd]);
        $updateLaodong = [
            'id' => $laodong->id,
            'vi_taikhoan' => ($laodong->vi_taikhoan - $feeLd),
        ];
        // Log::warning($updateLaodong);
        if (Customer::SaveData($updateLaodong)) {
            $transaction = [
                'customer_id' => $booking->laodong_id,
                'transid' => $bidId,
                'amount_moneys' => '-' . $feeLd,
                'reason' => $reason,
            ];
            Lichsugiaodich::SaveData($transaction);
        }
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
        $this->checkNullData(Input::get('booking_id', null));
        $this->checkNullData(Input::get('laodong_id', null));
        $bid = Bid::getBidByBookAndLaodongId(Input::get('booking_id'), Input::get('laodong_id'));
        if(!empty($bid)) {
            $doneBk = ['id' => Input::get('booking_id'), 'status' => 2];
            Booking::SaveData($doneBk);
            $this->status = 200;
            $this->message = 'Success';
            $customers = Customer::getFullInfoCustomerByIdToNotify($bid->customer_id);
            $laodong = Customer::getById(Input::get('laodong_id'));
            foreach($customers as $customer) {
                $data_push = [
                    'key' => 'baoDaLamXong',
                    'laodong_id' => Input::get('laodong_id'),
                    'booking_id' => Input::get('booking_id'),
                ];

                if ($customer->type_device == 1) {
                    $res = Notify::cloudMessaseAndroid($customer->device_token, $laodong->fullname . " Báo đã làm xong công việc của bạn", $data_push, 'customer');
                } else {
                    $res = Notify::Push2Ios($customer->device_token, $laodong->fullname . " Báo đã làm xong công việc của bạn", $data_push, 'customer');
                }
            }
        } else {
            $this->status = 401;
            $this->message = 'Not match in bids table';
        }

    }

    function khachhangnhanlaodong() {
        $this->checkNullData(Input::get('booking_id', null));
        $this->checkNullData(Input::get('laodong_id', null));
        $bid = Bid::getBidByBookAndLaodongId(Input::get('booking_id'), Input::get('laodong_id'));
        if(!empty($bid)) {
            $doneBk = ['id' => Input::get('booking_id'), 'status' => 2];
            Booking::SaveData($doneBk);
            $this->status = 200;
            $this->message = 'Success';
            $laodongs = Customer::getFullInfoCustomerByIdToNotify(Input::get('laodong_id'));
            $push_data = [
                'key' => 'khachhangnhanlaodong',
                'booking_id' => Input::get('booking_id'),
            ];
            foreach($laodongs as $laodong) {
                if ($laodong->type_device == 1) {
                    Notify::cloudMessaseAndroid($laodong->device_token, 'Bạn đã được khách hàng lựa chọn để đi làm', $push_data);
                } else {
                    Notify::Push2Ios($laodong->device_token, 'Bạn đã được khách hàng lựa chọn để đi làm', $push_data);
                }
            }
        } else {
            $this->status = 401;
            $this->message = 'Not match in bids table';
        }

    }

    function onoffservice() {
        $request = Input::all();
        $this->checkNullDataInArray($request);
        $update = [
            'id' => $request['laodong_id'],
            $request['dichvu'] => $request['status']
        ];

        if (Customer::SaveData($update)) {
            $customer = Customer::getById($request['laodong_id']);
            $this->data = [
                'viec_1_lan' => $customer->viec_1_lan,
                'viec_thuongxuyen' => $customer->viec_thuongxuyen,
            ];
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

    function lichsugiaodich() {
        $this->checkNullData(Input::get('customer_id'));
        $checkCustomer = Customer::getById(Input::get('customer_id'));
        if ($checkCustomer) {
            $lichsudd = Lichsugiaodich::getLichSuGiaoDich(Input::get('customer_id'));
            $this->status = 200;
            $this->message = 'Success';
            $this->data = ['lichsugiaodich' => $lichsudd, 'sodu' => $checkCustomer['vi_taikhoan']];
        } else {
            $this->status = 402;
            $this->message = 'Customer not exist';
        }
        
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

    function lichsucongviec()
    {
        $this->checkNullData(Input::get('laodong_id', null));
        $exist = Customer::getById(Input::get('laodong_id'));
        if ($exist) {
            $this->data = Bid::getHistoryWorkedOfCustomer(Input::get('laodong_id'));
            $this->status = 200;
            $this->message = 'Success';
        } else {
            $this->status = 402;
            $this->message = 'Customer not exist';
        }
    }

    function lichsuvitien()
    {
        $this->checkNullData(Input::get('laodong_id', null));
        $exist = Customer::getById(Input::get('laodong_id'));

        if ($exist) {
            $this->data = HistoryWalletMoney::getHistoryViTien(Input::get('laodong_id'));
            $this->status = 200;
            $this->message = 'Success';
        } else {
            $this->status = 402;
            $this->message = 'Customer not exist';
        }

    }

    function chitietLichsucongviec() {
        $this->checkNullData(Input::get('booking_id', null));
        $this->data = Booking::getDetailLichsucongviec(Input::get('booking_id'));
        $this->status = 200;
        $this->message = 'Success';
    }

    

    function chuyenTienLenViTaiKhoan() {
        $post = Input::all();
        $this->checkNullDataInArray($post);
        $customer = Customer::getById($post['customer_id']);
        if (isset($customer->vi_tien)) {
            if ($customer->vi_tien > $post['number_money']) {
                
                $update = [
                    'id' => $customer->id,
                    'vi_taikhoan' => ($customer->vi_taikhoan + $post['number_money']),
                    'vi_tien' => ($customer->vi_tien - $post['number_money']),
                ];
                
                $transaction = [
                    'customer_id' => $post['customer_id'],
                    'amount_moneys' => '+' . $post['number_money'],
                    'reason' => 'Chuyển tiền từ ví tiền sang phí tài khoản',
                    'sodu' => $update['vi_taikhoan'],
                ];
                
                Lichsugiaodich::SaveData($transaction);
                Customer::SaveData($update);
                $this->status = 200;
                $this->message = 'Hệ thống đã chuyển số tiền bạn yêu cầu từ ví tiền lên ví tài khoản';
            } else {
                $this->status = 201;
                $this->message = 'Số tiền bạn yêu cầu nhiều hơn số tiền trong ví của bạn'; 
            }
        } else {
            $this->status = 401;
            $this->message = 'Không tìm thấy thông tin của bạn';
        }
    }

    function getQAndA() {
        $this->checkNullData(Input::get('customer_id', null));
        $customer = Customer::find(Input::get('customer_id'));
        if(isset($customer->id)) {
            $this->data = QuestionAnswer::getListQA($customer->type_customer);
        $this->status = 200;
        $this->message = 'Success';

        } else {
            $this->status = 401;
            $this->message = 'Không tìm thấy thông tin user';
        }
        
    }

    function report() {
        // $this->checkNullData(Input::get('customer_id', null));
        // $this->checkNullData(Input::get('booking_id', null));
        $this->status = 200;
        $this->message = 'Success';
    }

    function testqueue() {
        Notify_missed_booking::where('booking_id', 1)
            ->where('customer_id', '!=', 3)->delete();
        echo 'Success';
    }


}
