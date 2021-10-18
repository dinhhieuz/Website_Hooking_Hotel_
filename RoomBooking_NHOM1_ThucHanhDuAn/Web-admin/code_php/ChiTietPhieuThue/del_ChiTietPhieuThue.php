<?php
    require_once('../database/dbhelper.php');
?>
<?php
    if(isset($_GET['id'])){
        $del_MaPhieuThue = substr($_GET['id'],0,8) ;
        $del_MaPhong = substr($_GET['id'],8,8+7);

        $sql =  "   SELECT TongTien FROM chitietphieuthue WHERE MaPhieuThue = '".$del_MaPhieuThue."'
                ";
        $Result = executeSingleResult($sql);

        $sql_del =  "   DELETE FROM chitietphieuthue
                        WHERE MaPhieuThue = '".$del_MaPhieuThue."' AND MaPhong = '".$del_MaPhong."' 
                    ";
        execute($sql_del);
        $sql_updt = "   UPDATE phieuthue
                        SET SoLuongPhong = SoLuongPhong - 1, ThanhTien = ThanhTien - ".$Result['TongTien']."
                        WHERE MaPhieuThue = '".$del_MaPhieuThue."' 
                    ";
        execute($sql_updt);
    }
    header("Refresh:0; url=../../Bang_ChiTiet.php?id=".$del_MaPhieuThue);
?>
