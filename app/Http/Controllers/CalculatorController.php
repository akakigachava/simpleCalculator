<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function calculate(Request $request)
    {

        $num1 = $request->input('num1');
        $num2 = $request->input('num2');
        $operator = $request->input('operator');

        if ($num1 === null || $num1 === '' || $num2 === null || $num2 === '' || $operator === null) {
           return response()->json(['error'=>'Please enter all the required fields'],400);
       }

        if($operator=='add'){
            $result = $num1 + $num2;
        }
        else if($operator=='subtract'){
            $result = $num1 - $num2;
        }
        else if($operator=='divide'){
            if($num2==0){
                return response()->json(['error' => 'Cannot divide by zero'], 400);
            }
            $result = $num1 / $num2;
        }
        else{
            $result = $num1 * $num2;
        }
        return response()->json(['result' => $result]);
    }
}
