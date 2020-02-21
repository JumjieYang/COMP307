<?php

session_start();
unset($_SESSION['username']);
?>
<body>
    <?php include 'menu.html';?>
    <?php print("<br/>You are now logged out");?>
</body>