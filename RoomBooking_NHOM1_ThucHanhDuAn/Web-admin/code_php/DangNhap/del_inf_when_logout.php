<?php
    if($_POST['action'] == 'call_this') {
        session_start();
        $_SESSION["thongbao"] = NULL;
        $_SESSION["user"] = NULL;
        header("location: ../../login.php");
      }
?>