<!-- register.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Portal - Register</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="login-container">
        <form action="register.php" method="POST">
            <h2>Register</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
            <div class="error-message">
                <?php
                if (isset($_GET['error'])) {
                    echo htmlspecialchars($_GET['error']);
                }
                ?>
            </div>
        </form>
    </div>
</body>

</html>
<?php
session_start();
require 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('SELECT * FROM teachers WHERE username = ?');
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        header('Location: register.php?error=Username already exists');
        exit;
    }
    
    $stmt = $pdo->prepare('INSERT INTO teachers (username, password) VALUES (?, ?)');
    if ($stmt->execute([$username, $password])) {
        $_SESSION['loggedin'] = true;
        header('Location: home.php');
        exit;
    } else {
        header('Location: register.php?error=Registration failed');
        exit;
    }
}
?>