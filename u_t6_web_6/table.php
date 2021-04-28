<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>u_t6_web_6</title>

    <style>
        table, th, td {
            border: 1px solid black;
            font-weight: normal;
        }

        #top-row {
            font-weight: bold;
        }
    </style>

</head>
<body>
    <table>
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

    function buildTable($fileName) {
        $rowCount = 0;
        $rowColumns = 1;
        $fullData = array();

        $first = true;
        if (($handle = fopen($fileName, "r")) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                if ($first) {
                    $rowColumns = count($data);
                    $first = false;
                }

                $fullData[$rowCount] = $data;

                $rowCount++;
            }

            fclose($handle);
        }

        // Form top row
        echo "<tr id='top-row'>";
        for ($i = 0; $i < $rowColumns; $i++)
            echo "<th>" . ($fullData[0][$i]) . "</th>";
        echo "</tr>";

        // Form all other rows
        for ($i = 1; $i < $rowCount; $i++) {
            echo "<tr>";

            for ($j = 0; $j < $rowColumns; $j++)
                echo "<th>" . ($fullData[$i][$j]) . "</th>";

            echo "</tr>";
        }
    }

    ?>
    </table>
</body>
</html>
