<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

class ProfileController extends Controller
{
    public function getProfile(Request $request){
        $data = $request->user();
        $response = [
            'success'   => true,
            'profile'      => $data,
        ];
    
        return response($response,200);
    }

    public function editProfile(Request $request){
        $data = User::find($request->user()->id);
        $request->validate([
            'name'  =>'required|unique:users,name,'.$data->id,
            'email' =>'required|email|unique:users,email,'.$data->id,
            'phone' =>'nullable',
        ]);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->save();

        $response = [
            'success'   => true,
            'profile'      => $data,
        ];
        return response($response,200);
    }

    public function passwordProfile(Request $request){
        $request->validate([
            'oldPassword'  =>'required|min:6',
            'newPassword'  =>'required|min:6',
            'rePassword'  =>'required|min:6|same:newPassword',
        ]);
        $user = User::where('id', $request->user()->id)->first();
            if (!$user || !Hash::check($request->oldPassword, $user->password)) {
                return response([
                    'success'   => false,
                    'errors' => ['auth'=> 'password salah']
                ], 401);
            }
        $data = User::find($user->id);
        $data->password = bcrypt($request->newPassword);
        $data->save();

        $response = [
            'success'   => true,
            'profile'      => $data,
        ];
        return response($response,200);
    }
}
