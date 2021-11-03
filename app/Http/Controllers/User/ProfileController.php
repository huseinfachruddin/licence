<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
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
        $request->validate([
            'name'  =>'required|unique:users,name,'.$data->id,
            'email' =>'required|email|unique:users,email,'.$data->id,
            'phone' =>'nullable',
        ]);
        $data = User::find($request->user()->id);
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
        ]);
        $user = User::where('id', $request->user()->id)->first();
            if (!$user || !Hash::check($request->oldPassword, $user->password)) {
                return response([
                    'success'   => false,
                    'errors' => ['auth'=> 'password salah']
                ], 401);
            }
        $data = User::find($user->id);
        $data->password = bcrypt($request->password);
        $data->save();

        $response = [
            'success'   => true,
            'profile'      => $data,
        ];
        return response($response,200);
    }
}
