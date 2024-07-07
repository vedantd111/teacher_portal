<?php
session_start();
require 'models/Student.php';

$id = $_POST['id'];
$name = $_POST['name'];
$subject = $_POST['subject'];
$marks = $_POST['marks'];

$studentModel = new Student($pdo);
$studentModel->editStudent($id, $name, $subject, $marks);

header('Location: home.php');
?>