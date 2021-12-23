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
		
		function __construct($data)
		{
			$this->data = $data;
		}

		public function createPayment()
		{
			$params = [
			    'external_id' => $this->data->id,
			    'retail_outlet_name' => $this->data->channel,
			    'name' => 'user',
			    'expected_amount' => $this->data->total,
			   	"expiration_date" => date('Y-m-d\TH:i:sO', strtotime('+1 days')),
			];
			
			$createFPC = \Xendit\Retail::create($params);
			return $createFPC;
		}

		public function checkPayment()
		{
			$getFPC = \Xendit\Retail::retrieve($this->data->id);
			return $getFPC;
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