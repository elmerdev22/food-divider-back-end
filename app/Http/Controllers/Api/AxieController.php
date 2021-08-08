<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AxieController extends Controller
{
    public function index($ronin_address){
        $ronin_address = Str::replace('ronin:', '0x', $ronin_address);
        $response      = Http::get('https://api.lunaciarover.com/stats/'.$ronin_address);
        return $response;
    }
    
    public function all(Request $request){

        $collection = json_decode($request->data);
        $data       = [];

        foreach($collection as $item){

            $details              = self::index($item->roninAddress);
            $updated_on           = Carbon::createFromTimestamp($details['updated_on'])->format('F d, Y h:i:s a');
            $last_claim_timestamp = Carbon::createFromTimestamp($details['last_claim_timestamp'])->format('F d, Y h:i:s a');
            $next_claim_timestamp = Carbon::createFromTimestamp($details['last_claim_timestamp'])->addDays(14)->format('F d, Y h:i:s a');;

            $now                  = Carbon::now();
            $last_claim_datetime  = Carbon::parse(Carbon::createFromTimestamp($details['last_claim_timestamp'])->format('Y-m-d'));
            $last_claim_date_diff = $last_claim_datetime->diffInDays($now);

            $data[] = [
                'roninAddress'       => $item->roninAddress,
                'scholarName'        => $item->scholarName,
                'managerShare'       => $item->managerShare,
                'scholarShare'       => 100 - $item->managerShare,
                'ign'                => $details['ign'],
                'lastClaimDateDiff'  => $last_claim_date_diff,
                'totalSlp'           => $details['total_slp'],
                'inGameSlp'          => $details['in_game_slp'],
                'updatedOn'          => $updated_on,
                'lastClaimTimestamp' => $last_claim_timestamp,
                'nextClaimTimestamp' => $next_claim_timestamp,
                'lastClaimAmount'    => $details['last_claim_amount'],
                'gameStatsSuccess'   => $details['game_stats_success'],
                'winRate'            => $details['win_rate'],
                'totalMatches'       => $details['total_matches'],
                'mmr'                => $details['mmr'],
                'rank'               => $details['rank'],
                'slpSuccess'         => $details['slp_success'],
                'roninSlp'           => $details['ronin_slp'],
            ];
        }

        return response()->json($data);
    }
}
