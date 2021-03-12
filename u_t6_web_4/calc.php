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
            $begin = $_POST["begin"];
            $end   = $_POST["end"];
            $step  = $_POST["step"];

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