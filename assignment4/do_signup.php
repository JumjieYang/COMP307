
    <?php include 'connect.php';?>
    <?php include 'menu.html';?>
    <?php

    $stmt = $conn -> prepare("insert into user (username, password) values (?, ?)");

    $stmt -> bind_param("ss", $username, $password);

    $username = strip_tags(htmlspecialchars($_POST['username']));
    $password = password_hash(
        strip_tags(htmlspecialchars($_POST['password'])),PASSWORD_DEFAULT);

    $success=$stmt -> execute();
    print($success);
    ?>