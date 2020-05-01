<?php
    require "connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <h3 class="heading">Registration form</h3>
    <div class="container">
        <form method="post">
            <table>
                <tr>
                    <button class="icon-btn-google"><i class="fa fa-google" id="google_icon" style="font-size:24px"></i>  Login via Gmail</button>
                </tr>
                <tr>
                    <button class="icon-btn-fb"><i class="fa fa-facebook-official"></i>  Login via Facebook</button>
                </tr>
                <tr>
                    <br><br>
                    <hr>
                </tr>
                <tr>
                    <br>
                    <input type="text" name="username" placeholder="Username" class="box" required>
                </tr>
                <tr>
                    <br><br>
                    <input type="email" name="email" class="box" placeholder="Email address" required>
                </tr>
                <tr>
                    <br><br>
                    <input type="number" name="phone_number" class="box" placeholder="Phone number" required>
                </tr>
                <tr>
                    <br><br>
                    <input type="password" name="password" class="box" placeholder="Password" required>
                </tr>
                <tr>
                    <br><br>
                    <input type="password" name="cpassword" class="box" placeholder="Conform Password" required>
                </tr>
                <tr>
                    <br><br>
                    <button class="submit-btn" name="submit">Create Account</button>
                </tr>
                <tr>
                    <br><br>
                    <p class="last_sentence">Have an account ? <a href="login.php" class="link">Log in</a></p>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
<?php
    if (isset($_POST['submit'])) {
        
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $phone_number = mysqli_real_escape_string($connection, $_POST['phone_number']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $conform_password = mysqli_real_escape_string($connection, $_POST['cpassword']);

        $select_email = "SELECT * FROM regi_detail WHERE email = '$email'";

        $select_run = mysqli_query($connection, $select_email);

        $email_number = mysqli_num_rows($select_run);

        if ($email_number == 0) {

            $pass_hass = password_hash($password, PASSWORD_BCRYPT);
            $conform_pass_hash = password_hash($conform_password, PASSWORD_BCRYPT);

            $token = bin2hex(random_bytes(15));

            if ($password === $conform_password) {

                $insert_query = "INSERT INTO regi_detail (username, email, phone_number, password, conform_password, token, status) VALUES ('$username', '$email', '$phone_number', '$pass_hass', '$conform_pass_hash', '$token', 'inactive')";

                $insert_run = mysqli_query($connection, $insert_query);

                if ($insert_run) {
                    
                    $sub = "Activate account";
                    $body = "hiiii, $username. activate your account click this link http://localhost/viral/email/active.php?token=$token";
                    $from = "From: viralghodadra37@gmail.com";

                    if (mail($email, $sub, $body, $from)) {
                        session_start();
                        $_SESSION['msg'] = "Please open your gmail account and click the verification link";
                        header('location: login.php');
                    }
                }

            } else {
                echo "Please enter the same password";
            }

        } else {
            echo "Please enter the another email address";
        }
    }
?>