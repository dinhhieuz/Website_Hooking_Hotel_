<?php
    require_once('../database/dbhelper.php');
?>
<?php
    if(isset($_GET['id'])){
        $nowdate = date('Y-m-d', strtotime(date('Y-m-d')));
        $sql = "   UPDATE phieuthue
                        SET NgayThanhToan = '".$nowdate."'
                        WHERE MaPhieuThue = '".$_GET['id']."' 
                    ";
        execute($sql);
        // echo $sql;
    }
    header("Refresh:0; url=../../Bang_DatPhong.php");
?>
