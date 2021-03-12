<!DOCTYPE html>
<html lang="ru_RU">
<head>
    <meta charset="UTF-8">
    <title>Результат</title>
</head>
<body>
<h3>Перевод периода</h3>
    <?php
        $count = $_POST["count"];

        // calc
        $remain = $count;

        // - days
        $days = (int)($remain / 60 / 60 / 24);
        $remain -= $days * 24 * 60 * 60;

        // - hours
        $hours = (int)($remain / 60 / 60);
        $remain -= $hours * 60 * 60;

        // - minutes
        $minutes = (int)($remain / 60);
        $remain -= $minutes * 60;

        echo "Длина периода в секундах - $count <br>";
        echo "Дней - $days<br>";
        echo "Часов - $hours<br>";
        echo "Минут - $minutes<br>";
        echo "Секунд - $remain<br>";
    ?>
</body>
</html>