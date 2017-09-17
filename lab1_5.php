<?php

/* Лабораторна работа 5.
 * Devise a function that takes an input 'n' (integer) and returns a string that is the
 * decimal representation of that number grouped by commas after every 3 digits. You can't
 * solve the task using a built-in formatting function that can accomplish the whole
 * task on its own.
 * 
 * Assume: 0 <= n < 1000000000
 * 
 * 1 -> "1"
 * 10 -> "10"
 * 100 -> "100"
 * 1000 -> "1,000"
 * 10000 -> "10,000"
 * 100000 -> "100,000"
 * 1000000 -> "1,000,000"
 * 35235235 -> "35,235,235"
 * 
 * Copyright (C) 2017 Алексей Тихонов (tixonb@gmail.com)
 */

$n = 1000000; //число

function int_format($n) {
    $n = (string) $n; //преобразуем число в строку
    $len = strlen($n); //размер(длина) строки, соответствующее кол-ву цифр в числе 
    $first = $len % 3; //первая часть числа до запятой
    $num = intdiv($len, 3); //кол-во частей числа, состоящих из 3х цифр
    $str = ""; //возвращаемое значение
    $j = 0;
    while ($num >= 0) {
        for ($i = $j; $i < $first; $i++) {
            $str .= $n[$i];
        }
        $j = $first;
        $first += 3;
        $num--;
        if ($num >= 0) {
            $str .= ",";
        }
    }
    return $str;
}

echo int_format($n);
