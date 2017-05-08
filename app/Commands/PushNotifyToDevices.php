<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Log;
use App\Models\Notify\Notify;
use App\Notify_missed_booking;

class PushNotifyToDevices extends Command implements SelfHandling {

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($devices, $message, $pushData, $bookingId)
	{
		$this->devices = $devices;
		$this->message = $message;
		$this->pushData = $pushData;
		$this->bookingId = $bookingId;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		Log::info(['queue' => 'running']);
		$customers = $this->devices;
		$message = $this->message;
		$pushData = $this->pushData;

        $missed['push_data'] = json_encode($pushData);
        $missed ['booking_id'] = $this->bookingId;
		foreach($customers as $customer)
		{
			if ($customer->type_device == 2) { /* Push IOS */
				$typeUser = ($customer->type_customer == 1) ? 'laodong' : 'customer';
				$result = Notify::Push2Ios($customer->device_token, $message, $pushData, $typeUser);
			} else { /* Push Android */

            	$result = Notify::cloudMessaseAndroid($customer->device_token, $message, $pushData);
            	$result = json_decode($result, true);

			}

            $missed['note'] = 'Missed push notify ' . $customer->device_token;
            $missed['customer_id'] = $customer->id;

            if ($result['success'] != 1) {
                $missed ['status'] = 0;
                Notify_missed_booking::SaveData($missed);
            } else {
                $missed ['status'] = 1;
                Notify_missed_booking::SaveData($missed);
            }

        }
	}

}
