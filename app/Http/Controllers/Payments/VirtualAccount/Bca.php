<?php 

	namespace App\Http\Controllers\Payments\virtualAccount;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;

	use Xendit\Xendit;
	/**
	 * 
	 */
	Xendit::setApiKey('xnd_production_bFCXKxdow7fRIccoLP4kptLTSdsJMwMOVxIFzCR04x8KZzNr583Kgzvf3NtMnSRD');
	class Bca extends controller
	{

		static function createPayment($request)
		{
			$params = [
			   	"is_closed" => true,
				"external_id" => (string)$request->id,
			   	"bank_code" => (string)$request->channel,
			   	"name" => $request->user()->name,
			   	"expiration_date" => date('Y-m-d\TH:i:sO', strtotime('+1 days')),
         		"expected_amount" => $request->total,
			];

			$createVA = \Xendit\VirtualAccounts::create($params);
			return $createVA;
		}

		static function checkPayment($request)
		{
			$getVA = \Xendit\VirtualAccounts::retrieve($request->id, []);
			return $getVA;
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