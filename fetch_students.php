<?php
// fetch_students.php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/Student.php';

$studentModel = new Student($pdo);
$students = $studentModel->getAllStudents();

header('Content-Type: application/json');
echo json_encode($students);
?>