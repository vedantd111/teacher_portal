<?php
require_once dirname(__DIR__) . '/config/database.php';

class Student
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllStudents()
    {
        $stmt = $this->pdo->query('SELECT * FROM students');
        return $stmt->fetchAll();
    }

    public function addStudent($name, $subject, $marks)
    {
        $stmt = $this->pdo->prepare('INSERT INTO students (name, subject, marks) VALUES (?, ?, ?)');
        return $stmt->execute([$name, $subject, $marks]);
    }

    public function updateStudentMarks($name, $subject, $marks)
    {
        $stmt = $this->pdo->prepare('UPDATE students SET marks = marks + ? WHERE name = ? AND subject = ?');
        return $stmt->execute([$marks, $name, $subject]);
    }

    public function findStudentByNameAndSubject($name, $subject)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM students WHERE name = ? AND subject = ?');
        $stmt->execute([$name, $subject]);
        return $stmt->fetch();
    }

    public function editStudent($id, $name, $subject, $marks)
    {
        $stmt = $this->pdo->prepare('UPDATE students SET name = ?, subject = ?, marks = ? WHERE id = ?');
        return $stmt->execute([$name, $subject, $marks, $id]);
    }

    public function deleteStudent($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM students WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
?>
