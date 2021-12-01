<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domain;

class DomainController extends Controller
{
    public function getDomain(Request $request){
        $request->validate([
            'licence_id'  =>'required',
        ]);
        $data = Domain::where('licence',$request->licence_id)->get();

        $response = [
            'success'   => true,
            'domain'      => $data,
        ];
        return response($response,200);
    }
    public function deleteDomain(Request $request){
        if (!empty($request->licence_id)) {
            $data = Domain::where('licence',$request->licence_id);
        }else{
            $data = Domain::find($request->id);
        }

        $data->delete();
        $response = [
            'success'   => true,
            'domain'      => $data,
        ];
        return response($response,200);
    }
}
