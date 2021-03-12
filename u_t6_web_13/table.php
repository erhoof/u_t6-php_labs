<?php
/**
 * Fetch table from SQL
 * @param array dict    Dictionray with req params [param=value]
 *
 * @return array    Array of table rows
 */
function fetchData (array $dict)
{
    // Set SQL Server
    $link = mysql_connect('localhost', 'root', '')
    or die('Ошибка соединения с SQL ' . mysql_error());

    // Set DB
    mysql_select_db('csv_db')
    or die('<br>Ошибка установки DB');

    // Set UTF-8
    mysql_query('SET CHARACTER SET utf8',$link);
    mysql_query("set NAMES utf8");

    // Form query
    $query = "SELECT * FROM main_table\n";

    if (!empty($dict)) {
        $query .= 'where ';

        foreach ($dict as $key => $value) {
            if (empty($value))
                continue;

            $query .= "$key = '$value' AND \n";
        }

        $query = mb_substr($query, 0, -5);
    }

    // Query result
    $result = mysql_query($query);

    // Finalized data
    $finalized = array();
    $rowCount = 0;
    while ($data = mysql_fetch_row($result))
        $finalized[$rowCount++] = $data;

    return $finalized;
}

/**
 * Form HTML row
 * @param data array of cells
 *
 * @return string   html table row
 */
function showAsHTML($data)
{
    $row = '<tr>';
    foreach ($data as $cell)
        $row .= "<td>$cell";

    return $row;
}

$params = array();
$params["ФИО"]    = $_POST["name"];
$params["Город"]    = $_POST["city"];
$params["телефон"]  = $_POST["number"];

$data = fetchData($params);
?>

<table border="1">
    <th>
        <td>ФИО</td>
        <td>Должность</td>
        <td>телефон</td>
        <td>Город</td>
        <td>Дом_улица_кв</td>
    </th>
    <?php
        foreach ($data as $row)
            echo showAsHTML($row);
    ?>
</table>

