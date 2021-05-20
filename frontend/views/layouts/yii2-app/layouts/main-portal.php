<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
frontend\assets\AppAsset::register($this);
dmstr\web\AdminLteAsset::register($this);

$query  = 'SELECT * FROM cms_portal WHERE id = 1';
$data = Yii::$app->db->createCommand($query)->queryOne();


?>
<?php $this->beginPage() ?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>CMT Online</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Content-Security-Policy: frame-ancestors 'self' https://example.com -->

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="portal/css/bootstrap.min.css">
    <link rel="stylesheet" href="portal/css/owl.carousel.min.css">
    <link rel="stylesheet" href="portal/css/magnific-popup.css">
    <link rel="stylesheet" href="portal/css/font-awesome.min.css">
    <link rel="stylesheet" href="portal/css/themify-icons.css">
    <link rel="stylesheet" href="portal/css/nice-select.css">
    <link rel="stylesheet" href="portal/css/flaticon.css">
    <link rel="stylesheet" href="portal/css/gijgo.css">
    <link rel="stylesheet" href="portal/css/animate.css">
    <link rel="stylesheet" href="portal/css/slicknav.css">
    <link rel="stylesheet" href="portal/css/style.css">
    <style>
    .loader {
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid blue;
      border-right: 16px solid green;
      border-bottom: 16px solid red;
      width: 150px;
      height: 150px;
      -webkit-animation: spin 2s linear infinite;
      animation: spin 2s linear infinite;
      margin-left: calc(50% - 50px);
      margin-top:15%;
    }

    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    </style>
    <!-- <link rel="stylesheet" href="portal/css/responsive.css"> -->
</head>

<body >
    <div class="col-xl-12 text-center" style="z-index: 800; position: fixed; height: 100%; display: none;" id="dontTouch">
    </div>
    <div class="col-xl-12 text-center" style="background-color: #828282ad; z-index: 1000; position: fixed; height: 100%; display: none;" id="loading">
        <div class="loader" ></div>
        <span style="margin-left: 4%;">Please Wait..</span>
    </div>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!-- header-start -->
    <header>
        <div class="header-area ">
            <div class="header-top_area">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-md-6 ">
                            <div class="social_media_links">
                                <a href="#">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                                <a href="#">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <a href="#">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="short_contact_list">
                                <ul>
                                    <li><a href="#"> <i class="fa fa-envelope"></i> cmtonline.care@gmail.com</a></li>
                                    <li><a href="#"> <i class="fa fa-phone"></i> +62811-993-762</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="sticky-header" class="main-header-area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-2">
                            <div class="logo">
                                <a href="index.html">
                                    <img src="portal/img/logo.png" width="250px" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-7">
                            <div class="main-menu  d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a class="active" href="<?= Url::to(['portal'])?>">home</a></li>
                                        <li><a href="<?= Url::to(['contact'])?>">Customer Services</a></li>
                                        <li><a href="<?= Url::to(['information'])?>">Information</a></li>
                                        <li class="login-class"><a href="<?= Url::to(['login'])?>">Login</a></li>
                                        <!-- <li><a href="#">blog <i class="ti-angle-down"></i></a>
                                            <ul class="submenu">
                                                <li><a href="blog.html">blog</a></li>
                                                <li><a href="single-blog.html">single-blog</a></li>
                                            </ul>
                                        </li> -->
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 d-none d-lg-block">
                            <div class="Appointment">
                                <div class="book_btn d-none d-lg-block">
                                    <!-- <a class="popup-with-form" href="#test-form">Make an Appointment</a> -->
                                    <a class="popup-with-form" href="<?= Url::to(['login'])?>">Login</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-end -->

    <!-- slider_area_start CUSTOME -->
     <div class="slider_area" id="banner">
        <div class="slider_active owl-carousel">
            <?php
                $banner = glob(Yii::$app->params['pathBanner']."banner*");
                foreach ($banner as $key => $value) {
                    $explode = explode('/', $value);
                    $filename = [];
                    $true = false;
                    foreach ($explode as $v) {
                        if ($v=='portal') {
                            $true = true;
                        }
                        if ($true) {
                           $filename[] = $v;
                        }
                    }
                    $filename = implode('/', $filename);
                    echo '<div class="single_slider  d-flex align-items-center" style="background-image: url('.$filename.') !important;">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xl-12">
                                           <!--  <div class="slider_text ">
                                                <h3> <span>Health care</span> <br>
                                                    For Hole Family </h3>
                                                <p>In healthcare sector, service excellence is the facility of <br> the hospital as
                                                    healthcare service provider to consistently.</p>
                                                <a href="#" class="boxed-btn3">Check Our Services</a>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>';
                }
            ?>
        </div>
    </div>
    <!-- slider_area_end -->

    <!-- service_area_start -->
    <div class="service_area" id="fitur">
        <div class="container p-0">
            <div class="row no-gutters">
                <div class="col-xl-4 col-md-4">
                    <div class="single_service">
                        <!-- <div class="icon">
                            <i class="flaticon-electrocardiogram"></i>
                        </div> -->
                        <?= $data['fitur1'] ?>
                        <!-- <a href="#" class="boxed-btn3-white">Apply For a Bed</a> -->
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="single_service">
                        <!-- <div class="icon">
                            <i class="flaticon-emergency-call"></i>
                        </div> -->
                        <?= $data['fitur2'] ?>
                        <!-- <a href="#" class="boxed-btn3-white">+10 672 356 3567</a> -->
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="single_service">
                        <!-- <div class="icon">
                            <i class="flaticon-first-aid-kit"></i>
                        </div> -->
                        <?= $data['fitur3'] ?>
                        <!-- <a href="#" class="boxed-btn3-white">Make an Appointment</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- service_area_end -->

    <!-- offers_area_start -->
    <div class="our_department_area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="section_title text-center mb-55" id="deskripsi">
                         <?= $data['deskripsi'] ?>
                        <!-- <h3>Welcome to CMT-Online</h3>
                        <p>Esteem spirit temper too say adieus who direct esteem. <br>
                            It esteems luckily or picture placing drawing. </p> -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-md-6 col-lg-4">
                    <div class="single_department">
                        <div class="department_thumb" id="deskripsi_img1">
                            <?php 
                            $banner = glob(Yii::$app->params['pathDeskripsi']."deskripsi_img1*");
                            foreach ($banner as $key => $value) {
                                $explode = explode('/', $value);
                                $filename = [];
                                $true = false;
                                foreach ($explode as $v) {
                                    if ($v=='portal') {
                                        $true = true;
                                    }
                                    if ($true) {
                                       $filename[] = $v;
                                    }
                                }
                                $filename = implode('/', $filename);
                                echo '<img src="'.$filename.'" alt="">';
                                break;
                            }
                            ?>
                        </div>
                        <div class="department_content">
                            <?= $data['deskripsi_text1'] ?>
                            <!-- <h3><a href="#">Eye Care</a></h3>
                            <p>Esteem spirit temper too say adieus who direct esteem.</p> -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-lg-4">
                    <div class="single_department">
                        <div class="department_thumb" id="deskripsi_img2">
                            <?php 
                            $banner = glob(Yii::$app->params['pathDeskripsi']."deskripsi_img2*");
                            foreach ($banner as $key => $value) {
                                $explode = explode('/', $value);
                                $filename = [];
                                $true = false;
                                foreach ($explode as $v) {
                                    if ($v=='portal') {
                                        $true = true;
                                    }
                                    if ($true) {
                                       $filename[] = $v;
                                    }
                                }
                                $filename = implode('/', $filename);
                                echo '<img src="'.$filename.'" alt="">';
                                break;
                            }
                            ?>
                        </div>
                        <div class="department_content">
                            <?= $data['deskripsi_text2'] ?>
                            <!-- <h3><a href="#">Eye Care</a></h3>
                            <p>Esteem spirit temper too say adieus who direct esteem.</p> -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-lg-4">
                    <div class="single_department">
                        <div class="department_thumb" id="deskripsi_img3">
                            <?php 
                            $banner = glob(Yii::$app->params['pathDeskripsi']."deskripsi_img3*");
                            foreach ($banner as $key => $value) {
                                $explode = explode('/', $value);
                                $filename = [];
                                $true = false;
                                foreach ($explode as $v) {
                                    if ($v=='portal') {
                                        $true = true;
                                    }
                                    if ($true) {
                                       $filename[] = $v;
                                    }
                                }
                                $filename = implode('/', $filename);
                                echo '<img src="'.$filename.'" alt="">';
                                break;
                            }
                            ?>
                        </div>
                        <div class="department_content">
                            <?= $data['deskripsi_text3'] ?>
                            <!-- <h3><a href="#">Eye Care</a></h3>
                            <p>Esteem spirit temper too say adieus who direct esteem.</p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- offers_area_end -->

    <!-- expert_doctors_area_start -->
    <div class="expert_doctors_area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="doctors_title text-center mb-55">
                        <h3>Our Partner</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 d-flex flex-row justify-content-center" id="partner">
                        <div class="single_expert " style="max-width: 350px;">
                            <div class="expert_thumb">
                                <?php 
                                $banner = glob(Yii::$app->params['pathPartner']."partner_img*");
                                foreach ($banner as $key => $value) {
                                    $explode = explode('/', $value);
                                    $filename = [];
                                    $true = false;
                                    foreach ($explode as $v) {
                                        if ($v=='portal') {
                                            $true = true;
                                        }
                                        if ($true) {
                                           $filename[] = $v;
                                        }
                                    }
                                    $filename = implode('/', $filename);
                                    echo '<img src="'.$filename.'" alt="">';
                                }?>
                            </div>
                            <div class="experts_name text-center">
                                <h3>Partner1 Here</h3>
                                <span>The Best Partner1</span>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <!-- expert_doctors_area_end -->

    
    <!-- expert_doctors_area_end -->

    

<!-- footer start -->
    <footer class="footer">
            <div class="footer_top">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-3 offset-xl-1 col-md-6 col-lg-3">
                            <div class="footer_widget">
                                <h3 class="footer_title">
                                        Customer Services
                                </h3>
                                <ul>
                                    <li><a href="#" onclick="openterm();return false;">Term & Conditions</a></li>
                                    <li><a href="#" onclick="openpolicy();return false;">Privacy Policy</a></li>
                                </ul>
    
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-6 col-lg-2">
                            <div class="footer_widget">
                                <h3 class="footer_title">
                                        Information
                                </h3>
                                <ul>
                                    <li><a href="#">About Us</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-6 col-lg-3">
                            <div class="footer_widget">
                                <h3 class="footer_title">
                                        
                                </h3>
                                <p>
                                   
                                </p>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 col-lg-4">
                            <div class="footer_widget">
                                <h3 class="footer_title">
                                        Contact Us :
                                </h3>
                                <div class="footer_logo">
                                    <a href="#">
                                        <img src="portal/img/partner/amoeba.png" width="250px" alt="">
                                    </a>
                                </div>
                                <div class="socail_links">
                                    <ul>
                                        <li>
                                            <a href="#">
                                                <i class="ti-facebook"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="ti-twitter-alt"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-instagram"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copy-right_text">
                <div class="container">
                    <div class="footer_border"></div>
                    <div class="row">
                        <div class="col-xl-12">
                            <p class="copy_right text-center">
                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> CMT-ONLINE
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
<!-- footer end  -->
    <!-- link that opens popup -->


    <!-- JS here -->
    <script src="portal/js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="portal/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="portal/js/popper.min.js"></script>
    <script src="portal/js/bootstrap.min.js"></script>
    <script src="portal/js/owl.carousel.min.js"></script>
    <script src="portal/js/isotope.pkgd.min.js"></script>
    <script src="portal/js/ajax-form.js"></script>
    <script src="portal/js/waypoints.min.js"></script>
    <script src="portal/js/jquery.counterup.min.js"></script>
    <script src="portal/js/imagesloaded.pkgd.min.js"></script>
    <script src="portal/js/scrollIt.js"></script>
    <script src="portal/js/jquery.scrollUp.min.js"></script>
    <script src="portal/js/wow.min.js"></script>
    <script src="portal/js/nice-select.min.js"></script>
    <script src="portal/js/jquery.slicknav.min.js"></script>
    <script src="portal/js/jquery.magnific-popup.min.js"></script>
    <script src="portal/js/plugins.js"></script>
    <script src="portal/js/gijgo.min.js"></script>
    <!--contact js-->
    <script src="portal/js/contact.js"></script>
    <script src="portal/js/jquery.ajaxchimp.min.js"></script>
    <script src="portal/js/jquery.form.js"></script>
    <script src="portal/js/jquery.validate.min.js"></script>
    <script src="portal/js/mail-script.js"></script>

    <script src="portal/js/main.js"></script>
    <script>
        $('#datepicker').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
                rightIcon: '<span class="fa fa-caret-down"></span>'
            }
        });
        $('#datepicker2').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
                rightIcon: '<span class="fa fa-caret-down"></span>'
            }

        });
        function openterm() {
            $('.modal-dialog').width(1200);
            $('#modalterm').modal('show')
            .find('#modalContentterm');
            $('#scrollUp').remove();
        }
        function openpolicy() {
            $('.modal-dialog').width(1200);
            $('#modalpolicy').modal('show')
            .find('#modalContentpolicy');
            $('#scrollUp').remove();
        }
    $(document).ready(function() {
    });
    </script>
    <style type="text/css">
        ol > li { margin-bottom:10px; }
        ol > li:before {    
            font-family: 'FontAwesome';
            content: '\f111';
            margin:0 5px 0 -15px;
            font-size: 8px;
        }
    </style>
    <?php
        $term = '<div class="our_department_area" style="  padding-top: 0px; padding-bottom: 0px;">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="section_title text-center mb-55" id="term_con" style="text-align: left!important;">
                                     '.$data["term_con"].'
                                    <!-- <h3>Welcome to CMT-Online</h3>
                                    <p>Esteem spirit temper too say adieus who direct esteem. <br>
                                        It esteems luckily or picture placing drawing. </p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        Modal::begin([
            // 'header' => 'Info',
            'id' => 'modalterm',
            'size' => 'modal-lg',
            'options' => ['style' => 'z-index:9999999 !important;'],
        ]);
        echo "<div id='modalContentterm'></div>
                <div class='modal-body' style='text-align:center;'>
                <div class='check_mark'>
                  <div class='sa-icon sa-success animate'>
                    <span class='sa-line sa-tip animateSuccessTip'></span>
                    <span class='sa-line sa-long animateSuccessLong'></span>
                    <div class='sa-placeholder'></div>
                    <div class='sa-fix'></div>
                  </div>
                </div>
                    $term
                </div>
                <div class='modal-footerterm' style='padding: 15px 15px 1px 15px !important;'>
                    <button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>
                </div>";
        Modal::end();
    ?>
    <?php
        $term = '<div class="our_department_area" style="  padding-top: 0px; padding-bottom: 0px;">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="section_title text-center mb-55" id="policy" style="text-align: left!important; padding-top: 0px; padding-bottom: 0px;">
                                     '.$data["policy"].'
                                    <!-- <h3>Welcome to CMT-Online</h3>
                                    <p>Esteem spirit temper too say adieus who direct esteem. <br>
                                        It esteems luckily or picture placing drawing. </p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        Modal::begin([
            // 'header' => 'Info',
            'id' => 'modalpolicy',
            'size' => 'modal-lg',
            'options' => ['style' => 'z-index:9999999 !important;'],
        ]);
        echo "<div id='modalContentpolicy'></div>
                <div class='modal-body' style='text-align:center;'>
                <div class='check_mark'>
                  <div class='sa-icon sa-success animate'>
                    <span class='sa-line sa-tip animateSuccessTip'></span>
                    <span class='sa-line sa-long animateSuccessLong'></span>
                    <div class='sa-placeholder'></div>
                    <div class='sa-fix'></div>
                  </div>
                </div>
                    $term
                </div>
                <div class='modal-footerterm' style='padding: 15px 15px 1px 15px !important;'>
                    <button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>
                </div>";
        Modal::end();
    ?>
</body>

</html>
<?php $this->endPage() ?>
