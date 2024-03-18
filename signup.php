<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'mysql';

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$createTableQuery = "CREATE TABLE IF NOT EXISTS users (
    Fullname VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    Username VARCHAR(50) NOT NULL,
    Password VARCHAR(255) NOT NULL
)";
if ($mysqli->query($createTableQuery) !== TRUE) {
    die("Error creating table: " . $mysqli->error);
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = $mysqli->real_escape_string($_POST['fullname']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $password_confirm = $mysqli->real_escape_string($_POST['confirmpassword']);

    if (empty($full_name) || empty($email) || empty($username) || empty($password) || empty($password_confirm)) {
        $message = "All fields are required!";
    } elseif ($password !== $password_confirm) {
        $message = "Passwords do not match!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format!";
    } else {
        $checkQuery = "SELECT Id FROM users WHERE Username = '$username' OR Email = '$email' LIMIT 1";
        $result = $mysqli->query($checkQuery);
        if ($result && $result->num_rows > 0) {
            $message = "Username or email already exists!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO users (Fullname, Email, Username, Password) VALUES ('$full_name', '$email', '$username', '$hashed_password')";
            if ($mysqli->query($insertQuery) === TRUE) {
                $message = "Registration successful!";
            } else {
                $message = "Error: " . $insertQuery . "<br>" . $mysqli->error;
            }
        }
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <style>
      
        <Style>
        body{
            margin: 0;
            padding: 0;
            background: linear-gradient(black,#402D16);
        }
        .content{
            border: 2px solid #B8860B;
            width: 500px;
            height: 600px;
            margin-top: 60px;
        }
        h1{
            color: #B8860B;
        }
        .forms{
            font-size: 20px;
            color: white;
        }
        .name,.email,.number{
            background-color: rgba(0, 0, 0, 0.408);
            border-bottom: 4px solid #B8860B;
            color: white;
        }
        
        .button{
            padding-top: 10px;
        }
        #bnt{
            width: 100px;
            height: 35px;
            border: 4px solid black;
            border-radius: 8px;
            background-color: #B8860B;
        }
        #bnt:hover{
            cursor: pointer;
            width: 150px;
            height: 35px;
            font-size: 20px;
            background-color: #B8860B;
            color: silver;
            border: 3px solid #B8860B;
            border-radius: 8px;
            box-shadow: 0px 2px 3px 3px #B8860B;
        }

    </Style>
</head>
<body>
    <center> 
        <div class="content">
            <h1>SIGNUP FORM</h1>
            <div class="forms">
                <form action="signup.php" method="post">
                    Full Name: <br>
                    <input type="text" class="name" name="fullname" id="name" required> <br> <br>
                    Email: <br>
                    <input type="email" class="email" name="email" id="email" required> <br> <br>
                    User name: <br>
                    <input type="text" class="number" name="username" id="username" required> <br><br>
                    Password: <br>
                    <input type="password" class="number" name="password" id="password" required> <br><br>
                    Confirm password: <br>
                    <input type="password" class="number" name="confirmpassword" id="confirmpassword" required> <br><br>
                    <button type="submit" id="bnt">Sign Up</button>
                </form>
            </div>
            <div class="message">
                <?php echo $message; ?>
            </div>
        </div>
    </center> 
</body>
</html>
