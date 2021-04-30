<?php

class ExamResult
{

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
        $words = explode(' ', $name);
        foreach ($words as $word)
            $this->studentName .= mb_strtoupper(
                mb_substr($word, 0, 1), "utf-8")
                . mb_substr($word, 1) . ' ';

        $this->studentName = mb_substr($this->studentName, 0, -1);
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