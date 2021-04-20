<!DOCTYPE html>
<html lang="ru_RU">
<head>
    <meta charset="UTF-8">
    <title>u_t6_web-4 Результат</title>
    <style>
        table, th, td {
            border: 1px solid #f08080;
            border-collapse: collapse;
        }

        th, td {
            padding: 5px;
        }
    </style>
</head>
<body>
    <h3>Квадраты чисел</h3>
    <table>
        <tr>
            <th> <b>x</b> </th>
            <th> <b>x<sup>2</sup></b> </th>
        </tr>
        <?php
            function alert() {
                echo "<script type='text/javascript'>alert('Ошибка формата ввода');</script>";
            }

            $begin = $_POST["begin"];
            $end   = $_POST["end"];
            $step  = $_POST["step"];

            if ($step == null) { $step = 1; alert(); }
            if ($begin == null) { $begin = 0; alert(); }
            if ($end == null) { $end = 10; alert(); }

            if ($end < $begin && $step > 0) { $step = -1; alert(); }
            if ($end > $begin && $step < 0) { $step = 1; alert(); }

            if ($end < $begin && $step < ($begin - $end)) { $step = -1; alert(); }
            if ($end > $begin && $step > ($end - $begin)) { $step = 1; alert(); }

            for ($i = $begin; $i <= $end; $i += $step) {
                echo "<tr>
                        <th>$i</th>
                        <th>" . ($i*$i) . "</th>
                      </tr>
                     ";
            }
        ?>
    </table>
</body>
</html>