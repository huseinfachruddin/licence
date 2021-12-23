<?php 

	namespace App\Http\Controllers\Payments\eWallet;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;

	use Xendit\Xendit;
	/**
	 * 
	 */
	Xendit::setApiKey('xnd_production_bFCXKxdow7fRIccoLP4kptLTSdsJMwMOVxIFzCR04x8KZzNr583Kgzvf3NtMnSRD');
	class LinkAja extends controller
	{
		
		function __construct($data)
		{
			$this->data = $data;
		}

		public function createPayment()
		{
			$id = $this->data->id;
			$ewalletChargeParams = [
			    'reference_id' => "{$id}",
			    'currency' => 'IDR',
			    'amount' => intval($this->data->total),
			    'checkout_method' => 'ONE_TIME_PAYMENT',
			    'channel_code' => "ID_{$this->data->channel}",
			    'channel_properties' => [
			        'success_redirect_url' => 'http://localhost:8080',
			        'mobile_number' => $this->data->phone
			    ],
			    'metadata' => [
			        'meta' => 'data'
			    ]
			];

			$createEWalletCharge = \Xendit\EWallets::createEWalletCharge($ewalletChargeParams);
			return $createEWalletCharge;
		}

		public function checkPayment()
		{
			$charge_id = $this->data->id;
			$getEWalletChargeStatus = \Xendit\EWallets::getEWalletChargeStatus($charge_id, []);
			return $getEWalletChargeStatus;
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