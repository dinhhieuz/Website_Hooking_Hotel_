<!-------------------------------- Code PHP -->
<!-- Xét đăng nhập -->
<?php
    session_start();
    if( !isset($_SESSION["user"]) ){
        header("location:login.php");
    }
?>
<?php
    require_once('./code_php/database/dbhelper.php');
?>
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

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                    
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
                    <h1 class="h3 mb-2 text-gray-800">QUẢN LÍ CHI TIẾT THÔNG TIN ĐẶT PHÒNG</h1>
                    <p class="mb-4"> Dữ liệu chi tiết thông tin đặt phòng của khách hàng <a target="_blank"

                        <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Database</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead style="color:#242424;  background:#90adf5 ;">
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã Phiếu Thuê</th>
                                            <th>Mã Phòng</th>
                                            <th>Loại Phòng</th>
                                            <th>Tên Khách hàng</th>
                                            <th>Đơn Giá Phòng</th>
                                            <th>Tổng Tiền</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                               
                                    <tbody>
<!-- Get list-data from Mysql to import table -->
<?php
    $ID_MaPhieuPhong = '';
    if (isset($_GET['id'])){
        $ID_MaPhieuPhong = "WHERE chitietphieuthue.MaPhieuThue = '".$_GET['id']."'";
    }
    $sql = "    SELECT chitietphieuthue.MaPhieuThue, chitietphieuthue.MaPhong, TenLoai, TenKhachHang , FORMAT(chitietphieuthue.DonGia,0) as DonGia, FORMAT(TongTien,0) as TongTien
                FROM chitietphieuthue LEFT JOIN phieuthue on chitietphieuthue.MaPhieuThue = phieuthue.MaPhieuThue 
                                      LEFT JOIN khachhang on phieuthue.MaKhachHang = khachhang.MaKhachHang 
                                      LEFT JOIN phong on chitietphieuthue.MaPhong = phong.MaPhong 
                                      LEFT JOIN loaiphong on phong.MaLoaiPhong = loaiphong.MaLoaiPhong 
                ".$ID_MaPhieuPhong."

            ";
    $Detail_List = executeResult($sql);
    $index = 1;

    foreach ($Detail_List as $item) {
        $Note = "'Bạn có chắc chắn xoá phòng này không ?'";
        echo    '<tr>
                    <td>'.($index++).'</td>
                    <td>'.$item['MaPhieuThue'].'</td>
                    <td>'.$item['MaPhong'].'</td>
                    <td>'.$item['TenLoai'].'</td>
                    <td>'.$item['TenKhachHang'].'</td>
                    <td>'.$item['DonGia'].'</td>
                    <td>'.$item['TongTien'].'</td>
                    <td>
                        <button type="button" rel="tooltip" title="" class="btn btn-danger btn-link btn-sm">
                            <a onclick="return confirm('.$Note.')" href="./code_php/ChiTietPhieuThue/del_ChiTietPhieuThue.php?id='.$_GET['id'].$item['MaPhong'].'"><i class="material-icons" style="color: black;font-weight: bolder;">DELETE</i></a>
                        </button> </td>
                </tr>';
}
?>
                                       
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
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