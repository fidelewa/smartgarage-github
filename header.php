<?php
// ob_start();
// session_start();

include(__DIR__ . "/session.php");
include(__DIR__ . "/config.php");
include(__DIR__ . "/helper/common.php");

// if (!isset($_SESSION['objLogin']) || empty($_SESSION['objLogin'])) {
//   header("Location: logout.php");
//   die();
// }

// if($_SESSION['objLogin'] == null){
//         header("Location: logout.php");
//         unset($_SESSION);
// 	die();

// }

// core init
$wms = new wms_core();

//menu seleciton
$page_name = '';
$page_name = pathinfo(curPageURL(), PATHINFO_FILENAME);
function curPageURL()
{
  $pageURL = 'http';
  if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
    $pageURL .= "s";
  }
  $pageURL .= "://";
  if ($_SERVER["SERVER_PORT"] != "80") {
    $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
  } else {
    $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
  }
  return $pageURL;
}

$site_name = '';
$currency = '';
$email = '';
$address = '';
$estimate_data = array();

$result_settings = $wms->getWebsiteSettingsInformation($link);
if (!empty($result_settings)) {
  $site_name = $result_settings['site_name'];
  $currency = $result_settings['currency'];
  $email = $result_settings['email'];
  $address = $result_settings['address'];
}


//mini cart load
$cart_total = $wms->loadMiniCartHtml();
// apointment status
$apointment_list = $wms->get_all_waiting_apointment_list($link);
// contact us status
$contact_us_list = $wms->get_all_contact_us_list($link);
// car list status
$car_request_list = $wms->get_all_waiting_car_list($link);


$user_image = WEB_URL . 'img/no_image.jpg';

if (!empty($_SESSION['objLogin']['image'])) {
  $user_image = WEB_URL . 'img/' . $_SESSION['objLogin']['image'];
}
if (!empty($_SESSION['objMech']['image'])) {
  $user_image = WEB_URL . 'img/' . $_SESSION['objMech']['image'];
}
if (!empty($_SESSION['objRecep']['image'])) {
  $user_image = WEB_URL . 'img/' . $_SESSION['objRecep']['image'];
}
if (!empty($_SESSION['objCompta']['image'])) {
  $user_image = WEB_URL . 'img/' . $_SESSION['objCompta']['image'];
}
if (!empty($_SESSION['objServiceClient']['image'])) {
  $user_image = WEB_URL . 'img/' . $_SESSION['objServiceClient']['image'];
}
if (!empty($_SESSION['objCust']['image'])) {
  $user_image = WEB_URL . 'img/' . $_SESSION['objServiceClient']['image'];
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>LUXURY GARAGE</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <!-- Bootstrap 3.3.4 -->
  <link href="<?php echo WEB_URL; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <!-- Font Awesome Icons -->
  <link href="<?php echo WEB_URL; ?>dist/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <!-- Ionicons -->
  <link href="<?php echo WEB_URL; ?>dist/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
  <link href="<?php echo WEB_URL; ?>dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
  <!-- AdminLTE Skins. Choose a skin from the css/skins 
 folder instead of downloading all of them to reduce the load. -->
  <link href="<?php echo WEB_URL; ?>dist/css/skins/_all-skins.css" rel="stylesheet" type="text/css" />
  <!-- iCheck for checkboxes and radio inputs -->
  <link href="<?php echo WEB_URL; ?>plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo WEB_URL; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo WEB_URL; ?>dist/css/dataTables.responsive.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo WEB_URL; ?>dist/css/dataTables.tableTools.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo WEB_URL; ?>plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo WEB_URL; ?>plugins/timepicker/bootstrap-timepicker.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo WEB_URL; ?>plugins/summernote/summernote.css" rel="stylesheet" type="text/css" />
  <!-- <link href="<?php echo WEB_URL; ?>plugins/select2/select2.min.css" rel="stylesheet" type="text/css" /> -->
  <!-- <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet"> -->
  <!-- <link rel="stylesheet" type="text/css" media="screen" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css"> -->
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- jQuery 2.1.4 -->
  <script src="<?php echo WEB_URL; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <script src="<?php echo WEB_URL; ?>dist/js/printThis.js"></script>
  <script src="<?php echo WEB_URL; ?>dist/js/common.js"></script>
  <link href="<?php echo WEB_URL; ?>plugins/range_slider/nouislider.css" rel="stylesheet" type="text/css" />
  <script src="<?php echo WEB_URL; ?>plugins/range_slider/nouislider.js"></script>
  <link href="<?php echo WEB_URL; ?>plugins/jQuery/chosen.css" rel="stylesheet" type="text/css" />
  <script src="<?php echo WEB_URL; ?>plugins/jQuery/chosen.jquery.js"></script>
  <script src="<?php echo WEB_URL; ?>plugins/summernote/summernote.min.js"></script>
  <script src="<?php echo WEB_URL; ?>plugins/chartjs/Chart.min.js" type="text/javascript"></script>
  <!-- <script src="<?php echo WEB_URL; ?>plugins/select2/select2.min.js" type="text/javascript"></script> -->
  <!-- <script src="<?php echo WEB_URL; ?>plugins/datepicker/bootstrap-datepicker.min.js" type="text/javascript"></script> -->
  <!-- <script src="<?php echo WEB_URL; ?>plugins/datepicker/locales/bootstrap-datepicker.fr.js" type="text/javascript"></script> -->
  <script src="<?php echo WEB_URL; ?>dist/js/addcar_reception.js"></script>
  <!-- <script src="<?php echo WEB_URL; ?>dist/js/personnel_salaire.js"></script> -->
  <!-- <script src="<?php echo WEB_URL; ?>dist/js/adddevis.js"></script> -->
  <script type="text/javascript" src="<?php echo WEB_URL; ?>dist/js/typeahead.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.min.js"></script>

  <!-- <script src="https://cdn.lr-ingest.io/LogRocket.min.js" crossorigin="anonymous"></script>
  <script>
    window.LogRocket && window.LogRocket.init('0a2c67/smartgarage');
  </script> -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.5.3/cleave.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.1/parsley.min.js"></script>

  <style>
    .typeahead {
      border: 2px solid #FFF;
      border-radius: 4px;
      padding: 8px 12px;
      max-width: 300px;
      min-width: 290px;
      background: rgba(66, 52, 52, 0.5);
      color: #FFF;
    }

    .tt-menu {
      width: 300px;
    }

    ul.typeahead {
      margin: 0px;
      padding: 10px 0px;
    }

    ul.typeahead.dropdown-menu li a {
      padding: 10px !important;
      border-bottom: #CCC 1px solid;
      color: #FFF;
    }

    ul.typeahead.dropdown-menu li:last-child a {
      border-bottom: 0px !important;
    }

    .bgcolor {
      max-width: 550px;
      min-width: 290px;
      max-height: 340px;
      background: url("world-contries.jpg") no-repeat center center;
      padding: 100px 10px 130px;
      border-radius: 4px;
      text-align: center;
      margin: 10px;
    }

    .demo-label {
      font-size: 1.5em;
      color: #686868;
      font-weight: 500;
      color: #FFF;
    }

    .dropdown-menu>.active>a,
    .dropdown-menu>.active>a:focus,
    .dropdown-menu>.active>a:hover {
      text-decoration: none;
      background-color: #1f3f41;
      outline: 0;
    }
  </style>
  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script> -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  <style>
    /* Echaffaudage #2 */
    /* [class*="col-"]{
          border: 1px dotted rgb(0, 0, 0);
          border-radius: 1px;
      }  */
  </style>
</head>

<body class="skin-blue sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <header class="main-header">
      <!-- Logo -->
      <!--      <a href="#" class="logo">-->
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <!--        <span class="logo-mini">WMS</span>-->
      <!-- logo for regular state and mobile devices -->
      <!--        <span class="logo-lg"><img src="--><?php
                                                      ?>
      <!--/img/admin_logo.png"></span> </a>-->
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span> </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown messages-menu hidden-xs"> <a href="<?php echo WEB_URL; ?>" target="_blank"> <i style="font-size:18px" class="fa fa-home"></i></a></li>
            <li class="dropdown messages-menu"> <a title="Sample Estimate" href="<?php echo WEB_URL; ?>estimate/sample_estimate.php"> <i class="fa fa-calculator"></i><span class="label label-danger">E</span></a></li>
            <li class="dropdown messages-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-car"></i> <span class="label label-danger"><?php echo !empty($car_request_list) ? count($car_request_list) : '0'; ?></span> </a>
              <ul class="dropdown-menu">
                <li class="header" style="text-align:center;font-weight:bold;">vous avez <?php echo !empty($car_request_list) ? count($car_request_list) : '0'; ?> demande de voiture en attente.</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <div class="slimScrollDiv" style="position: relative; overflow: auto; width: auto; height: 200px;">
                    <ul class="menu" style="overflow: auto; width: 100%; height: 200px;">
                      <?php foreach ($car_request_list as $c_list) { ?>
                        <li>
                          <a href="<?php echo WEB_URL; ?>car_request/carrequest.php?rid=<?php echo $c_list['car_request_id']; ?>">
                            <div class="pull-left"><i class="fa fa-phone fa-2x"></i></div>
                            <h4> <?php echo $c_list['name']; ?> <small><i class="fa fa-clock-o"></i> <b><?php echo $wms->mySqlToDatePicker($c_list['requested_date']); ?></b></small> </h4>
                            <p><?php echo $c_list['email']; ?></p>
                          </a> </li>
                      <?php } ?>
                    </ul>
                    <div class="slimScrollBar" style="background: rgb(0, 0, 0) none repeat scroll 0% 0%; width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 131.148px;"></div>
                    <div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;"></div>
                  </div>
                </li>
                <li class="footer"><a href="<?php echo WEB_URL; ?>car_request/carrequest.php"><span style="font-size:12px;" class="label label-success">Liste de contrôle</span></a></li>
              </ul>
            </li>

            <li class="dropdown messages-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-phone"></i> <span class="label label-warning"><?php echo !empty($apointment_list) ? count($apointment_list) : '0'; ?></span> </a>
              <ul class="dropdown-menu">
                <li class="header" style="text-align:center;font-weight:bold;">vous avez <?php echo !empty($apointment_list) ? count($apointment_list) : '0'; ?> demande de rendez-vous en attente.</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <div class="slimScrollDiv" style="position: relative; overflow: auto; width: auto; height: 200px;">
                    <ul class="menu" style="overflow: auto; width: 100%; height: 200px;">
                      <?php foreach ($apointment_list as $a_list) { ?>
                        <li>
                          <a href="<?php echo WEB_URL; ?>apointment/apointment.php?aid=<?php echo $a_list['apointment_id']; ?>">
                            <div class="pull-left"><i class="fa fa-phone fa-2x"></i></div>
                            <h4> <?php echo $a_list['name']; ?> <small><i class="fa fa-clock-o"></i> <b><?php echo $wms->mySqlToDatePicker($a_list['added_date']); ?></b></small> </h4>
                            <p><?php echo $a_list['email']; ?></p>
                          </a> </li>
                      <?php } ?>
                    </ul>
                    <div class="slimScrollBar" style="background: rgb(0, 0, 0) none repeat scroll 0% 0%; width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 131.148px;"></div>
                    <div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;"></div>
                  </div>
                </li>
                <li class="footer"><a href="<?php echo WEB_URL; ?>apointment/apointment.php"><span style="font-size:12px;" class="label label-success">Liste de contrôle</span></a></li>
              </ul>
            </li>

            <!-- Messages: style can be found in dropdown.less-->
            <li class="dropdown messages-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-envelope-o"></i> <span class="label label-info"><?php echo !empty($contact_us_list) ? count($contact_us_list) : '0'; ?></span> </a>
              <ul class="dropdown-menu">
                <li class="header">Vous avez <?php echo !empty($contact_us_list) ? count($contact_us_list) : '0'; ?> messages</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <div class="slimScrollDiv" style="position:relative;overflow:auto;width:auto;min-height: 100px;">
                    <ul class="menu" style="overflow:auto;width: 100%;min-height:100px;">
                      <?php foreach ($contact_us_list as $c_list) { ?>
                        <li>
                          <a href="<?php echo WEB_URL; ?>contact_list/contact_list.php?cid=<?php echo $c_list['contact_id']; ?>">
                            <div class="pull-left"><i class="fa fa-envelope-o fa-2x"></i></div>
                            <h4> <?php echo $c_list['name']; ?> <small><i class="fa fa-clock-o"></i> <b><?php echo $wms->mySqlToDatePicker($c_list['added_date']); ?></b></small> </h4>
                            <p><?php echo $c_list['email']; ?></p>
                          </a> </li>
                      <?php } ?>
                    </ul>
                    <div class="slimScrollBar" style="background: rgb(0, 0, 0) none repeat scroll 0% 0%; width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 131.148px;"></div>
                    <div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;"></div>
                  </div>
                </li>
                <li class="footer"><a href="<?php echo WEB_URL; ?>contact_list/contact_list.php"><span style="font-size:12px;" class="label label-success">Liste de contrôle</span></a></li>
              </ul>
            </li>
            <!-- Tasks: style can be found in dropdown.less -->
            <li class="dropdown tasks-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-shopping-cart"></i> <span class="label label-danger parts_cart"><?php echo $cart_total; ?></span> </a>
              <ul class="dropdown-menu">
                <li class="header text-center"><b>Vous avez ajouté <span class="parts_cart"><?php echo $cart_total; ?></span> les pièces</b></li>
                <li class="footer"> <a href="<?php echo WEB_URL; ?>/parts_stock/partssellform.php"><span class="btn btn-danger btn-sm"><i class="fa fa-shopping-cart"></i> Vérifier</span></a> </li>
              </ul>
            </li>
            <!-- User Account: style can be found in dropdown.less -->
            <?php if (isset($_SESSION['objMech'])) { ?>
              <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="<?php echo $user_image; ?>" class="user-image" alt="User Image"> <span class="hidden-xs"><?php echo !empty($_SESSION['objMech']['name']) ? $_SESSION['objMech']['name'] : ''; ?></span> </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header"> <img src="<?php echo $user_image; ?>" class="img-circle" alt="User Image">

                    <p style="text-transform:capitalize;"> <b style="color:#fff;font-weight:normal !important;"><?php echo !empty($_SESSION['objMech']['name']) ? $_SESSION['objMech']['name'] : ''; ?></b> <small style="color:#fff;font-weight:bold;"><?php echo !empty($_SESSION['login_type']) ? $_SESSION['login_type'] : ''; ?></small> </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left"> <a href="<?php echo WEB_URL; ?>user/profile.php" class="btn btn-success btn-flat"><b>Profile</b></a> </div>
                    <div class="pull-right"> <a href="<?php echo WEB_URL; ?>logout.php" class="btn btn-danger btn-flat"><b>Déconnexion</b></a> </div>
                  </li>
                </ul>
              </li>
            <?php } elseif (isset($_SESSION['objRecep'])) { ?>
              <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="<?php echo $user_image; ?>" class="user-image" alt="User Image"> <span class="hidden-xs"><?php echo !empty($_SESSION['objRecep']['name']) ? $_SESSION['objRecep']['name'] : ''; ?></span> </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header"> <img src="<?php echo $user_image; ?>" class="img-circle" alt="User Image">

                    <p style="text-transform:capitalize;"> <b style="color:#fff;font-weight:normal !important;"><?php echo !empty($_SESSION['objRecep']['name']) ? $_SESSION['objRecep']['name'] : ''; ?></b> <small style="color:#fff;font-weight:bold;"><?php echo !empty($_SESSION['login_type']) ? $_SESSION['login_type'] : ''; ?></small> </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left"> <a href="<?php echo WEB_URL; ?>user/profile.php" class="btn btn-success btn-flat"><b>Profile</b></a> </div>
                    <div class="pull-right"> <a href="<?php echo WEB_URL; ?>logout.php" class="btn btn-danger btn-flat"><b>Déconnexion</b></a> </div>
                  </li>
                </ul>
              </li>
            <?php } elseif (isset($_SESSION['objCompta'])) { ?>
              <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="<?php echo $user_image; ?>" class="user-image" alt="User Image"> <span class="hidden-xs"><?php echo !empty($_SESSION['objCompta']['name']) ? $_SESSION['objCompta']['name'] : ''; ?></span> </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header"> <img src="<?php echo $user_image; ?>" class="img-circle" alt="User Image">

                    <p style="text-transform:capitalize;"> <b style="color:#fff;font-weight:normal !important;"><?php echo !empty($_SESSION['objCompta']['name']) ? $_SESSION['objCompta']['name'] : ''; ?></b> <small style="color:#fff;font-weight:bold;"><?php echo !empty($_SESSION['login_type']) ? $_SESSION['login_type'] : ''; ?></small> </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left"> <a href="<?php echo WEB_URL; ?>user/profile.php" class="btn btn-success btn-flat"><b>Profile</b></a> </div>
                    <div class="pull-right"> <a href="<?php echo WEB_URL; ?>logout.php" class="btn btn-danger btn-flat"><b>Déconnexion</b></a> </div>
                  </li>
                </ul>
              </li>
            <?php } elseif (isset($_SESSION['objServiceClient'])) { ?>
              <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="<?php echo $user_image; ?>" class="user-image" alt="User Image"> <span class="hidden-xs"><?php echo !empty($_SESSION['objServiceClient']['name']) ? $_SESSION['objServiceClient']['name'] : ''; ?></span> </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header"> <img src="<?php echo $user_image; ?>" class="img-circle" alt="User Image">

                    <p style="text-transform:capitalize;"> <b style="color:#fff;font-weight:normal !important;"><?php echo !empty($_SESSION['objServiceClient']['name']) ? $_SESSION['objServiceClient']['name'] : ''; ?></b> <small style="color:#fff;font-weight:bold;"><?php echo !empty($_SESSION['login_type']) ? $_SESSION['usr_type'] : ''; ?></small> </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left"> <a href="<?php echo WEB_URL; ?>user/profile.php" class="btn btn-success btn-flat"><b>Profile</b></a> </div>
                    <div class="pull-right"> <a href="<?php echo WEB_URL; ?>logout.php" class="btn btn-danger btn-flat"><b>Déconnexion</b></a> </div>
                  </li>
                </ul>
              </li>
            <?php } elseif (isset($_SESSION['objCust'])) { ?>
              <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="<?php echo $user_image; ?>" class="user-image" alt="User Image"> <span class="hidden-xs"><?php echo !empty($_SESSION['objCust']['name']) ? $_SESSION['objCust']['name'] : ''; ?></span> </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header"> <img src="<?php echo $user_image; ?>" class="img-circle" alt="User Image">

                    <p style="text-transform:capitalize;"> <b style="color:#fff;font-weight:normal !important;"><?php echo !empty($_SESSION['objCust']['name']) ? $_SESSION['objCust']['name'] : ''; ?></b> <small style="color:#fff;font-weight:bold;"><?php echo !empty($_SESSION['login_type']) ? "client" : ''; ?></small> </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left"> <a href="<?php echo WEB_URL; ?>user/profile.php" class="btn btn-success btn-flat"><b>Profile</b></a> </div>
                    <div class="pull-right"> <a href="<?php echo WEB_URL; ?>logout.php" class="btn btn-danger btn-flat"><b>Déconnexion</b></a> </div>
                  </li>
                </ul>
              </li>
            <?php } else { ?>
              <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="<?php echo $user_image; ?>" class="user-image" alt="User Image"> <span class="hidden-xs"><?php echo !empty($_SESSION['objLogin']['name']) ? $_SESSION['objLogin']['name'] : ''; ?></span> </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header"> <img src="<?php echo $user_image; ?>" class="img-circle" alt="User Image">

                    <p style="text-transform:capitalize;"> <b style="color:#fff;font-weight:normal !important;"><?php echo !empty($_SESSION['objLogin']['name']) ? $_SESSION['objLogin']['name'] : ''; ?></b> <small style="color:#fff;font-weight:bold;"><?php echo !empty($_SESSION['login_type']) ? $_SESSION['login_type'] : ''; ?></small> </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left"> <a href="<?php echo WEB_URL; ?>user/profile.php" class="btn btn-success btn-flat"><b>Profile</b></a> </div>
                    <div class="pull-right"> <a href="<?php echo WEB_URL; ?>logout.php" class="btn btn-danger btn-flat"><b>Déconnexion</b></a> </div>
                  </li>
                </ul>
              </li>
            <?php } ?>
            <!-- Control Sidebar Toggle Button -->
            <li class="hidden-xs"> <a href="<?php echo WEB_URL; ?>/setting/setting.php"><i class="fa fa-gears"></i></a> </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- =============================================== -->
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <div class="user-panel admin_header_border">
        <div class="pull-left image"> <img src="<?php echo $user_image; ?>" class="img-circle" alt="User Image"> </div>
        <div class="pull-left info">
          <?php if (isset($_SESSION['objMech'])) { ?>
            <p><?php echo !empty($_SESSION['objMech']['name']) ? $_SESSION['objMech']['name'] : ''; ?></p>
          <?php } elseif (isset($_SESSION['objRecep'])) { ?>
            <p><?php echo !empty($_SESSION['objRecep']['name']) ? $_SESSION['objRecep']['name'] : ''; ?></p>
          <?php } elseif (isset($_SESSION['objCompta'])) { ?>
            <p><?php echo !empty($_SESSION['objCompta']['name']) ? $_SESSION['objCompta']['name'] : ''; ?></p>
          <?php } elseif (isset($_SESSION['objServiceClient'])) { ?>
            <p><?php echo !empty($_SESSION['objServiceClient']['name']) ? $_SESSION['objServiceClient']['name'] : ''; ?></p>
          <?php } elseif (isset($_SESSION['objCust'])) { ?>
            <p><?php echo !empty($_SESSION['objCust']['name']) ? $_SESSION['objCust']['name'] : ''; ?></p>
          <?php } else { ?>
            <p><?php echo !empty($_SESSION['objLogin']['name']) ? $_SESSION['objLogin']['name'] : ''; ?></p>
          <?php }
          ?>

          <?php if (isset($_SESSION['objMech'])) { ?>
            <a href="#"><i class="fa fa-circle text-success"></i> <?php echo $_SESSION['objMech']['usr_type']; ?></a>
          <?php } ?>
          <?php if (isset($_SESSION['objRecep'])) { ?>
            <a href="#"><i class="fa fa-circle text-success"></i> <?php echo $_SESSION['objRecep']['usr_type']; ?></a>
          <?php } ?>
          <?php if (isset($_SESSION['objLogin'])) { ?>
            <a href="<?php echo WEB_URL; ?>user/profile.php"><i class="fa fa-circle text-success"></i> <?php echo $_SESSION['login_type']; ?></a>
          <?php } ?>
          <?php if (isset($_SESSION['objServiceClient'])) { ?>
            <a href="#"><i class="fa fa-circle text-success"></i> <?php echo $_SESSION['objServiceClient']['usr_type']; ?></a>
          <?php } ?>
          <?php if (isset($_SESSION['objCompta'])) { ?>
            <a href="#"><i class="fa fa-circle text-success"></i> <?php echo $_SESSION['objCompta']['usr_type']; ?></a>
          <?php } ?>
          <?php if (isset($_SESSION['objCust'])) { ?>
            <a href="#"><i class="fa fa-circle text-success"></i> Client</a>
          <?php } ?>

          <!-- <a href="<?php echo WEB_URL; ?>user/profile.php"><i class="fa fa-circle text-success"></i> En ligne</a> -->
          <!-- <a href="<?php echo WEB_URL; ?>user/profile.php"><i class="fa fa-circle text-success"></i> <?php echo $_SESSION['login_type']; ?></a> -->

        </div>
      </div>
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->

        <?php if (isset($_SESSION['objMech'])) {

          // Définition des droits en fonction des profils utilisateurs
          $mech_elec_droit_acces = 'role_mecano_eletro';

          // DROIT MECANICIEN ELECTRICIEN

          // On vérifie que l'enregistrement du droit d'accès par role courant exsite déja en BDD
          $querySelMechElecDroitMenuRole = "SELECT droit_menu_role_id, role_name FROM tbl_droit_menu_role WHERE role_name = '" . $mech_elec_droit_acces  . "'";

          // On exécute la requête
          $resultSelMechElecDroitMenuRole = mysql_query($querySelMechElecDroitMenuRole, $link);

          // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
          // if (!$resultSelMechElecDroitMenuRole) {
          //   $message  = 'Invalid query: ' . mysql_error() . "\n";
          //   $message .= 'Whole query: ' . $querySelMechElecDroitMenuRole;
          //   die($message);
          // }

          // On récupère le jeu de résultat de la requête
          $listeMechElecDroitMenuRole = mysql_fetch_assoc($resultSelMechElecDroitMenuRole);

          // Si l'array n'est pas vide, alors il y a au moin un enregistrement correspondant à la sélection
          // Dans ce cas, on fait la sélection
          if (!empty($listeMechElecDroitMenuRole)) {

            // Droit menu mécanicien et électricien
            $resultDroitMenuMechElec = $wms->getDroitMenuMechElecInfo($link, $mech_elec_droit_acces);
          }

          ?>

          <ul class="sidebar-menu">

            <li class="header">Menus</li>
            <li class="tm10 <?php if ($page_name != '' && $page_name == 'mech_dashboard') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>mech_panel/mech_dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a> </li>

            <?php if (isset($resultDroitMenuMechElec) || !empty($resultDroitMenuMechElec)) {
                // Si le droit du role du service client existe déja en BDD, on récupère les données du droit en BDD
                if ($resultDroitMenuMechElec['menu_client'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'customerlist') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>customer/customerlist.php"> <i class="fa fa-user"></i> <span>Client</span></a></li>
              <?php }
                  if ($resultDroitMenuMechElec['menu_recep_vehi'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'reception_vehicule') {
                                            echo 'active';
                                          } ?>">
                  <a href="<?php echo WEB_URL; ?>reception/repaircar_reception.php"> <i class="fa fa-user"></i> <span>Réception de véhicules</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'reception_vehicule') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>reception/repaircar_reception.php"><i class="fa fa-arrow-circle-right"></i>Réception de véhicules</a>
                    </li>
                    <!-- <li class="<?php if ($page_name != '' && $page_name == 'reception_vehicule_list') {
                                            echo 'active';
                                          } ?>">
                                                                      <a href="<?php echo WEB_URL; ?>reception/repaircar_reception_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules réceptionnés</a>
                                                                    </li>
                                                                    <li class="<?php if ($page_name != '' && $page_name == 'diagnostic_vehicule_list') {
                                                                                        echo 'active';
                                                                                      } ?>">
                                                                      <a href="<?php echo WEB_URL; ?>reception/repaircar_diagnostic_list.php"><i class="fa fa-arrow-circle-right"></i>Diagnostics des véhicules</a>
                                                                    </li> -->

                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuMechElec['menu_vehi'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'addcar' || $page_name == 'carlist') {
                                            echo 'active';
                                          } ?>">
                  <a href="<?php echo WEB_URL; ?>repaircar/addcar.php"> <i class="fa fa-car"></i> <span>Véhicules</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'liste_vehicule_client') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>repaircar/carlist.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules des clients</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'liste_vehicule_garage') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>repaircar/carlist_garage.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules au garage</a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuMechElec['menu_devis'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'findcar' || $page_name == 'estimate_form') {
                                            echo 'active';
                                          } ?>">
                  <a href="<?php echo WEB_URL; ?>estimate/adddevis.php"> <i class="fa fa-calculator"></i> <span>Devis</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'ajout_devis') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/adddevis.php"><i class="fa fa-arrow-circle-right"></i>Créer un devis de réparation</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'repair_diagnostic_devis_list') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/repaircar_diagnostic_devis_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des devis de réparation</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'repair_simulation_devis_list') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/repaircar_simu_devis_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des autres devis</a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuMechElec['menu_facture'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'repaircar_devis_facture_list' || $page_name == 'repaircar_simu_devis_facture_list') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>estimate/repaircar_devis_facture_list.php"> <i class="fa fa-files-o"></i> <span>Factures</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'repaircar_devis_facture_list') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/repaircar_devis_facture_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des factures de réparation</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'repaircar_simu_devis_facture_list') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/repaircar_simu_devis_facture_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des autres factures</a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuMechElec['menu_stock_piece'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'buyparts' || $page_name == 'partsstocklist' || $page_name == 'mouvstock') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>parts_stock/buyparts.php"> <i class="fa fa-truck"></i> <span>Stock de pièces</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">

                    <li class="<?php if ($page_name != '' && $page_name == 'buyparts') {
                                        echo 'active';
                                      } ?>"><a href="<?php echo WEB_URL; ?>parts_stock/buyparts.php"><i class="fa fa-arrow-circle-right"></i>Créer article</a></li>
                    <li class="<?php if ($page_name != '' && $page_name == 'partsstocklist') {
                                        echo 'active';
                                      } ?>"><a href="<?php echo WEB_URL; ?>parts_stock/partsstocklist.php"><i class="fa fa-arrow-circle-right"></i>Liste des articles</a></li>
                    <li class="<?php if ($page_name != '' && $page_name == 'mouvstock') {
                                        echo 'active';
                                      } ?>"><a href="<?php echo WEB_URL; ?>parts_stock/mouvstock.php"><i class="fa fa-arrow-circle-right"></i>Mouvements de stock</a></li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuMechElec['menu_four'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'addsupplier' || $page_name == 'supplierlist' || $page_name == 'boncmdeList' || $page_name == 'supplierManage' || $page_name == 'addBonCmde') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>supplier/addsupplier.php"> <i class="fa fa-user"></i> <span>Fournisseurs</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'addsupplier') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>supplier/addsupplier.php"><i class="fa fa-arrow-circle-right"></i>Créer un fournisseur</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'supplierlist') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>supplier/supplierlist.php"><i class="fa fa-arrow-circle-right"></i>Liste des fournisseurs</a>
                    </li>
                    <!-- <li class="<?php if ($page_name != '' && $page_name == 'addBonCmde') {
                                            echo 'active';
                                          } ?>">
                                                    <a href="<?php echo WEB_URL; ?>bon_cmde/addBonCmde.php"><i class="fa fa-arrow-circle-right"></i>Créer un bon de commande</a>
                                                  </li>
                                                  <li class="treeview <?php if ($page_name != '' && $page_name == 'boncmdeList') {
                                                                              echo 'active';
                                                                            } ?>"> <a href="<?php echo WEB_URL; ?>bon_cmde/boncmdeList.php"> <i class="fa fa-arrow-circle-right"></i> <span>Liste des bons de commande</span> </a>
                                                  </li> -->
                    <li class="treeview <?php if ($page_name != '' && $page_name == 'supplierManage') {
                                                echo 'active';
                                              } ?>"> <a href="<?php echo WEB_URL; ?>supplier/supplierManage.php"> <i class="fa fa-arrow-circle-right"></i> <span>Gestion des fournisseurs</span> </a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuMechElec['menu_ges_personnel'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'personnelist' || $page_name == 'personnel') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>user/addpersonnel.php"> <i class="fa fa-users"></i> <span>Personnel</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="treeview <?php if ($page_name != '' && $page_name == 'addPersonnel' || $page_name == 'personnellist') {
                                                echo 'active';
                                              } ?>"> <a href="<?php echo WEB_URL; ?>user/addpersonnel.php"> <i class="fa fa-arrow-circle-right"></i> <span>Ajouter personnel</span> </a>
                    </li>
                    <li class="treeview <?php if ($page_name != '' && $page_name == 'listepersonnel') {
                                                echo 'active';
                                              } ?>"> <a href="<?php echo WEB_URL; ?>user/listepersonnel.php"> <i class="fa fa-arrow-circle-right"></i> <span>Liste du personnel</span> </a>
                    </li>
                    <li class="treeview <?php if ($page_name != '' && $page_name == 'presenceperso') {
                                                echo 'active';
                                              } ?>"> <a href="<?php echo WEB_URL; ?>user/presenceperso.php"> <i class="fa fa-arrow-circle-right"></i> <span>Liste de présences</span> </a>
                    </li>
                    <!-- <li class="treeview <?php if ($page_name != '' && $page_name == 'salperso') {
                                                      echo 'active';
                                                    } ?>"> <a href="<?php echo WEB_URL; ?>user/salperso.php"> <i class="fa fa-arrow-circle-right"></i> <span>Salaires</span> </a>
                                                              </li> -->
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuMechElec['menu_ges_user'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'gesuser' || $page_name == 'gesusers') {
                                            echo 'active';
                                          } ?>">
                  <a href="<?php echo WEB_URL; ?>gesuser.php"> <i class="fa fa-users"></i> <span>Utilisateurs</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'adduser') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>user/adduser.php"><i class="fa fa-arrow-circle-right"></i>Créer un utilisateur</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'userlist') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>user/userlist.php"><i class="fa fa-arrow-circle-right"></i>Liste des utilisateurs</a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuMechElec['menu_rapport'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'reprepairdelivery' || $page_name == 'rptcarbuy' || $page_name == 'rptcarsell' || $page_name == 'rptpartsbuy' || $page_name == 'rptpartssell' || $page_name == 'rptmsalary' || $page_name == 'synthActivity') {
                                            echo 'active';
                                          } ?>"> <a href="#"> <i class="fa fa-bar-chart-o"></i> <span>Statistique</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'synthActivity') {
                                        echo 'active';
                                      } ?>"><a href="<?php echo WEB_URL; ?>report/synthActivity.php"><i class="fa fa-arrow-circle-right"></i> Synthèse d'activités</a></li>
                  </ul>
                </li>
              <?php }
                  ?>

            <?php } ?>

          </ul>

        <?php } ?>

        <?php if (isset($_SESSION['objRecep'])) {

          $recep_droit_acces = 'role_recep';

          // DROIT RECEPTIONNISTE

          // On vérifie que l'enregistrement du droit d'accès par role courant exsite déja en BDD
          $querySelRecepDroitMenuRole = "SELECT droit_menu_role_id, role_name FROM tbl_droit_menu_role WHERE role_name = '" . $recep_droit_acces  . "'";

          // On exécute la requête
          $resultSelRecepDroitMenuRole = mysql_query($querySelRecepDroitMenuRole, $link);

          // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
          // if (!$resultSelRecepDroitMenuRole) {
          //   $message  = 'Invalid query: ' . mysql_error() . "\n";
          //   $message .= 'Whole query: ' . $querySelRecepDroitMenuRole;
          //   die($message);
          // }

          // On récupère le jeu de résultat de la requête
          $listeRecepDroitMenuRole = mysql_fetch_assoc($resultSelRecepDroitMenuRole);

          // Si l'array n'est pas vide, alors il y a au moin un enregistrement correspondant à la sélection
          // Dans ce cas, on fait la sélection
          if (!empty($listeRecepDroitMenuRole)) {

            // Droit menu réceptionniste
            $resultDroitMenuRecep = $wms->getDroitMenuRecepInfo($link, $recep_droit_acces);
          }

          ?>

          <ul class="sidebar-menu">

            <li class="header">Menus</li>
            <li class="tm10 <?php if ($page_name != '' && $page_name == 'recep_dashboard') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>recep_panel/recep_dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a> </li>

            <?php if (isset($resultDroitMenuRecep) || !empty($resultDroitMenuRecep)) {
                // Si le droit du role du service client existe déja en BDD, on récupère les données du droit en BDD
                if ($resultDroitMenuRecep['menu_client'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'customerlist') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>customer/customerlist.php"> <i class="fa fa-user"></i> <span>Client</span></a></li>
              <?php }
                  if ($resultDroitMenuRecep['menu_recep_vehi'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'reception_vehicule') {
                                            echo 'active';
                                          } ?>">
                  <a href="<?php echo WEB_URL; ?>reception/repaircar_reception.php"> <i class="fa fa-user"></i> <span>Réception de véhicules</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'reception_vehicule') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>reception/repaircar_reception.php"><i class="fa fa-arrow-circle-right"></i>Réception de véhicules</a>
                    </li>
                    <!-- <li class="<?php if ($page_name != '' && $page_name == 'reception_vehicule_list') {
                                            echo 'active';
                                          } ?>">
                                                                      <a href="<?php echo WEB_URL; ?>reception/repaircar_reception_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules réceptionnés</a>
                                                                    </li>
                                                                    <li class="<?php if ($page_name != '' && $page_name == 'diagnostic_vehicule_list') {
                                                                                        echo 'active';
                                                                                      } ?>">
                                                                      <a href="<?php echo WEB_URL; ?>reception/repaircar_diagnostic_list.php"><i class="fa fa-arrow-circle-right"></i>Diagnostics des véhicules</a>
                                                                    </li> -->

                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuRecep['menu_vehi'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'addcar' || $page_name == 'carlist') {
                                            echo 'active';
                                          } ?>">
                  <a href="<?php echo WEB_URL; ?>repaircar/addcar.php"> <i class="fa fa-car"></i> <span>Véhicules</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'liste_vehicule_client') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>repaircar/carlist.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules des clients</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'liste_vehicule_garage') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>repaircar/carlist_garage.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules au garage</a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuRecep['menu_devis'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'findcar' || $page_name == 'estimate_form') {
                                            echo 'active';
                                          } ?>">
                  <a href="<?php echo WEB_URL; ?>estimate/adddevis.php"> <i class="fa fa-calculator"></i> <span>Devis</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'ajout_devis') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/adddevis.php"><i class="fa fa-arrow-circle-right"></i>Créer un devis de réparation</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'repair_diagnostic_devis_list') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/repaircar_diagnostic_devis_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des devis de réparation</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'repair_simulation_devis_list') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/repaircar_simu_devis_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des autres devis</a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuRecep['menu_facture'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'repaircar_devis_facture_list' || $page_name == 'repaircar_simu_devis_facture_list') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>estimate/repaircar_devis_facture_list.php"> <i class="fa fa-files-o"></i> <span>Factures</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'repaircar_devis_facture_list') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/repaircar_devis_facture_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des factures de réparation</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'repaircar_simu_devis_facture_list') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/repaircar_simu_devis_facture_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des autres factures</a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuRecep['menu_stock_piece'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'buyparts' || $page_name == 'partsstocklist' || $page_name == 'mouvstock') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>parts_stock/buyparts.php"> <i class="fa fa-truck"></i> <span>Stock de pièces</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">

                    <li class="<?php if ($page_name != '' && $page_name == 'buyparts') {
                                        echo 'active';
                                      } ?>"><a href="<?php echo WEB_URL; ?>parts_stock/buyparts.php"><i class="fa fa-arrow-circle-right"></i>Créer article</a></li>
                    <li class="<?php if ($page_name != '' && $page_name == 'partsstocklist') {
                                        echo 'active';
                                      } ?>"><a href="<?php echo WEB_URL; ?>parts_stock/partsstocklist.php"><i class="fa fa-arrow-circle-right"></i>Liste des articles</a></li>
                    <li class="<?php if ($page_name != '' && $page_name == 'mouvstock') {
                                        echo 'active';
                                      } ?>"><a href="<?php echo WEB_URL; ?>parts_stock/mouvstock.php"><i class="fa fa-arrow-circle-right"></i>Mouvements de stock</a></li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuRecep['menu_four'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'addsupplier' || $page_name == 'supplierlist' || $page_name == 'boncmdeList' || $page_name == 'supplierManage' || $page_name == 'addBonCmde') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>supplier/addsupplier.php"> <i class="fa fa-user"></i> <span>Fournisseurs</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'addsupplier') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>supplier/addsupplier.php"><i class="fa fa-arrow-circle-right"></i>Créer un fournisseur</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'supplierlist') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>supplier/supplierlist.php"><i class="fa fa-arrow-circle-right"></i>Liste des fournisseurs</a>
                    </li>
                    <!-- <li class="<?php if ($page_name != '' && $page_name == 'addBonCmde') {
                                            echo 'active';
                                          } ?>">
                                                    <a href="<?php echo WEB_URL; ?>bon_cmde/addBonCmde.php"><i class="fa fa-arrow-circle-right"></i>Créer un bon de commande</a>
                                                  </li>
                                                  <li class="treeview <?php if ($page_name != '' && $page_name == 'boncmdeList') {
                                                                              echo 'active';
                                                                            } ?>"> <a href="<?php echo WEB_URL; ?>bon_cmde/boncmdeList.php"> <i class="fa fa-arrow-circle-right"></i> <span>Liste des bons de commande</span> </a>
                                                  </li> -->
                    <li class="treeview <?php if ($page_name != '' && $page_name == 'supplierManage') {
                                                echo 'active';
                                              } ?>"> <a href="<?php echo WEB_URL; ?>supplier/supplierManage.php"> <i class="fa fa-arrow-circle-right"></i> <span>Gestion des fournisseurs</span> </a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuRecep['menu_ges_personnel'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'personnelist' || $page_name == 'personnel') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>user/addpersonnel.php"> <i class="fa fa-users"></i> <span>Personnel</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="treeview <?php if ($page_name != '' && $page_name == 'addPersonnel' || $page_name == 'personnellist') {
                                                echo 'active';
                                              } ?>"> <a href="<?php echo WEB_URL; ?>user/addpersonnel.php"> <i class="fa fa-arrow-circle-right"></i> <span>Ajouter personnel</span> </a>
                    </li>
                    <li class="treeview <?php if ($page_name != '' && $page_name == 'listepersonnel') {
                                                echo 'active';
                                              } ?>"> <a href="<?php echo WEB_URL; ?>user/listepersonnel.php"> <i class="fa fa-arrow-circle-right"></i> <span>Liste du personnel</span> </a>
                    </li>
                    <li class="treeview <?php if ($page_name != '' && $page_name == 'presenceperso') {
                                                echo 'active';
                                              } ?>"> <a href="<?php echo WEB_URL; ?>user/presenceperso.php"> <i class="fa fa-arrow-circle-right"></i> <span>Liste de présences</span> </a>
                    </li>
                    <!-- <li class="treeview <?php if ($page_name != '' && $page_name == 'salperso') {
                                                      echo 'active';
                                                    } ?>"> <a href="<?php echo WEB_URL; ?>user/salperso.php"> <i class="fa fa-arrow-circle-right"></i> <span>Salaires</span> </a>
                                                              </li> -->
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuRecep['menu_ges_user'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'gesuser' || $page_name == 'gesusers') {
                                            echo 'active';
                                          } ?>">
                  <a href="<?php echo WEB_URL; ?>gesuser.php"> <i class="fa fa-users"></i> <span>Utilisateurs</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'adduser') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>user/adduser.php"><i class="fa fa-arrow-circle-right"></i>Créer un utilisateur</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'userlist') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>user/userlist.php"><i class="fa fa-arrow-circle-right"></i>Liste des utilisateurs</a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuRecep['menu_rapport'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'reprepairdelivery' || $page_name == 'rptcarbuy' || $page_name == 'rptcarsell' || $page_name == 'rptpartsbuy' || $page_name == 'rptpartssell' || $page_name == 'rptmsalary' || $page_name == 'synthActivity') {
                                            echo 'active';
                                          } ?>"> <a href="#"> <i class="fa fa-bar-chart-o"></i> <span>Statistique</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'synthActivity') {
                                        echo 'active';
                                      } ?>"><a href="<?php echo WEB_URL; ?>report/synthActivity.php"><i class="fa fa-arrow-circle-right"></i> Synthèse d'activités</a></li>
                  </ul>
                </li>
              <?php }
                  ?>

            <?php } ?>

          </ul>

        <?php } ?>

        <?php if (isset($_SESSION['objCompta'])) {

          $compta_droit_acces = 'role_comptable';

          // DROIT COMPTABLE

          // On vérifie que l'enregistrement du droit d'accès par role courant exsite déja en BDD
          $querySelComptaDroitMenuRole = "SELECT droit_menu_role_id, role_name FROM tbl_droit_menu_role WHERE role_name = '" . $compta_droit_acces  . "'";

          // On exécute la requête
          $resultSelComptaDroitMenuRole = mysql_query($querySelComptaDroitMenuRole, $link);

          // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
          // if (!$resultSelComptaDroitMenuRole) {
          //   $message  = 'Invalid query: ' . mysql_error() . "\n";
          //   $message .= 'Whole query: ' . $querySelComptaDroitMenuRole;
          //   die($message);
          // }

          // On récupère le jeu de résultat de la requête
          $listeComptaDroitMenuRole = mysql_fetch_assoc($resultSelComptaDroitMenuRole);

          // Si l'array n'est pas vide, alors il y a au moin un enregistrement correspondant à la sélection
          // Dans ce cas, on fait la sélection
          if (!empty($listeComptaDroitMenuRole)) {

            // Droit menu compta
            $resultDroitMenuCompta = $wms->getDroitMenuComptaInfo($link, $compta_droit_acces);
          }

          ?>

          <ul class="sidebar-menu">

            <li class="header">Menus</li>
            <li class="tm10 <?php if ($page_name != '' && $page_name == 'compta_dashboard') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>compta_panel/compta_dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a> </li>

            <?php if (isset($resultDroitMenuCompta) || !empty($resultDroitMenuCompta)) {
                // Si le droit du role du service client existe déja en BDD, on récupère les données du droit en BDD
                if ($resultDroitMenuCompta['menu_client'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'customerlist') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>customer/customerlist.php"> <i class="fa fa-user"></i> <span>Client</span></a></li>
              <?php }

                  if ($resultDroitMenuCompta['menu_recep_vehi'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'reception_vehicule') {
                                            echo 'active';
                                          } ?>">
                  <a href="<?php echo WEB_URL; ?>reception/repaircar_reception.php"> <i class="fa fa-user"></i> <span>Réception de véhicules</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'reception_vehicule') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>reception/repaircar_reception.php"><i class="fa fa-arrow-circle-right"></i>Réception de véhicules</a>
                    </li>
                    <!-- <li class="<?php if ($page_name != '' && $page_name == 'reception_vehicule_list') {
                                            echo 'active';
                                          } ?>">
                                                                      <a href="<?php echo WEB_URL; ?>reception/repaircar_reception_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules réceptionnés</a>
                                                                    </li>
                                                                    <li class="<?php if ($page_name != '' && $page_name == 'diagnostic_vehicule_list') {
                                                                                        echo 'active';
                                                                                      } ?>">
                                                                      <a href="<?php echo WEB_URL; ?>reception/repaircar_diagnostic_list.php"><i class="fa fa-arrow-circle-right"></i>Diagnostics des véhicules</a>
                                                                    </li> -->

                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuCompta['menu_vehi'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'addcar' || $page_name == 'carlist') {
                                            echo 'active';
                                          } ?>">
                  <a href="<?php echo WEB_URL; ?>repaircar/addcar.php"> <i class="fa fa-car"></i> <span>Véhicules</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'liste_vehicule_client') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>repaircar/carlist.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules des clients</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'liste_vehicule_garage') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>repaircar/carlist_garage.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules au garage</a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuCompta['menu_devis'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'findcar' || $page_name == 'estimate_form') {
                                            echo 'active';
                                          } ?>">
                  <a href="<?php echo WEB_URL; ?>estimate/adddevis.php"> <i class="fa fa-calculator"></i> <span>Devis</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'ajout_devis') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/adddevis.php"><i class="fa fa-arrow-circle-right"></i>Créer un devis de réparation</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'repair_diagnostic_devis_list') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/repaircar_diagnostic_devis_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des devis de réparation</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'repair_simulation_devis_list') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/repaircar_simu_devis_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des autres devis</a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuCompta['menu_facture'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'repaircar_devis_facture_list' || $page_name == 'repaircar_simu_devis_facture_list') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>estimate/repaircar_devis_facture_list.php"> <i class="fa fa-files-o"></i> <span>Factures</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'repaircar_devis_facture_list') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/repaircar_devis_facture_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des factures de réparation</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'repaircar_simu_devis_facture_list') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/repaircar_simu_devis_facture_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des autres factures</a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuCompta['menu_stock_piece'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'buyparts' || $page_name == 'partsstocklist' || $page_name == 'mouvstock') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>parts_stock/buyparts.php"> <i class="fa fa-truck"></i> <span>Stock de pièces</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">

                    <li class="<?php if ($page_name != '' && $page_name == 'buyparts') {
                                        echo 'active';
                                      } ?>"><a href="<?php echo WEB_URL; ?>parts_stock/buyparts.php"><i class="fa fa-arrow-circle-right"></i>Créer article</a></li>
                    <li class="<?php if ($page_name != '' && $page_name == 'partsstocklist') {
                                        echo 'active';
                                      } ?>"><a href="<?php echo WEB_URL; ?>parts_stock/partsstocklist.php"><i class="fa fa-arrow-circle-right"></i>Liste des articles</a></li>
                    <li class="<?php if ($page_name != '' && $page_name == 'mouvstock') {
                                        echo 'active';
                                      } ?>"><a href="<?php echo WEB_URL; ?>parts_stock/mouvstock.php"><i class="fa fa-arrow-circle-right"></i>Mouvements de stock</a></li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuCompta['menu_four'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'addsupplier' || $page_name == 'supplierlist' || $page_name == 'boncmdeList' || $page_name == 'supplierManage' || $page_name == 'addBonCmde') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>supplier/addsupplier.php"> <i class="fa fa-user"></i> <span>Fournisseurs</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'addsupplier') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>supplier/addsupplier.php"><i class="fa fa-arrow-circle-right"></i>Créer un fournisseur</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'supplierlist') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>supplier/supplierlist.php"><i class="fa fa-arrow-circle-right"></i>Liste des fournisseurs</a>
                    </li>
                    <!-- <li class="<?php if ($page_name != '' && $page_name == 'addBonCmde') {
                                            echo 'active';
                                          } ?>">
                                                    <a href="<?php echo WEB_URL; ?>bon_cmde/addBonCmde.php"><i class="fa fa-arrow-circle-right"></i>Créer un bon de commande</a>
                                                  </li>
                                                  <li class="treeview <?php if ($page_name != '' && $page_name == 'boncmdeList') {
                                                                              echo 'active';
                                                                            } ?>"> <a href="<?php echo WEB_URL; ?>bon_cmde/boncmdeList.php"> <i class="fa fa-arrow-circle-right"></i> <span>Liste des bons de commande</span> </a>
                                                  </li> -->
                    <li class="treeview <?php if ($page_name != '' && $page_name == 'supplierManage') {
                                                echo 'active';
                                              } ?>"> <a href="<?php echo WEB_URL; ?>supplier/supplierManage.php"> <i class="fa fa-arrow-circle-right"></i> <span>Gestion des fournisseurs</span> </a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuCompta['menu_ges_personnel'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'personnelist' || $page_name == 'personnel') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>user/addpersonnel.php"> <i class="fa fa-users"></i> <span>Personnel</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="treeview <?php if ($page_name != '' && $page_name == 'addPersonnel' || $page_name == 'personnellist') {
                                                echo 'active';
                                              } ?>"> <a href="<?php echo WEB_URL; ?>user/addpersonnel.php"> <i class="fa fa-arrow-circle-right"></i> <span>Ajouter personnel</span> </a>
                    </li>
                    <li class="treeview <?php if ($page_name != '' && $page_name == 'listepersonnel') {
                                                echo 'active';
                                              } ?>"> <a href="<?php echo WEB_URL; ?>user/listepersonnel.php"> <i class="fa fa-arrow-circle-right"></i> <span>Liste du personnel</span> </a>
                    </li>
                    <li class="treeview <?php if ($page_name != '' && $page_name == 'presenceperso') {
                                                echo 'active';
                                              } ?>"> <a href="<?php echo WEB_URL; ?>user/presenceperso.php"> <i class="fa fa-arrow-circle-right"></i> <span>Liste de présences</span> </a>
                    </li>
                    <!-- <li class="treeview <?php if ($page_name != '' && $page_name == 'salperso') {
                                                      echo 'active';
                                                    } ?>"> <a href="<?php echo WEB_URL; ?>user/salperso.php"> <i class="fa fa-arrow-circle-right"></i> <span>Salaires</span> </a>
                                                              </li> -->
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuCompta['menu_ges_user'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'gesuser' || $page_name == 'gesusers') {
                                            echo 'active';
                                          } ?>">
                  <a href="<?php echo WEB_URL; ?>gesuser.php"> <i class="fa fa-users"></i> <span>Utilisateurs</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'adduser') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>user/adduser.php"><i class="fa fa-arrow-circle-right"></i>Créer un utilisateur</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'userlist') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>user/userlist.php"><i class="fa fa-arrow-circle-right"></i>Liste des utilisateurs</a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuCompta['menu_rapport'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'reprepairdelivery' || $page_name == 'rptcarbuy' || $page_name == 'rptcarsell' || $page_name == 'rptpartsbuy' || $page_name == 'rptpartssell' || $page_name == 'rptmsalary' || $page_name == 'synthActivity') {
                                            echo 'active';
                                          } ?>"> <a href="#"> <i class="fa fa-bar-chart-o"></i> <span>Statistique</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'synthActivity') {
                                        echo 'active';
                                      } ?>"><a href="<?php echo WEB_URL; ?>report/synthActivity.php"><i class="fa fa-arrow-circle-right"></i> Synthèse d'activités</a></li>
                  </ul>
                </li>
              <?php }
                  ?>

            <?php } ?>

          </ul>

        <?php } ?>

        <?php if (isset($_SESSION['objServiceClient'])) {

          $client_droit_acces = 'role_client';

          // DROIT SERVICE CLIENT

          // On vérifie que l'enregistrement du droit d'accès par role courant exsite déja en BDD
          $querySelClientDroitMenuRole = "SELECT droit_menu_role_id, role_name FROM tbl_droit_menu_role WHERE role_name = '" . $client_droit_acces  . "'";

          // On exécute la requête
          $resultSelClientDroitMenuRole = mysql_query($querySelClientDroitMenuRole, $link);

          // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
          // if (!$resultSelClientDroitMenuRole) {
          //   $message  = 'Invalid query: ' . mysql_error() . "\n";
          //   $message .= 'Whole query: ' . $querySelClientDroitMenuRole;
          //   die($message);
          // }

          // On récupère le jeu de résultat de la requête
          $listeClientDroitMenuRole = mysql_fetch_assoc($resultSelClientDroitMenuRole);

          // Si l'array n'est pas vide, alors il y a au moin un enregistrement correspondant à la sélection
          // Dans ce cas, on fait la sélection
          if (!empty($listeClientDroitMenuRole)) {

            // Droit menu client
            $resultDroitMenuClient = $wms->getDroitMenuClientInfo($link, $client_droit_acces);
          }
          ?>

          <ul class="sidebar-menu">

            <li class="header">Menus</li>
            <li class="tm10 <?php if ($page_name != '' && $page_name == 'servcli_dashboard') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>servcli_panel/servcli_dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a> </li>

            <?php if (isset($resultDroitMenuClient) || !empty($resultDroitMenuClient)) {
                // Si le droit du role du service client existe déja en BDD, on récupère les données du droit en BDD
                if ($resultDroitMenuClient['menu_client'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'add_client' || $page_name == 'list_client') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>customer/addcustomer.php"> <i class="fa fa-user"></i> <span>Client</span><i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'add_client') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>customer/addcustomer.php"><i class="fa fa-arrow-circle-right"></i>Enregistrer un client</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'list_client') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>customer/customerlist.php"><i class="fa fa-arrow-circle-right"></i>Liste des clients</a>
                    </li>

                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuClient['menu_recep_vehi'] == 'O') { ?>

                <!-- <li class="treeview <?php if ($page_name != '' && $page_name == 'reception_vehicule') {
                                                  echo 'active';
                                                } ?>">
                              <a href="<?php echo WEB_URL; ?>reception/repaircar_reception.php"> <i class="fa fa-user"></i> <span>Réception de véhicules</span> <i class="fa fa-angle-left pull-right"></i> </a>
                              <ul class="treeview-menu">
                                <li class="<?php if ($page_name != '' && $page_name == 'reception_vehicule') {
                                                    echo 'active';
                                                  } ?>">
                                  <a href="<?php echo WEB_URL; ?>reception/repaircar_reception.php"><i class="fa fa-arrow-circle-right"></i>Réception de véhicules</a>
                                </li>
                                <li class="<?php if ($page_name != '' && $page_name == 'reception_vehicule_list') {
                                                    echo 'active';
                                                  } ?>">
                                  <a href="<?php echo WEB_URL; ?>reception/repaircar_reception_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules réceptionnés</a>
                                </li>

                              </ul>
                            </li> -->
              <?php }

                  if ($resultDroitMenuClient['menu_vehi'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'addcar' || $page_name == 'liste_vehicule_scanning') {
                                            echo 'active';
                                          } ?>">
                  <a href="<?php echo WEB_URL; ?>repaircar/addcar.php"> <i class="fa fa-car"></i> <span>Véhicules</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'liste_vehicule_client') {

                                        echo 'active';
                                      } ?>">

                      <a href="<?php echo WEB_URL; ?>repaircar/carlist.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules des clients</a>

                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'liste_vehicule_scanning') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>repaircar/vehicule_scanning_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules à scanner</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'reception_vehicule') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>reception/repaircar_reception.php"><i class="fa fa-arrow-circle-right"></i>Réception de véhicules</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'diagnostic_vehicule_list') {

                                        echo 'active';
                                      } ?>">

                      <a href="<?php echo WEB_URL; ?>reception/repaircar_diagnostic_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules diagnostiqués</a>

                    </li>
                    <!-- <li class="<?php if ($page_name != '' && $page_name == 'reception_vehicule_list') {
                                            echo 'active';
                                          } ?>">
                                  <a href="<?php echo WEB_URL; ?>reception/repaircar_reception_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules réceptionnés</a>
                                </li> -->
                    <!-- <li class="<?php if ($page_name != '' && $page_name == 'liste_vehicule_client') {
                                            echo 'active';
                                          } ?>">
                                        <a href="<?php echo WEB_URL; ?>repaircar/carlist.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules des clients</a>
                                      </li>
                                      <li class="<?php if ($page_name != '' && $page_name == 'liste_vehicule_garage') {
                                                          echo 'active';
                                                        } ?>">
                                        <a href="<?php echo WEB_URL; ?>repaircar/carlist_garage.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules au garage</a>
                                      </li>
                                      <li class="<?php if ($page_name != '' && $page_name == 'diagnostic_vehicule_list') {
                                                          echo 'active';
                                                        } ?>">
                                        <a href="<?php echo WEB_URL; ?>reception/repaircar_diagnostic_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules diagnostiqués</a>
                                      </li> -->
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuClient['menu_devis'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'findcar' || $page_name == 'estimate_form') {
                                            echo 'active';
                                          } ?>">
                  <a href="<?php echo WEB_URL; ?>estimate/adddevis.php"> <i class="fa fa-calculator"></i> <span>Devis</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'ajout_devis') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/adddevis.php"><i class="fa fa-arrow-circle-right"></i>Créer un devis de réparation</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'repair_diagnostic_devis_list') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/repaircar_diagnostic_devis_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des devis de réparation</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'repair_simulation_devis_list') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/repaircar_simu_devis_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des autres devis</a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuClient['menu_facture'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'repaircar_devis_facture_list' || $page_name == 'repaircar_simu_devis_facture_list') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>estimate/repaircar_devis_facture_list.php"> <i class="fa fa-files-o"></i> <span>Factures</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'repaircar_devis_facture_list') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/repaircar_devis_facture_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des factures de réparation</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'repaircar_simu_devis_facture_list') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>estimate/repaircar_simu_devis_facture_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des autres factures</a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuClient['menu_stock_piece'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'buyparts' || $page_name == 'partsstocklist' || $page_name == 'mouvstock') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>parts_stock/buyparts.php"> <i class="fa fa-truck"></i> <span>Stock de pièces</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">

                    <li class="<?php if ($page_name != '' && $page_name == 'buyparts') {
                                        echo 'active';
                                      } ?>"><a href="<?php echo WEB_URL; ?>parts_stock/buyparts.php"><i class="fa fa-arrow-circle-right"></i>Créer article</a></li>
                    <li class="<?php if ($page_name != '' && $page_name == 'partsstocklist') {
                                        echo 'active';
                                      } ?>"><a href="<?php echo WEB_URL; ?>parts_stock/partsstocklist.php"><i class="fa fa-arrow-circle-right"></i>Liste des articles</a></li>
                    <li class="<?php if ($page_name != '' && $page_name == 'mouvstock') {
                                        echo 'active';
                                      } ?>"><a href="<?php echo WEB_URL; ?>parts_stock/mouvstock.php"><i class="fa fa-arrow-circle-right"></i>Mouvements de stock</a></li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuClient['menu_four'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'addsupplier' || $page_name == 'supplierlist' || $page_name == 'boncmdeList' || $page_name == 'supplierManage' || $page_name == 'addBonCmde') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>supplier/addsupplier.php"> <i class="fa fa-user"></i> <span>Fournisseurs</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'addsupplier') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>supplier/addsupplier.php"><i class="fa fa-arrow-circle-right"></i>Créer un fournisseur</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'supplierlist') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>supplier/supplierlist.php"><i class="fa fa-arrow-circle-right"></i>Liste des fournisseurs</a>
                    </li>
                    <!-- <li class="<?php if ($page_name != '' && $page_name == 'addBonCmde') {
                                            echo 'active';
                                          } ?>">
                                                    <a href="<?php echo WEB_URL; ?>bon_cmde/addBonCmde.php"><i class="fa fa-arrow-circle-right"></i>Créer un bon de commande</a>
                                                  </li>
                                                  <li class="treeview <?php if ($page_name != '' && $page_name == 'boncmdeList') {
                                                                              echo 'active';
                                                                            } ?>"> <a href="<?php echo WEB_URL; ?>bon_cmde/boncmdeList.php"> <i class="fa fa-arrow-circle-right"></i> <span>Liste des bons de commande</span> </a>
                                                  </li> -->
                    <li class="treeview <?php if ($page_name != '' && $page_name == 'supplierManage') {
                                                echo 'active';
                                              } ?>"> <a href="<?php echo WEB_URL; ?>supplier/supplierManage.php"> <i class="fa fa-arrow-circle-right"></i> <span>Gestion des fournisseurs</span> </a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuClient['menu_ges_personnel'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'personnelist' || $page_name == 'personnel') {
                                            echo 'active';
                                          } ?>"> <a href="<?php echo WEB_URL; ?>user/addpersonnel.php"> <i class="fa fa-users"></i> <span>Personnel</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="treeview <?php if ($page_name != '' && $page_name == 'addPersonnel' || $page_name == 'personnellist') {
                                                echo 'active';
                                              } ?>"> <a href="<?php echo WEB_URL; ?>user/addpersonnel.php"> <i class="fa fa-arrow-circle-right"></i> <span>Ajouter personnel</span> </a>
                    </li>
                    <li class="treeview <?php if ($page_name != '' && $page_name == 'listepersonnel') {
                                                echo 'active';
                                              } ?>"> <a href="<?php echo WEB_URL; ?>user/listepersonnel.php"> <i class="fa fa-arrow-circle-right"></i> <span>Liste du personnel</span> </a>
                    </li>
                    <li class="treeview <?php if ($page_name != '' && $page_name == 'presenceperso') {
                                                echo 'active';
                                              } ?>"> <a href="<?php echo WEB_URL; ?>user/presenceperso.php"> <i class="fa fa-arrow-circle-right"></i> <span>Liste de présences</span> </a>
                    </li>
                    <!-- <li class="treeview <?php if ($page_name != '' && $page_name == 'salperso') {
                                                      echo 'active';
                                                    } ?>"> <a href="<?php echo WEB_URL; ?>user/salperso.php"> <i class="fa fa-arrow-circle-right"></i> <span>Salaires</span> </a>
                                                              </li> -->
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuClient['menu_ges_user'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'gesuser' || $page_name == 'gesusers') {
                                            echo 'active';
                                          } ?>">
                  <a href="<?php echo WEB_URL; ?>gesuser.php"> <i class="fa fa-users"></i> <span>Utilisateurs</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'adduser') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>user/adduser.php"><i class="fa fa-arrow-circle-right"></i>Créer un utilisateur</a>
                    </li>
                    <li class="<?php if ($page_name != '' && $page_name == 'userlist') {
                                        echo 'active';
                                      } ?>">
                      <a href="<?php echo WEB_URL; ?>user/userlist.php"><i class="fa fa-arrow-circle-right"></i>Liste des utilisateurs</a>
                    </li>
                  </ul>
                </li>
              <?php }

                  if ($resultDroitMenuClient['menu_rapport'] == 'O') { ?>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'reprepairdelivery' || $page_name == 'rptcarbuy' || $page_name == 'rptcarsell' || $page_name == 'rptpartsbuy' || $page_name == 'rptpartssell' || $page_name == 'rptmsalary' || $page_name == 'synthActivity') {
                                            echo 'active';
                                          } ?>"> <a href="#"> <i class="fa fa-bar-chart-o"></i> <span>Statistique</span> <i class="fa fa-angle-left pull-right"></i> </a>
                  <ul class="treeview-menu">
                    <li class="<?php if ($page_name != '' && $page_name == 'synthActivity') {
                                        echo 'active';
                                      } ?>"><a href="<?php echo WEB_URL; ?>report/synthActivity.php"><i class="fa fa-arrow-circle-right"></i> Synthèse d'activités</a></li>
                  </ul>
                </li>
              <?php }
                  ?>

            <?php } ?>

          </ul>

        <?php } ?>

        <?php if (isset($_SESSION['objLogin'])) { ?>

          <ul class="sidebar-menu">

            <li class="header">Menus</li>

            <li class="tm10 <?php if ($page_name != '' && $page_name == 'dashboard') {

                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a> </li>

            <li class="treeview <?php if ($page_name != '' && $page_name == 'customerlist' || $page_name == 'addcustomer') {

                                    echo 'active';
                                  } ?>"> <a href="<?php echo WEB_URL; ?>customer/customerlist.php"> <i class="fa fa-user"></i> <span>Client</span></a></li>

            <li class="treeview <?php if ($page_name != '' && $page_name == 'reception_vehicule') {

                                    echo 'active';
                                  } ?>">



            <li class="treeview <?php if ($page_name != '' && $page_name == 'reception_vehicule') {

                                    echo 'active';
                                  } ?>">

              <a href="<?php echo WEB_URL; ?>reception/repaircar_reception.php"> <i class="fa fa-user"></i> <span>Réception de véhicules</span> <i class="fa fa-angle-left pull-right"></i> </a>

              <ul class="treeview-menu">

                <li class="<?php if ($page_name != '' && $page_name == 'reception_vehicule') {

                                echo 'active';
                              } ?>">

                  <a href="<?php echo WEB_URL; ?>reception/repaircar_reception.php"><i class="fa fa-arrow-circle-right"></i>Réception de véhicules</a>

                </li>

                <li class="<?php if ($page_name != '' && $page_name == 'reception_vehicule_list') {

                                echo 'active';
                              } ?>">

                  <a href="<?php echo WEB_URL; ?>reception/repaircar_reception_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules réceptionnés</a>

                </li>



              </ul>

            </li>



            <li class="treeview <?php if ($page_name != '' && $page_name == 'addcar' || $page_name == 'carlist') {

                                    echo 'active';
                                  } ?>">

              <a href="<?php echo WEB_URL; ?>repaircar/addcar.php"> <i class="fa fa-car"></i> <span>Véhicules</span> <i class="fa fa-angle-left pull-right"></i> </a>

              <ul class="treeview-menu">

                <li class="<?php if ($page_name != '' && $page_name == 'liste_vehicule_client') {

                                echo 'active';
                              } ?>">

                  <a href="<?php echo WEB_URL; ?>repaircar/carlist.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules des clients</a>

                </li>

                <li class="<?php if ($page_name != '' && $page_name == 'liste_vehicule_garage') {

                                echo 'active';
                              } ?>">

                  <a href="<?php echo WEB_URL; ?>repaircar/carlist_garage.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules au garage</a>

                </li>

                <li class="<?php if ($page_name != '' && $page_name == 'diagnostic_vehicule_list') {

                                echo 'active';
                              } ?>">

                  <a href="<?php echo WEB_URL; ?>reception/repaircar_diagnostic_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des véhicules diagnostiqués</a>

                </li>

              </ul>

            </li>



            <li class="treeview <?php if ($page_name != '' && $page_name == 'findcar' || $page_name == 'estimate_form') {

                                    echo 'active';
                                  } ?>">

              <a href="<?php echo WEB_URL; ?>estimate/adddevis.php"> <i class="fa fa-calculator"></i> <span>Devis</span> <i class="fa fa-angle-left pull-right"></i> </a>

              <ul class="treeview-menu">

                <li class="<?php if ($page_name != '' && $page_name == 'ajout_devis') {

                                echo 'active';
                              } ?>">

                  <a href="<?php echo WEB_URL; ?>estimate/adddevis.php"><i class="fa fa-arrow-circle-right"></i>Créer un devis de réparation</a>

                </li>

                <li class="<?php if ($page_name != '' && $page_name == 'repair_diagnostic_devis_list') {

                                echo 'active';
                              } ?>">

                  <a href="<?php echo WEB_URL; ?>estimate/repaircar_diagnostic_devis_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des devis de réparation</a>

                </li>

                <li class="<?php if ($page_name != '' && $page_name == 'repair_simulation_devis_list') {

                                echo 'active';
                              } ?>">

                  <a href="<?php echo WEB_URL; ?>estimate/repaircar_simu_devis_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des autres devis</a>

                </li>

              </ul>

            </li>



            <li class="treeview <?php if ($page_name != '' && $page_name == 'repaircar_devis_facture_list' || $page_name == 'repaircar_simu_devis_facture_list') {

                                    echo 'active';
                                  } ?>"> <a href="<?php echo WEB_URL; ?>estimate/repaircar_devis_facture_list.php"> <i class="fa fa-files-o"></i> <span>Factures</span> <i class="fa fa-angle-left pull-right"></i> </a>

              <ul class="treeview-menu">

                <li class="<?php if ($page_name != '' && $page_name == 'repaircar_devis_facture_list') {

                                echo 'active';
                              } ?>">

                  <a href="<?php echo WEB_URL; ?>estimate/repaircar_devis_facture_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des factures de réparation</a>

                </li>

                <li class="<?php if ($page_name != '' && $page_name == 'repaircar_simu_devis_facture_list') {

                                echo 'active';
                              } ?>">

                  <a href="<?php echo WEB_URL; ?>estimate/repaircar_simu_devis_facture_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des autres factures</a>

                </li>

              </ul>

            </li>

            <li class="treeview <?php if ($page_name != '' && $page_name == 'buyparts' || $page_name == 'partsstocklist' || $page_name == 'mouvstock') {

                                    echo 'active';
                                  } ?>"> <a href="<?php echo WEB_URL; ?>parts_stock/buyparts.php"> <i class="fa fa-truck"></i> <span>Stock de pièces</span> <i class="fa fa-angle-left pull-right"></i> </a>

              <ul class="treeview-menu">



                <li class="<?php if ($page_name != '' && $page_name == 'buyparts') {

                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>parts_stock/buyparts.php"><i class="fa fa-arrow-circle-right"></i>Créer article</a></li>

                <li class="<?php if ($page_name != '' && $page_name == 'partsstocklist') {

                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>parts_stock/partsstocklist.php"><i class="fa fa-arrow-circle-right"></i>Liste des articles</a></li>

                <li class="<?php if ($page_name != '' && $page_name == 'mouvstock') {

                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>parts_stock/mouvstock.php"><i class="fa fa-arrow-circle-right"></i>Mouvements de stock</a></li>

              </ul>

            </li>

            <li class="treeview <?php if ($page_name != '' && $page_name == 'addsupplier' || $page_name == 'supplierlist' || $page_name == 'boncmdeList' || $page_name == 'supplierManage' || $page_name == 'addBonCmde') {

                                    echo 'active';
                                  } ?>"> <a href="<?php echo WEB_URL; ?>supplier/addsupplier.php"> <i class="fa fa-user"></i> <span>Fournisseurs</span> <i class="fa fa-angle-left pull-right"></i> </a>

              <ul class="treeview-menu">

                <li class="<?php if ($page_name != '' && $page_name == 'addsupplier') {

                                echo 'active';
                              } ?>">

                  <a href="<?php echo WEB_URL; ?>supplier/addsupplier.php"><i class="fa fa-arrow-circle-right"></i>Créer un fournisseur</a>

                </li>

                <li class="<?php if ($page_name != '' && $page_name == 'supplierlist') {

                                echo 'active';
                              } ?>">

                  <a href="<?php echo WEB_URL; ?>supplier/supplierlist.php"><i class="fa fa-arrow-circle-right"></i>Liste des fournisseurs</a>

                </li>

                <!-- <li class="<?php if ($page_name != '' && $page_name == 'addBonCmde') {

                                    echo 'active';
                                  } ?>">

                        <a href="<?php echo WEB_URL; ?>bon_cmde/addBonCmde.php"><i class="fa fa-arrow-circle-right"></i>Créer un bon de commande</a>

                      </li>

                      <li class="treeview <?php if ($page_name != '' && $page_name == 'boncmdeList') {

                                              echo 'active';
                                            } ?>"> <a href="<?php echo WEB_URL; ?>bon_cmde/boncmdeList.php"> <i class="fa fa-arrow-circle-right"></i> <span>Liste des bons de commande</span> </a>

                      </li> -->

                <li class="treeview <?php if ($page_name != '' && $page_name == 'supplierManage') {

                                        echo 'active';
                                      } ?>"> <a href="<?php echo WEB_URL; ?>supplier/supplierManage.php"> <i class="fa fa-arrow-circle-right"></i> <span>Gestion des fournisseurs</span> </a>

                </li>

              </ul>

            </li>



            <li class="treeview <?php if ($page_name != '' && $page_name == 'personnelist' || $page_name == 'personnel') {

                                    echo 'active';
                                  } ?>"> <a href="<?php echo WEB_URL; ?>user/addpersonnel.php"> <i class="fa fa-users"></i> <span>Personnel</span> <i class="fa fa-angle-left pull-right"></i> </a>

              <ul class="treeview-menu">

                <li class="treeview <?php if ($page_name != '' && $page_name == 'addPersonnel' || $page_name == 'personnellist') {

                                        echo 'active';
                                      } ?>"> <a href="<?php echo WEB_URL; ?>user/addpersonnel.php"> <i class="fa fa-arrow-circle-right"></i> <span>Ajouter personnel</span> </a>

                </li>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'listepersonnel') {

                                        echo 'active';
                                      } ?>"> <a href="<?php echo WEB_URL; ?>user/listepersonnel.php"> <i class="fa fa-arrow-circle-right"></i> <span>Liste du personnel</span> </a>

                </li>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'presenceperso') {

                                        echo 'active';
                                      } ?>"> <a href="<?php echo WEB_URL; ?>user/presenceperso.php"> <i class="fa fa-arrow-circle-right"></i> <span>Liste de présences</span> </a>

                </li>

                <li class="treeview <?php if ($page_name != '' && $page_name == 'salpersolist') {

                                        echo 'active';
                                      } ?>"> <a href="<?php echo WEB_URL; ?>user/salpersolist.php"> <i class="fa fa-arrow-circle-right"></i> <span>Salaires</span> </a>

                </li>

              </ul>

            </li>



            <li class="treeview <?php if ($page_name != '' && $page_name == 'gesuser' || $page_name == 'gesusers') {

                                    echo 'active';
                                  } ?>">

              <a href="<?php echo WEB_URL; ?>gesuser.php"> <i class="fa fa-users"></i> <span>Utilisateurs</span> <i class="fa fa-angle-left pull-right"></i> </a>

              <ul class="treeview-menu">

                <li class="<?php if ($page_name != '' && $page_name == 'adduser') {

                                echo 'active';
                              } ?>">

                  <a href="<?php echo WEB_URL; ?>user/adduser.php"><i class="fa fa-arrow-circle-right"></i>Créer un utilisateur</a>

                </li>

                <li class="<?php if ($page_name != '' && $page_name == 'userlist') {

                                echo 'active';
                              } ?>">

                  <a href="<?php echo WEB_URL; ?>user/userlist.php"><i class="fa fa-arrow-circle-right"></i>Liste des utilisateurs</a>

                </li>

              </ul>

            </li>



            <li class="treeview <?php if ($page_name != '' && $page_name == 'gestionRole') {

                                    echo 'active';
                                  } ?>"> <a href="<?php echo WEB_URL; ?>user/addrole.php"> <i class="fa fa-shield"></i> <span>Droits d'accès</span> <i class="fa fa-angle-left pull-right"></i> </a>

              <ul class="treeview-menu">

                <li class="treeview <?php if ($page_name != '' || $page_name == 'addrole') {

                                        echo 'active';
                                      } ?>"> <a href="<?php echo WEB_URL; ?>user/addrole.php"> <i class="fa fa-arrow-circle-right"></i> <span>Gérer les droits d'accès</span> </a>

                </li>

              </ul>

            </li>



            <li class="treeview <?php if ($page_name != '' && $page_name == 'reprepairdelivery' || $page_name == 'rptcarbuy' || $page_name == 'rptcarsell' || $page_name == 'rptpartsbuy' || $page_name == 'rptpartssell' || $page_name == 'rptmsalary' || $page_name == 'synthActivity') {

                                    echo 'active';
                                  } ?>"> <a href="#"> <i class="fa fa-bar-chart-o"></i> <span>Statistique</span> <i class="fa fa-angle-left pull-right"></i> </a>

              <ul class="treeview-menu">

                <li class="<?php if ($page_name != '' && $page_name == 'synthActivity') {

                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>report/synthActivity.php"><i class="fa fa-arrow-circle-right"></i> Synthèse d'activités</a></li>

              </ul>

            </li>

          </ul>

        <?php } ?>

        <?php if (isset($_SESSION['objCust'])) { ?>
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="tm10 <?php if ($page_name != '' && $page_name == 'mech_dashboard') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>cust_panel/cust_dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a> </li>
            <!-- <li class="treeview <?php if ($page_name != '' && $page_name == 'mycar' || $page_name == 'mycar') {
                                          echo 'active';
                                        } ?>"> <a href="<?php echo WEB_URL; ?>cust_panel/mycar.php"> <i class="fa fa-car"></i> <span>Ma voiture</span></a></li> -->
            <!-- <li class="treeview <?php if ($page_name != '' && $page_name == 'estimate') {
                                          echo 'active';
                                        } ?>"> <a href="<?php echo WEB_URL; ?>cust_panel/estimate.php"> <i class="fa fa-calculator"></i> <span>Historique des Devis </span></a></li> -->
            </li>
            <li class="treeview <?php if ($page_name != '' && $page_name == 'cust_devis_repaircar_diagnostic_list') {
                                    echo 'active';
                                  } ?>"> <a href="<?php echo WEB_URL; ?>cust_panel/cust_repaircar_diagnostic_devis_list.php"> <i class="fa fa-file-powerpoint-o"></i> <span>Liste des devis de réparation</span></a></li>
            <!-- <li class="treeview <?php if ($page_name != '' && $page_name == 'cust_devis_repaircar_diagnostic_list') {
                                          echo 'active';
                                        } ?>"> <a href="<?php echo WEB_URL; ?>cust_panel/cust_repaircar_devis_bcmde_list.php"> <i class="fa fa-file-powerpoint-o"></i> <span>Liste des bons de commande</span></a></li> -->
            <li class="treeview <?php if ($page_name != '' && $page_name == 'cust_devis_repaircar_diagnostic_list') {
                                    echo 'active';
                                  } ?>"> <a href="<?php echo WEB_URL; ?>cust_panel/cust_repaircar_devis_facture_list.php"> <i class="fa fa-file-powerpoint-o"></i> <span>Liste des factures</span></a></li>
          </ul>
        <?php } ?>

      </section>
      <!-- /.sidebar -->
    </aside>
    <!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">