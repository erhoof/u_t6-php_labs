<?php
include_once('ExamResult.php');

/**
 * Gaining data from file
 * @param string    $filename   Filename
 * @param string    $separator  CSV Separator
 *
 * @return array    Full Data from file
 */
function getFromCSV(
    $filename,
    $separator)
{
    // Array of Exam Results
    $fullData = array();

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

                $result = new ExamResult();

                $result->setStudentName($data[0]);
                $result->setDiscipline($data[1]);
                $result->setGrade($data[2]);
                $result->setTeacherName($data[3]);
                $result->setDate($currentDate);

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
        if ($student->getDiscipline() == $discipline) {
            array_push($result, $student);
        }
    }

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
        $studentRows .= $st->getTableRow();
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