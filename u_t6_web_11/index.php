<?php
/**
 * Form table cell
 * @param int   $red    red color
 * @param int   $green  green color
 * @param int   $blue   blue color
 *
 * @return string table cell
 */
function CreateColorCell(
    int $red,
    int $green,
    int $blue) : string
{
    return "<td style='background-color: rgb($red, $green, $blue);'>$red $green $blue</td>";
}

/**
 * Prepare array of color values
 * @return int[] color values
 */
function GetColorCodes() : array
{
    $result = [];

    for ($i = 255; $i >= 0; $i -= 15)
        $result[] = $i;

    return $result;
}
?>

<!-- Set StyleSheets -->
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

<!-- Prepare table -->
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

            <!-- Show table rows -->
            <tr>
                <?php echo CreateColorCell($color, 0, 0); ?>
                <?php echo CreateColorCell(0, $color, 0); ?>
                <?php echo CreateColorCell(0, 0, $color); ?>
            </tr>

            <?php
        }
    ?>
</table>