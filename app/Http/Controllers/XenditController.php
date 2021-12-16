<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Licence;
use Xendit\Xendit;
Xendit::setApiKey('xnd_development_78pJkaHadrSYbhUvpTKEiXe3nvDbkTvBHIMeay8gcCUFmDeT8ea8fPaKUpA0vDD');

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

        $params = [
            'external_id' => (string)$request->id,
            'retail_outlet_name' => $request->channel,
            'name' => $request->user()->name,
            'expected_amount' => $request->total
        ];

        $createFPC = \Xendit\Retail::create($params);

        $data = Order::find($request->id); 
        $data->paid_code = $createFPC['id'];
        $data->status = "pending";
        $data->save();

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
        ]);

        $data = Order::find($request->id);
        $data = \Xendit\Retail::retrieve((string)$data->paid_code);
        $response = [
            'success'   => true,
            'xendit'    => $data,
        ];
        return response($response,200);
    }

    public function paid(Request $request){

        $order = Order::with('user','suborder.package.product')->where('paid_code',$request->id)->first();
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
