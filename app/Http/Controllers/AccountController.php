<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

class AccountController extends Controller
{
    public function getAccount(){
        $data = Account::all();
        
        $response = [
            'success'   => true,
            'account'      => $data,
        ];
        return response($response,200);
    }

    public function detailAccount(Request $request){
        $data = Account::find($request->id);
        
        $response = [
            'success'   => true,
            'account'      => $data,
        ];
        
        return response($response,200);
    }

    public function createAccount(Request $request){
        $request->validate([
            'name'  =>'required',
            'num_account'  =>'required',
            'bank'  =>'required'
        ]);

        $data = new Account;
        $data->name= $request->name;
        $data->num_account = $request->num_account;
        $data->bank = $request->bank;
        $data->save();

        $response = [
            'success'   => true,
            'account'      => $data,
        ];
        return response($response,200);
    }

    public function editAccount(Request $request){
        $request->validate([
            'name'  =>'required',
            'num_account'  =>'required',
            'bank'  =>'required'
        ]);

        $data = Account::find($request->id);
        $data->name= $request->name;
        $data->num_account = $request->num_account;
        $data->bank = $request->bank;
        $data->save();

        $response = [
            'success'   => true,
            'account'      => $data,
        ];
        return response($response,200);
    }

    public function deleteAccount(Request $request){
        $data = Account::find($request->id);
        $data->delete();

        $response = [
            'success'   => true,
            'account'  => $data,
        ];
        return response($response,200);
    }
}
