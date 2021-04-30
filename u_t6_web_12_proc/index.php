<?php
function u_getTableRow(
    array $note)
{
    return "
    <tr>
        <td>$note[1]</td>
        <td>$note[2]</td>
        <td>$note[3]</td>
        <td>$note[4]</td>
    </tr>";
}

function u_setStudentName(
    $name,
    array $note)
{
    $words = explode(' ', $name);
    foreach ($words as $word)
        $note[1] .= mb_strtoupper(
            mb_substr($word, 0, 1), "utf-8")
            . mb_substr($word, 1) . ' ';

    $note[1] = mb_substr($note[1], 0, -1);
    return $note;
}

function u_setDiscipline(
    $discipline,
    array $note)
{
    $disPatterns = array('/Про/', '/Мат/', '/Физ/');
    $disReplacements = array('Программирование', 'Математика', 'Физика');

    $note[0] = substr($discipline, 0, 6);

    $note[0] = preg_replace($disPatterns, $disReplacements, $note[0]);

    return $note;
}

function u_setGrade(
    $grade,
    array $note)
{
    $note[2] = $grade;

    $note[2] = substr($grade, 0, 6);

    $note[2] = preg_replace('/уд\.|удо/', 'уд', $note[2]);

    $note[2] .= '.';

    return $note;
}

function getFromCSV(
    $filename,
    $separator)
{
    // Array of Exam Results
    $fullData = array(); // DIS : NAME : GRADE : DATE : TEACHER

    // Open file
    $handle = fopen($filename, 'r');
    if ($handle != TRUE)
        return array();

    // Read File Line By Line
    $gotTableHeader = false; // Check if got table header "Дата Проведения 01.01.2020" extracted
    $columnsReady = false; // Header prepared
    $currentDate = ""; // Current Date
    while (($data = fgetcsv($handle, 0, $separator)) !== FALSE) {

        // 1. Skip empty lines and reset Header Flag
        if ($data[0] == '') {
            $gotTableHeader = false;
            continue;
        }

        // 2. Get Table Values OR try to find next header
        if ($gotTableHeader) {

            if ($columnsReady) {

                $result = array('', '', '', '', '');
                $result = u_setStudentName($data[0], $result);
                $result = u_setDiscipline($data[1], $result);
                $result = u_setGrade($data[2], $result);
                $result[4] = $data[3];
                $result[3] = $currentDate;
                /*$result = new ExamResult();

                $result->setStudentName($data[0]);
                $result->setDiscipline($data[1]);
                $result->setGrade($data[2]);
                $result->setTeacherName($data[3]);
                $result->setDate($currentDate);

                array_push($fullData, $result)*/
                array_push($fullData, $result);

            } else {
                $columnsReady = true;
            }

        } else {
            $curTableHeader = explode(' ', $data[0]);

            // Skip entry line or set Header
            if ($curTableHeader[0] == "Результаты") {
                continue;
            } else if ($curTableHeader[1] == "Дата") {
                $currentDate = $curTableHeader[3];

                $gotTableHeader = true;
                $columnsReady = false;
            }
        }
    }

    fclose($handle);

    echo "<p> Записей: " . count($fullData) . '</p>';

    return $fullData;
}

/**
 * Get Discipline Students
 * @param array    $students   Array of Students
 * @param string   $discipline  Discipline name
 *
 * @return array    Array of students with this discipline
 */
function getStudentsOf(
    array $students,
    $discipline)
{
    $result = array();

    foreach ($students as $student) {
        if ($student[0] == $discipline) {
            array_push($result, $student);
        }
    }

    echo count($result);
    
    return $result;
}

/**
 * Get Table with Students of Discipline
 * @param array     $students   Array of Students
 * @param string    $discipline Discipline Name
 *
 * @return string   HTML Table with <p> header
 */
function getTableOf(
    array $students,
    $discipline)
{
    $disStudent = getStudentsOf($students, $discipline);

    $studentRows = "";
    foreach ($disStudent as $st) {
        $studentRows .= u_getTableRow($st);
    }

    return "
    <p style='width:50%; text-align: center;'>$discipline:</p>
    <table border='1' style='width:50%'>
        <tr>
            <th>ФИО студента</th>
            <th>Оценка</th>
            <th>Дата сдачи</th>
            <th>Преподаватель</th>
        </tr>
        $studentRows
    </table>
    ";
}

$fullData = getFromCSV('Exam.txt', "\t");

echo getTableOf($fullData, 'Математика');
echo getTableOf($fullData, 'Физика');
echo getTableOf($fullData, 'Программирование');