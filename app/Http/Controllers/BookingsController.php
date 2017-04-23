<?php namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Booking;
use App\Setting;
use App\Customer;
use Input;
use App\Commands\PushNotifyToDevices;
use Illuminate\Support\Facades\Queue;

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
            $booking_id = Booking::SaveData($post);
            $pushData = ['key' => 'GV1L', 'booking_id' => $booking_id];
	        $customers = Customer::getLaborsArround($post['lat'], $post['long'], 50, 'GV1L');
	        Queue::later(5, new PushNotifyToDevices($customers, 'GV1L' . $post['address'], $pushData, $booking_id));
	        return redirect('secret/bookings/motlan');
        }
		$setting = Setting::getConfig();
		return view('admin.create_motlan', [
			'mucthuongs' => json_decode($setting->thuonggvmotlan, true),
		]);
	}

	function createGvThuongXuyen() {
		return view('admin.create_thuongxuyen', [
			'bookings' => $bookings,
			'statuses' => $statuses,
		]);
	}

	public function giupviecmotlan()
	{
		$search = Input::query('search');
		$status = Input::query('status');
		$bookings = Booking::where('type', 1);
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
