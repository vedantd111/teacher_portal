<?php
// delete_student.php
session_start();
require 'models/Student.php';

$id = $_GET['id'];

$studentModel = new Student($pdo);
$studentModel->deleteStudent($id);

header('Location: home.php');
?>