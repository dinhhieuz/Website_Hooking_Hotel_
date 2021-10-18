<?php
    // require_once('../../giohangdatphong.php');
    session_start();
    if($_POST['action'] == 'call_this') {
        if (    sizeof($_SESSION['giohang']) <= 0 ){
            echo 1;
        }elseif ( (strtotime($_SESSION['end_date']) < strtotime($_SESSION['start_date'])) ) {
            echo 2;
        }elseif ( strtotime($_SESSION['start_date']) < strtotime(date("Y-m-d"))) {
            echo 3;
        }
        else{
            echo 0;
        }
        
    }
?>