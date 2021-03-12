<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>u_t6_web_6</title>

    <style>
        table, th, td, tr {
            border: 1px solid black;
            font-weight: normal;
        }

        #bold-row {
            font-weight: bold;
        }
    </style>

</head>
<body>
    <?php
    $rowCount = 0;
    $rowColumns = 1;
    $fullData = array();

    $first = true;
    if (($handle = fopen("students.txt", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, separator: "\t")) !== FALSE) {
            if ($first) {
                $rowColumns = count($data);
                $first = false;
            }

            $fullData[$rowCount] = $data;

            $rowCount++;
        }

        fclose($handle);
    }

    // -- Forgein cities students --

    echo "<h3>Список иногородних студентов</h3>
                <table>
                <tr>";

    for ($i = 0; $i < $rowColumns; $i++)
        echo "<th id='bold-row'>" . ($fullData[0][$i]) . "</th>";

    echo "</tr>";

    for ($i = 1; $i < $rowCount; $i++) {
        if ($fullData[$i][3] == "С-Петербург") continue;

        echo "<tr>";

        for ($j = 0; $j < $rowColumns; $j++)
            echo "<th>" . ($fullData[$i][$j]) . "</th>";

        echo "</tr>";
    }
    echo "</table>";

    // END - Forgein

    // -- Local cities students --

    echo "<h3>Местные студенты</h3>
            <table>
            <tr>";
    for ($i = 0; $i < $rowColumns; $i++) {
        if ($fullData[0][$i] == "Город")
            continue;

        echo "<th id='bold-row'>" . ($fullData[0][$i]) . "</th>";
    }
    echo "</tr>";

    for ($i = 1; $i < $rowCount; $i++) {
        if ($fullData[$i][3] != "С-Петербург")
            continue;

        echo "<tr>";

        for ($j = 0; $j < $rowColumns; $j++) {
            if ($fullData[$i][$j] == "С-Петербург")
                continue;

            echo "<th>" . ($fullData[$i][$j]) . "</th>";
        }

        echo "</tr>";
    }

    echo "</table>";

    // END - Local

    // Save new file
    $saveData = array();
    for ($i = 1; $i < count($fullData); $i++) {
        $saveData[$i][0] = $i;

        for($j = 0; $j < $rowColumns; $j++)
            $saveData[$i][$j+1] = $fullData[$i][$j];
    }

    $fp = fopen('out.txt', 'wb');
    foreach ($saveData as $line)
        fputcsv($fp, $line, "\t");
    fclose($fp);
    ?>
</body>
</html>
