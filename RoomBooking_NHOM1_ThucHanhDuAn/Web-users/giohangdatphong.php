<!----------------------------------- Code PHP -->
<!-- Handle cart -->
<?php
    require_once('./code_php/database/dbhelper.php');
?>
<?php

    session_start();

    If(!isset($_SESSION['giohang'])){ $_SESSION['giohang'] = [];}
    // If(isset($_GET['delcart']) && ($_GET['delcart' == 1])) unset($_SESSION['giohang']);
    // Khi bấm submit thì thêm giõ hàng
    If(isset($_POST['themphong']) && ($_POST['themphong'])){
        $MaLoaiPhong = $_POST['input_maloai'];
        $TenLoai = $_POST['input_tenloai'];
        $DonGia = number_format(intval($_POST['soluong']) * intval(str_replace(",", "", $_POST['input_dongia'])));
        $Mota = $_POST['input_mota'];
        $HinhAnh = $_POST['input_hinhanh'];
        $SoLuongPhong = $_POST['soluong'];
        $DonGiaLoai = $_POST['input_dongia'];
        //features: Kiểm tra số lượng đặt phòng có lớn hơn trong kho hay không
        $sql =  "   SELECT loaiphong.MaLoaiPhong, COUNT(MaPhong) as SoLuongPhong
                    FROM loaiphong LEFT JOIN phong on loaiphong.MaLoaiPhong = phong.MaLoaiPhong
                    WHERE phong.TinhTrang = 'Còn' and loaiphong.MaLoaiPhong = '".$MaLoaiPhong."'
                    GROUP by loaiphong.MaLoaiPhong
                ";
        $Check_RoomNumber = executeSingleResult($sql); //Số lượng phòng trong kho trống trong CSDL

        // Kiểm tra xem có tồn tại sản phẩm trong giõ hàng chưa
        $exist_items = 0; //Biến kiểm tra = 0 là chưa tồn tại
        for( $i=0; $i < sizeof($_SESSION['giohang']); $i++){
            if( $_SESSION['giohang'][$i][0] == $MaLoaiPhong ){
                // echo "hihih";
                $exist_items = 1; // đã tồn tại trong giõ hàng

                $SoLuongPhongNew = intval($SoLuongPhong) + intval($_SESSION['giohang'][$i][5]);
                $DonGiaNew = number_format($SoLuongPhongNew * intval(str_replace(",", "", $_SESSION['giohang'][$i][6]))); //$DonGia là 1 biến mới thêm và khi tìm được mã hàng trùng thì cộng dồn biến mới vào hàng trùng với mã đó
                // Checking Số lượng cộng dồn có > Số lượng CSDL không, nếu có thì out và note 
                if( $SoLuongPhongNew > intval($Check_RoomNumber['SoLuongPhong'])){
                    $exist_items = 2; // vượt quá số lượng phòng trống
                    $note_RoomNumber = ' * Số phòng của loại '. $_SESSION['giohang'][$i][1].' đã vượt quá cho phép!!!\n * Thêm phòng thất bại';
                    phpAlert($note_RoomNumber);
                    break;
                }
                $_SESSION['giohang'][$i][2] = $DonGiaNew;
                $_SESSION['giohang'][$i][5] = $SoLuongPhongNew;
                // echo $DonGiaNew;
                break;
            }
        }
        // Kiểm tra và thêm vào giõ hàng nếu chưa tồn tại
        if( $exist_items == 0 && $SoLuongPhong > 0){
            $sp = [$MaLoaiPhong, $TenLoai, $DonGia, $Mota, $HinhAnh, $SoLuongPhong, $DonGiaLoai];
            $_SESSION['giohang'][] = $sp;
        }
        // var_dump($_SESSION['giohang']);
        header("Refresh:0; url=giohangdatphong.php"); // Để refresh value in $_POST để không bị lập khi Reload Website 

    }
    // Xóa giõ hàng được chỉ định
    If( isset($_GET['del_cart']) && ($_GET['del_cart'] >= 0) ){
        array_splice($_SESSION['giohang'],$_GET['del_cart'],1); //array_splice: sử dụng để xóa hàng hay kí tự trong mảng
    }
    
    $numbers_date = 0;
    if( isset($_SESSION['start_date']) && isset($_SESSION['end_date']) &&  (strtotime($_SESSION['end_date']) >= strtotime($_SESSION['start_date'])) ){
        // tính số ngày ở
        $numbers_date = (floor((abs(strtotime($_SESSION['start_date']) - strtotime($_SESSION['end_date']))) / (60*60*24)) + 1);
        // Convert kiểu ngày
        $Show_start_date = date("d-m-Y", strtotime($_SESSION['start_date']));  
        $Show_end_date = date("d-m-Y", strtotime($_SESSION['end_date'])); 
    }else{
        $Show_start_date = $Show_end_date = '';
        // number-date condition notification
        $note = 'Vui lòng nhập chính xác ngày như hướng dẫn!!! \nChơi vậy mà coi được à :)';
        phpAlert($note);
        // Quay trở lại trang 
        header("Refresh:0; url=hethongphong.php");
    }

    // Feature: Thông báo bằng JS
    function phpAlert($msg) {
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }
    
    // unset($_POST); // Xóa giá trị biến
    // var_dump(): Sẽ in ra thông tin của biến và kiểu dữ liệu
    // $_SESSION['giohang'] = []; //xóa giõ hàng để kiểm tra
?>
<!-- ----------------------------------- Code CSS-->
<style>
    input[type=date]{
      /* width: 100%; */
      padding: 3px 10px;
      margin: 8px 0;
      box-sizing: border-box;
      border: 3px solid #e9d8f4;
      -webkit-transition: 0.5s;
      transition: 0.5s;
      outline: none;
    }
</style>

<!----------------------------------- Code HTML -->
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
    <title>Giỏ hàng đặt Phòng</title>
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
        <img src="assets/images/contact.jpg"  width="100%" height="520hv"  alt="">
        <div class="title">TRANG CHỦ > <b>GIỎ ĐẶT PHÒNG</b></div>
        <hr>
        <div style= "margin-left: 10%; font-size: 20px;">
            Thời gian ở: <b style= "color:#f75200; font-size:25px; margin-left:10px;"><?=$Show_start_date?> ➜  <?=$Show_end_date?></b>    
        </div>
        <div class="box">
            <div class="box-head">
                <h2>GIỎ ĐẶT PHÒNG</h2>
            </div>
            <!-- Decription Cart -->
<?php
    $TongPhong = $TongTien = $TongPhieuThue = $TongThanhTien = 0; 
    // $sp = [$MaLoaiPhong, $TenLoai, $DonGia, $Mota, $HinhAnh, $SoLuongPhong];
    if(isset($_SESSION['giohang']) && (is_array($_SESSION['giohang']) && sizeof($_SESSION['giohang']) > 0 )){
        for( $i=0; $i < sizeof($_SESSION['giohang']); $i++){
            $TongPhong += intval($_SESSION['giohang'][$i][5]);
            $TongTien += intval(str_replace(",","",$_SESSION['giohang'][$i][2]));
            // $TongPhieuThue += intval($_SESSION['giohang'][$i][5]) * intval(str_replace(",","",$_SESSION['giohang'][$i][2]));
            echo '
            <div class="row " style="border: 7px inset orange;">
                <div class="productwell">
                    <div class="col-md-3">
                        <div class="image">
                            <img src=" ../Web-admin/img/img-LoaiPhong/'.$_SESSION['giohang'][$i][4].'" style="width:333px; height:222px; margin-left: 8%; margin-top: 15%" />
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="caption" >
                            <div class="name" ><h5 style ="color:Red; margin-left: 5%">'.$_SESSION['giohang'][$i][1].'</h5></div>
                            <div class="info" style ="color:#2e2e2e">
                                <ul>
                                    <li style="font-size: 16px;font-weight: 666; position: absolute; left: 700px; top: 44px;" >
                                        <i>- Số phòng ở: <b style="font-size:25px; color:#ff3e1c; margin-left:0%">'.$_SESSION['giohang'][$i][5].'</b></i>
                                    </li>
                                    <li style="font-size: 16px;font-weight: 666; position: absolute; left: 700px; top: 80px;" >
                                        <i>- Thành tiền: <b style="font-size:25px; color:#ff3e1c; margin-left:0%">'.$_SESSION['giohang'][$i][2].' Vnđ</b></i>
                                    </li>
                                    <li style="font-size: 18px;font-weight: 666"><i>- Mô tả: </i></li>
                                    <div style="margin-left: 2%">
                                        '.$_SESSION['giohang'][$i][3].'
                                        <br>
                                    </div>
                                </ul>
                            </div>
                            <div class="price" style ="color:#2e2e2e">
                                <i style="font-size: 18px; font-weight: 666">- Giá loại: </i>
                                <b style="font-size: 20px;font-weight: 400; color: red; margin-left:2%"> '.$_SESSION['giohang'][$i][6].' Vnd</b>
                            </div>
                            <a href="giohangdatphong.php?del_cart='.$i.'" class="btn btn-3 pull-right ">Xóa loại</a>
                            <hr>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>	
            </div>
                 ';
        }
        $_SESSION['SoLuongPhong'] = $TongPhong;
        $_SESSION['ThanhTien'] = $TongThanhTien = ($TongTien * $numbers_date);
    }
?>
            <hr>
			<div class="row">
				<div class="col-md-1 col-md-offset-1 ">
					<center><a href="hethongphong.php" class="btn btn-3 " style ="background:#ffcc5e">⇽ Tiếp Tục Lựa Phòng</a></center>
				</div>
				<div class="col-md-1 col-md-offset-7 ">
                    <center><a class="btn btn-3" onclick="CheckCart()" style ="background:orange; color:black">Tiến hành đặt phòng ⇾</a></center>
				</div>
			</div>
            <script type="text/javascript">
                // JS Check inside cart trống hay không?
                function CheckCart() {
                    $.ajax({
                        type: "POST",
                        url: './code_php/giohangdatphong/ajax_CheckCart.php',
                        data:{action:'call_this'},
                        success:function(html) {
                            // Kết quả là số lượng trong giỏ hàng
                            var check = parseInt(html);
                            if (check == 1){
                                alert("Giỏ hàng trống \nKhông thể đặt phòng!!!");
                            }else if (check == 2){
                                alert("Ngày ở sai quy định\nKhông thể đặt phòng!!!");
                            }else if (check == 3){
                                alert("Ngày bắt đầu phải lớn hơn hoặc bằng ngày hôm nay\nKhông thể đặt phòng!!!");
                            }else{
                                window.location = "khachhang.php";
                            }
                        }
                    });
                }
            </script>
            <!-- Charge Price -->
            <div class="row">
                <div class="pricedetails">
                    <div class="col-md-4 col-md-offset-5">
                        <table style="font-size:20px">
                            <h6 style="margin-bottom:4%;">Thông tin thanh toán: </h6>
                            <tr>
                                <td>Tổng số phòng: </td>
                                <td style="font-weight: 450; color:#593600"><?=$TongPhong?></td>
                            </tr>
                            <tr style="margin-bottom:4%;">
                                <td>Tổng ngày ở: </td>
                                <td id = "hihi" style="font-weight: 450; color:#593600"><?=$numbers_date?></td>
                            </tr>
                            <tr style="margin-bottom:4%;">
                                <td>Tổng tiền phòng: </td>
                                <td style="font-weight: 450; color:#593600"><?=number_format($TongTien)?></td>
                            </tr>
                            <tr style="border-top: 2px solid #333; margin-bottom:4%;">
                                <td><h6>TỔNG THÀNH TIỀN: </h6></td>
                                <td style="font-size:30px; font-weight: 700; color:#cf7d00"><?=number_format($TongThanhTien)?></td>
                            </tr>
                        </table>
                    </div>
                </div>
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