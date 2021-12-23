<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Channel;

class ChannelController extends Controller
{
    public function getChannel(Request $request){
        $user = User::find($request->user()->id);
        if ($user->hasRole('admin')) {
            $data = Channel::orderBy('queue','ASC')->get();
        }else{
            $data = Channel::orderBy('queue','ASC')->where('active',true)->get();
        }
        foreach ($data as $key => $value) {
            $value->img= url("/channel/".$value->img);
        }

        $response = [
            'success'   => true,
            'channel'      => $data,
        ];
        return response($response,200);
    }

    public function createChannel(Request $request){
        $request->validate([
            'name'  =>'required',
            'code'  =>'required',
            'img'  =>'required',
            'active'=>'required',
            'queue'=>'required'
        ]);

        $data = new Channel;
        $data->name= $request->name;
        $data->code = $request->code;
        $data->img = $request->img;
        $data->active = $request->active;
        $data->queue = $request->queue;
        $data->save();

        $response = [
            'success'   => true,
            'channel'      => $data,
        ];
        return response($response,200);
    }

    public function editChannel(Request $request){
        
        $data = Channel::find($request->id); 
        if ($request->name) $data->name= $request->name; 
        if ($request->code) $data->code= $request->code; 
        if ($request->active=='true') $data->active= true; 
        if ($request->active=='false') $data->active= false; 
        if ($request->queue) $data->queue= $request->queue; 
        $data->save();

        $response = [
            'success'   => true,
            'channel'      => $data,
        ];
        return response($response,200);
    }

    public function deleteChannel(Request $request){
        $data = Channel::find($request->id);
        $data->delete();

        $response = [
            'success'   => true,
            'channel'  => $data,
        ];
        return response($response,200);
    }
    public function queueChannel(Request $request){
        $request->validate([
            'channel'=>'required'
        ]);
        foreach ($request->channel as $key => $value) {
            $data = Channel::find($value['id']);
            $data->queue = $key;
            $data->save();
        }
        $response = [
            'success'   => true,
            'channel'  => $data,
        ];
        return response($response,200);
    }
}
