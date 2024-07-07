<?php
// add_student.php

session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/Student.php';

$name = $_POST['name'];
$subject = $_POST['subject'];
$marks = $_POST['marks'];

$studentModel = new Student($pdo);

// Check if a student with the same name and subject combination already exists
$existingStudent = $studentModel->findStudentByNameAndSubject($name, $subject);

if (!$existingStudent) {
    // Add new student if not exists
    $studentModel->addStudent($name, $subject, $marks);
}

header('Location: home.php');
?>