
<!-------------------------------- Code PHP -->
<!-- Xét đăng nhập -->
<?php
    session_start();
    if( !isset($_SESSION["user"]) ){
        header("location:login.php");
    }
?>
<?php
    require_once ("./code_php/database/dbhelper.php");
?>
<?php 
    $MaPhieuThue = $TenKhachHang = $GioiTinh = $NgaySinh = $CMND = $SDT = $NgayBatDau = $NgayKetThuc = $TinhTrang = '';
    //--- Get information from MySql for parameter input
    if( isset($_GET['id']) ){
        $MaPhieuThue = $_GET['id'];
        $sql = "SELECT MaPhieuThue, TenKhachHang, GioiTinh, NgaySinh, CMND, SDT, NgayBatDau, NgayKetThuc, TinhTrang 
                from phieuthue LEFT join khachhang on phieuthue.MaKhachHang = khachhang.MaKhachHang 
                WHERE MaPhieuThue = '".$MaPhieuThue."' ";
        $category = executeSingleResult($sql);
        if( $category != NULL ){
            $MaPhieuThue = $category['MaPhieuThue'];
            $TenKhachHang = $category['TenKhachHang'];
            $GioiTinh = $category['GioiTinh'];
            $NgaySinh = $category['NgaySinh'];
            $CMND = $category['CMND'];
            $SDT = $category['SDT'];
            $NgayBatDau = $category['NgayBatDau'];
            $NgayKetThuc = $category['NgayKetThuc'];
            $TinhTrang = $category['TinhTrang'];
        }
    }

    // show up error
    $tenKHErr = $ngaysinhErr = $sdtErr = $cmndErr = $ngaybatdauErr = $ngayketthucErr="";
    //--- Function Edit PHIEUPHONG table in Database
    if( !empty($_POST) ) {

        // Kiểm tra update
        $test = 1;

        if( isset($_POST['input_phieuthue']) ){ $MaPhieuThue = $_POST['input_phieuthue'];}
        // Kiểm tra Tên khách hàng
        if( isset($_POST['input_tenkhachhang']) ){ 
            $_POST['input_tenkhachhang'] = str_replace('"','\\"',$_POST['input_tenkhachhang']);
            if (empty($_POST["input_tenkhachhang"])) {
                $tenKHErr = "Bạn bắt buộc phải nhập tên";
                $test = 0;
            }elseif (!preg_match("/^([a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀẾỂưăạảấầẩẫậắằẳẵặẹẻẽềếểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+)$/i", $_POST['input_tenkhachhang'])) {
                // Kiểm tra và chỉ cho phép nhập chữ và khoảng trắng 
                $tenKHErr = "Bạn chỉ được nhập chữ cái và khoảng trắng. "; 
                $test = 0;
            }else{
                $TenKhachHang = $_POST['input_tenkhachhang'];  
                // header("Refresh:0; url=Bang_DatPhong.php"); // Refesh: "Time-Reload", URL="Đường dẫn hướng đến"         
            }
        }
        // Kiểm tra giới tính
        if( isset($_POST['input_gioitinh']) ){ $GioiTinh = $_POST['input_gioitinh'];}
        // Kiểm tra Ngày sinh
        if( isset($_POST['input_ngaysinh']) ){ 
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
        if( isset($_POST['input_cmnd']) ){ 
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
        if( isset($_POST['input_sdt']) ){ 
            $_POST['input_sdt'] = str_replace('"','\\"',$_POST['input_sdt']);

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
        // Kiểm tra ngày bắt đầu
        if( isset($_POST['input_ngaybatdau']) ){ 
            if (empty($_POST['input_ngaybatdau']) ){
                $ngaybatdauErr="Bạn bắt buộc phải nhập ngày bắt đầu";
                $test = 0;
            }else {
                //Kiểm tra và chỉ cho phép ngày bắt đầu lớn hơn ngày hiện tại
                $ngaybatdau =$_POST['input_ngaybatdau'];
                $entered_date=$_POST['input_ngayketthuc'];
                $dateTimestamp1 = strtotime($ngaybatdau);
                $dateTimestamp2 = strtotime($entered_date);
                $diff= $dateTimestamp1 - $dateTimestamp2;
                // echo $diff;
                if ($diff > 1){
                    $ngaybatdauErr="Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc ";
                    $test = 0;
                }else
                    {
                    $NgayBatDau = $_POST['input_ngaybatdau'];
                }
            }
        }
        // Kiểm tra ngày kết thúc
        if( isset($_POST['input_ngayketthuc']) ){ 
            if (empty($_POST['input_ngayketthuc']) ){
                $ngayketthucErr="Bạn bắt buộc phải nhập ngày kết thúc";
                $test = 0;
            }else {
                //Kiểm tra và chỉ cho phép ngày kết thúc > ngày hiện tại
                $ngaybatdau =$_POST['input_ngaybatdau'];
                $entered_date=$_POST['input_ngayketthuc'];
                $dateTimestamp1 = strtotime($ngaybatdau);
                $dateTimestamp2 = strtotime($entered_date);
                $diff= $dateTimestamp2-$dateTimestamp1;
                // echo $diff;
                if ( $diff < -1 ){
                    $ngayketthucErr= "Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu ";
                    $test = 0;
                }else {
                    $NgayKetThuc = $_POST['input_ngayketthuc'];
                }
            }
        }
        // Kiểm tra tình trạng
        if( isset($_POST['input_status']) ){$TinhTrang = $_POST['input_status'];}
        // Kiểm tra đầu vào thành công
        if ( $test == 1) {

            //----- Update KHÁCH HÀNG - Tên khách hàng, giới tính, ngày sinh, SĐT - CMND làm điều kiệt để chỉ định
            $sql_kh = " UPDATE khachhang 
                        set TenKhachHang = '".$TenKhachHang."', GioiTinh = ".$GioiTinh.", NgaySinh = '".$NgaySinh."', SDT = '".$SDT."' 
                        WHERE CMND = '".$CMND."'
                        ";
            execute($sql_kh);
            // echo($sql_kh);

            //----- Update PHIẾU THUÊ - Ngày bắt đầu, ngày kết thúc, trạng thái, Số ngày thuê (Để tính lại giá tiền)
            $sql_phieuthue = "  UPDATE phieuthue
                                SET NgayBatDau = '".$NgayBatDau."', NgayKetThuc = '".$NgayKetThuc."', TinhTrang = '".$TinhTrang."' , 
                                    SoNgayThue = timestampdiff(day,'".$NgayBatDau."','".$NgayKetThuc."') + 1
                                WHERE MaPhieuThue = '".$MaPhieuThue."'
                                ";
            execute($sql_phieuthue);
            // echo($sql_phieuthue);

            //----- Update CHI TIẾT PHIẾU THUÊ - Tổng Tiền
            $sql_chitietphieuthue = "   UPDATE chitietphieuthue left join phieuthue on chitietphieuthue.MaPhieuThue = phieuthue.MaPhieuThue
                                        SET chitietphieuthue.TongTien = (chitietphieuthue.DonGia * phieuthue.SoNgayThue)
                                        WHERE chitietphieuthue.MaPhieuThue = '".$MaPhieuThue."'
                                    ";
            execute($sql_chitietphieuthue);
            // echo($sql_chitietphieuthue);

            //----- Update PHIẾU THUÊ - Tính Sum "Thành tiền"
            $sql_phieuthue_thanhtien = "    drop temporary table if exists Sum_count_of_Phieuthue;
                                            create temporary table Sum_count_of_Phieuthue (s_maphieuthue char(8), count_songaythue int, sum_thanhtien int);
                                            insert into Sum_count_of_Phieuthue select maphieuthue, COUNT(chitietphieuthue.MaPhieuThue), sum(chitietphieuthue.TongTien) 
                                                                            from chitietphieuthue WHERE chitietphieuthue.MaPhieuThue = '".$MaPhieuThue."' group by maphieuthue;
                                            UPDATE phieuthue LEFT JOIN Sum_count_of_Phieuthue on phieuthue.MaPhieuThue = Sum_count_of_Phieuthue.s_maphieuthue
                                            set phieuthue.SoLuongPhong = count_songaythue, phieuthue.ThanhTien = sum_thanhtien
                                            WHERE phieuthue.MaPhieuThue = '".$MaPhieuThue."'
                                        ";
            Multiexecute($sql_phieuthue_thanhtien);
            //----
            //Rollback tất cả giá trị truyền vào
            If( $TinhTrang == 'Trả phòng' ) {
                $Get_list_chitietphieuthue = "  SELECT MaPhong FROM chitietphieuthue 
                                                WHERE MaPhieuThue = '".$MaPhieuThue."'
                                            ";
                $list_chitietphieuthue = executeResult($Get_list_chitietphieuthue);
                if ( sizeof($list_chitietphieuthue) > 0 ){
                    foreach( $list_chitietphieuthue as $items_phong ){
                        $sql_update_statusRoom = "  UPDATE phong
                                                    SET TinhTrang = 'còn'
                                                    WHERE MaPhong = '".$items_phong['MaPhong']."'
                                                    ";
                        execute($sql_update_statusRoom);
                    }
                }
            }
            // echo($sql_phieuthue_thanhtien);
            header("Refresh:0; url=Bang_DatPhong.php"); // Refesh: "Time-Reload", URL="Đường dẫn hướng đến" 
        }

    }
?>
<!------------------------------ Code CSS -->
  <style> 
    input[type=text],input[type=date]{
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      box-sizing: border-box;
      border: 3px solid #e9d8f4;
      -webkit-transition: 0.5s;
      transition: 0.5s;
      outline: none;
    }
    #input_status, #input_gioitinh{
      width: 100%;
      height: 50px;
      padding: 12px 20px;
      margin: 8px 0;
      box-sizing: border-box;
      border: 3px solid #e9d8f4;
      -webkit-transition: 0.5s;
      transition: 0.5s;
      outline: none;

    }
    input[type=text]:focus, #input_status, #input_gioitinh{
      border: 3px solid #58257b;
    }
    input[type=date]:focus{
      border: 3px solid #58257b;
    }
    input[type=submit] {
      width: 100%;
      background-color: #4e73df;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    textarea {
      width: 100%;
      height: 200px;
      padding: 12px 20px;
      box-sizing: border-box;
      border: 2px solid #ccc;
      border-radius: 4px;
      background-color: #f8f8f8;
      font-size: 16px;
      resize: none;
    }

</style>
<!-------------------------------------- Code HTML -->
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- add icon -->
    <link rel = "icon" href = "./img/img_logo/icon_web.png" type = "image/x-icon">


    <title>N1 HOTEL  - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">N1 HOTEL  Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Nav Item - Utilities Collapse Menu -->

            <!-- Heading -->
            <div class="sidebar-heading">
                QUẢN LÝ
            </div>

            
            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="Bang_DatPhong.php">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Đặt Phòng</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="Bang_Phong.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Phòng</span></a>
            </li>
           
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>
                    <h3 style = "color: #2f33c2; margin-left:35%">
                        <b>
                            QUẢN LÝ ĐẶT PHÒNG 
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-house" viewBox="0 1 16 20">
                                <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                                <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                            </svg>
                        </b>
                    </h3>
                    <!-- Topbar Search -->
                    <!-- <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">


                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <!-- sử dụng để hiển thị tên user -->
                                <?php
                                    echo "<span class='mr-2 d-none d-lg-inline text-gray-600 small' style='text-transform: capitalize;'>".$_SESSION["user"]."</span>"
                                ?>
                                <!-- <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span> -->
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">QUẢN LÍ  THÔNG TIN ĐẶT PHÒNG</h1>
                    <p class="mb-4"> Dữ liệu thông tin đặt phòng của khách hàng <a target="_blank"

                        <!-- DataTales Example -->

                        <form role="form" action="#" method="post">
                            <div class="container">
                                <div class="row"  style="border: 2px solid #c2bec4;">
                                    <!-- Update thông tin khách hàng -->
                                    <div class="col-sm-6"><p></p><label for="fname"><i style="color:#4e73df; font-size:20px; font-weight: 550;">- khách hàng -</i></label><p></p>
                                        <div><label for="fname">Tên Khách Hàng: &ensp; </label>
                                                <span style="color: red ; font-style: oblique;"> <?php echo $tenKHErr; ?> </span>  
                                                <input type="text" id="fname" name="input_tenkhachhang" value="<?=$TenKhachHang?>">
                                            </div> 
                                        <div><label for="fname">Giới Tính: &ensp; </label>
                                            <select class="form-control" name="input_gioitinh" id="input_gioitinh">
<?php
    $select_gioitinh1 = $select_gioitinh2 =$select_gioitinh3 = '';
    if ($GioiTinh == 1){
        $select_gioitinh1 = 'selected';
    }elseif ($GioiTinh == 0) {
        $select_gioitinh2 = 'selected';
    }else {
        $select_gioitinh3 = 'selected';
    }
    echo '
        <option '.$select_gioitinh2.' value="0">Nam</option>
        <option '.$select_gioitinh1.' value="1">Nữ</option>

    ';
?>
                                        </div> 
                                        <!-- Dòng ni bị ẩn do lỗi   -->
                                        <div><label for="fname">Ngày Sinh: &ensp; </label><input type="date1" value="" style="width: 0px; height: 0px;" hidden="true">
                                        </div>
                                        <!-- ----- -->
                                        <div><label for="fname">Ngày Sinh: &ensp; </label>
                                            <span style="color: red ; font-style: oblique;"> <?php echo $ngaysinhErr; ?> </span> 
                                            <input type="date" id="fname" name="input_ngaysinh" value="<?=$NgaySinh?>">
                                        </div>  
                                        <div><label for="fname">CMND: &ensp; </label>
                                            <span style="color: red ; font-style: oblique;"> <?php echo $cmndErr; ?> </span> 
                                            <input type="text" id="fname" name="input_cmnd" value="<?=$CMND?>" disabled>
                                        </div> 
                                        <div><label for="fname">Số Điện Thoại: &ensp; </label>
                                                <span style="color: red ; font-style: oblique;"> <?php echo $sdtErr; ?> </span> 
                                                <input type="text" id="fname" name="input_sdt" value="<?=$SDT?>">
                                        </div> 
                                    </div>
                                    <!-- Update thông tin phiếu thuê -->
                                    <div class="col-sm-6"><p></p><label for="fname"><i style="color:#4e73df; font-size:20px; font-weight: 550;">- phiếu thuê -</i></label><p></p>
                                        <div><label for="fname" readonly>Mã Phiếu Thuê: &ensp; </label>
                                            <input type="text" id="fname" name="input_phieuthue" value="<?=$MaPhieuThue?>" disabled>
                                        </div> 
                            
                                        <div><label for="fname">Ngày Bắt Đầu: &ensp; </label>
                                            <span style="color: red ; font-style: oblique;"> <?php echo $ngaybatdauErr; ?> </span> 
                                            <input type="date" id="fname" name="input_ngaybatdau" value="<?=$NgayBatDau?>">
                                        </div> 
                                        <div><label for="fname">Ngày Kết Thúc: &ensp; </label>
                                            <span style="color: red ; font-style: oblique;"> <?php echo $ngayketthucErr; ?> </span> 
                                            <input type="date" id="fname" name="input_ngayketthuc" value="<?=$NgayKetThuc?>">
                                        </div> 
                                        <div><label for="fname">Tình Trạng: &ensp; </label>
                                            <select class="form-control" name="input_status" id="input_status">
<?php
    $select_status1 = $select_status2 =$select_status3 = '';
    if ($TinhTrang == 'Xác nhận'){
        $select_status2 = 'selected';
    }elseif ($TinhTrang == 'Hủy phòng') {
        $select_status1 = 'selected';
    }elseif ($TinhTrang == 'Trả phòng') {
        $select_status0 = 'selected';
    }else {
        $select_status3 = 'selected';
    }
    echo '
        <option '.$select_status3.' value="">Đang Chờ</option>
        <option '.$select_status2.' value="Xác nhận">Xác nhận</option>
        <option '.$select_status1.' value="Hủy phòng">Hủy phòng</option>
        <option '.$select_status0.' value="Trả phòng">Trả phòng</option>
    ';
?>    
                                    
                                        </div> 
                                        <!-- Dòng ni bị ẩn do lỗi   -->
                                        <div><label for="fname">Ngày Sinh: </label><input type="date1" value="" style="width: 0px; height: 0px;" hidden="true">
                                        </div>

                                    </div>
                                </div>
                                    <input type="submit" value="Update" name="add_category_product">
                                </div> 
                            </form>
                          </div>  
                       </div>
                    <!-- Footer -->
                 <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; N1 HOTEL 2021</span>
                        </div>
                    </div>
                </footer>
<!-- End of Footer --> 
                </div>
                 
                  <!-- End of Main Content -->
                   
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

          
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
  
    