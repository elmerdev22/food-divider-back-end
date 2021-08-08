<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class AxieController extends Controller
{
    public function index($ronin_address){
        $collection = Http::get('https://axie-scho-tracker-server.herokuapp.com/api/account/'.$ronin_address);

        $data = [
            'data'        => $collection['slpData'],
            'leaderboard' => $collection['leaderboardData'],
        ];

        return response()->json($data, 200);
    }
}
