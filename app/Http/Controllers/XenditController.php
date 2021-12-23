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

    public function __construct()
    {
        $this->payment = new PaymentController();
    }
  
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
            $data = $this->payment->initializePayment($request, $request->channel)->createPayment();
            return response($data,200);
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
            $data = $this->payment->initializePayment($request, $request->channel)->checkPayment();
            return response($data,200);
        // end
    }

    public function paid(Request $request){

        // get data post
            $id = '';
            $data = json_decode(file_get_contents('php://input'),true); 
            if(isset($data['id'])) $id = $data['external_id'];
            if(!isset($data['id'])) $id = $data['data']['external_id'];
        // end

        $order = Order::with('user','suborder.package.product')->where('id',$id)->first();
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
