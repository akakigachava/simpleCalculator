<?php

namespace App\Http\Controllers;

use App\Models\Calculation;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use function Laravel\Prompts\error;

class CalculatorController extends Controller
{
    public function calculate(Request $request)
    {
        $expression=$request->input('expression');
        $firstExpression='';
        $operator='';
        $secondExpression='';
        $indicator=false;
        $operatorsSet = [
            "+" => true,
            "-" => true,
            "*" => true,
            "/" => true
        ];

        for ($i = 0; $i < strlen($expression); $i++) {
            if (isset($operatorsSet[$expression[$i]])) {
                $operator = $expression[$i];
                $indicator = true;
                continue;
            }
            if (!$indicator) {
                $firstExpression .= $expression[$i];
            }
            else {
                $secondExpression .= $expression[$i];
            }
        }

        if($firstExpression==='' || $secondExpression===''){
            return response()->json(['error'=>'please write valid expression'],400);
        }


        $firstNumber = (int)$firstExpression;
        $secondNumber = (int)$secondExpression;
        $result=0;


        if($operator==='+'){
            $result=$firstNumber+$secondNumber;
        }
        if($operator==='-') {
            $result=$firstNumber-$secondNumber;
        }
        if($operator==='*') {
            $result=$firstNumber*$secondNumber;
        }
        if($operator==='/') {
            if($secondNumber===0){
                return response()->json(['error'=>'you cant divide number by zero'],400);
            }
            $result=$firstNumber/$secondNumber;
        }

        Calculation::create(['expression'=>$request->expression,'result'=>$result]);
        return response()->json(['result'=>$result]);
    }
}
