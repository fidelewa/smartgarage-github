<?php include('../header.php'); ?>
<?php
//dashboard widget data
$total_paid = 0;
$total_due = 0;

$settings = $wms->getWebsiteSettingsInformation($link);
$total_car = $wms->getCustomerRepairCarList($link, $_SESSION['objRecep']['user_id']);
$car_repair = $wms->getAllRepairCarEstimateList($link, $_SESSION['objRecep']['user_id']);
if (!empty($car_repair)) {
  foreach ($car_repair as $xcr) {
    $total_paid += (float) $xcr['payment_done'];
    $total_due += (float) $xcr['payment_due'];
  }
}

$addinfo = 'none';
$failedinfo = 'none';
$msg = "";
$addinfo_2 = 'none';
$msg_2 = "";
$addinfo_3 = 'none';
$msg_3 = "";

if (isset($_GET['sms']) && $_GET['sms'] == 'send_client_sms_succes') {
  $addinfo = 'block';
  $msg = "SMS envoyé au client avec succès";
}

if (isset($_GET['sms']) && $_GET['sms'] == 'send_client_sms_failed') {
  $failedinfo = 'block';
  $msg = "L'envoi du SMS au client à échoué";
}

if (isset($_GET['m']) && $_GET['m'] == 'add') {
  $addinfo_2 = 'block';
  $msg_2 = "La voiture a été ajoutée à la liste des véhicules réceptionnés";
}

if (isset($_GET['m']) && $_GET['m'] == 'up') {
  $addinfo_3 = 'block';
  $msg_3 = "La voiture receptionnée a été modifiée";
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

$total_salary = 0;
$salary_default_data = '0,0,0,0,0,0';
$s_data = $wms->getCustomerRepairReportChartData($link, date('Y'), $_SESSION['objRecep']['user_id']);

if (!empty($s_data)) {
  $salary_report_data = '';
  foreach ($months as $month) {
    $salary_report_data .= arrayValueExist($s_data, $month) . ',';
  }
  $salary_report_data = trim($salary_report_data, ',');
  $salary_default_data = $salary_report_data;
  foreach ($s_data as $arr) {
    $total_salary += (int) $arr['paid_amount'];
  }
}

function arrayValueExist($array, $value)
{
  foreach ($array as $arr) {
    if (trim($arr['month_name']) == trim($value)) {
      return $arr['paid_amount'];
      break;
    }
  }
  return 0;
}

?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1 style="text-transform:uppercase;font-weight:bold;color:#00a65a;"> <?php echo $settings['site_name'] . ' Dashboard'; ?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL; ?>dashboard.php"><i class="fa fa-dashboard"></i> Accueil</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- /.row start -->
  <!-- <div class="row home_dash_box mech_dashboard"> -->
  <!-- col start -->
  <!-- <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?php echo count($total_car); ?></h3>
          <p><?php if (count($total_car) > 1) {
                echo 'CARS ';
              } else {
                'HOUR ';
              }; ?>CAR</p>
        </div>
        <div class="icon"> <img height="80" width="80" src="<?php echo WEB_URL; ?>img/car.png"></a> </div>
        <br/></div>
    </div> -->
  <!-- ./col end -->
  <!-- col start -->
  <!-- <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?php echo count($car_repair); ?></h3>
          <p>RÉPARATION TOTALE</p>
        </div>
        <div class="icon"> <img height="80" width="80" src="<?php echo WEB_URL; ?>img/car_parts.png"></a> </div>
        <br/></div>
    </div> -->
  <!-- ./col end -->
  <!-- col start -->
  <!-- <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-orange">
        <div class="inner">
           <h3><?php echo $currency . $total_paid; ?></h3>
          <p>TOTAL PAYÉ</p>
        </div>
        <div class="icon"> <img height="80" width="80" src="<?php echo WEB_URL; ?>img/salary.png"></a> </div>
        <br/></div>
    </div> -->
  <!-- ./col end -->
  <!-- col start -->
  <!-- <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?php echo $currency . $total_due; ?></h3>
          <p>TOTAL DÛ</p>
        </div>
        <div class="icon"> <img height="80" width="80" src="<?php echo WEB_URL; ?>img/money.png"></a> </div>
        <br/></div>
    </div> -->
  <!-- ./col end -->
  <!-- </div> -->
  <!-- /.row end -->
  <!-- <div class="row">
    <div class="col-md-12">
      <div class="box box-success"> -->
  <!-- <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-money"></i> Rapport de réparation mensuel (<?php echo $currency; ?>)</h3>
        </div> -->
  <!-- /.box-header -->
  <!-- <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <p class="text-center"> <strong>Rapport de réparation: 1 Jan, <?php echo date('Y'); ?> - 31 Decembre, <?php echo date('Y'); ?></strong> </p>
              <div class="chart">
                <canvas id="salesChart" style="height: 180px;"></canvas>
              </div>
            </div>
          </div>
        </div> -->
  <!-- <div class="box-footer no-padding">
          <ul class="nav nav-pills nav-stacked">
            <li><a><b>Coût total de réparation <?php echo date('Y'); ?></b><span class="pull-right label label-success" style="font-size:12px;"><b><?php echo $currency . number_format($total_salary, 2); ?></b></span></a></li>
          </ul>
        </div> -->
  <!-- </div>
    </div>
  </div> -->
  <div class="row">
    <div class="col-xs-12">
      <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i>
        </button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        <?php echo $msg; ?>
      </div>
      <div id="his" class="alert alert-danger alert-dismissable" style="display:<?php echo $failedinfo; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
        <!-- <h4><i class="icon fa fa-ban"></i></h4> -->
        <?php echo $msg; ?>
      </div>
      <div id="us" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo_2; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i>
        </button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        <?php echo $msg_2; ?>
      </div>
      <div id="her" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo_3; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i>
        </button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        <?php echo $msg_3; ?>
      </div>
      <div align="right" style="margin-bottom:1%;">
        <!-- <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/repaircar_reception.php" data-original-title="Créer un nouveau formulaire de réception de véhicule"><i class="fa fa-plus"></i></a> -->
        <!-- <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>recep_panel/recep_dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a> -->
      </div>
      <div class="box box-success">
        <div class="box-header">
          <!-- <h3 class="box-title"><i class="fa fa-list"></i> Voiture de réparation List</h3> -->
          <h3 class="box-title"><i class="fa fa-list"></i> Liste des véhicules réceptionnés par <?php echo '<b>' . $_SESSION['objRecep']['name'] . '</b>'; ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table sakotable table-bordered table-striped dt-responsive">
            <thead>
              <tr>
                <th>ID Reception</th>
                <th>Immatriculation</th>
                <th>Client</th>
                <th>Date reception</th>
                <th>Date exp. assur</th>
                <th>Date exp. vis. tech.</th>
                <!-- <th>Attribué à</th> -->
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php

              $result = $wms->getAllRecepRepairCarListByRecepId($link, $_SESSION['objRecep']['user_id']);

              // var_dump($result);

              // die();

              foreach ($result as $row) {
                // $image = WEB_URL . 'img/no_image.jpg';
                // $image_customer = WEB_URL . 'img/no_image.jpg';

                // if (file_exists(ROOT_PATH . '/img/upload/' . $row['image_vehi']) && $row['image_vehi'] != '') {
                //     $image = WEB_URL . 'img/upload/' . $row['image_vehi']; //car image
                // }
                // if (file_exists(ROOT_PATH . '/img/upload/' . $row['customer_image']) && $row['customer_image'] != '') {
                //     $image_customer = WEB_URL . 'img/upload/' . $row['customer_image']; //customer iamge
                // }

                ?>
              <tr>
                <td><span class="label label-success"><?php echo $row['car_id']; ?></span></td>
                <td><?php echo $row['num_matricule']; ?></td>
                <td><?php echo $row['c_name']; ?></td>
                <td><?php echo $row['add_date_recep_vehi']; ?></td>
                <td><?php echo $row['add_date_assurance']; ?></td>
                <td><?php echo $row['add_date_visitetech']; ?></td>
                <!-- <td><?php echo $row['m_name']; ?></td> -->
                <td>

                  <!-- <a class="btn btn-info" style="background-color:purple;color:#ffffff;" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/repaircar_diagnostic.php?add_car_id=<?php echo $row['add_car_id']; ?>&car_id=<?php echo $row['car_id']; ?>" data-original-title="Créer le formulaire de diagnostic du véhicule"><i class="fa fa-plus"></i></a> -->
                  <!-- <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc.php?car_id=<?php echo $row['car_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Fiche de reception du véhicule"><i class="fa fa-file-text-o"></i></a> -->
                  <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc_gene.php?car_id=<?php echo $row['car_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Fiche de reception du véhicule"><i class="fa fa-file-text-o"></i></a>
                </td>
              </tr>
              <?php }
              ?>
            </tbody>
          </table>
          <div class="box-footer clearfix"><a href="<?php echo WEB_URL; ?>recep_panel/recep_repaircar_reception_list.php" class="btn btn-sm btn-success btn-flat pull-right"><b><i class="fa fa-list"></i> &nbsp;Voir toute la liste</b></a> </div>
        </div>
        <!-- /.box-body -->
      </div>

      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-list"></i> Liste des véhicules à réceptionner</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table sakotable table-bordered table-striped dt-responsive">
            <thead>
              <tr>
                <th>ID</th>
                <th>Immatriculation</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Scanner mécanique</th>
                <th>Scanner électrique</th>
                <!-- <th>Frais de scanner</th> -->
                <th>Statut scanner</th>
                <th>Statut reception</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $results = $wms->getCarScanningTen($link);
              foreach ($results as $row) {
                // $image = WEB_URL . 'img/no_image.jpg';
                // if(file_exists(ROOT_PATH . '/img/upload/' . $row['usr_image']) && $row['usr_image'] != ''){
                // 	$image = WEB_URL . 'img/upload/' . $row['usr_image'];
                // }
                ?>
              <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['imma_vehi_client']; ?></td>
                <td><?php echo $row['marque_vehi_client']; ?></td>
                <td><?php echo $row['model_vehi_client']; ?></td>
                <td><?php echo $row['scanner_mecanique']; ?></td>
                <td><?php echo $row['scanner_electrique']; ?></td>
                <!-- <td><?php echo $row['frais_scanner']; ?></td> -->
                <td><?php
                      if ($row['statut_scannage'] == null) {
                        echo "<span class='label label-default'>En attente de scan</span> <br/>";
                      } else if ($row['statut_scannage'] == 1) {
                        echo "<span class='label label-success'>Scan effectué</span> <br/>";
                      }
                      ?></td>
                <td><?php
                      if ($row['statut_reception'] == null) {
                        echo "<span class='label label-default'>En attente de reception</span> <br/>";
                      } else if ($row['statut_reception'] == 1) {
                        echo "<span class='label label-success'>Reception effectuée</span> <br/>";
                      }
                      ?></td>
                <td>
                  <?php if ($row['statut_reception'] == null) { ?>
                  <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/addcar_reception.php?immat=<?php echo $row['imma_vehi_client']; ?>&vehicule_scanner_id=<?php echo $row['id']; ?>" data-original-title="Receptionner ce véhicule"><i class="fa fa-user"></i></a>
                  <?php } else {
                      ?>
                  <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/repaircar_reception.php?immat=<?php echo $row['imma_vehi_client']; ?>" data-original-title="Receptionner ce véhicule"><i class="fa fa-user"></i></a>
                  <?php }
                    ?>

                  <!-- <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="#" data-original-title="Afficher le reçu de paiement du scanner"><i class="fa fa-file-text-o"></i></a> -->
                </td>
              </tr>
              <?php }
              ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>

      <div class="box box-success">
        <div class="box-header with-border">

          <h3 class="box-title"><i class="fa fa-list"></i> Liste des derniers véhicules en réparation</h3>
        </div>

        <div class="box-body">
          <div class="table-responsive">
            <table class="table no-margin">
              <thead>
                <tr>
                  <th>ID Réception</th>
                  <th>Immatriculation</th>
                  <?php
                  if ($_SESSION['login_type'] != "mechanics") { ?>
                  <th>Client</th>
                  <?php } ?>
                  <th>Date reception</th>
                  <th>Date exp. assur</th>
                  <th>Date exp. vis. tech.</th>
                  <th>Statut réparation</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>

                  <?php

                  $result = $wms->getRecepCarListRepar($link);

                  foreach ($result as $row) { ?>

                  <td><span class="label label-success"><?php echo $row['car_id']; ?></span></td>
                  <td><?php echo $row['num_matricule']; ?></td>
                  <td><?php echo $row['c_name']; ?></td>
                  <td><?php echo $row['add_date_recep_vehi']; ?></td>
                  <td><?php echo $row['add_date_assurance']; ?></td>
                  <td><?php echo $row['add_date_visitetech']; ?></td>
                  <td><?php
                        if ($row['statut_reparation'] == null) {
                          echo "<span class='label label-default'>En attente de réparation</span> <br/>";
                        } else if ($row['statut_reparation'] == 0) {
                          echo "<span class='label label-warning'>En cours de reparation</span> <br/>";
                        } else if ($row['statut_reparation'] == 1) {
                          echo "<span class='label label-success'>Reparation effectuée</span> <br/>";
                        }
                        ?>
                  </td>
                  <td>
                    <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#infos_vehicule_modal_<?php echo $row['car_id']; ?>').modal('show');" data-original-title="Envoyer un SMS au client concernant le statut de réparation de son véhicule"><i class="fa fa-envelope-o"></i></a>
                  </td>
                </tr>

                <div id="infos_vehicule_modal_<?php echo $row['car_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <a class="close" data-dismiss="modal">×</a>
                        <h3>Envoyer un SMS à <?php echo $row['c_name']; ?></h3>
                      </div>
                      <form id="devisVehiForm" name="devis_vehi" role="form" enctype="multipart/form-data" method="POST" action="sendRepairSmsToClient.php">
                        <div class="modal-body">

                          <div class="form-group row">
                            <label for="remarque_mecano" class="col-md-2 col-form-label">Message</label>
                            <div class="col-md-10" style="padding-left:0px;">
                              <textarea class="form-control" id="message_status_reparation" rows="4" name="message_status_reparation"></textarea>
                            </div>
                          </div>

                          <input type="hidden" value="<?php echo $row['car_id']; ?>" name="reception_car_id" />
                          <input type="hidden" value="<?php echo $row['princ_tel']; ?>" name="client_telephone" />

                          <input type="hidden" value="<?php echo $row['make_name']; ?>" name="make_name" />
                          <input type="hidden" value="<?php echo $row['model_name']; ?>" name="model_name" />
                          <input type="hidden" value="<?php echo $row['VIN']; ?>" name="immatri" />
                          <input type="hidden" value="<?php echo $row['c_name']; ?>" name="client_nom" />
                          <input type="hidden" value="<?php echo $row['statut_reparation']; ?>" name="statut_reparation" />
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                          <button type="submit" class="btn btn-success" id="submit">Envoyer</button>
                        </div>

                      </form>
                    </div>
                  </div>
                  <?php }

                  mysql_close($link);
                  ?>

              </tbody>
            </table>
          </div>

        </div>

        <!-- <div class="box-footer clearfix"><a href="<?php echo WEB_URL; ?>mech_panel/mech_repaircar_reception_list.php" class="btn btn-sm btn-success btn-flat pull-right"><b><i class="fa fa-list"></i> &nbsp;Voir toute la liste</b></a> </div> -->

      </div>

      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
</section>
<!-- /.content -->
<script type="text/javascript">
  $(document).ready(function() {
    setTimeout(function() {
      $("#me").hide(8000);
      $("#you").hide(8000);
      $("#his").hide(8000);
      $("#her").hide(8000);
      $("#us").hide(8000);
    }, 8000);
  });

  // Get context with jQuery - using jQuery's .get() method.
  var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
  // This will get the first returned node in the jQuery collection.
  var salesChart = new Chart(salesChartCanvas);

  var salesChartData = {
    //labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'],
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    datasets: [{
      label: 'Salary Report',
      fillColor: 'rgba(0, 166, 90, 1)',
      strokeColor: 'rgba(0, 166, 90, 1)',
      pointColor: '#00a65a',
      pointStrokeColor: 'rgba(0, 166, 90, 1)',
      pointHighlightFill: '#fff',
      pointHighlightStroke: 'rgba(0, 166, 90, 1)',
      data: [<?php echo $salary_default_data; ?>]
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
    //legendTemplate          : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: true,
    // Boolean - whether to make the chart responsive to window resizing
    responsive: true
  };

  // Create the line chart
  salesChart.Line(salesChartData, salesChartOptions);

  // ---------------------------
  // - END MONTHLY SALES CHART -
  // ---------------------------
</script>
<?php include('../footer.php'); ?>