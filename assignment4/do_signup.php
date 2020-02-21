<body>
    <?php include 'menu.html'; ?>
    <?php include 'connect.php';?>

    <?php

    $stmt = $conn -> prepare("insert into user (username, password) values (?, ?)");

    $stmt -> bind_param("ss", $username, $password);

    $username = $_POST['username'];
    $password = password_hash(
        $_POST['password'],PASSWORD_DEFAULT);

    $success = $stmt -> execute();
    ?>
    <p>
        <?php
        if (!$success)
        {
            print ("Sign up failed ". $stmt -> error);
        }
        else
        {
            print ("Sign up successful");
        }
        ?>
    </p>
    </body>