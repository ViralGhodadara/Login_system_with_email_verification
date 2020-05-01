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
    <h3 class="heading">Login here</h3>
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
                    <?php
                        session_start();

                        if(isset($_SESSION['msg'])){
                        ?>
                            <p class="session_para"><?php echo $_SESSION['msg']; ?></p>
                        <?php
                        } else {
                            $_SESSION['msg'] = "Please you can first sign up your detail";
                        ?>
                            <p class="session_para"><?php echo $_SESSION['msg']; ?></p>
                        <?php
                        }
                    ?>
                </tr>
                <tr>
                    <br>
                    <input type="text" name="email" placeholder="Email address" class="box" required>
                </tr>
                <tr>
                    <br><br>
                    <input type="password" name="password" class="box" placeholder="Password" required>
                </tr>
                <tr>
                <tr>
                    <br><br>
                    <button class="submit-btn" name="submit">Create Account</button>
                </tr>
                <tr>
                    <br><br>
                    <p class="last_sentence">Have an account ? <a href="registration.php" class="link">Register detail</a></p>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
<?php

    if (isset($_POST['submit'])) {
        
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);

        $select_query = "SELECT * FROM regi_detail WHERE email = '$email'";

        $select_run = mysqli_query($connection, $select_query);

        $number_of_email = mysqli_num_rows($select_run);

        if ($number_of_email == 1) {
            $data = mysqli_fetch_array($select_run);

            $databased_password = password_verify($password, $data['password']);

            if($data['status'] = 'active') {
                if ($databased_password ) {
                    header('location: home.php');
                } else {
                    echo "Please Enter the valid password";
                }
            } else {
                echo "Please activate your account";
            }
        } else {
            echo "Please enter valid email";
        }
    }
?>