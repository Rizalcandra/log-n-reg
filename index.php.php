<?php
// --- DATABASE CONFIG ---
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "login_system";

// Connect to database
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- REGISTER ---
if (isset($_POST['register'])) {
    $username = $_POST['reg_username'];
    $password = password_hash($_POST['reg_password'], PASSWORD_DEFAULT);

    $check = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($check->num_rows > 0) {
        echo "Username already exists!";
    } else {
        $conn->query("INSERT INTO users (username, password) VALUES ('$username', '$password')");
        echo "Registered successfully!";
    }
}

// --- LOGIN ---
if (isset($_POST['login'])) {
    $username = $_POST['log_username'];
    $password = $_POST['log_password'];

    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo "Login successful! Welcome, $username";
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "User not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login & Register</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST">
        Username: <input type="text" name="reg_username" required><br>
        Password: <input type="password" name="reg_password" required><br>
        <button type="submit" name="register">Register</button>
    </form>

    <h2>Login</h2>
    <form method="POST">
        Username: <input type="text" name="log_username" required><br>
        Password: <input type="password" name="log_password" required><br>
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>
