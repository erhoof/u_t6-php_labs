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
    </style>
</head>
<body>
    <h3>Таблица синусов</h3>
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
            for ($i = 0; $i <= 90; $i += 5) {
                $rad = deg2rad($i);
                $sin = sin($rad);
                $radFormat = sprintf("%5.3f", $rad);
                $sinFormat = sprintf("%5.3f", $sin);

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