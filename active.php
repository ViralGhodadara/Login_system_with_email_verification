<?php

    require "connection.php";

    $token = $_GET['token'];

    $select_token_detail = "SELECT * FROM regi_detail WHERE token LIKE '$token'";

    $token_detail_run = mysqli_query($connection, $select_token_detail);
    
    if($token_detail_run) {

        $update_status = "UPDATE regi_detail SET status = 'active' WHERE token = '$token'";

        $update_status_run = mysqli_query($connection, $update_status);

        if ($update_status_run) {

            session_start();

            $_SESSION['msg'] = "Please enter your email and password";

            header('location: login.php');
        } 
    }

?>