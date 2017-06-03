<?php namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Booking;
use App\Setting;
use App\Customer;
use App\Requires;
use Input;
use App\Commands\PushNotifyToDevices;
use Illuminate\Support\Facades\Queue;
use App\Models\Media\Media;
use Illuminate\Support\Facades\Log;

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
		// $bks = Booking::get();
		// foreach ($bks as $value) {
		// 	$update = ['id' => $value->id, 'time_start' => '', 'time_end' => ''];
		// 	$explode = explode(':', $value->time_start);
		// 	if($explode) {
		// 		$update['time_start'] =  trim($explode[0]) .':'.$explode[1];
		// 	}
		// 	$explode = explode(':', $value->time_end);
		// 	if($explode) {
		// 		$update['time_end'] =  trim($explode[0]) .':'.$explode[1];
		// 	}
		// 	Booking::SaveData($update);

		// }
		$search = Input::query('search');
		$status = Input::query('status');
		$bookings = Booking::where('type', 1);
		($status) ? $bookings = $bookings->where('bookings.status', (int) $status) : '';
		if ($search) {
            $bookings = $bookings->where(function($orConditions) use ($search) {
                $orConditions->where('address', 'like', "%$search%");
            });
        };
		$bookings = $bookings->orderBy('bookings.id', 'desc')->paginate(15);
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
		$status = Input::query('status');
		$bookings = Booking::where('type', 2);
		($status) ? $bookings = $bookings->where('bookings.status', (int) $status) : '';
		if ($search) {
            $bookings = $bookings->where(function($orConditions) use ($search) {
                $orConditions->where('address', 'like', "%$search%");
            });
        };
        $bookings = $bookings->orderBy('bookings.updated_at', 'desc')->paginate(15);
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
}
