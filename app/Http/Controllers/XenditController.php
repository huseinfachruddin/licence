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
        $this->url = 'http://localhost:5000/wa/send-bulk';
        $this->client = new \GuzzleHttp\Client();
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

            $data["createPayment"] = $this->payment->initializePayment($request, $request->channel)->createPayment();
            $data['postData'] = $this->client->request('POST', $this->url, ["json" => ["contact" => '6285882843337', "message" => "halo test wa dan lisensi"]]);
            return response($data, 200);
        // end

        if ($data['id']) {
            $order = Order::find($request->id);
            $order->paid_code=$data['id'];
            $order->status='menunggu pembayaran';
            $order->method=$request->channel;
            $order->save();
        }
        $response = [
            'success'   => true,
            'xendit'     =>$data,
            'order' =>$order
        ];
        return response($response,200);
    }

    public function getInvoice(Request $request){
        $request->validate([
            'id'  =>'required',
            'channel' => 'required'
        ]);
            $data = PaymentController::initializePayment($request->channel)->checkPayment($request);
            if ($data['external_id']) {
                $order = Order::find($data['external_id']);
                $order->paid_code=$data['id'];
                $order->status='menunggu pembayaran';
                $order->save();
            }
            $response = [
                'success'   => true,
                'xendit'     =>$data,
                'order'     =>$order,
            ];
            return response($response,200);
    }

    public function paid(Request $request){

        // get data post
            $id = '';
            $data = json_decode(file_get_contents('php://input'),true); 
            if(isset($data['id'])) $id = $data['external_id'];
            if(!isset($data['id'])) $id = $data['data']['external_id'];
        // end

        // wa
            $data['postData'] = $this->client->request('POST', $this->url, ["json" => ["contact" => '6285882843337', "message" => "halo test wa dan lisensi"]]);
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
