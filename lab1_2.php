<?php

/* Лабораторна работа 2.
 * Напишите на PHP функцию, получающую на входе строку, 
 * содержащую математическое выражение в обратной польской нотации 
 * (например, «5 8 3 + *»), и возвращающую значение этого выражения (в примере — 55).
 * 
 * Copyright (C) 2017 Алексей Тихонов (tixonb@gmail.com)
 */

$expr = '5 8 3 + *';
echo "Обратная польская запись: " . $expr . "<br>";

echo math($expr);

function math($str) {
    $stack = array(); //стек
    /* обрабатываем обратную польскую запись слева направо.
     * для этого разбиваем строку на подстроки, используя в качестве разделителя  пробел - " "
     * так как каждый операнд(оператор) выражения (обратной польской записи) в строке разделен пробелом.
     */
    $substr = strtok($str, ' '); //получаем первый операнд(оператор) выражения
    while ($substr !== false) {
        if (is_numeric($substr)) { //если подстрока является операндом (числом)
            array_push($stack, $substr); //подстроку помещаем в стек
        } else if (in_array($substr, array('+', '-', '*', '/', '^'))) { //если символ является оператором
            //стек должен содержать не менее 2х операндов, 
            //над которыми совершается действие, задаваемое оператором.
            if (count($stack) < 2) {
                throw new Exception("Недостаточно данных в стеке для операции '$substr'");
            }
            /* извлекаем два операнда из стека */
            $operand2 = array_pop($stack);
            //echo $operand2 . "<br>";
            $operand1 = array_pop($stack);
            //echo $operand1 . "<br>";
            //выполняем заданную оператором операцию
            switch ($substr) {
                case '+': $result = $operand1 + $operand2;
                    break;
                case '-': $result = $operand1 - $operand2;
                    break;
                case '*': $result = $operand1 * $operand2;
                    break;
                case '/': $result = $operand1 / $operand2;
                    break;
                case '^': $result = pow($operand1, $operand2);
                    break;
            }
            //результат выполнения операции помещаем в стек
            array_push($stack, $result);
        } else {
            throw new Exception("Недопустимый символ в выражении: $substr");
        }
        //получаем следующий операнд(оператор) выражения
        $substr = strtok(' ');
    }
    if (count($stack) > 1) {
        throw new Exception("Количество операторов не соответствует количеству операндов");
    }
    return "Ответ: " . array_pop($stack);
}
