<?php
    session_start();
    // $_SESSION['bill_khachhang'] = [$NgayBatDau, $NgayKetThuc, $result_MaPhieuThue['MaPhieuThue'], $ThanhTien,  $TenKhachHang, $GioiTinh, $NgaySinh, $CMND, $SDT ];
    $NgayBatDau = $NgayKetThuc = $MaPhieuThue = $ThanhTien = '';
    $TenKhachHang = $GioiTinh = $NgaySinh = $CMND = $SDT = '';
    if ( sizeof($_SESSION['bill_khachhang']) > 0 ){
        $NgayBatDau = date("d/m/Y", strtotime($_SESSION['bill_khachhang'][0])); 
        $NgayKetThuc = date("d/m/Y", strtotime($_SESSION['bill_khachhang'][1])); 
        $MaPhieuThue = $_SESSION['bill_khachhang'][2];
        $ThanhTien = number_format($_SESSION['bill_khachhang'][3]);
        $TenKhachHang = $_SESSION['bill_khachhang'][4];
        if ( intval($_SESSION['bill_khachhang'][5]) == 0){
            $GioiTinh = "Nam";
        }else{
            $GioiTinh = "Nữ";
        }
        $NgaySinh = date("d/m/Y", strtotime($_SESSION['bill_khachhang'][6])); 
        $CMND = $_SESSION['bill_khachhang'][7];
        $SDT = $_SESSION['bill_khachhang'][8];
    }
    
    function refresh_all (){
        $_SESSION['bill_khachhang'] = [];
        $_SESSION['giohang'] = [];
        
        header("Refresh:0; url=../index.html");
    }
    if(array_key_exists('refresh_all', $_POST)) {
        refresh_all();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/nhahang&bar.css">
    <link rel="stylesheet" href="assets/css/style1.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">

    
    
    <title>THÔNG BÁO</title>
</head>

<body style="background-color: #FFFBD1">
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
         <section class="pt80 pb80 booking-section login-area thanksYou">
            <div class="container" >
              <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12" >
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="login-box Booking-box" style ="background:#f7f7f7; margin-left: 4%; width: 113%;">
                        <div class="login-top" >
                          <h3 style="font-size: 40px">XÁC NHẬN ĐẶT PHÒNG</h3>
                          <marquee width="50%" scrollamount="15"><p style="font-size: 20px">Cảm ơn ! Bạn đã đặt phòng thành công </p></marquee>
                          
                        </div>
                            <img src="./assets/images/sucess.png" alt="Girl in a jacket" width="6%" height="6%">
                           <div class="login-top cardInfo" >
                              <h3 style="font-size: 30px; margin-bottom: -35px">Thông tin đặt phòng </h3>
                            </div> 
                            <div style= "margin-left: 10%; font-size: 20px;">
                                <p style= "margin-right: 200px; margin-bottom: -30px"><b style= "font-weight: 500; "> Thời gian ở: </b><b style= "color:#f75200; font-size:25px; margin-left:10px;"><?=$NgayBatDau?> ➜  <?=$NgayKetThuc?></b></p><br>
                                <p style= "margin-right: 393px; margin-bottom: -30px"><b style= "font-weight: 500; "> Mã Phiếu: </b><b style= "color:#f75200; font-size:25px; margin-left:25px"><?=$MaPhieuThue?></b></p><br>
                                <p style= "margin-right: 400px; margin-bottom: 20px"><b style= "font-weight: 500; "> Tổng Tiền: </b><b style= "color:#f75200; font-size:25px; margin-left:20px;"><?=$ThanhTien?></b></p><br>
                                
                            </div>
                          <table style="margin-left: 140px;" >
                          <tbody  style="text-align: left;"  >
                                <tr style="margin-left: 100px">
                                    <td class="bookex" style="font-size: 20px;color: black; width:27%; font-weight: 500;">
                                        Tên khách hàng: 
                                    </td>
                                    <td style="font-size: 24px; width:39%; font-weight: 500; color:#f75200;"><?= $TenKhachHang ?></td>

                                    <td class="bookex" style="font-size: 20px;color: black; width:15%;font-weight: 500; ">
                                        CMND: 
                                    </td>
                                    <td style="font-size: 24px; font-weight: 500; color:#f75200;"><?= $CMND ?></td>
                                </tr>
                                <tr>
                                    <td class="bookex" style="font-size: 20px;color: black; font-weight: 500; ">Giới tính: </td>
                                    <td style="font-size: 24px; font-weight: 500; color:#f75200;"><?= $GioiTinh ?></td>
                                    <td class="bookex" style="font-size: 20px;color: black; font-weight: 500; ">SĐT: </td>
                                    <td style="font-size: 24px; font-weight: 500; color:#f75200;"><?= $SDT ?></td>
                                </tr>
                                    <tr>
                                    <td class="bookex" style="font-size: 20px;color: black; font-weight: 500; ">Ngày sinh: </td>
                                    <td style="font-size: 24px; font-weight: 500; color:#f75200; "><?= $NgaySinh ?></td>
                                </tr>       
                          </tbody>
                          
                        
                        </table>  
                        <br>
                            <div class="login-top cardInfo">
                              <h3 style="font-size: 26px">Cảm ơn quý khách đã sử dụng dịch vụ</h3>
                              <p style="font-size: 23px; margin-bottom: -50px">Chúc quý khách ngày mới tốt lành !!! </p>
                            </div>             
                              <div class="login-top cardInfo" style = "margin-top:-1% " >
                              <h3 style="font-size: 24px">Lời nhắn gửi</h3>
                              <p style="font-size: 20px"><i>Nhân viên sẽ sớm liên hệ quý khách để kiểm tra thông tin, xin hãy chú ý!!!<br>
                                      Chụp thông báo để dễ dàng và thuận tiện hơn trong quá trình nhận phòng</i>
                              </p>
                            </div>   
                        </div>
                    </div>
                  </div>
                </div>  
              </div>
            </div>
          </section>
        <form method = "post" >
                <center><input type="submit" id ="trangchu" name="refresh_all" class="btn btn-3 " value="Trang chủ ⇾" /></center>
        </form>
        <style>
            #trangchu{
                background: #75f1ff;
                color: #f54900; 
                border-radius: 8px;
                font-size: 28px; 
                width:19%;
                border: none;
                font-weight: 400;
                font-size: 36px;

            }
            #trangchu:hover{
                color: #00f7ff; 
                background: #ffae00;
                font-weight: 600;
                font-size: 40px;
            }
        </style>
        <!-- end content -->

        <div id="footer" style="margin-top:100px;">
            <div class="container">
                <div class="box logo-footer">
                    <!-- <div class="box-head">
                        <h3><i class="far fa-grin-squint-tears"></i>
                            <i class="far fa-laugh-squint"></i>
                            <i class="far fa-grin-hearts"></i>
                            <i class="far fa-kiss-beam"></i>
                        </h3>
                    </div> -->
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