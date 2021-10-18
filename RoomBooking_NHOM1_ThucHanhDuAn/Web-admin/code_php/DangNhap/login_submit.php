<?php
    require_once('../database/dbhelper.php');
    // include 'config.php';
?>
<?php
    // Xữ lý đăng nhập không thành công
    session_start();
    // Xác thực đăng nhập

    if( isset($_POST["submit"])){
        if ( strlen($_POST["username"]) > 0 && strlen($_POST["password"]) > 0 ){
            
            if( strlen($_POST['username']) > 20 || strlen($_POST['password']) > 20){
                $_SESSION["thongbao"] = "Bạn chỉ được dưới 20 kí tự hoi";
                header("location: ../../login.php");
            }else{
                $username = str_replace('"','\\"', $_POST['username']);
                $password = str_replace('"','\\"', $_POST['password']);
                $sql =  "    SELECT COUNT(TaiKhoan) as SoTaiKhoan FROM dangnhap WHERE TaiKhoan = '".$username."' AND MatKhau = '".$password."' LIMIT 1  
                        ";
                $user = executeSingleResult($sql);
                if( intval($user['SoTaiKhoan']) == 1){
                    $_SESSION["user"] = $username;
                    $_SESSION["thongbao"] = "";
                    header("location: ../../index.php");
                }else {
                    $_SESSION["thongbao"] = "Tài khoản hay mật khẩu sai rồi kìa :)))";
                    header("location: ../../login.php");
                }
            }

            
        }else{
            $_SESSION["thongbao"] = "Vui lòng nhập đủ thông tin bạn ơi!!!";
            header("location: ../../login.php");
        }
    }
    if ( isset($_POST["back"]) ){
        $_SESSION["thongbao"] = "";
        header("location: ../../../index.html");
    }
    mysqli_close($conn);
?>