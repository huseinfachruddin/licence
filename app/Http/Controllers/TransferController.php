<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Licence;
use App\Models\Transfer;

class TransferController extends Controller
{
    public function getTransfer(){
        $data = Transfer::with('order.user','order.suborder.package.product','account')->get();
        
        $response = [
            'success'   => true,
            'transfer'      => $data,
        ];
        return response($response,200);
    }

    public function detailTransfer(Request $request){
        $data = Transfer::with('order','account')->where('id',$request->id)->first();
        
        $response = [
            'success'   => true,
            'transfer'      => $data,
        ];
        
        return response($response,200);
    }

    public function createTransfer(Request $request){
        $request->validate([
            'order_id'  =>'required',
            'account_id'  =>'required',
            'paid'  =>'required'
        ]);
        $order = Order::find($request->order_id);
        if ($order->total>$request->paid) {

            $response = [
                'success'   => false,
                'errors'      => ['total pembayaran kurang dari total tagihan'],
            ];
            return response($response,400);
        }

        $data = new Transfer;
        $data->order_id = $request->order_id;
        $data->account_id = $request->account_id;
        $data->paid = $request->paid;
        $data->save();

        $response = [
            'success'   => true,
            'transfer'      => $data,
        ];
        return response($response,200);
    }

    public function editTransfer(Request $request){
        $request->validate([
            'order_id'  =>'required',
            'account_id'  =>'required',
            'paid'  =>'required'
        ]);
        $order = Order::find($request->order_id);
        if ($oder->total>$request->paid) {

            $response = [
                'success'   => false,
                'errors'      => ['total pembayaran kurang dari total tagihan'],
            ];
            return response($response,400);
        }

        $data =Transfer::find($request->id);
        $data->order_id = $request->order_id;
        $data->account_id = $request->account_id;
        $data->paid = $request->paid;
        $data->save();

        $response = [
            'success'   => true,
            'transfer'      => $data,
        ];
        return response($response,200);
    }

    public function deleteTransfer(Request $request){
        $data = Transfer::find($request->id);
        $data->delete();

        $response = [
            'success'   => true,
            'transfer'  => $data,
        ];
        return response($response,200);
    }
}
