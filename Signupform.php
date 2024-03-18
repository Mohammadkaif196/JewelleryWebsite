<?php
$nameErr = "";
$passErr = "";
$emailErr = "";
$uname = "";
$pass = "";
$email = "";
$repass = "";
$repassErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST["uname"];
    $pass = $_POST["pass"];
    $email = $_POST["email"];
    $repass = $_POST["Repass"];

    if (empty($uname)) {
        $nameErr = "Name is Required";
    } else {
        if (!preg_match('/^[a-zA-Z ]*$/', $uname)) {
            $nameErr = "Only alphabets and white space allowed";
        }
    }
    
    }
    if (empty($pass)) {
        $passErr = "Password is Required";
    } else {
        $re = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/";
        if (!preg_match($re, $pass)) {
            $passErr = "Password should be alphanumeric with a special character";
        }
    }
    if (empty($repass)) {
        $repassErr = "Reenter the password is required";
    } else {
        if ($pass != $repass) {
            $repassErr = "Enter correct password";
        }
    }

    if (empty($email)) {
        $emailErr = "Email is required";
    } else {
        $reg = "/^\w+([\.-]?\w+)@\w+([\.-]?\w+)(\.\w{2,3})+$/";
        if (!preg_match($reg, $email)) {
            $emailErr = "Email should be in the correct format";
        }
    }

   

    if (empty($nameErr) && empty($passErr) && empty($emailErr) && empty($repassErr) ) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $conn = mysqli_connect($servername, $username, $password,'db2');
        $result=mysqli_query($conn,"insert into information(UserName,Email,Password) values('$uname','$email','$pass');") or $val='email already exists';
        header('Location: new.php');
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                User name: <br>
                    <input type="text" class="number" name="uname" id="username" required> <br><br>
                    Email: <br>
                    <input type="email" class="email" name="email" id="email" required> <br> <br>
                    
                    Password: <br>
                    <input type="password" class="number" name="pass" id="password" required> <br><br>
                    confirm password: <br>
                    <input type="password" class="number" name="repass" id="confirmpassword" required> <br><br>
                </form>
            </div>
            <div class="button">
                <input type="submit" name="submit" value="submit" id="bnt">
            </div>

        </div>
    </center> 


   
</body>
</html>