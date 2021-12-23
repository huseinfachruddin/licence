<?php 

	namespace App\Http\Controllers\Payments\virtualAccount;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;

	use Xendit\Xendit;
	/**
	 * 
	 */
	Xendit::setApiKey('xnd_production_bFCXKxdow7fRIccoLP4kptLTSdsJMwMOVxIFzCR04x8KZzNr583Kgzvf3NtMnSRD');
	class Mandiri extends controller
	{

		public function createPayment($request)
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

		public function checkPayment($request)
		{
			$getVA = \Xendit\VirtualAccounts::retrieve($request->id, []);
			return $getVA;
		}

		public function updatePayment($request)
		{
			# code...
		}

		public function deletePayment($request)
		{
			# code...
		}

	}
 ?>