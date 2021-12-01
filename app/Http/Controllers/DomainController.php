<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domain;

class DomainController extends Controller
{
    public function getDomain(Request $request){
        $data = Domain::where('licence_id',$request->licence_id)->get();

        $response = [
            'success'   => true,
            'domain'      => $data,
        ];
        return response($response,200);
    }
    public function deleteDomain(Request $request){
        $data = Domain::find($request->id);
        $data->delete();
        $response = [
            'success'   => true,
            'domain'      => $data,
        ];
        return response($response,200);
    }
}
