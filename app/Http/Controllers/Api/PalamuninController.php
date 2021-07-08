<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Palamunin;
use Utility;

class PalamuninController extends Controller
{
    public function index(Request $request){
        $data = Palamunin::orderBy('name','desc')->where('user_id', $request->user()->id)->paginate(10);
        return response()->json($data);
    }

    public function all(Request $request){
        $data = Palamunin::orderBy('name','desc')->where('user_id', $request->user()->id)->get();
        return response()->json($data);
    }

    public function add(Request $request){
        
        $rules = [
            'name' => 'required|unique:palamunins',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->all()

            ], 200); // 400 being the HTTP code for an invalid request.
        }

        $data               = new Palamunin();
        $data->user_id      = $request->user()->id;
        $data->name         = $request->name;
        $data->palamunin_no = Utility::generate_unique_token();

        $data->save() ? $response = true : $response = false;

        return response()->json(['success' => $response]);
    }

    public function delete($id){
        
        $data = Palamunin::whereId($id)->first();
        $data->delete() ? $response = true : $response = false;

        return response()->json(['success' => $response]);
    }
}
