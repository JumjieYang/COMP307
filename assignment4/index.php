<?php

session_start();
?>
<body>
    <p>
    <?php include 'menu.html';?>
    <?php include 'connect.php';?>
    </p>
    <h3> Posts </h3>
    <?php
        $stmt = $conn -> prepare("select * from post");
        $stmt -> execute();
        ?>
    <div id="posts">
        <?php
        $result = $stmt -> get_result();
        if ($result->num_rows == 0)
        {
            print("No posts available <br/>");
        }
        else {
                while($row = $result -> fetch_assoc())
                {
                print(" <fieldset><b>Title:".$row['title']."</b><br/>");
                $stmt = $conn -> prepare("select * from user where id=?");
                $stmt -> bind_param("i",
                $row['creator']);
                $stmt -> execute();
                $answer = $stmt -> get_result();
                $answerRow = $answer -> fetch_assoc();
                print("By:".$answerRow['username']."<br />");
                print($row['content']."</fieldset><br/>");
                }
            }
    ?>
    </div>
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