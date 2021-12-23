<?php

namespace App\Http\Controllers;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Licence;
use Xendit\Xendit;
Xendit::setApiKey('xnd_production_bFCXKxdow7fRIccoLP4kptLTSdsJMwMOVxIFzCR04x8KZzNr583Kgzvf3NtMnSRD');

class XenditController extends Controller
{
  
    public function getChannel(){

        $data = \Xendit\PaymentChannels::list();

        $response = [
            'success'   => true,
            'xendit'      => $data,
        ];
        return response($response,200);
    }

    public function payment(Request $request){


        $request->validate([
            'id'  =>'required',
            'channel'  =>'required',
            'total'  =>'required',
        ]);

        // made by imron
            $payment = new PaymentController();
            $init = $payment->initializePayment($request, $request->channel);
            $result = $init->createPayment();
            return response($result,200);
        // end

        $response = [
            'success'   => true,
            'order'     =>$data,
            'xendit'    => $createFPC,
        ];
        return response($response,200);
    }

    public function invoice(Request $request){
        $request->validate([
            'id'  =>'required',
            'channel' => 'required'
        ]);

       // made by imron
            $payment = new PaymentController();
            $init = $payment->initializePayment($request, $request->channel);
            $result = $init->checkPayment();
            return response($result,200);
        // end
    }

    public function paid(Request $request){

        $order = Order::with('user','suborder.package.product')->where('paid_code',$request->id)->first();
        $order = Order::find($order->id);
        $order->status = 'sudah dibayar';
        foreach ($order->suborder as $key => $value) {
            $product = $value->package->product;
            for ($i=0; $i < $value->package->num_licence; $i++) { 

                $data = new Licence;
                $data->product_id = $product->id;
                $data->user_id = $value->user->id;
                $data->licence = Str::random(15);
                $data->max_domain = $value->package->num_domain;
                $data->due = date('Y-m-d',strtotime($date1 . "+".$value->package->num_expired." days"));
                $data->save();
            }
        }

        $response = [
            'success'   => true,
            'xendit'    => $data,
        ];
        return response($response,200);
    }

}
