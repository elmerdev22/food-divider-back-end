<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class FoodController extends Controller
{
    
    public function add(Request $request){

        $rules = [
            'name'         => 'required',
            'palwal'       => 'required',
            'total_amount' => 'required|numeric|min:0',
            'start_date'   => 'required|date',
            'end_date'     => 'required|after_or_equal:start_date',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->all()

            ], 200); // 400 being the HTTP code for an invalid request.
        }

        $data                = new Food();
        $data->user_id       = $request->user()->id;
        $data->name          = ucfirst($request->name);
        $data->palwal        = ucfirst($request->palwal);
        $data->total_amount  = $request->total_amount;
        $data->start_date    = $request->start_date;
        $data->end_date      = $request->end_date;
        $data->palamunin_ids = $request->palamunin_ids ? implode(',',$request->palamunin_ids) : null;

        $data->save() ? $response = true : $response = false;

        return response()->json(['success' => $response]);
    }

    public function update(Request $request, $id){

        $rules = [
            'name'         => 'required',
            'palwal'       => 'required',
            'total_amount' => 'required|numeric|min:0',
            'start_date'   => 'required|date',
            'end_date'     => 'required|after_or_equal:start_date',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->all()

            ], 200); // 400 being the HTTP code for an invalid request.
        }

        $data                = Food::whereId($id)->first();
        $data->user_id       = $request->user()->id;
        $data->name          = ucfirst($request->name);
        $data->palwal        = ucfirst($request->palwal);
        $data->total_amount  = $request->total_amount;
        $data->start_date    = $request->start_date;
        $data->end_date      = $request->end_date;
        $data->palamunin_ids = $request->palamunin_ids ? implode(',',$request->palamunin_ids) : null;

        $data->save() ? $response = true : $response = false;

        return response()->json(['success' => $response]);
    }

    public function edit($id){

        $data = Food::whereId($id)->first();
        return response()->json(['data' => $data]);
    }
}
