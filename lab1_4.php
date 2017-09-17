<?php
/* Лабораторна работа 4.
 * На картинке у нас есть крыша различной высоты. 
 * Картинка представлена массивом целых чисел, где индекс — это точка на оси X, 
 * а значение каждого индекса — это глубина крыши (значение по оси Y). 
 * Теперь представьте: идет дождь. Сколько воды соберется в «лужах» между пазами крыши?
 * 
 * Copyright (C) 2017 Алексей Тихонов (tixonb@gmail.com)
 */

/* решение задачи следующее:
 * 1)определяем наибольшее(максимальное) значение,
 * 2)проходим по каждому элементу массива:
 * - сначала слева до максимального элемента,
 * - затем справа.
 */

//формируем значения элементов массива случайным образом
for ($i = 0; $i < 9; $i++) {
    $graphic[] = rand(1, 9);
}
$water = [];
$json_graphic = json_encode($graphic);

function volume($graphic) {
    global $water;
    $left = 0; // индекс первого элемента
    $right = count($graphic) - 1; //индекс последнего элемента
    $max = max($graphic); //определяем максимальный элемент массива
//условно разбиваем массив на две части (области): 
//1 - все, что слева от максимального элемента, 2 - все, что справа от максимального элемента 
    /* максимальные элементы левой и правой частей массива соответственно */
    $leftmax = $graphic[$left]; //за максимальный элемент левой части считаем первый элемент
    $rightmax = $graphic[$right]; //за максимальный элемент правой части считаем последний элемент
    $volume = 0; //объем воды

    /* когда максимальный элемент единственный, то достаточно двух проходов: слева и справа;
     * при этом, при достижении максимума, индексы $left и $right должны быть равными
     */
//проход слева до максимума
    while ($leftmax < $max) {
        $left++;
        if ($leftmax < $graphic[$left]) {
            $leftmax = $graphic[$left];
        } else {
            $water[] = [n => $left, max => $leftmax];
            $volume += $leftmax - $graphic[$left];
        }
    }
//проход справа до максимума
    while ($rightmax < $max) {
        $right--;
        if ($rightmax < $graphic[$right]) {
            $rightmax = $graphic[$right];
        } else {
            $water[] = [n => $right, max => $rightmax];
            $volume += $rightmax - $graphic[$right];
        }
    }
    /* случай, когда максимальных элементов несколько;
     * при этом, в результате выполнения проходов слева и справа, индексы $left и $right не равны между собой, 
     * а, значит, необходимо выполнить еще один проход - от левого индека до правого.
     */
    while ($left != $right) {
        //echo $left . " " . $right . "<br>";
        $water[] = [n => $left, max => $max];
        $volume += $leftmax - $graphic[$left];
        $left++;
    }
    return $volume;
}

$volume = volume($graphic);
//print_r($water);
$json_water = json_encode($water);
?>
<canvas id='canvas' width='350' height='350'></canvas>
<script type="text/javascript">
    var canvas = document.getElementById("canvas");
    var context = canvas.getContext("2d");
    context.fillStyle = "black";
    context.moveTo(30, 30);
    context.lineTo(30, 330);
    context.lineTo(330, 330);
    var i = 1;
    for (var x = 60; x < 330; x += 30) {
        context.moveTo(x, 325);
        context.lineTo(x, 335);
        context.fillText(i, x, 345);
        i++;
    }
    for (var y = 60; y < 330; y += 30) {
        i--;
        context.moveTo(25, y);
        context.lineTo(35, y);
        context.fillText(i, 15, y);
    }
    context.fillText(0, 20, 340);
    var graphic = JSON.parse('<?php echo $json_graphic; ?>');
    x = 30;
    y = 330;
    for (var key in graphic) {
        context.moveTo(x, y);
        context.lineTo(x, y - graphic[key] * 30);
        x += 30;
        context.lineTo(x, y - graphic[key] * 30);
        context.lineTo(x, y);
        context.fillStyle = "red";
        context.fillText(graphic[key], x - 20, y - graphic[key] * 30 + 15);
        context.fillStyle = "black";
    }
    var water = JSON.parse('<?php echo $json_water; ?>');
    for (var key in water) {
        context.fillStyle = 'rgb(059,131,189)';
        context.fillRect((water[key]['n'] + 1) * 30, 330 - water[key]['max'] * 30, 30, (water[key]['max'] - graphic[water[key]['n']]) * 30);
    }
    context.stroke();
</script>
<?php
//вывод, собственно, результата выполнения функции
echo "V = " . $volume;
