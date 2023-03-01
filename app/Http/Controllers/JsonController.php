<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJsonRequest;
use App\Http\Requests\UpdateJsonRequest;
use App\Models\Json;
use Illuminate\Support\Facades\Auth;

class JsonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jsons = Json::with('user')->get();

        return view('json.index', compact('jsons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('json.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreJsonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJsonRequest $request)
    {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $json = Json::findOrFail($id)->json;
        $json = json_decode($json);
        
        return view('json.show', compact('json'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('json.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateJsonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJsonRequest $request)
    {
        $data = Json::whereId($request->id)->where('user_id', Auth::id())->value('json');
        if (!$data) {
            return response()->json(['message' => 'No record with this ID'], 400);
        }
        
        /*
            Split the code into expession and value parts. 
            ex: $code = '$data->a[1]->b->c[0][1] = 1' 
            into $expression = '$data->a[1]->b->c[0][1]' and $assignableValueString = '1'
        */
        $codeSplitted = explode("=", $request->code);
        $expression = trim($codeSplitted[0]);
        $assignableValueString = rtrim(trim($codeSplitted[1]), ';');
        
        //Check if $assignableValue is valid and convert it into actual type by json_decode
        $assignableValue = json_decode($assignableValueString);
        if (strtolower($assignableValueString) !== 'null' && is_null($assignableValue)) {
            return response()->json(['message' => 'The assignable value is not valid'], 422);
        }
        //Remove '$data->' part
        $expression = substr($expression, 7);
        /*
            Split $expression into separate properties.
            ex: $expression = 'a[1]->b->c[0][1]'
            into $properties = ['a[1]', 'b', 'c[0][1]']
        */
        $properties = explode('->', $expression);
        
        $data = json_decode($data, true);
        $value = &$data;
        foreach ($properties as $property) {
            /*
                Split $property like 'c[0][1]' 
                into $property = 'c' and $indexes = [0, 1]
            */
            $pattern = '/^(\w+)((\[\d+\])+)$/';
            preg_match($pattern, $property, $matches);
            if (count($matches)) {
                $property = $matches[1];
                $indexes = explode('][', trim($matches[2], '[]'));  
                $value = &$value[$property];
                foreach($indexes as $index) {
                    $value = &$value[$index];
                }
            } else {
                $value = &$value[$property];
            }
        }
        $value = $assignableValue;
        $json = json_encode($data);
        Json::whereId($request->id)->update(compact('json'));

        return response()->json(['data' => $json]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $json = Json::find($id);
        $json->delete();

        return to_route('jsons.index');
    }
}
