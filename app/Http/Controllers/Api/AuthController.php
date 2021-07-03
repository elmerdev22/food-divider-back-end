<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        
        $rules = [
            'name'                  => 'required|unique:users|min:3',
            'password'              => 'required|confirmed',
            'password_confirmation' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->all()

            ], 200); // 400 being the HTTP code for an invalid request.
        }

        $data           = new User();
        $data->name     = $request->name;
        $data->email    = $request->name.'@gmail.com';
        $data->password = Hash::make($request->password);

        $data->save() ? $response = true : $response = false;

        return response()->json(['success' => $response]);
    }

    public function login(Request $request){
        $response = [
            'success'      => false,
            'errors'       => '',
            'access_token' => '',
        ];

        $rules = [
            'name'     => 'required',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->all()

            ], 200); // 400 being the HTTP code for an invalid request.
        }

        $auth = [
            'name'     => $request->name,
            'password' => $request->password
        ];

        if(!Auth::attempt($auth)){
            $response = [
                'success'      => false,
                'errors'       => ['Invalid Credentials'],
                'access_token' => '',
            ];
        }
        else{
            $accessToken = Auth::User()->createToken('authToken')->accessToken;
            $response = [
                'success'      => true,
                'errors'       => '',
                'access_token' => $accessToken,
            ];
        }

        return response()->json($response);
    }

    public function profile(Request $request){
        return response()->json($request->user());
    }
}
