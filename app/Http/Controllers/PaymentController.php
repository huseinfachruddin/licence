<?php 

	namespace App\Http\Controllers;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Payments\Retail\Alfamart;
	use App\Http\Controllers\Payments\Retail\Indomart;
	use App\Http\Controllers\Payments\eWallet\Dana;
	use App\Http\Controllers\Payments\eWallet\LinkAja;
	use App\Http\Controllers\Payments\VirtualAccount\Bca;
	use App\Http\Controllers\Payments\VirtualAccount\Bri;
	use App\Http\Controllers\Payments\VirtualAccount\Bni;
	use App\Http\Controllers\Payments\VirtualAccount\Mandiri;
	/**
	 * 
	 */
	class PaymentController extends Controller
	{
	  	public function initializePayment($data, $channel)
	  	{
			// $class = "App\Http\Controllers\Payments\Retail"."\\".$channel;
		 	// return new $class($data);
		 	if($channel == "ALFAMART") return new Alfamart($data);
		 	if($channel == "INDOMART") return new Indomart($data);
		 	if($channel == "DANA") return new Dana($data);
		 	if($channel == "LINKAJA") return new LinkAja($data);
		 	if($channel == "BCA") return new Bca($data);
		 	if($channel == "BRI") return new Bri($data);
		 	if($channel == "BNI") return new BNI($data);
		 	if($channel == "MANDIRI") return new Mandiri($data);
	  	}

	}
 ?>