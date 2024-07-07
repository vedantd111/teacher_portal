<!-- index.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Portal - Login</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="login-container">
        <form action="login.php" method="POST">
            <h2>Login</h2>
             <label for="name">Name:</label>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
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
// login.php
session_start();
require 'config/database.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $pdo->prepare('SELECT * FROM teachers WHERE username = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['loggedin'] = true;
    header('Location: home.php');
} else {
    header('Location: index.php?error=Invalid credentials');
}
?>