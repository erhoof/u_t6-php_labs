<?php
/**
 * Form table cell - Получить строки формы
 * @param int   $red    red color
 * @param int   $green  green color
 * @param int   $blue   blue color
 *
 * @return string table cell
 */
function CreateColorCell(
    $red,
    $green,
    $blue)
{
    $redHex = fixHex(dechex($red));
    $greenHex = fixHex(dechex($green));
    $blueHex = fixHex(dechex($blue));

    #return "<td style='background-color: rgb($red, $green, $blue);'>$red $green $blue</td>";
    return "<td bgcolor=" . $redHex . $greenHex . $blueHex .">$red $green $blue</td>";
}

function fixHex($hex)
{
    if (strlen($hex) == 1) {
        return '0' . $hex;
    }

    return $hex;
}

/**
 * Prepare array of color values - Получить варианты чисел
 * @return int[] color values
 */
function GetColorCodes()
{
    $result = [];

    $begin = $_POST['begin'];
    $end = $_POST['end'];
    $step = $_POST['step'];

    if ($step == null) { $step = 1; alert(); }
    if ($begin == null) { $begin = 0; alert(); }
    if ($end == null) { $end = 10; alert(); }

    if ($end < $begin && $step > 0) { $step = -1; alert(); }
    if ($end > $begin && $step < 0) { $step = 1; alert(); }

    if ($end < $begin && $step < ($begin - $end)) { $step = -1; alert(); }
    if ($end > $begin && $step > ($end - $begin)) { $step = 1; alert(); }

    for ($i = $begin; $i <= $end; $i += $step) {
        $result[] = $i;
    }

    return $result;
}

function alert() {
    echo "<script type='text/javascript'>alert('Ошибка формата ввода');</script>";
}

?>

<!-- Set StyleSheets - Установить стили -->
<style>
    table {
        color: white;
        text-align: center;

        width: 12em;
    }

    td {
        font-size: 0.8em;
    }

    #table-label {
        font-size: 1.3em;
    }
</style>

<!-- Prepare table - Подготовить таблицу -->
<table border="1">
    <tr>
        <td
            colspan="3"
            rowspan=""
            style="background-color: blueviolet"
            id="table-label">
            Коды цветов. Модель RGB
        </td>
    </tr>

    <tr>
        <th style="background-color: red">красный</th>
        <th style="background-color: lawngreen">зеленый</th>
        <th style="background-color: blue">синий</th>
    </tr>

    <?php
        $colorCodes = GetColorCodes();

        foreach($colorCodes as $color)
        {
            ?>

            <!-- Show table rows - Показать строки таблицы -->
            <tr>
                <?php echo CreateColorCell($color, 0, 0); ?>
                <?php echo CreateColorCell(0, $color, 0); ?>
                <?php echo CreateColorCell(0, 0, $color); ?>
            </tr>

            <?php
        }
    ?>
</table>