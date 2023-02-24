<?php

namespace App\Http\Controllers;

use App\Models\Json;
use Error;
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

    public function updateJson(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'code' => [
                'required',
                'regex:/^\$data(->[a-zA-Z0-9_]+)+(\[[0-9]+\])*\s*=\s*\S+;$/'
            ]
        ], [
            'code.regex' => 'The :attribute field must contain a valid JSON manipulation code, starting with "$data->". Example: $data->list->sublist[0] = 0;'
        ]);

        $data = Json::whereId($request->id)->where('user_id', Auth::id())->value('json');
        if (!$data) {
            return response()->json(['message' => 'No record with this ID'], 400);
        }
        $data = json_decode($data);

        try {
            $functionCode = 'return function($data) {' . $request->code . '};';
            $result = call_user_func(eval($functionCode), $data);
        } catch (Error $err) {
            return response()->json(['message' => 'Either the given code doesn\'t match the json or assigned value is wrong'], 400);
        }
        
        $json = json_encode($data);
        Json::whereId($request->id)->update(compact('json'));

        return response()->json(['data' => $json]);
    }
}
