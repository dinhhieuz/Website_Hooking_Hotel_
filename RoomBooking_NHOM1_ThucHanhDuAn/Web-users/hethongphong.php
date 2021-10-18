<!-------------------------------- code PHP -->
<?php
    require_once('./code_php/database/dbhelper.php');
?>
<?php
    session_start();

    // Hiển thị thông báo đặt phòng
    if ( !isset($_SESSION['Inform_date_start'])){
        $_SESSION['Inform_date_start'] = '';
    }
    if ( !isset($_SESSION['Inform_date_end'])){
        $_SESSION['Inform_date_end'] = '';
    }
    // Kiểm tra điều kiện nếu test_date ở trong "./code_php/giohangdatphong/ajax.php"
    // features: để hiển thị và giới hạn range-date, then onchange 1 in 2 argument thì reset hiện thị và limit range-date
    if( !isset($_SESSION['test_date']) ){
        $start_date = $end_date = date("Y-m-d");
        $start_min_limit_rangedate = $end_min_limit_rangedate = date("Y-m-d");
        
    }else{
        $start_date = $_SESSION['start_date'];
        $end_date = $_SESSION['end_date'];
        $start_min_limit_rangedate = date("Y-m-d");
        $end_min_limit_rangedate = $_SESSION['start_date'];
    }
    $max_limit_rangedate = date('Y-m-d', strtotime(' + 1 years'));
    
?>
<!---------------------------------- code CSS -->
<style>
    input[type=date]{
      /* width: 100%; */
      padding: 5px 10px;
      margin: 8px 0;
      box-sizing: border-box;
      border: 3px solid #e9d8f4;
      -webkit-transition: 0.5s;
      transition: 0.5s;
      outline: none;
    }
</style>
<!-------------------------------- code HTML -->
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
    <link rel="stylesheet" href="css/ButtonSearch_hethongphong.css">
    <title>Hệ thống phòng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <!-- Core source Javascript -->
    <!-- jQuery and Modernizr-->
    <script src="js/jquery-2.1.1.js"></script>
     
     <!-- Core JavaScript Files -->  	 
     <script src="js/bootstrap.min.js"></script>
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
        <img src="assets/images/contact.jpg" width="100%" height="520hv" alt="">
        <div class="title">TRANG CHỦ ><b>HỆ THỐNG PHÒNG</b></div>
        <hr>
        <div class="box">
            <div class="box-head">
                <h2>HỆ THỐNG PHÒNG</h2>
            </div>
            <div class="container d-flex-wrap">
                <div class="about">
                        Khách sạn The Royal Hotel cao 16 tầng với 219 phòng nghỉ đạt tiêu chuẩn quốc tế với hướng
                        nhìn thoáng đãng ra khu đô thị mới. Nội thất sang trọng, tiện nghi, dịch vụ cao cấp sẽ là điểm
                        nhấn
                        đặc
                        biệt của The Royal Hotel khi đặt chân đến vùng đất<b style = "color: #f75200"> Cali-Phọt-Nia.</b> <br><br>
                        <b>Giờ check-in: </b>2h00 <br>
                        <b>Giờ check-out: </b>12h00 <br><br>
                        Nếu Quý khách có bất cứ câu hỏi gì về việc đặt phòng, vui lòng liên hệ với chúng tôi qua số
                        Hotline:
                        <b>(+84)236 3586 222</b>
                        <br><br>
                        <b>Hướng dẫn đặt phòng: </b><br>
                        <ol>
                            <li>Khách hàng tiến hành chọn ngày bắt đầu và ngày kết thúc muốn ở lại <i  style = "color: #f75200">(ngày bắt đầu lớn hoặc bằng ngày kết thúc)</i></li>
                            <li>Chọn loại phòng và số lượng phòng muốn đặt</li>
                            <li>Ấn nút "Chọn Phòng" để lựa chọn</li>
                            <li>Sau khi chọn khách hàng sẽ đến trang giỏ hàng để xem danh sách ở và tổng tiền trả</li>
                            <li>Ở trang giỏ hàng khách hàng chọn "Tiếp tục đặt phòng" để chọn loại mong muốn</li>
                        </ol> 
                </div>
                <!-- Chọn ngày để đặc phòng -->
                <div class="col text-center" style="text-algin: center; margin-top: 30px">
                    <h3>CHỌN NGÀY Ở</h3>
                    <form role="form" method="post">
                        <table  style="margin:auto;">
                            <tr>
                                <td width="140px" style="font-size: 18px;font-weight: 500; color: #f75200">
                                    Ngày bắt đầu: 
                                </td>
                                <td width="210px">
                                    <input type="date" id="input_startdate" style="<?=$_SESSION['Inform_date_start']?>" name="input_ngaybatdau" onchange="upgrade_s_date(this.value)" value="<?=$start_date?>" min="<?=$start_min_limit_rangedate?>" max="<?=$max_limit_rangedate?>"> 
                                </td>
                                <td width="140px" style="font-size: 18px;font-weight: 500; color: #f75200">
                                     Ngày kết thúc: 
                                </td>
                                <td width="121px">
                                    <input type="date" id="input_enddate"  style="<?=$_SESSION['Inform_date_end']?>" name="input_ngayketthuc" onchange="upgrade_e_date(this.value)" value="<?=$end_date?>" min="<?=$end_min_limit_rangedate?>" max="<?=$max_limit_rangedate?>"> 
                                </td>
                            </tr>
                        </table>
                    </form>

                    <!-- JS sử dụng để lấy 2 ngày bắt đầu và kết thúc ban đầu khi chưa onchange -->
                    <script>
                        var start_date = document.getElementById("input_startdate").value; // Lấy giá trị bằng id
                        var end_date = document.getElementById("input_enddate").value; 
                        // Tạo ajax liên kiến với file ajax.php và truyền dict với 3 keys và 3 values
                        $.ajax({
                                type: "POST",
                                url: './code_php/giohangdatphong/ajax.php',
                                data:{action:'call_this', start: start_date, end: end_date},
                                success:function(html) {
                                    // value return result bằng string trong biến "html"
                                    // alert(html);
                                }
                            });
                    </script>
                    <!-- JS sử dụng để lấy 2 biến input khi onchange của ngày bđ và ngày kthuc, xữ lý riêng lẽ từng hàm -->
                    <script type="text/javascript">
                        // JS handle change start_date
                        function upgrade_s_date(start_date_j) {
                            $('#input_enddate').attr('min', $('#input_startdate').val() );
                            $.ajax({
                                type: "POST",
                                url: './code_php/giohangdatphong/ajax.php',
                                data:{action:'call_this', start: start_date_j},
                                success:function(html) {
                                    // alert(html);
                                    location.reload(true);
                                }
                            });
                        }
                        // JS handle change end_date
                        function upgrade_e_date(end_date_j) {
                            $.ajax({
                                type: "POST",
                                url: './code_php/giohangdatphong/ajax.php',
                                data:{action:'call_this', end: end_date_j},
                                success:function(html) {
                                    // alert(html);
                                    location.reload(true);
                                }
                            });
                        }
                    </script>
                    <br>
                    <!-- Content about list type of room -->

                    <h3>DANH SÁCH LOẠI PHÒNG</h3>
                </div>
                
                <!-- function search -->
                <div class = "container" id = "button_search" style="background:#fffbd1; max-width: 1000px; margin-bottom: 10px; ">
                    
                    <form role="form" action="#" method="post">
                        <div class="input-group mb-3">
                            <select class="form-select" id="inputGroupSelect01" name="input_search_LoaiPhong">
                                <option selected value="">Tất cả loại phòng</option>
<?php
    $sql_catagory = ' SELECT MaLoaiPhong, TenLoai FROM loaiphong  ';
    $category_TypyRoom = executeResult($sql_catagory);
    foreach ($category_TypyRoom as $items_category) {
        echo '
                <option value="'.$items_category['MaLoaiPhong'].'">'.$items_category['TenLoai'].'</option> 
             ';
    }

?>
                            </select>
                            <input id="inputText"type="text" class="form-control"  name="input_search_Mota" placeholder="Thông tin phòng..." aria-label="Example text with button addon" aria-describedby="button-addon1">
                            <input td="inputSubmit" type="submit" value="Tìm kiếm"  name="input_search_submit">
                        </div>    
                    </form>
                    <a id="button_giohang" href="giohangdatphong.php"><button class="btn btn-3" style ="background:Orange">Giỏ hàng ⇾</button></a>
                    
                </div>

                <!-- detailed list of room types -->
                <div>
                    <ul class="product-menu">
<?php
    $TypeSearch = $DecriptionSearch = '';
    if( isset($_POST['input_search_LoaiPhong']) && $_POST['input_search_LoaiPhong'] != ''){ $TypeSearch = " and loaiphong.MaLoaiPhong = '".$_POST['input_search_LoaiPhong']."' ";}
    if( isset($_POST['input_search_Mota']) && $_POST['input_search_Mota'] != ''){ $DecriptionSearch = " and loaiphong.Mota LIKE '%".$_POST['input_search_Mota']."%' ";}

    $sql = "    SELECT loaiphong.MaLoaiPhong, TenLoai, Format(DonGia,0) as DonGia, Mota, HinhAnh, COUNT(MaPhong) as SoLuongPhong
                FROM loaiphong LEFT JOIN phong on loaiphong.MaLoaiPhong = phong.MaLoaiPhong
                WHERE phong.TinhTrang = 'Còn' ".$TypeSearch.$DecriptionSearch." 
                GROUP by loaiphong.MaLoaiPhong
            ";
    // echo $sql;
    $detailed_list = executeResult($sql);
    foreach($detailed_list as $items){
        echo '
                <li class="product-item d-flex">
                    <img src="../Web-admin/img/img-LoaiPhong/'.$items['HinhAnh'].'" alt="" style="width:39%; height: 48vh; margin: 0px;">
                    <p>
                        <b>Tên Loại: <b style="font-size: 18px; font-weight: 700; color: #fa9829">'.$items['TenLoai'].'</b></b><br>
                        <br>
                            '.$items['Mota'].'
                        <br><br>
                        <b> Phòng trống: </b><b style="font-size: 20px;font-weight: 700; color: #ff8a04">'.$items['SoLuongPhong'].'</b><br>
                        <b style="font-size: 17px;font-weight: 700; color: #ff8a04">Giá loại: </b>
                        <b style="font-size: 19px;font-weight: 400; color: #222121">'.$items['DonGia'].' Vnđ</b>

                        <form action="giohangdatphong.php?" method="POST">
                            <i id ="p_soluong">Phòng đặt: </i>
                            <input id="input_soluong" type="number" name="soluong" min="0" max="'.$items['SoLuongPhong'].'" value="1">
                            <input type="hidden" name="input_maloai" value="'.$items['MaLoaiPhong'].'" >
                            <input type="hidden" name="input_tenloai" value="'.$items['TenLoai'].'" >
                            <input type="hidden" name="input_dongia" value="'.$items['DonGia'].'" >
                            <input type="hidden" name="input_mota" value="'.$items['Mota'].'" >
                            <input type="hidden" name="input_hinhanh" value="'.$items['HinhAnh'].'" >
                            <div class="book-room"><input type="submit" name="themphong" value="Chọn loại"></div>
                        </form>
                    </p>
                </li>
        ';
    }
?>
                    </ul>
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
                            <ul class="list-social d-flex" >
                                <li id="facebook">
                                    <a href=""><i class="fab fa-facebook-square"></i></a>
                                </li>
                                <li id="instagram">
                                    <a href=""><i class="fab fa-instagram-square"></i></a>
                                </li>
                                <li id="youtube">
                                    <a href=""><i class="fab fa-youtube"></i></a>
                                </li>
                                <li id="pinterest">
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
