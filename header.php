<?php
ob_start();
session_start();

include(__DIR__ . "/config.php");
include(__DIR__ . "/helper/common.php");

if (!isset($_SESSION['objLogin']) || empty($_SESSION['objLogin'])) {
  header("Location: logout.php");
  die();
}

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
  <!-- <script src="<?php echo WEB_URL; ?>dist/js/adddevis.js"></script> -->
  <script type="text/javascript" src="<?php echo WEB_URL; ?>dist/js/typeahead.js"></script>
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
          <p><?php echo !empty($_SESSION['objLogin']['name']) ? $_SESSION['objLogin']['name'] : ''; ?></p>
          <a href="<?php echo WEB_URL; ?>user/profile.php"><i class="fa fa-circle text-success"></i> En ligne</a>
        </div>
      </div>
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
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
              <li class="<?php if ($page_name != '' && $page_name == 'diagnostic_vehicule_list') {
                            echo 'active';
                          } ?>">
                <a href="<?php echo WEB_URL; ?>reception/repaircar_diagnostic_list.php"><i class="fa fa-arrow-circle-right"></i>Diagnostics des véhicules</a>
              </li>
            </ul>
          </li>

          <li class="treeview <?php if ($page_name != '' && $page_name == 'addcar' || $page_name == 'carlist') {
                                echo 'active';
                              } ?>">
            <a href="<?php echo WEB_URL; ?>repaircar/addcar.php"> <i class="fa fa-car"></i> <span>Véhicules</span> <i class="fa fa-angle-left pull-right"></i> </a>
            <ul class="treeview-menu">
              <!-- <li class="<?php if ($page_name != '' && $page_name == 'creation_vehicule') {
                                echo 'active';
                              } ?>">
                <a href="<?php echo WEB_URL; ?>repaircar/addcar.php"><i class="fa fa-arrow-circle-right"></i>Ajout d'un véhicule</a>
              </li> -->
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

          <li class="treeview <?php if ($page_name != '' && $page_name == 'findcar' || $page_name == 'estimate_form') {
                                echo 'active';
                              } ?>">
            <a href="#"> <i class="fa fa-calculator"></i> <span>Devis</span> <i class="fa fa-angle-left pull-right"></i> </a>
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
                <a href="<?php echo WEB_URL; ?>estimate/repaircar_simu_devis_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des devis de simulation</a>
              </li>
            </ul>
          </li>

          <li class="treeview <?php if ($page_name != '' && $page_name == 'deliverylist' || $page_name == 'finddeliverycar') {
                                echo 'active';
                              } ?>"> <a href="<?php echo WEB_URL; ?>delivery/finddeliverycar.php"> <i class="fa fa-files-o"></i> <span>Factures</span> <i class="fa fa-angle-left pull-right"></i> </a>
            <ul class="treeview-menu">
              <li class="<?php if ($page_name != '' && $page_name == 'repair_diagnostic_facture_list') {
                            echo 'active';
                          } ?>">
                <a href="<?php echo WEB_URL; ?>estimate/repaircar_devis_facture_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des factures de réparation</a>
              </li>
              <li class="<?php if ($page_name != '' && $page_name == 'repair_simulation_facture_list') {
                            echo 'active';
                          } ?>">
                <a href="<?php echo WEB_URL; ?>estimate/repaircar_simu_devis_facture_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des factures de simulation</a>
              </li>
              <!-- <li class="<?php if ($page_name != '' && $page_name == 'finddeliverycar') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>delivery/finddeliverycar.php"><i class="fa fa-arrow-circle-right"></i>Livraison de voiture</a></li>
              <li class="<?php if ($page_name != '' && $page_name == 'deliverylist') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>delivery/deliverylist.php"><i class="fa fa-arrow-circle-right"></i>Liste de livraison</a></li> -->
            </ul>
          </li>

          <!-- <li class="treeview <?php if ($page_name != '' && $page_name == 'presence') {
                                      echo 'active';
                                    } ?>">
            <a href="<?php echo WEB_URL; ?>pointage/presence.php"> <i class="fa fa-calendar-check-o"></i> <span>Présences</span> <i class="fa fa-angle-left pull-right"></i> </a>
            <ul class="treeview-menu">
              <li class="<?php if ($page_name != '' && $page_name == 'pointage') {
                            echo 'active';
                          } ?>">
                <a href="<?php echo WEB_URL; ?>pointage/presence.php"><i class="fa fa-arrow-circle-right"></i>Pointage</a>
              </li>
              <li class="<?php if ($page_name != '' && $page_name == 'Pointagelist') {
                            echo 'active';
                          } ?>">
                <a href="<?php echo WEB_URL; ?>pointage/presence_liste.php"><i class="fa fa-arrow-circle-right"></i>Liste de pointage</a>
              </li>
            </ul>
          </li> -->

          <li class="treeview <?php if ($page_name != '' && $page_name == 'buyparts' || $page_name == 'partsstocklist') {
                                echo 'active';
                              } ?>"> <a href="<?php echo WEB_URL; ?>parts_stock/buyparts.php"> <i class="fa fa-truck"></i> <span>Stock de pièces</span> <i class="fa fa-angle-left pull-right"></i> </a>
            <ul class="treeview-menu">

              <li class="<?php if ($page_name != '' && $page_name == 'buypartslist') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>parts_stock/buyparts.php"><i class="fa fa-arrow-circle-right"></i>Créer article</a></li>
              <li class="<?php if ($page_name != '' && $page_name == 'partsstocklist') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>parts_stock/partsstocklist.php"><i class="fa fa-arrow-circle-right"></i>Liste des articles</a></li>
            </ul>
          </li>
          <!-- <li class="treeview <?php if ($page_name != '' && $page_name == 'buycarlist' || $page_name == 'buycar' || $page_name == 'sellcarlist' || $page_name == 'sellcar' || $page_name == 'carsellform') {
                                      echo 'active';
                                    } ?>"> <a href="#"> <i class="fa fa-car"></i> <span>Stock de voiture</span> <i class="fa fa-angle-left pull-right"></i> </a>
            <ul class="treeview-menu">
              <li class="<?php if ($page_name != '' && $page_name == 'buycarlist' || $page_name == 'buycar') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>carstock/buycarlist.php"><i class="fa fa-arrow-circle-right"></i>Achats de Voitures</a></li>
              <li class="<?php if ($page_name == 'sellcarlist' || $page_name == 'sellcar' || $page_name == 'carsellform') {
                            echo 'active';
                          } ?>"><a href="#"><i class="fa fa-arrow-circle-right"></i>Voitures vendues<i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li class="<?php if ($page_name != '' && $page_name == 'sellcarlist') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>carstock/sellcarlist.php"><i class="fa fa-arrow-circle-right"></i>Liste de voitures vendues</a></li>
                  <li class="<?php if ($page_name != '' && $page_name == 'sellcar' || $page_name == 'carsellform') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>carstock/sellcar.php"><i class="fa fa-arrow-circle-right"></i>Trouver une voiture</a></li>
                </ul>
              </li>
            </ul>
          </li> -->
          <!-- <li class="treeview <?php if ($page_name != '' && $page_name == 'addreception' || $page_name == 'receptionlist') {
                                      echo 'active';
                                    } ?>"> <a href="<?php echo WEB_URL; ?>reception/receptionnistelist.php"> <i class="fa fa-user"></i> <span>Receptionnistes</span></a>

          </li> -->
          <li class="treeview <?php if ($page_name != '' && $page_name == 'addsupplier' || $page_name == 'supplierlist') {
                                echo 'active';
                              } ?>"> <a href="<?php echo WEB_URL; ?>supplier/supplierlist.php"> <i class="fa fa-user"></i> <span>Fournisseurs</span> <i class="fa fa-angle-left pull-right"></i> </a>
            <ul class="treeview-menu">
              <li class="treeview <?php if ($page_name != '' && $page_name == 'addBoncmde' || $page_name == 'bonCmdeList') {
                                    echo 'active';
                                  } ?>"> <a href="<?php echo WEB_URL; ?>bon_cmde/boncmdeList.php"> <i class="fa fa-arrow-circle-right"></i> <span>Liste des bons de commande</span> </a>
              </li>
              <li class="treeview <?php if ($page_name != '' && $page_name == 'gesFour') {
                                    echo 'active';
                                  } ?>"> <a href="#"> <i class="fa fa-arrow-circle-right"></i> <span>Gestion des fournisseurs</span> </a>
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
              <li class="treeview <?php if ($page_name != '' && $page_name == 'personnellist') {
                                    echo 'active';
                                  } ?>"> <a href="<?php echo WEB_URL; ?>user/listepersonnel.php"> <i class="fa fa-arrow-circle-right"></i> <span>Liste du personnel</span> </a>
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
              <!-- <li class="treeview <?php if ($page_name != '' && $page_name == 'mechanicsalarylist' || $page_name == 'mechanicslist' || $page_name == 'addmechanics') {
                                          echo 'active';
                                        } ?>"> <a href="#"> <i class="fa fa-users"></i> <span>Mecaniciens</span> <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                  <li class="<?php if ($page_name != '' && $page_name == 'addmechanics') {
                                echo 'active';
                              } ?>">
                    <a href="<?php echo WEB_URL; ?>mechanics/addmechanics.php"><i class="fa fa-arrow-circle-right"></i>Créer un mécanicien</a>
                  </li>
                  <li class="<?php if ($page_name != '' && $page_name == 'mechanicslist' || $page_name == 'addmechanics') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>mechanics/mechanicslist.php"> <i class="fa fa-arrow-circle-right"></i>Liste des mécaniciens</a></li>
                  <li class="<?php if ($page_name != '' && $page_name == 'mechanicsalarylist') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>mechanics/mechanicsalarylist.php"> <i class="fa fa-arrow-circle-right"></i> Salaire Mecaniciens</a></li>
                </ul>
              </li> -->
              <!-- <li class="<?php if ($page_name != '' && $page_name == 'addduser') {
                                echo 'active';
                              } ?>">
                <a href="<?php echo WEB_URL; ?>estimate/repaircar_diagnostic_devis_list.php"><i class="fa fa-arrow-circle-right"></i>Liste des utilisateurs</a>
              </li> -->
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
              <!-- <li class="treeview <?php if ($page_name != '' && $page_name == 'personnellist') {
                                          echo 'active';
                                        } ?>"> <a href="<?php echo WEB_URL; ?>user/listepersonnel.php"> <i class="fa fa-arrow-circle-right"></i> <span>Liste du personnel</span> </a>
              </li> -->
            </ul>
          </li>


          <!--<li class="treeview <?php
                                  ?>"> <a href="#"> <i class="fa fa-edit"></i> <span>Invoice</span> <i class="fa fa-angle-left pull-right"></i> </a>-->
          <ul class="treeview-menu">
            <li class="<?php if ($page_name != '' && $page_name == 'addinvoice') {
                          echo 'active';
                        } ?>"><a href="<?php echo WEB_URL; ?>invoice/addinvoice.php"><i class="fa fa-arrow-circle-right"></i> Ajouter une facture</a></li>
            <li class="<?php if ($page_name != '' && $page_name == 'invoicelist') {
                          echo 'active';
                        } ?>"><a href="<?php echo WEB_URL; ?>invoice/invoicelist.php"><i class="fa fa-arrow-circle-right"></i> Liste de factures</a></li>
          </ul>
          </li>
          <!-- <li class="treeview <?php if ($page_name != '' && $page_name == 'addnotification' || $page_name == 'notificationlist') {
                                      echo 'active';
                                    } ?>"> <a href="#"> <i class="fa fa-comment"></i> <span>Des rappels</span> <i class="fa fa-angle-left pull-right"></i> </a>
            <ul class="treeview-menu">
              <li class="<?php if ($page_name != '' && $page_name == 'addnotification') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>notification/addnotification.php"><i class="fa fa-arrow-circle-right"></i> Envoyer rappels</a></li>
              <li class="<?php if ($page_name != '' && $page_name == 'notificationlist') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>notification/notificationlist.php"><i class="fa fa-arrow-circle-right"></i> Liste rappels</a></li>
            </ul>
          </li> -->
          <!-- <li class="<?php if ($page_name != '' && $page_name == 'apointment') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>apointment/apointment.php"><i class="fa fa-phone"></i> <span>Rendez-vous</span></a> </li> -->
          <!-- <li class="<?php if ($page_name != '' && $page_name == 'carrequest') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>car_request/carrequest.php"><i class="fa fa-car"></i> <span>Demande de voiture</span></a> </li> -->
          <!-- <li class="<?php if ($page_name != '' && $page_name == 'contact_list') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>contact_list/contact_list.php"><i class="fa fa-envelope-o"></i> <span>Contact</span></a> </li> -->
          <li class="treeview <?php if ($page_name != '' && $page_name == 'reprepairdelivery' || $page_name == 'rptcarbuy' || $page_name == 'rptcarsell' || $page_name == 'rptpartsbuy' || $page_name == 'rptpartssell' || $page_name == 'rptmsalary') {
                                echo 'active';
                              } ?>"> <a href="#"> <i class="fa fa-bar-chart-o"></i> <span>Statistique</span> <i class="fa fa-angle-left pull-right"></i> </a>
            <ul class="treeview-menu">
              <li class="<?php if ($page_name != '' && $page_name == 'reprepairdelivery') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>report/reprepairdelivery.php"><i class="fa fa-arrow-circle-right"></i> Rapport de réparation de voiture</a></li>
              <li class="<?php if ($page_name != '' && $page_name == 'rptcarbuy') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>report/rptcarbuy.php"><i class="fa fa-arrow-circle-right"></i> Rapport d'achat de voiture</a></li>
              <li class="<?php if ($page_name != '' && $page_name == 'rptcarsell') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>report/rptcarsell.php"><i class="fa fa-arrow-circle-right"></i>Rapport de vente de voitures</a></li>
              <li class="<?php if ($page_name != '' && $page_name == 'rptpartsbuy') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>report/rptpartsbuy.php"><i class="fa fa-arrow-circle-right"></i>Rapport d'achat de pièces</a></li>
              <li class="<?php if ($page_name != '' && $page_name == 'rptpartssell') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>report/rptpartssell.php"><i class="fa fa-arrow-circle-right"></i> Rapport de vente de piècest</a></li>
              <li class="<?php if ($page_name != '' && $page_name == 'rptmsalary') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>report/rptmsalary.php"><i class="fa fa-arrow-circle-right"></i> Salaire Mécaniciens</a></li>
            </ul>
          </li>
          <!-- <li class="treeview <?php if ($page_name != '' && $page_name == 'menulist' || $page_name == 'addmenu' || $page_name == 'servicelist' || $page_name == 'addservice' || $page_name == 'commentslist' || $page_name == 'addcomments' || $page_name == 'sliderlist' || $page_name == 'addslider' || $page_name == 'cmslist' || $page_name == 'addcms' || $page_name == 'teamview' || $page_name == 'gallerylist' || $page_name == 'addgallery' || $page_name == 'widgetlist' || $page_name == 'wprocess' || $page_name == 'author' || $page_name == 'category' || $page_name == 'bloglist' || $page_name == 'blog' || $page_name == 'faq' || $page_name == 'newscommentslist') {
                                      echo 'active';
                                    } ?>"> <a href="#"> <i class="fa fa-file-text-o"></i> <span>Catalogue</span> <i class="fa fa-angle-left pull-right"></i> </a>
            <ul class="treeview-menu">
              <li class="<?php if ($page_name != '' && $page_name == 'cmslist' || $page_name == 'addcms') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>cms/cmslist.php"><i class="fa fa-file-o"></i> CMS</a></li>
              <li class="<?php if ($page_name != '' && $page_name == 'menulist' || $page_name == 'addmenu') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>cms/menulist.php"><i class="fa fa-list"></i> Menu</a></li>
              <li class="<?php if ($page_name != '' && $page_name == 'faq') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>cms/faq.php"><i class="fa fa-question-circle-o"></i> FAQ</a></li>
              <li class="<?php if ($page_name != '' && $page_name == 'commentslist' || $page_name == 'addcomment') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>cms/commentslist.php"><i class="fa fa-comments-o"></i> Testimonials</a></li>
              <li class="<?php if ($page_name != '' && $page_name == 'author' || $page_name == 'category' || $page_name == 'newscommentslist' || $page_name == 'bloglist' || $page_name == 'blog') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>cms/menulist.php"><i class="fa fa-newspaper-o"></i> News<i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li class="<?php if ($page_name != '' && $page_name == 'author') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>cms/author.php"><i class="fa fa-arrow-circle-right"></i> Auteur</a></li>
                  <li class="<?php if ($page_name != '' && $page_name == 'category') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>cms/category.php"><i class="fa fa-arrow-circle-right"></i> Categories</a></li>
                  <li class="<?php if ($page_name != '' && $page_name == 'bloglist' || $page_name == 'blog') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>cms/bloglist.php"><i class="fa fa-arrow-circle-right"></i> News</a></li>
                  <li class="<?php if ($page_name != '' && $page_name == 'newscommentslist' || $page_name == 'blog') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>cms/newscommentslist.php"><i class="fa fa-commenting-o" aria-hidden="true"></i> Commentaires</a></li>
                </ul>
              </li>
              <li class="<?php
                          ?>"><a href="<?php
                                        ?>cms/widgetlist.php"><i class="fa fa-th-large"></i> Widgets</a></li>
              <li class="<?php if ($page_name != '' && $page_name == 'servicelist' || $page_name == 'wprocess' || $page_name == 'addservice' || $page_name == 'sliderlist' || $page_name == 'addslider' || $page_name == 'teamview' || $page_name == 'gallerylist' || $page_name == 'addgallery') {
                            echo 'active';
                          } ?>"><a href="#"><i class="fa fa-cubes"></i> Modules<i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li class="<?php if ($page_name != '' && $page_name == 'sliderlist' || $page_name == 'addslider') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>cms/sliderlist.php"><i class="fa fa-arrow-circle-right"></i> Slider</a></li>
                  <li class="<?php if ($page_name != '' && $page_name == 'servicelist' || $page_name == 'addservice') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>cms/servicelist.php"><i class="fa fa-arrow-circle-right"></i> Service</a></li>
                  <li class="<?php if ($page_name != '' && $page_name == 'teamview') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>cms/teamview.php"><i class="fa fa-arrow-circle-right"></i> Team Widget</a></li>
                  <li class="<?php if ($page_name != '' && $page_name == 'wprocess') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>cms/wprocess.php"><i class="fa fa-arrow-circle-right"></i>Widget de processus de travail</a></li>
                  <li class="<?php if ($page_name != '' && $page_name == 'gallerylist' || $page_name == 'addgallery') {
                                echo 'active';
                              } ?>"><a href="<?php echo WEB_URL; ?>cms/gallerylist.php"><i class="fa fa-arrow-circle-right"></i> Galerie Widget</a></li>
                </ul>
              </li>
            </ul>
          </li> -->
          <li class="treeview <?php if ($page_name != '' && $page_name == 'setting' || $page_name == 'carcolor' || $page_name == 'parts_manufacturer' || $page_name == 'carsetting') {
                                echo 'active';
                              } ?>"> <a href="#"> <i class="fa fa-gear"></i> <span>Paramétrage</span> <i class="fa fa-angle-left pull-right"></i> </a>
            <ul class="treeview-menu">
              <li class="<?php if ($page_name != '' && $page_name == 'carsetting') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>setting/carsetting.php"><i class="fa fa-arrow-circle-right"></i>Réglage voiture</a></li>
              <li class="<?php if ($page_name != '' && $page_name == 'carsetting') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>setting/car_assurance_setting.php"><i class="fa fa-arrow-circle-right"></i>Réglage assurances</a></li>
              <li class="<?php if ($page_name != '' && $page_name == 'assurancesetting') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>setting/prestationsetting.php"><i class="fa fa-arrow-circle-right"></i>Réglage prestations de services</a></li>
              <li class="<?php if ($page_name != '' && $page_name == 'parts_manufacturer') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>parts_manufacturer/parts_manufacturer.php"><i class="fa fa-arrow-circle-right"></i>Fabricant de pièces</a></li>
              <li class="<?php if ($page_name != '' && $page_name == 'carcolor') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>carcolor/carcolor.php"><i class="fa fa-arrow-circle-right"></i>Couleur de voiture et porte</a></li>
              <li class="<?php if ($page_name != '' && $page_name == 'setting') {
                            echo 'active';
                          } ?>"><a href="<?php echo WEB_URL; ?>setting/setting.php"><i class="fa fa-arrow-circle-right"></i>Installation du système</a></li>
            </ul>
          </li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
    <!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">