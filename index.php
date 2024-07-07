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
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </div>
</body>

</html>