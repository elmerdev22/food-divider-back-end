<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;

class CalendarController extends Controller
{
    public function index(Request $request){
        $data = Food::where('user_id', $request->user()->id)->get();
        return response()->json($data);
    }
}
