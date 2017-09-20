<?php

/* Лабораторна работа 6.
 * Devise a function that gets one word as parameter 
 * and returns all the anagrams for it from the file words.txt.
 * "Anagram": An anagram is a type of word play, the result of rearranging 
 * the letters of a word or phrase to produce a new word or phrase,
 * using all the original letters exactly once; for example
 * orchestra can be rearranged into carthorse.
 * 
 * You can not use permutations to generate the possible words.
 * anagrams("horse") should return:
 * ['heros', 'horse', 'shore']
 * 
 * Copyright (C) 2017 Алексей Тихонов (tixonb@gmail.com)
 */

$word = "heros";
print_r(search_anagram($word));

function search_anagram($word) {
    $anagrams = []; //массив для хранения анагарамм
    $sort_word = sort_word($word); //сортируем символы слова в алфавитном порядке
    $file = fopen("words.txt", "r"); //открываем текстовый файл для чтения
    // читаем построчно до конца файла
    while(!feof($file)) { 
        $word_from_file = fgets($file); //текущее слово из файла 
        $sort_word_from_file = sort_word($word_from_file); //сортируем в алфавитном порядке символы слова, прочитанного из файла
        /* сравниваем отсортированные слова */
        if ($sort_word === $sort_word_from_file) {
            $anagrams[] = $word_from_file;
        }
    }
    fclose($file);
    return $anagrams;
}

/* функция сортировки символов массива в алфавитном порядке */

function sort_word($word) {
    $word_from_file = trim($word); // удаляем пробелы из строки
    $split_word = str_split($word_from_file); //преобразуем строку в массив
    sort($split_word, SORT_STRING); //отсортируем массив в алфавитном порядке
    return implode($split_word); //преобразуем массив в строку
}
