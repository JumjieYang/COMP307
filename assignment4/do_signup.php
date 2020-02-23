
    <?php include 'connect.php';?>
    <?php include 'menu.html';?>
    <?php

    $stmt = $conn -> prepare("insert into user (username, password) values (?, ?)");

    $stmt -> bind_param("ss", $username, $password);

    $username = strip_tags(htmlspecialchars($_POST['username']));
    $password = strip_tags(htmlspecialchars($_POST['password']));

    if(strlen($password)!= 0)
    {
    $password = password_hash($password,PASSWORD_DEFAULT);
    }
    $success=$stmt -> execute();
    if ($success)
    {
        print("<br/>Sign Up successful");
    }
    else
    {
        print("<br/>Please check your input");
    }
    ?>