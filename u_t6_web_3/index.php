<!DOCTYPE html>
<html lang="ru_RU">
<head>
    <meta charset="UTF-8">
    <title>u_t6_web_3</title>

    <style>
        table, th, td {
            border: 1px solid #f08080;
            border-collapse: collapse;
        }

        th, td {
            padding: 5px;
        }

        label {
            display: inline-block;
            width: 150px;
            text-align: right;
        }
    </style>
</head>
<body>
    <h3>Таблица синусов</h3>
    <form action="index.php" method="post">
        <p>Укажите формат ввода до\после запятой</p>

        <div>
            <label for="before">До запятой </label>
            <input type="number" name="before" value=5>
        </div>

        <div>
            <label for="after">После запятой </label>
            <input type="number" name="after" value=3>
        </div><br>

        <input type="submit" value="Перевести">
    </form><br>
    <table>
        <tr>
            <th colspan="2">Угол</th>
            <th rowspan="2">Синус</th>
        </tr>
        <tr>
            <th>В градусах</th>
            <th>В радианах</th>
        </tr>
        <?php
            $before = $_POST["before"];
            echo $format;
            $after = $_POST["after"];

            if ($before == null || (int)$before > 10)
                $before = 5;

            if ($after == null || (int)$after > 10)
                $after = 5;

            $format = "%{$before}.{$after}f";

            for ($i = 0; $i <= 90; $i += 5) {
                $rad = deg2rad($i);
                $sin = sin($rad);
                $radFormat = sprintf($format, $rad);
                $sinFormat = sprintf($format, $sin);

                echo "  <tr>
                            <th align='right'>$i</th>
                            <th align='right'>$radFormat</th>
                            <th align='left'>$sinFormat</th>
                        </tr>";
            }
        ?>
    </table>
</body>
</html>