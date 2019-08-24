<?php
ob_start();
session_start();
if(!file_exists("config.php")){
	header("Location: install/index.php");
	die();
}

include("./config.php");
include("./helper/common.php");
include("./language/lang_en.php");

$wms = new wms_core();
$menu_array = array();
$menu_array = $wms->getFrontentMenuList($link);

$site_name = '';
$currency = '';
$email = '';
$address = '';
$footer_box_1 = '';
$footer_box_2 = '';
$footer_box_3 = '';
$footer_box_4 = '';
$footer_box_5 = '';
$header_box_1 = '';
$header_box_2 = '';
$contact_us_text_1 = '';
global $api_key;
global $map_address;

$settings = $wms->getWebsiteSettingsInformation($link);
if(!empty($settings)) {
	$site_name = $settings['site_name'];
	$currency = $settings['currency'];
	$email = $settings['email'];
	$address = $settings['address'];
	$footer_box_1 = $settings['footer_box_1'];
	$footer_box_2 = $settings['footer_box_2'];
	$footer_box_3 = $settings['footer_box_3'];
	$footer_box_4 = $settings['footer_box_4'];
	$footer_box_5 = $settings['footer_box_5'];
	$header_box_1 = $settings['header_box_1'];
	$header_box_2 = $settings['header_box_2'];
	$contact_us_text_1 = $settings['contact_us_text_1'];
	$api_key = $settings['gogole_api_key'];
	$map_address = $settings['map_address'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title><?php echo $site_name; ?></title>
<meta name="description" content="Workshop">
<meta name="keywords" content="workshop,garage">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<!-- google fonts -->
<link href='http://fonts.googleapis.com/css?family=Lato:400,300italic,300,700%7CPlayfair+Display:400,700italic%7CRoboto:300%7CMontserrat:400,700%7COpen+Sans:400,300%7CLibre+Baskerville:400,400italic' rel='stylesheet' type='text/css'>
<!-- Bootstrap -->
<link href="<?php echo WEB_URL; ?>assets/frontend/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo WEB_URL; ?>assets/frontend/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo WEB_URL; ?>assets/frontend/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?php echo WEB_URL; ?>assets/frontend/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo WEB_URL; ?>assets/frontend/css/global.css" rel="stylesheet">
<link href="<?php echo WEB_URL; ?>assets/frontend/css/styleone.css" rel="stylesheet">
<link href="<?php echo WEB_URL; ?>assets/frontend/css/style.css" rel="stylesheet">
<link href="<?php echo WEB_URL; ?>assets/frontend/css/responsive.css" rel="stylesheet">
<link href="<?php echo WEB_URL; ?>assets/frontend/css/skin.css" rel="stylesheet">
<link href="<?php echo WEB_URL; ?>assets/frontend/css/flaticon.css" rel="stylesheet">
<link href="<?php echo WEB_URL; ?>assets/frontend/css/isotop.css" rel="stylesheet">
<link href="<?php echo WEB_URL; ?>assets/frontend/css/magnific-popup.css" rel="stylesheet">
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>
<body>
<div id="wrapper">
<!--Header Section Start Here -->
<!-- <header id="header">
  <div class="container">
    <div class="row primary-header"> <a href="<?php echo WEB_URL; ?>" class="col-xs-12 col-sm-4 brand" title="<?php echo $site_name; ?>"><img src="<?php echo WEB_URL; ?>img/logo.png" alt="Charity"></a>
      <div class="col-xs-12 col-sm-8 cp-top-right"> <a data-toggle="modal" data-target=".join-now-form" class="btn btn-default btn-estimate"><?php echo $_lang['__get_apointment']; ?></a>
        <div class="upper-column info-box">
          <?php echo $header_box_1; ?>
        </div>
        <div class="upper-column info-box">
          <?php echo $header_box_2; ?>
        </div>
      </div>
    </div>
  </div>
</header> -->
<!-- Header Section End Here -->
<!-- Site Content -->
<div id="main">
