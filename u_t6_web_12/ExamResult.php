<?php

class ExamResult
{
    private $studentName = "SN";
    private $discipline = "";
    private $grade = "g.";
    private $date = "01.01.1970";
    private $teacherName = "SN";

    // Discipline Replace Patterns (Repl goes backwards!)
    private $disPatterns = array('/Про/', '/Мат/', '/Физ/');
    private $disReplacements = array('Программирование', 'Математика', 'Физика');

    /**
     * Generate TableRow
     *
     * @return string   HTML <tr>
     */
    public function getTableRow()
    {
        return "
        <tr>
            <td>$this->studentName</td>
            <td>$this->grade</td>
            <td>$this->date</td>
            <td>$this->teacherName</td>
        </tr>
        ";
    }

    /**
     * Set StudentName
     * @param string    $name   Student Name
     */
    public function setStudentName($name)
    {
        $this->studentName = ucwords($name, ' '); // Capitalize Every Word
    }

    /**
     * Set Discipline
     * @param string    $discipline   Discipline
     */
    public function setDiscipline($discipline)
    {
        $this->discipline = substr($discipline, 0, 6);

        $this->discipline = preg_replace($this->disPatterns, $this->disReplacements, $this->discipline);
    }

    /**
     * Get Discipline
     *
     * @return string    $discipline   Discipline
     */
    public function getDiscipline()
    {
        return $this->discipline;
    }

    /**
     * Set Grade (String)
     * @param int    $grade   Grade
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        $this->grade = substr($grade, 0, 6);

        $this->grade = preg_replace('/уд\.|удо/', 'уд', $this->grade);

        $this->grade .= '.';
    }

    /**
     * Set Date
     * @param string    $date   Date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Set Teacher Name
     * @param string    $name   Teacher Name
     */
    public function setTeacherName($name)
    {
        $this->teacherName = $name;
    }
}