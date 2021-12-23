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

		static function createPayment($request)
		{
			$params = [
			    'external_id' => $request->id,
			    'retail_outlet_name' => $request->channel,
			    'name' => $request->user()->name,
			    'expected_amount' => $request->total
			];
			$createFPC = \Xendit\Retail::create($params);
			return $createFPC;
		}

		static function checkPayment($value='')
		{
			# code...
		}

		static function updatePayment($value='')
		{
			# code...
		}

		static function deletePayment($value='')
		{
			# code...
		}

	}
 ?>