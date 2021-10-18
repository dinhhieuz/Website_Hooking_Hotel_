<!-------------------Code PHP -->
<?php
    require_once('./code_php/database/dbhelper.php');
?>
<?php
    session_start();
    $TenKhachHang = $GioiTinh = $NgaySinh = $CMND = $SDT = $DiaChi = '';
    $NgayBatDau = $NgayKetThuc = '';
    $SoNgayThue = $SoLuongPhong = $ThanhTien = 0;
    //--------------------------- ***** Xữ lý giỏ hàng ***** ----------------------------
    // $_SESSION['giohang'] = [$MaLoaiPhong(0), $TenLoai(1), $DonGia(2), $Mota(3), $HinhAnh(4), $SoLuongPhong(5)];

    // Show up error
    $tenkhachhangErr = $ngaysinhErr = $cmndErr = $sdtErr = $diachiErr = "";
    // Kiểm tra kích thước giỏ hàng lớn hơn 0 và $_POST không được trống
    if ( sizeof($_SESSION['giohang']) > 0 && !empty($_POST) ){
        // Kiểm tra insert 
        $test = 1;
        // Kiểm tra Tên Khách Hàng
        if( isset($_POST['input_tenkhachhang']) ) { 

            $_POST['input_tenkhachhang'] = str_replace('"','\\"', $_POST['input_tenkhachhang']);
            if (empty($_POST["input_tenkhachhang"])) {
                $tenkhachhangErr = "Bạn bắt buộc phải nhập tên";
                $test = 0;
            }elseif( strlen($_POST['input_tenkhachhang']) > 50){
                $tenkhachhangErr = "Bạn không được nhập quá 50 kí tự";
                $test = 0;
            }elseif (!preg_match("/^([a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀẾỂưăạảấầẩẫậắằẳẵặẹẻẽềếểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+)$/i", $_POST['input_tenkhachhang'])) {
                // Kiểm tra và chỉ cho phép nhập chữ và khoảng trắng 
                $tenkhachhangErr = "Bạn chỉ được nhập chữ cái và khoảng trắng. "; 
                $test = 0;
            }else{
                $TenKhachHang = $_POST['input_tenkhachhang'];  
            }
        }
        // Kiểm tra giới tính
        if( isset($_POST['input_gioitinh']) ) { $GioiTinh = $_POST['input_gioitinh'] ;}
        // Kiểm tra ngày sinh
        if( isset($_POST['input_ngaysinh']) ) { 
            if (empty($_POST['input_ngaysinh']) ){
                $ngaysinhErr="Bạn bắt buộc phải nhập ngày sinh";
                $test = 0;
            }else{
                //Kiểm tra và chỉ cho phép ngày sinh nhỏ hơn ngày hiện tại
                $entered_date = $_POST['input_ngaysinh'];
                $diff = (date('Y') - date('Y',strtotime($entered_date)));
                // echo $diff;
                if ($diff < 18){
                    $ngaysinhErr="Bạn bắt buộc phải nhập ngày sinh lớn 18 tuổi";
                    $test = 0;
                } elseif ($diff > 101){
                    $ngaysinhErr="Bạn bắt buộc phải nhập ngày sinh nhỏ hơn 100 tuổi";
                    $test = 0;
                } else{
                    $NgaySinh = $_POST['input_ngaysinh'];
                }
            }
        }
        // Kiểm tra CMND
        if( isset($_POST['input_cmnd']) ) {
            $_POST['input_cmnd'] = str_replace('"','\\"', $_POST['input_cmnd']);
            if (empty($_POST['input_cmnd'])) {
                $cmndErr = "Số CMND là bắt buộc.";
                $test = 0;
            }else {
                $cmndtest = $_POST['input_cmnd'];
                // Kiểm tra xem số điện thoại đã đúng định dạng hay chưa 
                if (!preg_match ("/^[0-9]*$/", $cmndtest) ) {
                    $cmndErr = "Bạn chỉ được nhập giá trị số.";
                    $test = 0;
                }
                //Kiểm tra độ dài của số điện thoại 
                if (strlen ($cmndtest) != 9) {
                    $cmndErr = "Số CMND phải là 9 ký tự.";
                    $test = 0;
                }else{
                    $CMND = $_POST['input_cmnd'];
                }
            }
        }
        // Kiểm tra Số điện thoại
        if( isset($_POST['input_sdt']) ) { 
            
            $_POST['input_sdt'] = str_replace('"','\\"', $_POST['input_sdt']);

            if (empty($_POST["input_sdt"])) {
                $sdtErr = "Số điện thoại là bắt buộc.";
                $test = 0;
            }else {
                $mobileno = $_POST["input_sdt"];
                // Kiểm tra xem số điện thoại đã đúng định dạng hay chưa 
                if (!preg_match ("/^[0-9]*$/", $mobileno) ) {
                    $sdtErr = "Bạn chỉ được nhập giá trị số.";
                    $test = 0;
                }
                //Kiểm tra độ dài của số điện thoại 
                if (strlen ($mobileno) != 10) {
                    $sdtErr = "Số điện thoại phải là 10 ký tự.";
                    $test = 0;
                }else{
                    $SDT = $_POST['input_sdt'];
                }
            }
        }
        // Kiểm tra Địa chỉ
        if( isset($_POST['input_diachi']) ) { 
            $DiaChi = $_POST['input_diachi'] ;

            $_POST['input_diachi'] = str_replace('"','\\"', $_POST['input_diachi']);
            if (empty($_POST['input_diachi'])) {
                $diachiErr = "Bạn bắt buộc phải nhập địa chỉ";
                $test = 0;
            }elseif( strlen($_POST['input_diachi']) > 100){
                $diachiErr = "Bạn không được nhập quá 100 kí tự";
                $test = 0;
            }else{
                $DiaChi = $_POST['input_diachi'];  
            }
        }
        // Điều kiện nhập đúng
        if ( $test == 1 ){
            $NgayBatDau = $_SESSION['start_date'];
            $NgayKetThuc = $_SESSION['end_date'];
            $SoNgayThue = (floor((abs(strtotime($_SESSION['start_date']) - strtotime($_SESSION['end_date']))) / (60*60*24)) + 1);
            $SoLuongPhong = $_SESSION['SoLuongPhong'];
            $ThanhTien = $_SESSION['ThanhTien'];

            //----- Tạo mới đặt phòng -------
            // Tạo thông tin khách hàng ở bảng "KHACHHANG"
            $sql_create_khachhang = "   INSERT INTO khachhang (MaKhachHang, GioiTinh, TenKhachHang, NgaySinh, CMND, SDT, DiaChi) 
                                        SELECT Concat(LEFT(Max(MaKhachHang),2), LPAD(CONVERT(RIGHT(Max(MaKhachHang),8-2),int)+1,6,'0')), 
                                                ".$GioiTinh." , '".$TenKhachHang."' , '".$NgaySinh."' , '".$CMND."' , '".$SDT."' ,'".$DiaChi."' 
                                        from khachhang;
                                    ";
            $result_khachhang = MultiexecuteAndRollBack($sql_create_khachhang); //bool (True: Success, False: Fail)
            
            // Kiểm tra thêm khách hàng thành công hay không
            if ($result_khachhang == TRUE){
                // Tạo thông tin phiếu thuê ở bảng "PHIEUTHUE"
                $sql_create_phieuthue = "   INSERT INTO phieuthue (MaPhieuThue, MaKhachHang, NgayBatDau, NgayKetThuc, SoNgayThue, SoLuongPhong, ThanhTien) 
                                            SELECT Concat(LEFT(Max(MaPhieuThue),2), LPAD(CONVERT(RIGHT(Max(MaPhieuThue),8-2),int)+1,6,'0')), 
                                                (SELECT Max(MaKhachHang) from khachhang LIMIT 1), '".$NgayBatDau."', '".$NgayKetThuc."', ".$SoNgayThue.", ".$SoLuongPhong.", ".$ThanhTien."
                                            FROM phieuthue;
                                        ";
                $result_phieuthue = MultiexecuteAndRollBack($sql_create_phieuthue);
                // Kiểm tra thêm phiếu thuê thành công hay không
                if($result_phieuthue == TRUE){
                    // Tạo thông tin chi tiết phiếu thuê ở bảng "CHITIETPHIEUTHUE"
                    $CheckResult = 1;
                    for( $i=0; $i < sizeof($_SESSION['giohang']); $i++ ){
                        // Lấy mã phòng thuê theo "số lượng đặt phòng" và "mã loại"
                        $SqlQuery_MaPhong = "   SELECT MaPhong FROM phong 
                                                WHERE MaLoaiPhong = '".$_SESSION['giohang'][$i][0]."' and TinhTrang = 'Còn' 
                                                ORDER BY MaPhong ASC 
                                                Limit ".intval($_SESSION['giohang'][$i][5])."
                                            ";
                        $s_MaPhong = executeResult($SqlQuery_MaPhong);
                        // Kiểm tra kích thước bảng < 1 thì thoát
                        if ( sizeof($s_MaPhong) > 0){
                            $s_DonGia = (intval(str_replace(",","",$_SESSION['giohang'][$i][2])) / intval(str_replace(",","",$_SESSION['giohang'][$i][5])));
                            $s_TongTien = ($s_DonGia * $SoNgayThue);
                            foreach ($s_MaPhong as $items_phong) {
                                $sql_create_chitietphieuthue =  "   INSERT INTO chitietphieuthue (MaPhieuThue, MaPhong, DonGia, TongTien) 
                                                                    VALUES ((SELECT Max(MaPhieuThue) from phieuthue LIMIT 1), '".$items_phong['MaPhong']."', '".$s_DonGia."', '$s_TongTien' );
                                                                ";
                                $result_chitietphieuthue = MultiexecuteAndRollBack($sql_create_chitietphieuthue);
                                if ($result_chitietphieuthue == TRUE){
                                    $sql_update_statusRoom = "  UPDATE phong
                                                                set TinhTrang = 'Hết'
                                                                WHERE MaPhong = '".$items_phong['MaPhong']."'
                                                            ";
                                    $result_phong = MultiexecuteAndRollBack($sql_update_statusRoom);
                                    if ($result_phong == FALSE){ $CheckResult = 0; break; }
                                }else{ $CheckResult = 0; break; }
                            }
                        }else{ $CheckResult = 0; break; }
                    }
                    if ($CheckResult == 1 ){

                        $get_MaPhieuThue = " SELECT MAX(MaPhieuThue) as MaPhieuThue FROM phieuthue LIMIT 1 ";
                        $result_MaPhieuThue = executeSingleResult($get_MaPhieuThue);
                        // $_SESSION['giohang'] = [];
                        $_SESSION['bill_khachhang'] = [$NgayBatDau, $NgayKetThuc, $result_MaPhieuThue['MaPhieuThue'], $ThanhTien,  $TenKhachHang, $GioiTinh, $NgaySinh, $CMND, $SDT ];
                        
                        phpAlert('Yeahh, Đặt phòng thành công rồi!!!');
                        header("Refresh:0; url=thongbao.php");
                    }else{
                        //Rollback tất cả giá trị truyền vào
                        $Get_list_chitietphieuthue = "  SELECT MaPhieuThue, MaPhong FROM chitietphieuthue 
                                                        WHERE MaPhieuThue = (SELECT Max(MaPhieuThue) from phieuthue LIMIT 1)
                                                    ";
                        $list_chitietphieuthue = executeResult($Get_list_chitietphieuthue);
                        if ( sizeof($list_chitietphieuthue) > 0 ){
                            foreach( $list_chitietphieuthue as $items_phong ){
                                $sql_update_chitietphieuthue = "  DELETE FROM chitietphieuthue
                                                                WHERE MaPhieuThue = '".$items_phong['MaPhieuThue']."' AND MaPhong = '".$items_phong['MaPhong']."' 
                                                                ";
                                execute($sql_update_chitietphieuthue);
                                $sql_update_statusRoom = "  UPDATE phong
                                                            SET TinhTrang = 'còn'
                                                            WHERE MaPhong = '".$items_phong['MaPhong']."'
                                                        ";
                                execute($sql_update_statusRoom);
                            }
                        }
                        $Rollback_phieuthue =   "   DELETE FROM phieuthue
                                                    WHERE MaPhieuThue = (SELECT Max(MaPhieuTHue) from phieuthue LIMIT 1);
                                                ";
                        execute($Rollback_phieuthue);
                        $Rollback_khachhang = "     DELETE FROM khachhang
                                                    WHERE MaKhachHang = (SELECT Max(MaKhachHang) from khachhang LIMIT 1);
                                            ";
                        execute($Rollback_khachhang);

                        phpAlert('Đặt phòng thất bại òi, bạn làm sao ấy!!! <br> Kiểm tra lại các bước đi bạn êy :)'); 
                        
                    }
                }else{ 
                    $Rollback_khachhang = "     DELETE FROM khachhang
                                                WHERE MaKhachHang = (SELECT Max(MaKhachHang) from khachhang LIMIT 1);
                                        ";
                    execute($Rollback_khachhang);
                    phpAlert('Đặt phòng thất bại òi, bạn làm sao ấy!!! <br> Kiểm tra lại các bước đi bạn êy :)'); 
                }
            }else{ phpAlert('Đặt phòng thất bại òi, bạn làm sao ấy!!! Kiểm tra lại các bước đi bạn êy :)'); }
        }
    }

    // Hàm thông báo bằng JS
    function phpAlert($msg) {
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }
?>


<!----------------- Code HTML -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- add icon -->
    <link rel = "icon" href = "../Web-admin/img/img_logo/icon_web.png" type = "image/x-icon">

    <!-- File CSS -->
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/hethongphong.css">
     <!-- Bootstrap Core CSS -->
     <link rel="stylesheet" href="css/bootstrap.min.css"  type="text/css">
	
     <!-- Custom CSS -->
     <link rel="stylesheet" href="css/style.css">
     
     
     <!-- Custom Fonts -->
     <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"  type="text/css">
     <link rel="stylesheet" href="fonts/font-slider.css" type="text/css">
     
     <!-- jQuery and Modernizr-->
     <script src="js/jquery-2.1.1.js"></script>
     
     <!-- Core JavaScript Files -->  	 
     <script src="js/bootstrap.min.js"></script>

    <title>Thông tin khách hàng</title>
</head>

<body style="background-color: #FFFBD1">
    
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v11.0"
        nonce="UgYqpkdC"></script>
    <div id="wrapper">
        <div id="header">
            <div class="container justify-content-between">
                <a href="">
                    <img src="assets/images/logo6.png" alt="">
                </a>
                <!-- end logo -->
                <a href="">
                    <img src="assets/images/logo2.png" alt="">
                </a>
                <a href="">
                    <img src="assets/images/logo3.png" alt="">
                </a>
            </div>
            <hr>
            <div class="container">
                <nav>
                    <ul id="main-menu" class="justify-content-between d-flex">
                        <li><a href="../index.html"> TRANG CHỦ</a></li>
                        <li><a href="hethongphong.php">HỆ THỐNG PHÒNG</a></li>
                        <li><a href="nhahang&bar.html">NHÀ HÀNG & BAR</a></li>
                        <li><a href="dichvu1.html">DỊCH VỤ</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- end header -->
        <img src="assets/images/contact.jpg"   width="100%" height="520hv"  alt="">
        <div class="title">TRANG CHỦ > <b>THÔNG TIN KHÁCH HÀNG</b></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="heading"><h1>Điền thông tin của bạn</h1></div>
            </div>
            
            <div class="col-md-2 col-md-offset-1 "></div>
            <div class="col-md-6" style="margin-bottom: 30px;">
                <form name="form1" id="ff" method="post" action="#">
                    <div class="form-group">
                        <label for="fname">Họ và Tên: &ensp; </label>
                        <span style="color: red ; font-style: oblique;"> <?php echo $tenkhachhangErr; ?> </span>  
                        <input type="text" class="form-control" placeholder="Họ và Tên: *" name="input_tenkhachhang" id="name" required data-validation-required-message="Vui lòng điền tên của bạn">
                    </div>
                    <div class="form-group">
                        <label for="fname">Giới tính: &ensp; </label>
                        <select name="input_gioitinh"class="form-control" >
                                    <option value="0">Nam</option>
                                    <option value="1">Nữ</option>
                                </select>
        
                    </div>
                    <div class="form-group"> 
                        <label for="fname">Ngày sinh: &ensp; </label>
                        <span style="color: red ; font-style: oblique;"> <?php echo $ngaysinhErr; ?> </span>  
                        <input type="date" class="form-control" placeholder="Ngày Sinh *" name="input_ngaysinh" id="phone" required data-validation-required-message="Vui lòng điền ngày sinh của bạn">
                    </div>
                    <div class="form-group">
                        <label for="fname">CMND: &ensp; </label>
                        <span style="color: red ; font-style: oblique;"> <?php echo $cmndErr; ?> </span>  
                        <input type="text" class="form-control" placeholder="CMND *" name="input_cmnd" id="phone" required data-validation-required-message="Vui lòng điền CMND của bạn">
                    </div>
                    <div class="form-group">
                        <label for="fname">Số điện thoại: &ensp; </label>
                        <span style="color: red ; font-style: oblique;"> <?php echo $sdtErr; ?> </span>  
                        <input type="text" class="form-control" placeholder="Số điện thoại *" name="input_sdt" id="phone" required data-validation-required-message="Vui lòng điền số điện thoại của bạn">
                    </div>
                    <div class="form-group">
                        <label for="fname">Địa chỉ: &ensp; </label>
                        <span style="color: red ; font-style: oblique;"> <?php echo $diachiErr; ?> </span>  
                        <input type="text" class="form-control" placeholder="Địa chỉ " name="input_diachi" id="phone">
                    </div>
                        <div class ="containt">
                            <button type="submit" class="btn btn-3" onclick="return confirm('Xác nhận đặt phòng, bạn có chắc chắn không hối hận chứ ???')" style="margin-left:600px;background:orange">Đặt phòng</button>
                        </div>
                    </div>
                </form>
                </div>
                    <div class ="containt">
                        <a href="giohangdatphong.php"><button  class="btn btn-3" style ="position: absolute; left: 26%; bottom: -135%;background:#ffcc5e">⇽ Quay lại giỏ</button></a>
                    </div>
                </div>

            </div>
            <!-- end content -->
            <div id="footer" style="margin-top:100px;">
                <div class="container">
                    <div class="box logo-footer">
                        <div class="box-head">
                           <!--  <h3><i class="far fa-grin-squint-tears"></i>
                                <i class="far fa-laugh-squint"></i>
                                <i class="far fa-grin-hearts"></i>
                                <i class="far fa-kiss-beam"></i>
                            </h3> -->
                        </div>
                        <div class="box-body">
                            <a href=""><img src="assets/images/logo6.png" alt=""></a>
                        </div>
                    </div>
                    <div class="box about-us">
                        <div class="box-head">
                            <h3>ĐỊA CHỈ LIÊN HỆ:</h3>
                        </div>
                        <div class="box-body">
                            <p> ĐỊA CHỈ: Phao-sần-ba-lây City - Cali-Phọt-Nia Country <br>
                                <b>E:</b></b> INFO@THEROYAL.VN -<b>W:</b> WWW.THEOROYAL.VN <br>
                                <b>F:</b> (+84)236 3586 225 -<b>T:</b>: (+84)236 3586 222 <br>
                            </p>
                            <a href="">Theroyalhotel.vn</a>
                        </div>
                    </div>
                    <div class="box follow-us">
                        <div class="box-head">
                            <h3>THEO DÕI:</h3>
                        </div>
                        <div class="box-body">
                            <ul class="list-social d-flex">
                                <li>
                                    <a href=""><i class="fab fa-facebook-square"></i></a>
                                </li>
                                <li>
                                    <a href=""><i class="fab fa-instagram-square"></i></a>
                                </li>
                                <li>
                                    <a href=""><i class="fab fa-youtube"></i></a>
                                </li>
                                <li>
                                    <a href=""><i class="fab fa-pinterest-square"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end footer -->
            <div id="wp-copyright">
                <div class="container justify-content-between">
                    <p class="copyright"><i class="fas fa-globe"></i> Khách sạn: The Royal Hotel Cali-Phọt-Nia</p>
                    <ul id="footer-menu" class="d-flex">
                        <li><a href="">Bảo mật</a></li>
                        <li><a href="">Quảng cáo</a></li>
                        <li><a href="">Liên hệ</a></li>
                    </ul>
                </div>
            </div>
        </div>
</body>
</html>