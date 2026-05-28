<?php

session_start();
require_once '../classes/User.php';

$message = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User();

    $loggedUser = $user->login($username, $password);

    if($loggedUser) {

        $_SESSION['user_id'] = $loggedUser['id'];
        $_SESSION['username'] = $loggedUser['username'];
        $_SESSION['master_password'] = $password;

        header('Location: dashboard.php');
        exit;

    } else {
        $message = "Invalid credentials";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<form method="POST">

    <input type="text" name="username" placeholder="Username" required>
    <br><br>

    <input type="password" name="password" placeholder="Password" required>
    <br><br>

    <button type="submit">Login</button>

</form>

<p><?php echo $message; ?></p>

<a href="register.php">Register</a>

</body>
</html>