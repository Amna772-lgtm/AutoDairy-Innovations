<?php
// Define hardcoded username and password
$valid_username = 'admin';
$valid_password = '123';

$username = '';
$password = '';
$error = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the credentials
    if ($username === $valid_username && $password === $valid_password) {
        // Redirect to the home page or any other authorized page
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./login.css">
    <title>Login page</title>
</head>

<body>
    <form method="POST" action="">
        <div class="container" id="loginpg">
            <div class="background">
                <h1>AutoDairy Innovations</h1>
                <div class="container1" id="login">
                    <div class="admin-login">
                        <br><br>
                        <label for="admin-username" class="admin" id="un">Username:</label>
                        <br><br>
                        <input type="text" name="username" id="adminUR" required>
                        <br><br><br>
                        <label for="admin-pwd" class="admin" id="pwd">Password:</label>
                        <br><br>
                        <input type="password" name="password" id="adminPwd" required>

                        <div class="footer1">
                            <button class="bttn" id="btn"> Login
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <?php echo $error; ?>
        </div>
    </form>

</body>

</html>