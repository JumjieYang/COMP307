<?php

session_start();

?>
<?php include 'connect.php';?>
<?php
    $stmt = $conn -> prepare("select * from user where username=?");
    $stmt -> bind_param("s",
    $_SESSION['username']
    );            
    $stmt->execute();
    $result = $stmt -> get_result();
    $row = $result -> fetch_assoc();
    ?>
<?php

    $stmt = $conn -> prepare("insert into post (creator, title, content) values (?, ?, ?)");
    $stmt -> bind_param("iss",$creator, $title, $content);
    $creator = $row['id'];
    $title = htmlspecialchars($_POST['title']);
    $title = strip_tags($title);

    $content = htmlspecialchars($_POST['content']);
    $content =strip_tags($content);
    $stmt -> execute();

    $data = array('creator' => $_SESSION['username'], 'title' => $title, 'content' => $content);
    $json_obj = json_encode($data);

    print($json_obj);
    ?>