<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Palamunin;
use Utility;

class PalamuninController extends Controller
{
    public function index(){
        $data = Palamunin::orderBy('name','desc')->paginate(10);
        return response()->json($data);
    }

    public function all(){
        $data = Palamunin::orderBy('name','desc')->get();
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
