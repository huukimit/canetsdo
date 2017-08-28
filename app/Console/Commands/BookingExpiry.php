<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Log;
use App\Booking;
use App\Notify_missed_booking;


class BookingExpiry extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'booking_expiry';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Update booking to expiry';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$expiries = Booking::getBookingExpiry();
		$status = -2;
		$update = ['status' => -2, 'id' => 0];
		foreach ($expiries as $expiry) {
			$update['id'] = $expiry->id;
			Booking::SaveData($update);
			Notify_missed_booking::deleteBy($expiry->id, 'booking_id');
		}
	}
}
