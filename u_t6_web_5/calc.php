<!DOCTYPE html>
<html lang="ru_RU">
<head>
    <meta charset="UTF-8">
    <title>u_t6_web_5</title>
</head>
<body>
    <h3>С Р А В Н Е Н И Е  Ц В Е Т О В</h3>

    <?php
        $colorCode = $_POST["colorCode"];
        $colorList = $_POST["colorList"];

        $colors = array (
            "red" =>    "Красный",
            "green" =>  "Зеленый",
            "blue" =>   "Синий"
        );

        echo "<h1 style='color: #$colorCode'> $colorCode </h1>";
        echo "<h1 style='color: $colorList'>" . ($colors["$colorList"]) . "</h1>";

        echo "<a href='#' onclick='history.go(-1)'>Возврат</a>";
    ?>

</body>
</html>