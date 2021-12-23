<?php 

	namespace App\Http\Controllers\Payments\Retail;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;

	use Xendit\Xendit;
	/**
	 * 
	 */
	Xendit::setApiKey('xnd_production_bFCXKxdow7fRIccoLP4kptLTSdsJMwMOVxIFzCR04x8KZzNr583Kgzvf3NtMnSRD');
	class Indomart extends controller
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
			    'expected_amount' => $this->data->total
			];
			$createFPC = \Xendit\Retail::create($params);
			return $createFPC;
		}

		public function checkPayment($value='')
		{
			# code...
		}

		public function updatePayment($value='')
		{
			# code...
		}

		public function deletePayment($value='')
		{
			# code...
		}

	}
 ?>