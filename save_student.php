<?php
// save_student.php

session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/Student.php';

$id = $_POST['id'];
$name = $_POST['name'];
$subject = $_POST['subject'];
$marks = $_POST['marks'];

$studentModel = new Student($pdo);

if ($id) {
    $studentModel->editStudent($id, $name, $subject, $marks);
} else {

    $existingStudent = $studentModel->findStudentByNameAndSubject($name, $subject);

    if ($existingStudent) {
     
        $_SESSION['error'] = 'Student with the same subject already exists.';
        header('Location: home.php');
        exit;
    }

    $studentModel->addStudent($name, $subject, $marks);
}

header('Location: home.php');
?>