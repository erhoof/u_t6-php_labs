<?php
/**
 * @param int[]     $numbers    массив чисел
 * @param int       $begin      начало интервала
 * @param int       $end        конец интервала
 * @param callable  $func       используемая функция
 *
 * @return int  результат вычисления
 */
function calculate(
    array $numbers,
    $begin,
    $end,
    callable $func)
{
    $result = 0;

    for ($i = $begin - 1; $i < $end; $i++)
        $result += $func($numbers[$i]);

    return $result;
}

// Открытие файла
$file = fopen("numbers.txt", "r");
$fileData = fgetcsv($file);
fclose($file);
$numberCount = count($fileData);
    
// Расчет
$s1_func = function($n) { return $n; };
$s1 = calculate($fileData, 1, $numberCount, $s1_func);

$s2_func = function($n) { return $n*$n; };
$s2 = calculate($fileData, 2, $numberCount - 1, $s2_func);

$s3_func = function($n) { return sqrt($n); };
$s3 = calculate($fileData, 1, $numberCount - 2, $s3_func);

$s4_func = function($n) { return sqrt($n); };
$s4 = calculate($fileData, 1, $numberCount, $s4_func);

// Вывод результата
echo "s1: $s1 <br>";
echo "s2: $s2 <br>";
echo "s3: $s3 <br>";
echo "s4: $s4 <br>";

// Вывод конечной суммы
$result = ($s1 + $s2) / ($s3 + $s4);
echo "<br>Результат: $result";
