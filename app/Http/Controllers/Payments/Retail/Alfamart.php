<?php 

	namespace App\Http\Controllers\Payments\Retail;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;

	use Xendit\Xendit;
	/**
	 * 
	 */
	Xendit::setApiKey('xnd_production_bFCXKxdow7fRIccoLP4kptLTSdsJMwMOVxIFzCR04x8KZzNr583Kgzvf3NtMnSRD');
	class Alfamart extends controller
	{
		static function createPayment($request)
		{
			$params = [
			    'external_id' => $request->id,
			    'retail_outlet_name' => $request->channel,
			    'name' => $request->user()->name,
			    'expected_amount' => $request->total,
			   	"expiration_date" => date('Y-m-d\TH:i:sO', strtotime('+1 days')),
			];
			
			$createFPC = \Xendit\Retail::create($params);

			return $createFPC;
		}

		static function checkPayment($request)
		{
			$getFPC = \Xendit\Retail::retrieve($request->id);

			return $getFPC;
		}

		static function updatePayment($request)
		{
			# code...
		}

		static function deletePayment($request)
		{
			# code...
		}

	}
 ?>