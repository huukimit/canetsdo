<?php namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Booking;
use Input;

class BookingsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	function createGvMotlan() {

	}

	function createGvThuongXuyen() {

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
