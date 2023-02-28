@extends('../app')
@section('content')

@php
    function isAssoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
@endphp
@include('json.expandable_object', ['json' => $json])
