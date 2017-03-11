<?php namespace App\Http\Controllers;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Booking;
use Illuminate\Http\Request;

class BookingsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function giupviecmotlan()
	{
		$bookings = Booking::where('type', 1)->orderBy('updated_at', 'desc')->paginate(15);
		return view('admin.motlan', ['bookings' => $bookings]);
	}
	public function giupviecthuongxuyen()
	{
		$bookings = Booking::where('type', 2)->orderBy('updated_at', 'desc')->paginate(15);
		return view('admin.thuongxuyen', ['bookings' => $bookings]);
	}
}
