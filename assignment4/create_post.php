<body>
<?php

session_start();

?>

<?php include 'menu.html'; ?>
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
    
    $stmt -> bind_param("iss",$creater, $title, $content);
    $creater = $row['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $success = $stmt -> execute();
    ?>
    <p>
        <?php
        if (!$success)
        {
            print ("Unable to create post". $stmt -> error);
        }
        else
        {
            print ("Successfully create post");
        }
        ?>
</body>