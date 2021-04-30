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
        buildTable($target_file);
    }

    function buildTable($filename) {
        $localCity = $_POST["city"];
        if ($localCity == '') $localCity = 'С-Петербург';

        $rowCount = 0;
        $rowColumns = 1;
        $fullData = array();
    
        $first = true;
        if (($handle = fopen($filename, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 0, "\t")) !== FALSE) {
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
            if ($fullData[$i][3] == $localCity) continue;
    
            echo "<tr>";
    
            for ($j = 0; $j < $rowColumns; $j++)
                echo "<th>" . ($fullData[$i][$j]) . "</th>";
    
            echo "</tr>";
        }
        echo "</table>";
    
        // END - Forgein
    
        // -- Local cities students --
    
        echo "<h3>Местные студенты ($localCity)</h3>
                <table>
                <tr>";
        for ($i = 0; $i < $rowColumns; $i++) {
            if ($fullData[0][$i] == "Город")
                continue;
    
            echo "<th id='bold-row'>" . ($fullData[0][$i]) . "</th>";
        }
        echo "</tr>";
    
        for ($i = 1; $i < $rowCount; $i++) {
            if ($fullData[$i][3] != $localCity)
                continue;
    
            echo "<tr>";
    
            for ($j = 0; $j < $rowColumns; $j++) {
                if ($fullData[$i][$j] == $localCity)
                    continue;
    
                echo "<th>" . ($fullData[$i][$j]) . "</th>";
            }
    
            echo "</tr>";
        }
    
        echo "</table>";
    }

    // END - Local

    // Save new file
    /*$saveData = array();
    for ($i = 1; $i < count($fullData); $i++) {
        $saveData[$i][0] = $i;

        for($j = 0; $j < $rowColumns; $j++)
            $saveData[$i][$j+1] = $fullData[$i][$j];
    }

    $fp = fopen('out.txt', 'wb');
    foreach ($saveData as $line)
        fputcsv($fp, $line, "\t");
    fclose($fp);*/
    ?>
</body>
</html>
