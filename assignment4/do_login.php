<?php

session_start();
?>

    <?php include 'connect.php'?>
    <?php include 'menu.html'?>
    <?php
    $stmt = $conn -> prepare("select * from user where username=?");

    $stmt -> bind_param("s",
    $username
);

$username = htmlspecialchars($_POST['username']);
$username = strip_tags($username);
$stmt->execute();
?>
    <?php
    $result = $stmt -> get_result();
    if ($result->num_rows == 0)
    {
        print("user not found");
    }
    else {
        $row = $result -> fetch_assoc();
        $passowrd = strip_tags(htmlspecialchars($_POST['password']));
        if (password_verify($passowrd, $row['password']))
        {
            print("Hi ".$row['username'].', you are logged in.');
            $_SESSION['username'] = $row['username'];
        }
        else{
            print('Wrong password.');
        }
    }
    ?>