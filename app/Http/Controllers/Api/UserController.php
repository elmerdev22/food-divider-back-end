<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $data = User::get();
        return response()->json($data);
    }
    
    public function create(Request $request){
        
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
        
        $rules = [
            'name'     => 'required|unique:users|min:3',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->all()

            ], 200); // 400 being the HTTP code for an invalid request.
        }

        $response = true;

        return response()->json(['success' => $response]);
    }
    
    public function update(Request $request, $id){
        
        $data           = User::whereId($id)->first();
        $data->name     = $request->name;

        $data->save() ? $response = true : $response = false;

        return response()->json($response);
    }

    public function edit($id){
        $data = User::whereId($id)->first();
        return response()->json($data);
    }
    
    public function delete($id){
        $data = User::whereId($id)->first();
        $data->delete() ? $response = true : $response = false;

        return response()->json($response);
    }
}
