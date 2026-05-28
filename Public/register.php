<?php

require_once '../classes/User.php';

$message = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User();

    if($user->register($username, $password)) {
        $message = "Registration successful";
    } else {
        $message = "Registration failed";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Register</h2>

<form method="POST">

    <input type="text" name="username" placeholder="Username" required>
    <br><br>

    <input type="password" name="password" placeholder="Password" required>
    <br><br>

    <button type="submit">Register</button>

</form>

<p><?php echo $message; ?></p>

<a href="login.php">Login</a>

</body>
</html>