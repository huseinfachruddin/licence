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
	  	public function initializePayment($data, $value='')
	  	{
		    if($value == 'ALFAMART') return new Alfamart($data);
		    if($value == 'INDOMART') return new Indomart($data);
		    if($value == 'BNI') return new Bni($data);
		    if($value == 'BCA') return new Bca($data);
		    if($value == 'BRI') return new Bri($data);
		    if($value == 'MANDIRI') return new Mandiri($data);
		    if($value == 'DANA') return new Dana($data);
		    if($value == 'LINKAJA') return new LinkAja($data);
	  	}

	}
 ?>