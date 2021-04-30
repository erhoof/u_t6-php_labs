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
    $power)
{
    $result = 0;

    for ($i = $begin - 1; $i < $end; $i++) {
        if ($_POST["log"] == true)
            $result += powLog($numbers[$i], $power);
        else
            $result += pow($numbers[$i], $power);
    }

    return $result;
}

function powLog(
    $src,
    $exp)
{
    return exp($exp * log($src));
}

echo 'Вычисление...<p>';

$csvData = $_POST["line"];
if ($csvData == '') {
    echo 'Чтение из файла<p>';

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $target_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadStatus = 1;

    if ($target_file_type != "txt" && $target_file_type != "csv") {
        echo "Возможна загрузка только TXT, CSV файлов";
        $uploadStatus = 0;
    }

    if ($uploadStatus) {
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
        $file = fopen($target_file, 'r');
        $csvData = fgetcsv($file);
        fclose($file);
    }
} else {
    $csvData = str_getcsv($csvData);
}

$numberCount = count($csvData);

$s1 = calculate($csvData, 1, $numberCount, 1);
$s2 = calculate($csvData, 2, $numberCount - 1, 2);
$s3 = calculate($csvData, 1, $numberCount - 2, 1.0/2.0);
$s4 = calculate($csvData, 1, $numberCount - 2, 2.0/3.0);
    
// Расчет
#$s1_func = function($n) { return $n; };
#$s1 = calculate($fileData, 1, $numberCount, $s1_func);

#$s2_func = function($n) { return $n*$n; };
#$s2 = calculate($fileData, 2, $numberCount - 1, $s2_func);

#$s3_func = function($n) { return sqrt($n); };
#$s3 = calculate($fileData, 1, $numberCount - 2, $s3_func);

#$s4_func = function($n) { return sqrt($n); };
#$s4 = calculate($fileData, 1, $numberCount, $s4_func);

// Вывод результата
echo "s1: $s1 <br>";
echo "s2: $s2 <br>";
echo "s3: $s3 <br>";
echo "s4: $s4 <br>";

// Вывод конечной суммы
$result = ($s1 + $s2) / ($s3 + $s4);
echo "<br>Результат: $result";

echo '<p><a href="index.html">Переход на страницу ввода</a>';
