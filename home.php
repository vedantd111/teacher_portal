<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/Student.php';

$studentModel = new Student($pdo);
$students = $studentModel->getAllStudents();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Portal - Home</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .header-container h1 {
            margin: 0 auto;
            text-align: left;
            margin-left: 50px;
            flex: 1;
            color: red;
        }

        .header-container .nav-links {
            margin-left: auto;
        }

        .header-container .nav-links a {
            margin-right: 10px;
            text-decoration: none;
            color: #000;
        }

        .action-btn {
            padding: 5px 10px;
            background-color: black;
            color: white;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
        }

        .add-btn {
            padding: 10px 20px;
            background-color: black;
            color: white;
            border: none;
            cursor: pointer;
            margin-left: 48px;
            width: 6%;
        }

        .initial {
            display: inline-block;
            width: 20px;
            height: 20px;
            line-height: 20px;
            text-align: center;
            border-radius: 50%;
            background-color: #4CAF50;
            color: white;
            margin-right: 10px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content button {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
        }

        .dropdown-content button:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="header-container">
        <h1>tailwebs</h1>
        <div class="nav-links">
            <a href="#">Home</a> |
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="home-container">
        <?php if (!empty($error)): ?>
            <div class="error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <table id="student-table" class="display">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Marks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="student-list">
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><span
                                class="initial"><?= htmlspecialchars($student['name'][0]) ?></span><?= htmlspecialchars($student['name']) ?>
                        </td>
                        <td><?= htmlspecialchars($student['subject']) ?></td>
                        <td><?= htmlspecialchars($student['marks']) ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="action-btn">&#9660;</button>
                                <div class="dropdown-content">
                                    <button
                                        onclick="editStudent(<?= $student['id'] ?>, '<?= htmlspecialchars($student['name']) ?>', '<?= htmlspecialchars($student['subject']) ?>', <?= $student['marks'] ?>)">Edit</button>
                                    <button onclick="deleteStudent(<?= $student['id'] ?>)">Delete</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <button onclick="openAddStudentModal()" class="add-btn">Add</button>
    <div id="student-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <form id="student-form" action="save_student.php" method="POST">
                <h2>Add Student</h2>
                <input type="hidden" name="id" id="student-id">
                <input type="text" name="name" id="student-name" placeholder="Name" required>
                <input type="text" name="subject" id="student-subject" placeholder="Subject" required>
                <input type="number" name="marks" id="student-marks" placeholder="Marks" required>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            const modal = $('#student-modal');
            const closeModalBtn = $('.close');

            window.openAddStudentModal = () => {
                $('#student-form').trigger('reset');
                $('#student-id').val('');
                modal.css('display', 'block');
            };

            window.closeModal = () => {
                modal.css('display', 'none');
            };

            window.editStudent = (id, name, subject, marks) => {
                $('#student-id').val(id);
                $('#student-name').val(name);
                $('#student-subject').val(subject);
                $('#student-marks').val(marks);
                modal.css('display', 'block');
            };

            window.deleteStudent = (id) => {
                if (confirm('Are you sure you want to delete this student?')) {
                    $.ajax({
                        url: `delete_student.php?id=${id}`,
                        type: 'GET',
                        success: function (response) {
                            fetchStudents(); // Refresh student list after deletion
                        },
                        error: function (xhr, status, error) {
                            console.error('Error deleting student:', error);
                        }
                    });
                }
            };

            closeModalBtn.click(closeModal);

            $(window).click(function (event) {
                if (event.target === modal[0]) {
                    closeModal();
                }
            });

            // Initialize DataTables on the student table
            $('#student-table').DataTable();

            // Function to fetch and display student data using AJAX
            function fetchStudents() {
                $.ajax({
                    url: 'fetch_students.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        const table = $('#student-table').DataTable();
                        table.clear(); // Clear existing table rows

                        // Append fetched student data to the table
                        $.each(response, function (index, student) {
                            table.row.add([
                                `<span class="initial">${student.name[0]}</span>${student.name}`,
                                student.subject,
                                student.marks,
                                `<div class="dropdown">
                                    <button class="action-btn">&#9660;</button>
                                    <div class="dropdown-content">
                                        <button onclick="editStudent(${student.id}, '${student.name}', '${student.subject}', ${student.marks})">Edit</button>
                                        <button onclick="deleteStudent(${student.id})">Delete</button>
                                    </div>
                                </div>`
                            ]).draw(false);
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching students:', error);
                    }
                });
            }

            // Call fetchStudents() initially to populate the table
            fetchStudents();
        });
    </script>
</body>

</html>