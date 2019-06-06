<?php include('header.php'); ?>
<?php
//security
if ($_SESSION['login_type'] != 'admin') {
  header("Location: " . WEB_URL . "logout.php");
  die();
}
?>
<?php
//dashboard widget data
$customer = $wms->getAllCustomerList($link);
$parts_stock = $wms->partsStockTotalQty($link);
$car_stock = $wms->getAllActiveCarList($link);
$mechanic = $wms->getAllMechanicsList($link);
$settings = $wms->getWebsiteSettingsInformation($link);

//get all car info by current year
$total_car_year_sold = 0;
$sold_car = $wms->getSellCarMonthlyData($link, date('Y'));
//var_dump($sold_car);exit;
$car_sell_report = '';
if (!empty($sold_car)) {
  foreach ($sold_car as $scar) {
    $ccode = $wms->getChartColorCodeByMonth($scar['month_name']);
    $car_sell_report[] = array(
      'value'      => $scar['total_sell'],
      'color'      => $ccode,
      'highlight'    => $ccode,
      'label'      => ' Car Sold' . ' ' . $scar['month_name']
    );
    $total_car_year_sold += (int)$scar['total_sell'];
  }
  if (!empty($car_sell_report)) {
    $car_sell_report = json_encode($car_sell_report, JSON_NUMERIC_CHECK);
  }
}

//get all parts info by current year
$sold_parts = $wms->getSellPartsMonthlyData($link, date('Y'));

$total_parts_year_sold = 0;
$parts_sell_report = '';
if (!empty($sold_parts)) {
  foreach ($sold_parts as $sparts) {
    $ccode = $wms->getChartColorCodeByMonth($sparts['month_name']);
    $parts_sell_report[] = array(
      'value'      => $sparts['total_parts'],
      'color'      => $ccode,
      'highlight'    => $ccode,
      'label'      => ' Parts Sold' . ' ' . $sparts['month_name']
    );
    $total_parts_year_sold += (int)$sparts['total_parts'];
  }
  if (!empty($parts_sell_report)) {
    $parts_sell_report = json_encode($parts_sell_report, JSON_NUMERIC_CHECK);
  }
}

//get car repair chart data
$months = array(
  'January',
  'February',
  'March',
  'April',
  'May',
  'June',
  'July ',
  'August',
  'September',
  'October',
  'November',
  'December',
);

$total_car_repair_year = 0;
$car_repair_data_default = [0];
$car_repair = $wms->getCarRepairChartData($link, date('Y'));

if (!empty($car_repair)) {
  $car_repair_data = '';
  foreach ($months as $month) {
    $car_repair_data .= arrayValueExist($car_repair, $month) . ',';
  }
  $car_repair_data = trim($car_repair_data, ',');
  $car_repair_data_default = $car_repair_data;
  foreach ($car_repair as $arr) {
    $total_car_repair_year += (int)$arr['total_repair'];
  }
}

function arrayValueExist($array, $value)
{
  foreach ($array as $arr) {
    if ($arr['month_name'] == $value) {
      return $arr['total_repair'];
      break;
    }
  }
  return 0;
}

$msg = '';
$addinfo = 'none';
if (isset($_GET['m']) && $_GET['m'] == 'msg_envoye') {
  $addinfo = 'block';
  $msg = "Ajout du véhicule réussi";
}

?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
    <h4><i class="icon fa fa-check"></i> Success!</h4>
    <?php echo $msg; ?>
  </div>
  <h1 style="text-transform:uppercase;font-weight:bold;color:#00a65a;"> <?php echo $settings['site_name'] . ' Dashboard'; ?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL; ?>dashboard.php"><i class="fa fa-dashboard"></i> Accueil</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- /.row start -->
  <div class="row home_dash_box">
    <!-- col start -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?php echo $parts_stock; ?></h3>
          <p>PIÈCES EN STOCK</p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/car_parts.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>parts_stock/partsstocklist.php" class="small-box-footer">Plus d'infos <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col end -->
    <!-- col start -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-orange">
        <div class="inner">
          <h3><?php echo count($customer); ?></h3>
          <p><?php echo count($customer) > 1 ? 'CLIENTS' : 'CLIENT'; ?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/customer.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>customer/customerlist.php" class="small-box-footer">Plus d'infos <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col end -->
    <!-- col start -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?php echo count($car_stock); ?></h3>
          <p><?php echo count($car_stock) > 1 ? 'VOITURES EN STOCK' : 'VOITURE EN STOCK'; ?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/car.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>carstock/buycarlist.php" class="small-box-footer">Plus d'infos <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col end -->
    <!-- col start -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?php echo count($mechanic); ?></h3>
          <p><?php echo count($mechanic) > 1 ? 'MECANICIENS' : 'MECANICIEN'; ?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/mechanic.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>mechanics/mechanicslist.php" class="small-box-footer">Plus d'infos <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col end -->
  </div>
  <!-- /.row end -->
  <div class="box box-success">
    <div class="box-header">
      <h3 class="box-title"><i class="fa fa-list"></i> Liste de rappel des vehicules bientôt en échéance technique et assurances</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table class="table sakotable table-bordered table-striped dt-responsive">
        <thead>
          <tr>
            <th>Immatriculation</th>
            <th>Image</th>
            <th>Nom du client</th>
            <th>Echéance de la visite technique</th>
            <th>Status visite technique</th>
            <th>Echéance de l'assurance</th>
            <th>Status assurance</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $wms->getAllRepairCarList($link);

          // var_dump($result);

          // die();

          foreach ($result as $row) {

            // Envoi automatique d'alerte
            // VISITE TECHNIQUE
            if (isset($row['add_date_visitetech'])) {

              $dateprochvistech = DateTime::createFromFormat('d/m/Y', $row['add_date_visitetech']);

              if ($dateprochvistech instanceof DateTime) {

                // Définition du statut de la visite technique
                $diffTodayDateprochvistech = $dateprochvistech->diff(new \DateTime())->format('%R%a');
                $diffTodayDateprochvistechStr = $dateprochvistech->diff(new \DateTime())->format(' %a jours');
                $diffTodayDateprochvistechStr_2 = $dateprochvistech->diff(new \DateTime())->format('%a');

                // Conversion en entier
                $diffTodayDateprochvistech = (int)$diffTodayDateprochvistech;

                if (($diffTodayDateprochvistech == -14) || ($diffTodayDateprochvistech == -3)) {

                  $remainingDays = $diffTodayDateprochvistechStr_2;
                  $marque = $row['make_name'];
                  $modele = $row['model_name'];
                  $imma = $row['VIN'];
                  $nom_client = $row['c_name'];
                  $mobile_customer = $row['princ_tel'];

                  // Message de confirmation du devis
                  $content_msg = 'Cher client ' . $nom_client . ', nous vous informons que la date de la visite technique de votre voiture ' . $marque . ' ' . $modele . ' ' . $imma . ' expire dans ' . $remainingDays . ' jours ! Pensez donc a la repasser merci !';

                  // importation du fichier
                  require_once(ROOT_PATH . '/SmsApi.php');

                  // instanciation de la classe
                  $smsApi = new SmsApi();

                  // Exécution de la méthode d'envoi 
                  $resultSmsSent = $smsApi->isSmsapi($mobile_customer, $content_msg);

                  if ($resultSmsSent) {
                    echo "<p><span class='label label-success'>SMS automatique de rappel envoyé avec succès !</p><span>";
                    // $url = WEB_URL.'dashboard.php';
                    // header("Location: $url");
                  }
                } elseif ($diffTodayDateprochvistech == 0) {

                  $marque = $row['make_name'];
                  $modele = $row['model_name'];
                  $imma = $row['VIN'];
                  $nom_client = $row['c_name'];
                  $mobile_customer = $row['princ_tel'];

                  // Message de confirmation du devis
                  $content_msg = 'Cher  client  ' . $nom_client . ', nous vous informons que la date de la visite technique de votre voiture' . $marque . ' ' . $modele . ' ' . $imma . ' est depassee ! Pensez donc a la repasser !';

                  // importation du fichier
                  require_once(ROOT_PATH . '/SmsApi.php');

                  // instanciation de la classe
                  $smsApi = new SmsApi();

                  // Exécution de la méthode d'envoi 
                  $resultSmsSent = $smsApi->isSmsapi($mobile_customer, $content_msg);

                  if ($resultSmsSent) {
                    echo "<p><span class='label label-success'>SMS automatique de rappel envoyé avec succès !</p><span>";
                    // $url = WEB_URL.'dashboard.php';
                    // header("Location: $url");
                  }
                }
              }
            }

            // ASSURANCE
            if (isset($row['add_date_assurance']) && isset($row['add_date_assurance_fin'])) {
              $dateFinAssur = DateTime::createFromFormat('d/m/Y', $row['add_date_assurance_fin']);

              if ($dateFinAssur instanceof DateTime) {

                $diffDateDebutFinAssur = $dateFinAssur->diff(new \DateTime())->format('%R%a');
                $diffDateDebutFinAssurStr = $dateFinAssur->diff(new \DateTime())->format(' %a jours');
                $diffDateDebutFinAssurStr_2 = $dateFinAssur->diff(new \DateTime())->format('%a');

                // conversion en entier
                $diffDateDebutFinAssur = (int)$diffDateDebutFinAssur;

                if (($diffDateDebutFinAssur == -14) || ($diffDateDebutFinAssur == -3)) {

                  $remainingDays = $diffDateDebutFinAssurStr_2;
                  $marque = $row['make_name'];
                  $modele = $row['model_name'];
                  $imma = $row['VIN'];
                  $nom_client = $row['c_name'];
                  $mobile_customer = $row['princ_tel'];

                  // Message de confirmation du devis
                  $content_msg = 'Cher client ' . $nom_client . ', nous vous informons que l\'assurance de votre voiture ' . $marque . ' ' . $modele . ' ' . $imma . ' expire dans ' . $remainingDays . ' jours ! Pensez donc a la renouveler merci !';

                  // importation du fichier
                  require_once(ROOT_PATH . '/SmsApi.php');

                  // instanciation de la classe
                  $smsApi = new SmsApi();

                  // Exécution de la méthode d'envoi 
                  $resultSmsSent = $smsApi->isSmsapi($mobile_customer, $content_msg);

                  if ($resultSmsSent) {
                    echo "<p><span class='label label-success'>SMS automatique de rappel envoyé avec succès !</p><span>";
                    // $url = WEB_URL.'dashboard.php';
                    // header("Location: $url");
                  }
                } elseif ($diffDateDebutFinAssur == 0) {

                  $marque = $row['make_name'];
                  $modele = $row['model_name'];
                  $imma = $row['VIN'];
                  $nom_client = $row['c_name'];
                  $mobile_customer = $row['princ_tel'];

                  // Message de confirmation du devis
                  $content_msg = 'Cher client ' . $nom_client . ' nous vous informons que l\'assurance de votre voiture ' . $marque . ' ' . $modele . ' ' . $imma . ' a expire ! Pensez donc a la renouveler merci !';

                  // importation du fichier
                  require_once(ROOT_PATH . '/SmsApi.php');

                  // instanciation de la classe
                  $smsApi = new SmsApi();

                  // Exécution de la méthode d'envoi 
                  $resultSmsSent = $smsApi->isSmsapi($mobile_customer, $content_msg);

                  if ($resultSmsSent) {
                    echo "<p><span class='label label-success'>SMS automatique de rappel envoyé avec succès !</p><span>";
                    // $url = WEB_URL.'dashboard.php';
                    // header("Location: $url");
                  }
                }
              }
            }

            $image = WEB_URL . 'img/no_image.jpg';
            $image_customer = WEB_URL . 'img/no_image.jpg';

            if (file_exists(ROOT_PATH . '/img/upload/' . $row['car_image']) && $row['car_image'] != '') {
              $image = WEB_URL . 'img/upload/' . $row['car_image']; //car image
            }
            if (file_exists(ROOT_PATH . '/img/upload/' . $row['customer_image']) && $row['customer_image'] != '') {
              $image_customer = WEB_URL . 'img/upload/' . $row['customer_image']; //customer iamge
            }

            ?>
            <tr>
              <td><span><?php echo $row['VIN']; ?></span></td>
              <td><img class="photo_img_round" style="width:50px;height:50px;" src="<?php echo $image;  ?>" /></td>
              <td><?php echo $row['c_name']; ?></td>
              <td><?php echo $row['add_date_visitetech'] ?></td>
              <td>
                <?php

                // Traitement de la visiste technique
                if (isset($row['add_date_visitetech'])) { // Si la date de la visite technique existe

                  // On crée un objet Datetime à partir du format chaine de caractère de la date de la visite technique
                  $dateprochvistech = DateTime::createFromFormat('d/m/Y', $row['add_date_visitetech']);

                  if ($dateprochvistech instanceof DateTime) {

                    // Définition du statut de la visite technique
                    $diffTodayDateprochvistech = $dateprochvistech->diff(new \DateTime())->format('%R%a');

                    $diffTodayDateprochvistechStr = $dateprochvistech->diff(new \DateTime())->format(' %a jours');

                    // conversion en entier
                    $diffTodayDateprochvistech = (int)$diffTodayDateprochvistech;

                    if (($diffTodayDateprochvistech >= -14) && ($diffTodayDateprochvistech < 0)) {
                      echo "<span class='label label-warning'>Expire dans " . $diffTodayDateprochvistechStr . "</span>";
                    } elseif ($diffTodayDateprochvistech >= 0) {
                      echo "<span class='label label-danger'>Expiré</span>";
                    } else {
                      echo "<span class='label label-success'>Valide</span>";
                    }
                  }
                } ?>

              </td>
              <td><?php echo $row['add_date_assurance_fin'] ?></td>
              <td><?php

                  // Traitement de l'assurance
                  if (isset($row['add_date_assurance']) && isset($row['add_date_assurance_fin'])) {
                    $dateFinAssur = DateTime::createFromFormat('d/m/Y', $row['add_date_assurance_fin']);

                    if ($dateFinAssur instanceof DateTime) {

                      $diffDateDebutFinAssur = $dateFinAssur->diff(new \DateTime())->format('%R%a');
                      $diffDateDebutFinAssurStr = $dateFinAssur->diff(new \DateTime())->format(' %a jours');

                      // conversion en entier
                      $diffDateDebutFinAssur = (int)$diffDateDebutFinAssur;

                      if (($diffDateDebutFinAssur >= -14) && ($diffDateDebutFinAssur < 0)) {
                        echo "<span class='label label-warning'>Expire dans " . $diffDateDebutFinAssurStr . "</span>";
                      } elseif ($diffDateDebutFinAssur >= 0) {
                        echo "<span class='label label-danger'>Expiré</span>";
                      } else {
                        echo "<span class='label label-success'>Valide</span>";
                      }
                    }
                  } ?></td>
              <td>
                <?php

                // VISITE TECHNIQUE
                if (isset($row['add_date_visitetech'])) { // Si la date de la visite technique existe

                  // On crée un objet Datetime à partir du format chaine de caractère de la date de la visite technique
                  $dateprochvistech = DateTime::createFromFormat('d/m/Y', $row['add_date_visitetech']);

                  if ($dateprochvistech instanceof DateTime) {

                    // Définition du statut de la visite technique
                    $diffTodayDateprochvistech = $dateprochvistech->diff(new \DateTime())->format('%R%a');
                    $diffTodayDateprochvistechStr = $dateprochvistech->diff(new \DateTime())->format(' %a jours');
                    $diffTodayDateprochvistechStr_2 = $dateprochvistech->diff(new \DateTime())->format('%a');

                    // conversion en entier
                    $diffTodayDateprochvistech = (int)$diffTodayDateprochvistech;

                    if (($diffTodayDateprochvistech >= -14) && ($diffTodayDateprochvistech < 0)) { ?>
                      <a class="btn btn-primary" style="background-color:#FFD700;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>sendRappelAvExpVistechSms.php?remainingDays=<?php echo $diffTodayDateprochvistechStr_2 ?>&mobile_customer=<?php echo $row['princ_tel']; ?>&marque=<?php echo $row['make_name']; ?>&modele=<?php echo $row['model_name']; ?>&imma=<?php echo $row['VIN']; ?>&nom_client=<?php echo $row['c_name']; ?>" data-original-title="Envoyer un rappel au client par SMS concernant le statut de la visite technique du véhicule"><i class="fa fa-bell"></i>
                      <?php } elseif ($diffTodayDateprochvistech >= 0) { ?>
                        <a class="btn btn-primary" style="background-color:#FF4500;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>sendRappelExpVistechSms.php?mobile_customer=<?php echo $row['princ_tel']; ?>&marque=<?php echo $row['make_name']; ?>&modele=<?php echo $row['model_name']; ?>&imma=<?php echo $row['VIN']; ?>&nom_client=<?php echo $row['c_name']; ?>" data-original-title="Envoyer un rappel au client par SMS concernant le statut de la visite technique du véhicule"><i class="fa fa-bell"></i>
                        <?php }
                    }
                  }

                  // ASSURANCE
                  if (isset($row['add_date_assurance']) && isset($row['add_date_assurance_fin'])) {
                    $dateFinAssur = DateTime::createFromFormat('d/m/Y', $row['add_date_assurance_fin']);

                    if ($dateFinAssur instanceof DateTime) {

                      $diffDateDebutFinAssur = $dateFinAssur->diff(new \DateTime())->format('%R%a');
                      $diffDateDebutFinAssurStr = $dateFinAssur->diff(new \DateTime())->format(' %a jours');
                      $diffDateDebutFinAssurStr_2 = $dateFinAssur->diff(new \DateTime())->format('%a');

                      // conversion en entier
                      $diffDateDebutFinAssur = (int)$diffDateDebutFinAssur;

                      if (($diffDateDebutFinAssur >= -14) && ($diffDateDebutFinAssur < 0)) { ?>
                          <a class="btn btn-primary" style="background-color:#FFD700;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>sendRappelAvExpAssurSms.php?remainingDays=<?php echo $diffDateDebutFinAssurStr_2; ?>&mobile_customer=<?php echo $row['princ_tel']; ?>&marque=<?php echo $row['make_name']; ?>&modele=<?php echo $row['model_name']; ?>&imma=<?php echo $row['VIN']; ?>&nom_client=<?php echo $row['c_name']; ?>" data-original-title="Envoyer un rappel au client par SMS concernant le statut de l'assurance du véhicule"><i class="fa fa-bell"></i>
                          <?php } elseif ($diffDateDebutFinAssur >= 0) { ?>
                            <a class="btn btn-primary" style="background-color:#FF4500;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>sendRappelExpAssurSms.php?mobile_customer=<?php echo $row['princ_tel']; ?>&marque=<?php echo $row['make_name']; ?>&modele=<?php echo $row['model_name']; ?>&imma=<?php echo $row['VIN']; ?>&nom_client=<?php echo $row['c_name']; ?>" data-original-title="Envoyer un rappel au client par SMS concernant le statut de l'assurance du véhicule"><i class="fa fa-bell"></i>
                            <?php }
                        }
                      }
                      ?>
              </td>
            </tr>
          <?php }
        mysql_close($link); ?>
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->
  </div>

</section>
<!-- /.content -->
<script type="text/javascript">
  // Get context with jQuery - using jQuery's .get() method.
  var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
  // This will get the first returned node in the jQuery collection.
  var salesChart = new Chart(salesChartCanvas);

  var salesChartData = {
    //labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'],
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    datasets: [{
      label: 'Car Repair',
      fillColor: 'rgba(0, 166, 90, 1)',
      strokeColor: 'rgba(0, 166, 90, 1)',
      pointColor: '#00a65a',
      pointStrokeColor: 'rgba(0, 166, 90, 1)',
      pointHighlightFill: '#fff',
      pointHighlightStroke: 'rgba(0, 166, 90, 1)',
      data: [<?php echo $car_repair_data_default; ?>]
    }]
  };

  var salesChartOptions = {
    // Boolean - If we should show the scale at all
    showScale: true,
    // Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines: true,
    // String - Colour of the grid lines
    scaleGridLineColor: 'rgba(0,0,0,.05)',
    // Number - Width of the grid lines
    scaleGridLineWidth: 1,
    // Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    // Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines: true,
    // Boolean - Whether the line is curved between points
    bezierCurve: true,
    // Number - Tension of the bezier curve between points
    bezierCurveTension: 0.3,
    // Boolean - Whether to show a dot for each point
    pointDot: true,
    // Number - Radius of each point dot in pixels
    pointDotRadius: 4,
    // Number - Pixel width of point dot stroke
    pointDotStrokeWidth: 1,
    // Number - amount extra to add to the radius to cater for hit detection outside the drawn point
    pointHitDetectionRadius: 20,
    // Boolean - Whether to show a stroke for datasets
    datasetStroke: true,
    // Number - Pixel width of dataset stroke
    datasetStrokeWidth: 2,
    // Boolean - Whether to fill the dataset with a color
    datasetFill: true,
    // String - A legend template
    legendTemplate: '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio     : true,
    // Boolean - whether to make the chart responsive to window resizing
    responsive              : true
  };

  // Create the line chart
  salesChart.Line(salesChartData, salesChartOptions);

  // ---------------------------
  // - END MONTHLY SALES CHART -
  // ---------------------------
  
  
  // -------------
  // - PIE CHART -
//By E-MITIC
  // -------------
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
  var pieChart       = new Chart(pieChartCanvas);
  var PieData        = <?php $parts_sell_report; ?>;
  var pieOptions     = {
    // Boolean - Whether we should show a stroke on each segment
    segmentShowStroke    : true,
    // String - The colour of each segment stroke
    segmentStrokeColor   : '#fff',
    // Number - The width of each segment stroke
    segmentStrokeWidth   : 1,
    // Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    // Number - Amount of animation steps
    animationSteps       : 100,
    // String - Animation easing effect
    animationEasing      : 'easeOutBounce',
    // Boolean - Whether we animate the rotation of the Doughnut
    animateRotate        : true,
    // Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale         : false,
    // Boolean - whether to make the chart responsive to window resizing
    responsive           : true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    //maintainAspectRatio  : false,
    // String - A legend template
    //legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
    // String - A tooltip template
    tooltipTemplate: '<%=value %> <%=label%>'
  };
  // Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  pieChart.Doughnut(PieData, pieOptions);
  // -----------------
  // - END PIE CHART -
  // -----------------


  // -------------
  // - PIE CHART -
  // -------------
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas2 = $('#pieChart2').get(0).getContext('2d');
  var pieChart2 = new Chart(pieChartCanvas2);
  var PieData2 = <?php echo $car_sell_report; ?>;

  var pieOptions2 = {
    // Boolean - Whether we should show a stroke on each segment
    segmentShowStroke: true,
    // String - The colour of each segment stroke
    segmentStrokeColor: '#fff',
    // Number - The width of each segment stroke
    segmentStrokeWidth: 1,
    // Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    // Number - Amount of animation steps
    animationSteps: 100,
    // String - Animation easing effect
    animationEasing: 'easeOutBounce',
    // Boolean - Whether we animate the rotation of the Doughnut
    animateRotate: true,
    // Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale: false,
    // Boolean - whether to make the chart responsive to window resizing
    responsive: true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    //maintainAspectRatio  : false,
    // String - A legend template
    //legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
    // String - A tooltip template
    tooltipTemplate: '<%=value %> <%=label%>'
  };
  // Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  pieChart2.Doughnut(PieData2, pieOptions2);
  // -----------------
  // - END PIE CHART -
  // -----------------
  $(document).ready(function() {
    setTimeout(function() {
      $("#me").hide(300);
      $("#you").hide(300);
    }, 3000);
  });
</script>
<?php include('footer.php'); ?>