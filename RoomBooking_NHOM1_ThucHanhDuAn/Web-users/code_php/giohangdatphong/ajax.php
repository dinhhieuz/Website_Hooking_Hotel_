
<?php
    // require_once('../../giohangdatphong.php');
    session_start();
    if($_POST['action'] == 'call_this') {
        $_SESSION['test_date'] = 1;
        
        if( isset($_POST['start']) && !isset($_POST['end'])){
            //- Tồn tai ngày bắt đầu
            $_SESSION['start_date'] = $_POST['start'];

        }elseif( isset($_POST['end']) && !isset($_POST['start'])){
            //- Tồn tai ngày kết thúc
            $_SESSION['end_date'] = $_POST['end'];

        }else{
            $_SESSION['start_date'] = $_POST['start'];
            $_SESSION['end_date'] = $_POST['end'];
        }
        // Xuất hiện thông báo nếu nhập sai - ngày end < start 
        if ( (strtotime($_SESSION['end_date']) < strtotime($_SESSION['start_date'])) ) {
            $_SESSION['Inform_date_end'] = 'color:red; font-size:17px; font-weight: 700';
        }else{
            $_SESSION['Inform_date_end'] = '';
        }
        // Xuất hiện thông báo nếu nhập sai - ngày start < now
        if ( strtotime($_SESSION['start_date']) < strtotime(date("Y-m-d"))) {
            $_SESSION['Inform_date_start'] = 'color:red; font-size:17px; font-weight: 700';
        }else{
            $_SESSION['Inform_date_start'] = '';
        }
        //echo "-start: ".$_SESSION['start_date']." -end: ".$_SESSION['end_date'];
    }
?>