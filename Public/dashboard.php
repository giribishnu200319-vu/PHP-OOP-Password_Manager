<?php

session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../classes/PasswordGenerator.php';
require_once '../classes/PasswordEntry.php';
require_once '../classes/Encryption.php';

$generatedPassword = "";
$message = "";

$passwordEntry = new PasswordEntry();

//generate password based on user input

if(isset($_POST['generate'])) {

    $uppercase = (int)$_POST['uppercase'];
    $lowercase = (int)$_POST['lowercase'];
    $numbers = (int)$_POST['numbers'];
    $special = (int)$_POST['special'];

    $generator = new PasswordGenerator();

    $generatedPassword = $generator->generatePassword(
        $uppercase,
        $lowercase,
        $numbers,
        $special
    );
}

//save password for logged in user

if(isset($_POST['save'])) {

    $website = trim($_POST['website']);
    $password = trim($_POST['password']);

    if(!empty($website) && !empty($password)) {

        $saved = $passwordEntry->savePassword(
            $_SESSION['user_id'],
            $website,
            $password,
            $_SESSION['master_password']
        );

        if($saved) {
            $message = "Password saved successfully!";
        } else {
            $message = "Failed to save password!";
        }
    }
}

//Getting stored passwords for logged in user

$passwords = $passwordEntry->getPasswords($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Password Manager Dashboard</title>

    <style>

        body {
            font-family: Arial;
            margin: 40px;
            background: #f4f4f4;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        input {
            padding: 10px;
            width: 300px;
            margin-bottom: 10px;
        }

        button {
            padding: 10px 20px;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            background: white;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th {
            background: #333;
            color: white;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        .success {
            color: green;
            font-weight: bold;
        }

        .section {
            margin-top: 40px;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>Welcome <?php echo $_SESSION['username']; ?></h1>

    <a href="logout.php">Logout</a>

    <div class="section">

        <h2>Password Generator</h2>

        <form method="POST">

            <label>Uppercase Characters:</label><br>
            <input type="number" name="uppercase" min="0" required><br>

            <label>Lowercase Characters:</label><br>
            <input type="number" name="lowercase" min="0" required><br>

            <label>Numbers:</label><br>
            <input type="number" name="numbers" min="0" required><br>

            <label>Special Characters:</label><br>
            <input type="number" name="special" min="0" required><br>

            <button type="submit" name="generate">
                Generate Password
            </button>

        </form>

        <?php if($generatedPassword != ""): ?>

            <h3>Generated Password:</h3>

            <input type="text"
                   value="<?php echo $generatedPassword; ?>"
                   readonly>

        <?php endif; ?>

    </div>

    <div class="section">

        <h2>Save Password</h2>

        <form method="POST">

            <label>Website / Application Name:</label><br>

            <input type="text"
                   name="website"
                   placeholder="Facebook, Gmail, Instagram..."
                   required><br>

            <label>Password:</label><br>

            <input type="text"
                   name="password"
                   value="<?php echo $generatedPassword; ?>"
                   required><br>

            <button type="submit" name="save">
                Save Password
            </button>

        </form>

        <?php if($message != ""): ?>

            <p class="success">
                <?php echo $message; ?>
            </p>

        <?php endif; ?>

    </div>

    <div class="section">

        <h2>Stored Passwords</h2>

        <table>

            <tr>
                <th>ID</th>
                <th>Website</th>
                <th>Encrypted Password</th>
                <th>Decrypted Password</th>
                <th>Created Date</th>
            </tr>

            <?php foreach($passwords as $pass): ?>

            <tr>

                <td><?php echo $pass['id']; ?></td>

                <td><?php echo $pass['website_name']; ?></td>

                <td>
                    <?php echo $pass['encrypted_password']; ?>
                </td>

                <td>

                    <?php

                    echo Encryption::decrypt(
                        $pass['encrypted_password'],
                        $_SESSION['master_password']
                    );

                    ?>

                </td>

                <td><?php echo $pass['created_at']; ?></td>

            </tr>

            <?php endforeach; ?>

        </table>

    </div>

</div>

</body>
</html>