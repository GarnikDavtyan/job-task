<?php

namespace App\Http\Controllers;

use App\Models\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JsonController extends Controller
{
    public function createJson(Request $request)
    {
        $this->validate($request, [
            'json' => 'required|json'
        ]);
        
        $timeStart = microtime(true);
        $memoryStart = memory_get_peak_usage();

        $json = Json::create([
            'user_id' => Auth::id(),
            'json' => $request->json
        ]);
        
        $duration = microtime(true) - $timeStart;
        $memoryUsage = memory_get_peak_usage() - $memoryStart;
        
        return [ 
                'id' => $json->id,
                'query_time' => $duration * 1000,
                'query_memory_used' => $memoryUsage
            ];
    }
}
