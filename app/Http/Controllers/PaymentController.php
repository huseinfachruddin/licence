<?php 

	namespace App\Http\Controllers;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Payments\Retail\Alfamart;
	use App\Http\Controllers\Payments\Retail\Indomart;
	use App\Http\Controllers\Payments\VirtualAccount\Bni;
	use App\Http\Controllers\Payments\VirtualAccount\Bca;
	use App\Http\Controllers\Payments\VirtualAccount\Bri;
	use App\Http\Controllers\Payments\VirtualAccount\Mandiri;
	use App\Http\Controllers\Payments\eWallet\Dana;
	use App\Http\Controllers\Payments\eWallet\LinkAja;
	/**
	 * 
	 */
	class PaymentController extends Controller
	{
	  	static function initializePayment($channel=null)
	  	{
		    if($channel == 'ALFAMART') return new Alfamart;
		    if($channel == 'INDOMART') return new Indomart;
		    if($channel == 'BNI') return new Bni;
		    if($channel == 'BCA') return new Bca;
		    if($channel == 'BRI') return new Bri;
		    if($channel == 'MANDIRI') return new Mandiri;
		    if($channel == 'DANA') return new Dana;
		    if($channel == 'LINKAJA') return new LinkAja;
	  	}

	}
 ?>