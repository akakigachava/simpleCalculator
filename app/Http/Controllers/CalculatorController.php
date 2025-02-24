<?php

namespace App\Http\Controllers;

use App\Models\Calculation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class CalculatorController extends Controller
{
    /**
     * @throws \Exception
     */
    public function calculate(Request $request)
    {
        try {
            $expression = $request->input('expression');
            $firstExpression = '';
            $operator = '';
            $secondExpression = '';
            $indicator = false;
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
                } else {
                    $secondExpression .= $expression[$i];
                }
            }

            if ($firstExpression === '' || $secondExpression === '') {
                throw new \Exception('please write a valid expression');
            }

            $firstNumber = (int)$firstExpression;
            $secondNumber = (int)$secondExpression;
            $result = 0;

            if ($operator === '+') {
                $result = $firstNumber + $secondNumber;
            }
            if ($operator === '-') {
                $result = $firstNumber - $secondNumber;
            }
            if ($operator === '*') {
                $result = $firstNumber * $secondNumber;
            }
            if ($operator === '/') {
                if ($secondNumber === 0) {
                    throw new \Exception('you cant divide number by zero');
                }
                $result = $firstNumber / $secondNumber;
            }
            Calculation::create(['expression' => $request->expression, 'result' => $result]);
            return Inertia::render('Calculator', [
                'expression' => $expression,
                'result' => $result,
                'errorMessage' => null
            ]);

        } catch (\Exception $e) {
            return Inertia::render('Calculator', [
                'expression' => $expression,
                'result' => $expression,
                'errorMessage' => $e->getMessage()
            ]);
        }
    }
}
