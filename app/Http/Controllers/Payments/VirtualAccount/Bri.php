<?php 

	namespace App\Http\Controllers\Payments\virtualAccount;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;

	use Xendit\Xendit;
	/**
	 * 
	 */
	Xendit::setApiKey('xnd_production_bFCXKxdow7fRIccoLP4kptLTSdsJMwMOVxIFzCR04x8KZzNr583Kgzvf3NtMnSRD');
	class Bri extends controller
	{
		
		function __construct($data)
		{
			$this->data = $data;
		}

		public function createPayment()
		{
			$params = [
			   	"is_closed" => true,
				"external_id" => $this->data->id,
			   	"bank_code" => $this->data->channel,
			   	"name" => "user",
			   	"expiration_date" => date('Y-m-d\TH:i:sO', strtotime('+1 days')),
         		"expected_amount" => $this->data->total,
			];

			$createVA = \Xendit\VirtualAccounts::create($params);
			return $createVA;
		}

		public function checkPayment()
		{
			$getVA = \Xendit\VirtualAccounts::retrieve($this->data->id, []);
			return $getVA;
		}

		public function updatePayment()
		{
			# code...
		}

		public function deletePayment()
		{
			# code...
		}

	}
 ?>