<?php

namespace App\Http\Controllers\traits;

trait ArrayTrait {

    public function extractArray($keys, $values, $separator = '=', $upper = false)
    {
        $array = [];

        for($i = 0; $i < count($keys); $i++){
            if(isset($keys[$i]) && $values[$i]){
                $val = ($upper ? strtoupper($keys[$i]) : $keys[$i]).$separator.$values[$i];
                $array[] = $val;
            }
        }

        return $array;
    }

    public function extractLabels($request)
    {
        $labelKeys = $request->LabelKeys;
        $labelValues = $request->LabelValues;
        
        $labels = [];

        for($i = 0; $i < count($labelKeys); $i++){
            if(isset($labelKeys[$i]) && isset($labelValues[$i])){
                $labels[$labelKeys[$i]] = $labelValues[$i];
            }
        }
        
        return $labels;
    }

    public function extractArrayKey($keys, $values)
    {
        $array = [];

        for($i = 0; $i < count($keys); $i++){
            if(isset($keys[$i]) && isset($values[$i])){
                $array[$keys[$i]] = $values[$i];
            }
        }
        
        return $array;
    }

    public function removeNull($array, $index = 0)
    {
        unset($array[$index]);
        return $array;
    }
}