<?php

session_start();
?>
<body>
    <p>
    <?php include 'menu.html';?>
    <?php include 'connect.php';?>
    </p>
    <h3> Posts </h3>
    <p>
    <?php
        $stmt = $conn -> prepare("select * from post");
        $stmt -> execute();
        ?>

        <?php
        $result = $stmt -> get_result();
        if ($result->num_rows == 0)
        {
            print("user not found");
        }
        else {
                while($row = $result -> fetch_assoc())
                {
                print("<p><b>Title:".$row['title']."</b></p>");
                $stmt = $conn -> prepare("select * from user where id=?");
                $stmt -> bind_param("i",
                $row['creator']);
                $stmt -> execute();
                $answer = $stmt -> get_result();
                $answerRow = $answer -> fetch_assoc();
                print("<p>By:".$answerRow['username']."</p>");
                print($row['content']);
                }
            }
    ?>
    </p>
    <?php
        if (isset ($_SESSION['username']))
        {
            print("<strong>Create a post as ".$_SESSION['username']."</strong>");
            include 'post.php';
        }
        else{
            print('You need to login to make a post');
        }
    ?>
</body>