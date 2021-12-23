<?php 

	namespace App\Http\Controllers\Payments\eWallet;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;

	use Xendit\Xendit;
	/**
	 * 
	 */
	Xendit::setApiKey('xnd_production_bFCXKxdow7fRIccoLP4kptLTSdsJMwMOVxIFzCR04x8KZzNr583Kgzvf3NtMnSRD');
	class Dana extends controller
	{

		static function createPayment($request)
		{
			$ewalletChargeParams = [
			    'reference_id' => (string)$request->id,
			    'currency' => 'IDR',
			    'amount' => (int)$request->total,
			    'checkout_method' => 'ONE_TIME_PAYMENT',
			    'channel_code' => "ID_".(string)$request->channel,
			    'channel_properties' => [
			        'success_redirect_url' => (string)$request->redirect,
			        'mobile_number' => $request->user()->phone
			    ],
			    'metadata' => [
			        'meta' => 'data'
			    ]
			];

			$createEWalletCharge = \Xendit\EWallets::createEWalletCharge($ewalletChargeParams);
			return $createEWalletCharge;
		}

		static function checkPayment($request)
		{
			$charge_id = $request->id;
			$getEWalletChargeStatus = \Xendit\EWallets::getEWalletChargeStatus($charge_id, []);
			return $getEWalletChargeStatus;
		}

		public function updatePayment()
		{
		}

		public function deletePayment()
		{
		}

	}
 ?>