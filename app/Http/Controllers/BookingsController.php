<?php namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Booking;
use App\Feedback;
use App\Setting;
use App\Customer;
use App\Requires;
use App\Bid;
use Input;
use App\Commands\PushNotifyToDevices;
use Illuminate\Support\Facades\Queue;
use App\Models\Media\Media;
use Illuminate\Support\Facades\Log;
use Response;


class BookingsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	function createGvMotlan() {
		if (Input::method() == 'POST') {
            $post = Input::all();
            $post['type'] = 1;
            $post['customer_id'] = 1;
            $booking_id = Booking::SaveData($post);
            $pushData = ['key' => 'GV1L', 'booking_id' => $booking_id];
	        $customers = Customer::getLaborsArround($post['lat'], $post['long'], 50, 'GV1L');

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
	                // Log::info(['count' => $eachGroup]);
	                Queue::later(5, new PushNotifyToDevices($eachGroup, 'GV1L' . $post['address'], $pushData, $booking_id));
	                $i = 0;
	                $eachGroup = [];
	            }
	        }
	        return redirect('secret/bookings/motlan');
        }
		$setting = Setting::getConfig();
		return view('admin.create_motlan', [
			'mucthuongs' => json_decode($setting->thuonggvmotlan, true),
		]);
	}

	function createGvThuongXuyen() {
		if (Input::method() == 'POST') {
			$post = Input::all();
			$post['type'] = 2;
			$post['customer_id'] = 1;
			if (!empty($post['ngaylamtrongtuan'])) {
				$post['ngaylamtrongtuan'] = implode(',', $post['ngaylamtrongtuan']);
			}
			if (!empty($post['viecphailam'])) {
				$post['viecphailam'] = implode(',', $post['viecphailam']);
			}
			if ($_FILES['anh1']['size']) {
	            $_FILES['file'] = $_FILES ['anh1'];
	            $upImage = Media::uploadImage($_FILES, 'anhcanho');
	            $post['anh1'] = $upImage['url'];
	        }
	        if ($_FILES['anh2']['size']) {
	            $_FILES['file'] = $_FILES ['anh2'];
	            $upImage = Media::uploadImage($_FILES, 'anhcanho');
	            $post['anh2'] = $upImage['url'];
	        }
	        if ($_FILES['anh3']['size']) {
	            $_FILES['file'] = $_FILES ['anh3'];
	            $upImage = Media::uploadImage($_FILES, 'anhcanho');
	            $post['anh3'] = $upImage['url'];
	        }
	        $booking_id = Booking::SaveData($post);
            $pushData = ['key' => 'GVTX', 'booking_id' => $booking_id];
	        $customers = Customer::getLaborsArround($post['lat'], $post['long'], 50, 'GVTX');
	        Queue::later(5, new PushNotifyToDevices($customers, 'GVTX' . $post['address'], $pushData, $booking_id));
	        return redirect('secret/bookings/thuongxuyen');
        }
		$setting = Setting::getConfig();
		return view('admin.create_thuongxuyen', [
			'mucthuongs' => json_decode($setting->thuonggvthuongxuyen, true),
			'thutrongtuan' => ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
			'requires' => Requires::where('status', 1)->orderBy('stt')->get(),
			'thoigianlam' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
		]);
	}

	public function giupviecmotlan()
	{
		$search = Input::query('search');
		$status = Input::query('status');
		$createDate = Input::query('create_date');
		$bookings = Booking::where('type', 1)
			->join('customers', 'bookings.customer_id', '=', 'customers.id');
		($status) ? $bookings = $bookings->where('bookings.status', (int) $status) : '';
		($createDate != '') ? $bookings = $bookings->whereDate('bookings.created_at', '=', $createDate) : '';
		if ($search) {
            $bookings = $bookings->where(function($orConditions) use ($search) {
                $orConditions->where('address', 'like', "%$search%")
                    ->orWhere('fullname', 'like', "%$search%")
                    ->orWhere('phone_number', 'like', "%$search%");
            });
        };
		$bookings = $bookings->select('bookings.*')
		->orderBy('bookings.id', 'desc')->paginate(15);
		$statuses = [
			0 => 'Trạng thái công việc',
			100 => 'Mới tạo',
            1 => 'Đã có sinh viên nhận',
            2 => 'Đã hoàn thành',
            3 => 'Khách hàng đã chọn sinh viên',
            -2 => 'Hết hạn',
            -11 => 'Khách hàng hủy',
            -12 => 'Sinh viên hủy',
            -13 => 'Sinh viên đã làm, KH không nhận',
		];
		return view('admin.motlan', [
			'bookings' => $bookings,
			'statuses' => $statuses,
		]);
	}
	public function giupviecthuongxuyen()
	{
		$search = Input::query('search');
		$infoLaodong = Input::query('info_laodong');
		if ($infoLaodong) {
			$laodongs = Customer::where(function($orConditionsLd) use ($infoLaodong) {
                $orConditionsLd->where('phone_number', 'like', "%$infoLaodong%")
                	->orWhere('fullname', 'like', "%$infoLaodong%")
                	->orWhere('manv_kh', 'like', "%$infoLaodong%");
            });
            $laodongs = $laodongs->select('id')->get();
            $lds = [];
            foreach ($laodongs as $laodong) {
            	$lds[] = $laodong->id;
            }
            $bids = Bid::whereIn('laodong_id', $lds)->select('booking_id')->get();
            $bkHistory = [];
            foreach ($bids as $bidOne) {
            	$bkHistory[] = $bidOne->booking_id;
            }
		}
		$status = Input::query('status');
		$createDate = Input::query('create_date');
		$bookings = Booking::where('type', 2)
			->join('customers', 'bookings.customer_id', '=', 'customers.id');;
		($status) ? $bookings = $bookings->where('bookings.status', (int) $status) : '';
		($createDate != '') ? $bookings = $bookings->whereDate('bookings.created_at', '=', $createDate) : '';
		if(isset($bkHistory) && !empty($bkHistory)) {
			$bookings = $bookings->whereIn('bookings.id', $bkHistory);
		}

		if ($search) {
            $bookings = $bookings->where(function($orConditions) use ($search) {
                $orConditions->where('address', 'like', "%$search%")
                	->orWhere('fullname', 'like', "%$search%")
                	->orWhere('phone_number', 'like', "%$search%");
            });
        };
        $bookings = $bookings->select('bookings.*')->orderBy('bookings.id', 'desc')->paginate(15);
		$statuses = [
			0 => 'Trạng thái công việc',
			100 => 'Mới tạo',
            1 => 'Đã có sinh viên nhận',
            2 => 'Đã hoàn thành',
            3 => 'Khách hàng đã chọn sinh viên',
            -2 => 'Hết hạn',
            -11 => 'Khách hàng hủy',
            -12 => 'Sinh viên hủy',
            -13 => 'Sinh viên đã làm, KH không nhận',
		];
		return view('admin.thuongxuyen', [
			'bookings' => $bookings,
			'statuses' => $statuses,
		]);
	}

	public function updateNoteBooking()
    {
        $booking = Booking::find(Input::get('id'));
        if ($booking) {
            $booking->note_byadmin= Input::get('note');
            if ($booking->save()) {
                return Response::json(['status' => true]);
            }
        }
        return Response::json(['status' => false]);
    }


    

    public function updateNoteFeedback()
    {
        $fb = Feedback::find(Input::get('id'));
        if ($fb) {
            $fb->note_byadmin= Input::get('note');
            if ($fb->save()) {
                return Response::json(['status' => true]);
            }
        }
        return Response::json(['status' => false]);
    }
}
