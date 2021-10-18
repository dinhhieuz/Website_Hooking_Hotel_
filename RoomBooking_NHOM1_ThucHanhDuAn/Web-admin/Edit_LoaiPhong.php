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
    $Note_HinhAnh = "";

    $MaLoaiPhong = $TenLoai = $DonGia = $Mota = $HinhAnh = '';
    //--- Get information from MySql for parameter input
    if( isset($_GET['id']) ){
        $MaLoaiPhong = $_GET['id'];
        $sql = "SELECT * FROM loaiphong WHERE MaLoaiPhong = '".$MaLoaiPhong."'";
        $category = executeSingleResult($sql);
        if( $category != NULL ){
            $MaLoaiPhong = $category['MaLoaiPhong'];
            $TenLoai = $category['TenLoai'];
            $DonGia = $category['DonGia'];
            $Mota = $category['Mota'];
            $HinhAnh = $category['HinhAnh'];
        }
    }
    // show up error
    $tenloaiErr = $dongiaErr = $hinhanhErr = "";
    //--- Function Edit LOAIPHONG table in Database
    if( !empty($_POST) ) {
        // Kiểm tra update
        $test = 1;
        if(isset($_POST['input_MaLoaiPhong'])){
            $MaLoaiPhong = $_POST['input_MaLoaiPhong'];
        }
        if(isset($_POST['input_TenLoai'])){
            $_POST['input_TenLoai'] = str_replace('"','\\"',$_POST['input_TenLoai']);

            if(isset($_POST['input_TenLoai'])) { 
                if (empty($_POST["input_TenLoai"])) {
                    $tenloaiErr = "Tên loại phòng là bắt buộc.";
                    $test = 0;
                } else {
                    //Kiểm tra độ dài của tên loại
                    if (strlen ($_POST["input_TenLoai"]) > 50) {
                        $tenloaiErr = "Tên Loại Phòng phải là 50 ký tự.";
                        $test = 0;
                    }
                    else{
                        $TenLoai = $_POST['input_TenLoai'];
                    }
                }
            }
        }
        if(isset($_POST['input_DonGia'])){
            if (empty($_POST["input_DonGia"])) {
                $dongiaErr = "Đơn Giá là bắt buộc.";
                $test = 0;
            } else {
                // Kiểm tra xem đơn giá đã đúng định dạng hay chưa 
                if (!preg_match ("/^[0-9]*$/", $_POST["input_DonGia"]) ) {
                    $dongiaErr = "Bạn chỉ được nhập giá trị số.";
                    $test = 0;
                }else{
                    $DonGia = $_POST["input_DonGia"];
                }
            }
        }
        if(isset($_POST['input_Mota'])){
            $Mota = str_replace('"','\\"',$_POST['input_Mota']);
        }

        if(basename($_FILES['input_HinhAnh']['name']) != NULL){
            //Tên hình
            $HinhAnh = basename($_FILES['input_HinhAnh']['name']);
            $target_dir = "./img/img-LoaiPhong/";
            $target_file = $target_dir . $HinhAnh;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            if ($_FILES["input_HinhAnh"]["size"] > 2101250) {
                $hinhanhErr = "File ảnh của bạn quá lớn, không được vược quá 2 mb";
                $test = 0;
            }elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $hinhanhErr = "File ảnh phải thuộc loại PNG, JPEG, GIF";
                $test = 0;
            }else{
                if (move_uploaded_file($_FILES["input_HinhAnh"]["tmp_name"], $target_file)){
                    // upload trực tiếp trên dòng if và kiểm tra True thì về Fasle
                }else {
                    $hinhanhErr  = "Upload thấp bại, hãy kiểm tra file của bạn"; 
                    $test = 0;
                }
            }
        }
        if ( $test == 1){
            $sql = "UPDATE loaiphong 
                    SET TenLoai = '".$TenLoai."', DonGia = ".$DonGia.", Mota = '".$Mota."', HinhAnh = '".$HinhAnh."' 
                    WHERE MaLoaiPhong = '".$MaLoaiPhong."'
                    ";
            // echo $sql;
            execute($sql);
            header('Location: Bang_Phong.php');
        }
        

    }
?>
<!-------------------------------- Code Style -->
  <style> 
    input[type=text] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      box-sizing: border-box;
      border: 3px solid #e9d8f4;
      -webkit-transition: 0.5s;
      transition: 0.5s;
      outline: none;
    }

    input[type=text]:focus {
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
<!-------------------------------- Code HTML -->
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
                    <span>Đặt phòng</span></a>
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
                    <h1 class="h3 mb-2 text-gray-800">SỬA THÔNG TIN LOẠI PHÒNG</h1>
                    <p class="mb-4">Thông tin loại phòng của khách sạn <a target="_blank"
                        <!-- DataTales Example -->
                        <form role="form" action="#" method="post" enctype="multipart/form-data">
                            <!-- Input Mã Loại phòng -->
                            <div><label for="fname" readonly>Mã Loại Phòng*: </label>
                                    <input type="text" id="fname" name="input_MaLoaiPhong" value="<?=$MaLoaiPhong?>" disabled>
                                </div> 
                            <!-- Input Tên Loại phòng -->
                            <div><label for="fname">Tên Loại Phòng: &ensp; </label>
                                <span style="color: red ; font-style: oblique;"> <?php echo $tenloaiErr; ?> </span>  
                                <input type="text" id="fname" name="input_TenLoai" value="<?=$TenLoai?>">
                                </div> 
                            <!-- Input Đơn giá -->
                            <div><label for="fname">Đơn Giá: &ensp; </label>
                                    <span style="color: red; font-style: oblique;"> <?php echo $dongiaErr; ?> </span> 
                                    <input type="text" id="fname" name="input_DonGia" value="<?=$DonGia?>">
                                 </div> 
                            <div>
                            <!-- Input Hình ảnh -->
                            <div><label for="fname">Hình Ảnh Phòng: &ensp; </label>
                                <span style="color: red; font-style: oblique;"> <?php echo $hinhanhErr; ?> </span><br>
                                <input type="file" id="fname" name="input_HinhAnh" value=""><br><br>
                            </div> 
                            <!-- Input Mô tả -->
                            <div style="margin-bottom: 25px;"><label for="fname">Mô tả: <a href="https://gokisoft.com/editor?keycode=200927161231r" style="margin-left:10px"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-text-fill" viewBox="0 0 16 16"><path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm3.5 1a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5z"/></svg></a></label>
                            <textarea placeholder="Mô Tả" name="input_Mota"><?=$Mota?></textarea>
                            <input type="submit" value="Cập Nhập" name="verify_input">
                            </form>
                          </div>  
                        </div>
                </div>
                <!-- <script type="text/javascript">
                    $(function() {
                        //wait loading content website => handle this javascript
                        $('#content_mota').summernote();
                    })
                </script> -->
                
                  <!-- End of Main Content -->
                  <!-- Footer -->
                  <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; N1 HOTEL 2021</span>
                        </div>
                    </div>
                </footer>
<!-- End of Footer -->   
                <!-- /.container-fluid -->

            </div>
            
          
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

    