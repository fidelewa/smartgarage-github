<?php include('../header.php'); ?>
<?php
//dashboard widget data

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

if (isset($_GET['m']) && $_GET['m'] == 'reception_processing') {
  $addinfo_2 = 'block';
  $msg_2 = "Veuillez patienter, la réception du véhicule est en cours";
}

if (isset($_GET['m']) && $_GET['m'] == 'reception_success') {
  $addinfo_2 = 'block';
  $msg_2 = "La voiture a été ajoutée à la liste des véhicules réceptionnés";
}

if (isset($_GET['m']) && $_GET['m'] == 'add') {
  $addinfo_2 = 'block';
  $msg_2 = "La voiture a été ajoutée à la liste des véhicules réceptionnés";
}

if (isset($_GET['m']) && $_GET['m'] == 'up') {
  $addinfo_3 = 'block';
  $msg_3 = "La voiture receptionnée a été modifiée";
}

$settings = $wms->getWebsiteSettingsInformation($link);

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

      <div class="col-lg-6 col-md-6 col-sm-6">
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
                  <!-- <th>ID Diagnostic</th> -->
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
                    <!-- <td><?php echo $row['vehi_diag_id']; ?></td> -->
                    <td><?php echo $row['num_matricule']; ?></td>
                    <td><?php echo $row['c_name']; ?></td>
                    <td><?php echo $row['add_date_recep_vehi']; ?></td>
                    <td><?php echo $row['add_date_assurance']; ?></td>
                    <td><?php echo $row['add_date_visitetech']; ?></td>
                    <!-- <td><?php echo $row['m_name']; ?></td> -->
                    <td>

                      <!-- <a class="btn btn-info" style="background-color:purple;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/repaircar_diagnostic.php?add_car_id=<?php echo $row['add_car_id']; ?>&car_id=<?php echo $row['car_id']; ?>" data-original-title="Créer le formulaire de diagnostic du véhicule"><i class="fa fa-plus"></i></a> -->
                      <!-- <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc.php?car_id=<?php echo $row['car_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Fiche de reception du véhicule"><i class="fa fa-file-text-o"></i></a> -->
                      <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc_gene.php?car_id=<?php echo $row['car_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Fiche de reception du véhicule"><i class="fa fa-file-text-o"></i></a>
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
      </div>

      <div class="col-lg-6 col-md-6 col-sm-6">
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
                      <?php

                        $resultGetNbReceptionByCarImma = $wms->getNbReceptionByCarImma($link, $row['imma_vehi_client']);

                        // var_dump((int)$resultGetNbReceptionByCarImma['nb_reception']);

                        // Si le véhicule en question n'a jamais été réceptionné, on crée le véhicule puis on le réceptionne
                        if ((int) $resultGetNbReceptionByCarImma['nb_reception'] == 0 && $row['statut_reception'] == null) {
                          ?>
                        <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/addcar_reception.php?immat=<?php echo $row['imma_vehi_client']; ?>&vehicule_scanner_id=<?php echo $row['id']; ?>" data-original-title="Receptionner ce véhicule"><i class="fa fa-user"></i></a>
                      <?php
                        } ?>

                      <?php
                        // Si le véhicule en question a déja été réceptionné, et que l'on le réceptionne à nouveau
                        if ((int) $resultGetNbReceptionByCarImma['nb_reception'] > 0 && $row['statut_reception'] == null) {
                          ?>
                        <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/repaircar_reception.php?vehicule_scanner_id=<?php echo $row['id']; ?>" data-original-title="Receptionner ce véhicule à nouveau"><i class="fa fa-user"></i></a>
                      <?php
                        } ?>

                      <!-- <a class="btn btn-info" data-toggle="tooltip" href="#" data-original-title="Afficher le reçu de paiement du scanner"><i class="fa fa-file-text-o"></i></a> -->
                    </td>
                  </tr>
                <?php }
                ?>
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="box box-success">
          <div class="box-header">
            <!-- <h3 class="box-title"><i class="fa fa-list"></i> Voiture de réparation List</h3> -->
            <h3 class="box-title"><i class="fa fa-list"></i> Liste des derniers véhicules réparés</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table class="table sakotable table-bordered table-striped dt-responsive">
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
                  <th>Statut réparation mécanique</th>
                  <th>Statut réparation électrique</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php

                $result = $wms->getRecepCarListRepared($link);

                // var_dump($result);

                // die();

                foreach ($result as $row) {

                  ?>
                  <tr>
                    <td><span class="label label-success"><?php echo $row['car_id']; ?></span></td>
                    <td><?php echo $row['num_matricule']; ?></td>
                    <td><?php echo $row['c_name']; ?></td>
                    <td><?php echo $row['add_date_recep_vehi']; ?></td>
                    <td><?php echo $row['add_date_assurance']; ?></td>
                    <td><?php echo $row['add_date_visitetech']; ?></td>
                    <td><?php
                          if (!isset($row['statut_reparation_mecanique'])) {
                            echo "";
                          } else if ($row['statut_reparation_mecanique'] == null) {
                            echo "<span class='label label-default'>En attente de réparation</span> <br/>";
                          } else if ($row['statut_reparation_mecanique'] == 0) {
                            echo "<span class='label label-warning'>En cours de reparation</span> <br/>";
                          } else if ($row['statut_reparation_mecanique'] == 1) {
                            echo "<span class='label label-success'>Reparation effectuée</span> <br/>";
                          }
                          ?>
                    </td>
                    <td><?php
                          if (!isset($row['statut_reparation_electrique'])) {
                            echo "";
                          } else if ($row['statut_reparation_electrique'] == null) {
                            echo "<span class='label label-default'>En attente de réparation</span> <br/>";
                          } else if ($row['statut_reparation_electrique'] == 0) {
                            echo "<span class='label label-warning'>En cours de reparation</span> <br/>";
                          } else if ($row['statut_reparation_electrique'] == 1) {
                            echo "<span class='label label-success'>Reparation effectuée</span> <br/>";
                          }
                          ?>
                    </td>
                    <td>
                      <!-- <a class="btn btn-primary" style="background-color:#021254;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/vehicule_livraison.php?recep_car_id=<?php echo $row['car_id']; ?>" data-original-title="Confirmer la livraison du véhicule"><i class="fa fa-car"></i></a> -->
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
                  <?php
                    mysql_close($link);
                  }
                  ?>
              </tbody>
            </table>
            <!-- <div class="box-footer clearfix"><a href="<?php echo WEB_URL; ?>recep_panel/recep_repaircar_reception_list.php" class="btn btn-sm btn-success btn-flat pull-right"><b><i class="fa fa-list"></i> &nbsp;Voir toute la liste</b></a> </div> -->
          </div>
          <!-- /.box-body -->
        </div>
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


</script>
<?php include('../footer.php'); ?>