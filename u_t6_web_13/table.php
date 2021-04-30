<?php
/**
 * Fetch table from SQL - Получить данные из SQL таблицы (legacy)
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
    $query = "SELECT * FROM tbl_name\n";

    if (!empty($dict)) {
        $query .= 'where ';

        foreach ($dict as $key => $value) {
            if (empty($value))
                continue;
            echo $key . '<p>';

            $likeStr = processLike($key, $value);
            $query .= "$key" . $likeStr . " AND \n";
        }

        $query = mb_substr($query, 0, -5);
        echo $query;
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

function processLike(
    $key,
    $value)
{
    $value = mysql_real_escape_string($value);

    switch ($_POST[('chooseList_' . $key)]) {
        case 'word':
            return " = '$value'";
        case 'begin':
            return " LIKE '$value%'";
        case 'end':
            return " LIKE '%$value'";
        case 'mid':
            return " LIKE '%$value%'"; 
    }
}

/**
 * Form HTML row - Сформировать строку HTML
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
$params["Должность"]  = $_POST["position"];

$data = fetchData($params);
?>

<table border="1">
    <tr>
        <td>ФИО</td>
        <td>Должность</td>
        <td>телефон</td>
        <td>Город</td>
        <td>Дом_улица_кв</td>
    </tr>
    <?php
        foreach ($data as $row)
            echo showAsHTML($row);
    ?>
</table>

