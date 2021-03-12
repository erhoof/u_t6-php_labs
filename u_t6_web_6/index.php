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
    $rowCount = 0;
    $rowColumns = 1;
    $fullData = array();

    $first = true;
    if (($handle = fopen("text.txt", "r")) !== FALSE) {
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

    ?>
    </table>
</body>
</html>
