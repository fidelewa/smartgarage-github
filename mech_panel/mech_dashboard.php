<?php include('../header.php'); ?>
<?php

$settings = $wms->getWebsiteSettingsInformation($link);

//for image upload
function uploadImage()
{

  if ((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)) {
    $filename = basename($_FILES['uploaded_file']['name']);
    $ext = substr($filename, strrpos($filename, '.') + 1);
    if ($ext == "pdf") {
      $temp = explode(".", $_FILES["uploaded_file"]["name"]);
      $newfilename = NewGuid() . '.' . end($temp);
      move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], ROOT_PATH . '/img/upload/docs/scanner' . $newfilename);
      return $newfilename;
    } else {
      return var_dump($_FILES);
    }
  }
  return var_dump($_FILES);
}
function NewGuid()
{
  $s = strtoupper(md5(uniqid(rand(), true)));
  $guidText =
    substr($s, 0, 8) . '-' .
    substr($s, 8, 4) . '-' .
    substr($s, 12, 4) . '-' .
    substr($s, 16, 4) . '-' .
    substr($s, 20);
  return $guidText;
}

// var_dump($_SESSION);

$i = 0;

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

  <div class="row container-fluid">
    <div class="col-lg-6 col-md-6 col-sm-6">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-list"></i> Liste des véhicules diagnostiqués</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table sakotable table-bordered table-striped dt-responsive">
            <thead>
              <tr>
                <!-- <th>ID Réception</th> -->
                <th>ID Diagnostic</th>
                <th>Immatriculation</th>
                <?php
                if ($_SESSION['login_type'] != "mechanics") { ?>
                  <th>Client</th>
                <?php } ?>
                <th>Date reception</th>
                <th>Date exp. assur</th>
                <th>Date exp. vis. tech.</th>
                <th>Statut acceptation diagnostic mécanique</th>
                <th>Diagnostic mécanique accepté par</th>
                <th>Statut diagnostic mécanique</th>
                <th>Statut acceptation diagnostic électrique</th>
                <th>Diagnostic électrique accepté par</th>
                <th>Statut diagnostic électrique</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php

              if ($_SESSION['objMech']['usr_type'] == "chef electricien") {

                $result = $wms->getRecepCarListByChefElectricien($link);
              }

              if ($_SESSION['objMech']['usr_type'] == "chef mecanicien") {

                $result = $wms->getRecepCarListByChefMecanicien($link);
              }

              // $result = $wms->getAllRecepRepairCarListByMecanicien($link, $_SESSION['objMech']['user_id']);

              // var_dump($result);

              ?>

              <?php foreach ($result as $row) {

                // $_SESSION['recep_tel']=

                // Structure conditionnelle alternative sur le numéro de téléphone 
                // du chef mécanicien et du chef électricien
                if (isset($row['mech_tel'])) {
                  $mech_tel = $row['mech_tel'];
                } else {
                  $mech_tel = "";
                }

                if (isset($row['elec_tel'])) {
                  $elec_tel = $row['elec_tel'];
                } else {
                  $elec_tel = "";
                }

                ?>
                <tr>
                  <!-- <td><span class="label label-success"><?php echo $row['repair_car_id']; ?></span></td> -->
                  <!-- <td><span class="label label-success"><?php echo $row['car_id']; ?></span></td> -->
                  <td>
                    <?php
                      if (isset($row['vehi_diag_id'])) { ?>
                      <span class="label label-success"><?php echo $row['vehi_diag_id']; ?></span>
                    <?php }
                      if (isset($row['car_id']) && !isset($row['vehi_diag_id'])) { ?>
                      <span class="label label-success"><?php echo $row['car_id']; ?></span>
                    <?php } ?>
                  </td>

                  <td><?php echo $row['num_matricule']; ?></td>
                  <?php
                    if ($_SESSION['login_type'] != "mechanics") { ?>
                    <td><?php echo $row['c_name']; ?></td>
                  <?php } ?>
                  <td><?php echo $row['add_date_recep_vehi']; ?></td>
                  <td><?php echo $row['add_date_assurance']; ?></td>
                  <td><?php echo $row['add_date_visitetech']; ?></td>
                  <td><?php
                        if (!isset($row['statut_acceptation_mecanicien'])) {
                          echo "";
                        } else if ($row['statut_acceptation_mecanicien'] == null) {
                          echo "<span class='label label-default'>En attente d'acceptation</span> <br/>";
                        } else if ($row['statut_acceptation_mecanicien'] == 1) {
                          echo "<span class='label label-success'>Accepté pour diagnostic</span> <br/>";
                        }
                        ?>
                  </td>
                  <td><?php
                        // if ($_SESSION['objMech']['usr_type'] == "chef mecanicien") {
                        // if ($row['attribution_mecanicien_id'] == $row['chef_mech_elec_id']) {
                        // echo $_SESSION['objMech']['name'];
                        // echo $row['mech_name'];
                        echo $row['mecano_name'];
                        // }
                        ?>
                  </td>
                  <td><?php
                        if (!isset($row['statut_diagnostic_mecanique'])) {
                          echo "";
                        } else if ($row['statut_diagnostic_mecanique'] == null) {
                          echo "<span class='label label-default'>En attente de diagnostic</span> <br/>";
                        } else if ($row['statut_diagnostic_mecanique'] == 1) {
                          echo "<span class='label label-success'>diagnostic éffectué</span> <br/>";
                        }
                        ?>
                  </td>
                  <td><?php
                        if (!isset($row['statut_acceptation_electricien'])) {
                          echo "";
                        } else if ($row['statut_acceptation_electricien'] == null) {
                          echo "<span class='label label-default'>En attente d'acceptation</span> <br/>";
                        } else if ($row['statut_acceptation_electricien'] == 1) {
                          echo "<span class='label label-success'>Accepté pour diagnostic</span> <br/>";
                        }
                        ?>
                  </td>
                  <td>
                    <?php
                      // if ($_SESSION['objMech']['usr_type'] == "chef electricien") {
                      // if ($row['attribution_electricien_id'] == $row['chef_mech_elec_id']) {
                      // echo $_SESSION['objMech']['name'];
                      // echo $row['mech_name'];
                      echo $row['electro_name'];
                      // }
                      ?>
                  </td>
                  <td><?php
                        if (!isset($row['statut_diagnostic_electrique'])) {
                          echo "";
                        } else if ($row['statut_diagnostic_electrique'] == null) {
                          echo "<span class='label label-default'>En attente de diagnostic</span> <br/>";
                        } else if ($row['statut_diagnostic_electrique'] == 1) {
                          echo "<span class='label label-success'>diagnostic éffectué</span> <br/>";
                        }
                        ?>
                  </td>
                  <td>
                    <?php
                      // Pour chaque véhicule réceptionné, on vérifie si le véhicule en question a été attribué
                      // seulement au chef mécanicien
                      if (isset($row['attribution_mecanicien']) && !isset($row['attribution_electricien'])) {

                        if ($_SESSION['objMech']['usr_type'] == 'chef mecanicien') {

                          // Si le chef mécanicien a signalé sa disponibilité de faire le diagnostic ?
                          // if (isset($row['statut_acceptation_mecanicien'])) {

                          // On vérifie si un chef mécanicien a déja fait un diagnostic sur la voiture réceptionnée en question

                          $resultCarDiagByChefMecanicien = $wms->getCarDiagByChefMecanicien($link, $row['car_id']);

                          if (!empty($resultCarDiagByChefMecanicien)) {
                            // Si un chef mécanicien a déja effectué un diagnostic sur la voiture réceptionné
                            // en question, on affiche les fiches correspondants 
                            ?>

                          <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc.php?car_id=<?php echo $row['car_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Afficher la fiche de reception"><i class="fa fa-file-text-o"></i></a>
                          <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_piecechange_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Consulter la fiche des pièces de rechange requis par le chef mécanicien"><i class="fa fa-file-text-o"></i></a>
                          <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_diagnostic_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Consulter la fiche de diagnostic du véhicule du chef mécanicien"><i class="fa fa-file-text-o"></i></a>

                        <?php
                              } else {
                                // Sinon, on affiche le bouton de création du formulaire de diagnostic
                                ?>
                          <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc.php?car_id=<?php echo $row['car_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Afficher la fiche de reception"><i class="fa fa-file-text-o"></i></a>
                          <a class="btn btn-info" style="background-color:purple;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>mech_panel/mech_repaircar_diagnostic.php?add_car_id=<?php echo $row['add_car_id']; ?>&car_id=<?php echo $row['car_id']; ?>&mech_fonction=<?php echo $_SESSION['objMech']['usr_type']; ?>&vehicule_scanner_id=<?php echo $row['vehicule_scanner_id']; ?>&admin_ges_tel=<?php echo $row['admin_ges_tel']; ?>&recep_tel=<?php echo $row['recep_tel']; ?>&elec_tel=<?php echo $elec_tel; ?>&mech_tel=<?php echo $mech_tel; ?>&att_mecano_id=<?php echo $row['attribution_mecanicien_id']; ?>&att_electro_id=<?php echo $row['attribution_electricien_id']; ?>&make_name=<?php echo $row['make_name']; ?>&model_name=<?php echo $row['model_name']; ?>&VIN=<?php echo $row['VIN']; ?>&make_name=<?php echo $row['make_name']; ?>&model_name=<?php echo $row['model_name']; ?>&VIN=<?php echo $row['VIN']; ?>" data-original-title="Créer le formulaire de diagnostic du véhicule pour le chef mécanicien"><i class="fa fa-plus"></i></a>
                        <?php }
                              // }
                              ?>
                    <?php
                        }
                      }
                      ?>
                    <?php
                      // Pour chaque véhicule réceptionné, on vérifie si le véhicule en question a été attribué
                      // seulement au chef électricien
                      if (!isset($row['attribution_mecanicien']) && isset($row['attribution_electricien'])) {

                        if ($_SESSION['objMech']['usr_type'] == 'chef electricien') {

                          // Si le chef électricien a signalé sa disponibilité de faire le diagnostic ?
                          // if (isset($row['statut_acceptation_electricien'])) {

                          // On vérifie si un chef électricien a déja fait un diagnostic sur la voiture réceptionnée en question

                          $resultCarDiagByChefElectricien = $wms->getCarDiagByChefElectricien($link, $row['car_id']);

                          if (!empty($resultCarDiagByChefElectricien)) {
                            // Si un chef électricien a déja effectué un diagnostic sur la voiture réceptionné
                            // en question, on affiche les fiches correspondantes 
                            ?>

                          <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc.php?car_id=<?php echo $row['car_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Afficher la fiche de reception"><i class="fa fa-file-text-o"></i></a>
                          <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_piecechange_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Consulter la fiche des pièces de rechange requis par le chef électricien"><i class="fa fa-file-text-o"></i></a>
                          <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_diagnostic_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Consulter la fiche de diagnostic du véhicule du chef électricien"><i class="fa fa-file-text-o"></i></a>

                        <?php
                              } else {
                                // Sinon, on affiche le bouton de création du formulaire de diagnostic
                                ?>
                          <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc.php?car_id=<?php echo $row['car_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Afficher la fiche de reception"><i class="fa fa-file-text-o"></i></a>
                          <a class="btn btn-info" style="background-color:purple;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>mech_panel/mech_repaircar_diagnostic.php?add_car_id=<?php echo $row['add_car_id']; ?>&car_id=<?php echo $row['car_id']; ?>&mech_fonction=<?php echo $_SESSION['objMech']['usr_type']; ?>&vehicule_scanner_id=<?php echo $row['vehicule_scanner_id']; ?>&admin_ges_tel=<?php echo $row['admin_ges_tel']; ?>&recep_tel=<?php echo $row['recep_tel']; ?>&elec_tel=<?php echo $elec_tel; ?>&mech_tel=<?php echo $mech_tel; ?>&att_mecano_id=<?php echo $row['attribution_mecanicien_id']; ?>&att_electro_id=<?php echo $row['attribution_electricien_id']; ?>&make_name=<?php echo $row['make_name']; ?>&model_name=<?php echo $row['model_name']; ?>&VIN=<?php echo $row['VIN']; ?>" data-original-title="Créer le formulaire de diagnostic du véhicule pour le chef électricien"><i class="fa fa-plus"></i></a>
                        <?php }
                              ?>
                    <?php
                        }
                      }
                      ?>
                    <?php
                      // Pour chaque véhicule réceptionné, on vérifie si le véhicule en question a été attribué à la fois au chef
                      // mécanicien et électricien
                      if (isset($row['attribution_mecanicien']) && isset($row['attribution_electricien'])) {

                        /*************************
                         * Cas du chef mécanicien
                         *************************/

                        if ($_SESSION['objMech']['usr_type'] == 'chef mecanicien') {

                          // Si le chef mécanicien a signalé sa disponibilité de faire le diagnostic ?
                          if (isset($row['statut_acceptation_mecanicien'])) {

                            // On vérifie si un chef mécanicien a déja fait un diagnostic sur la voiture réceptionnée en question

                            $resultCarDiagByChefMecanicien = $wms->getCarDiagByChefMecanicien($link, $row['car_id']);

                            if (!empty($resultCarDiagByChefMecanicien)) {
                              // Si un chef mécanicien a déja effectué un diagnostic sur la voiture réceptionné
                              // en question, on affiche les fiches correspondants 

                              if (($_SESSION['objMech']['usr_type'] == "chef mecanicien") && ($row['type_diagnostic'] == 'mécanique')) {
                                ?>

                              <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc.php?car_id=<?php echo $row['car_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Afficher la fiche de reception"><i class="fa fa-file-text-o"></i></a>
                              <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_piecechange_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>&type_diagnostic=<?php echo $row['type_diagnostic']; ?>" data-original-title="Consulter la fiche des pièces de rechange requis par le chef mécanicien"><i class="fa fa-file-text-o"></i></a>
                              <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_diagnostic_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>&type_diagnostic=<?php echo $row['type_diagnostic']; ?>" data-original-title="Consulter la fiche de diagnostic du véhicule du chef mécanicien"><i class="fa fa-file-text-o"></i></a>

                            <?php }
                                    } else {
                                      // Sinon, on affiche le bouton de création du formulaire de diagnostic
                                      ?>
                            <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc.php?car_id=<?php echo $row['car_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Afficher la fiche de reception"><i class="fa fa-file-text-o"></i></a>
                            <a class="btn btn-info" style="background-color:purple;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>mech_panel/mech_repaircar_diagnostic.php?add_car_id=<?php echo $row['add_car_id']; ?>&car_id=<?php echo $row['car_id']; ?>&mech_fonction=<?php echo $_SESSION['objMech']['usr_type']; ?>&vehicule_scanner_id=<?php echo $row['vehicule_scanner_id']; ?>&admin_ges_tel=<?php echo $row['admin_ges_tel']; ?>&recep_tel=<?php echo $row['recep_tel']; ?>&elec_tel=<?php echo $elec_tel; ?>&mech_tel=<?php echo $mech_tel; ?>&att_mecano_id=<?php echo $row['attribution_mecanicien_id']; ?>&att_electro_id=<?php echo $row['attribution_electricien_id']; ?>&make_name=<?php echo $row['make_name']; ?>&model_name=<?php echo $row['model_name']; ?>&VIN=<?php echo $row['VIN']; ?>" data-original-title="Créer le formulaire de diagnostic du véhicule pour le chef mécanicien"><i class="fa fa-plus"></i></a>
                          <?php }
                                } else {
                                  // Sinon, on affiche le bouton permettant au chef mécanicien de signaler sa disponibilité de faire
                                  // le diagnostic

                                  // On vérifie si le chef électricien n'a pas encore signalé sa disponibilité de faire son diagnostic
                                  if ($row['statut_action_electricien'] == 0) {
                                    ?>
                            <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#infos_vehicule_modal_<?php echo $row['car_id']; ?>').modal('show');" data-original-title="Accepter de faire le diagnostic mécanique"><i class="fa fa-check"></i></a>
                            <?php }
                                  }
                                }

                                /**************************
                                 * Cas du chef électricien
                                 **************************/

                                if ($_SESSION['objMech']['usr_type'] == 'chef electricien') {

                                  // Si le chef électricien a signalé sa disponibilité de faire le diagnostic ?
                                  if (isset($row['statut_acceptation_electricien'])) {

                                    // On vérifie si un chef électricien a déja fait un diagnostic sur la voiture réceptionnée en question

                                    $resultCarDiagByChefElectricien = $wms->getCarDiagByChefElectricien($link, $row['car_id']);

                                    if (!empty($resultCarDiagByChefElectricien)) {
                                      // Si un chef électricien a déja effectué un diagnostic sur la voiture réceptionné
                                      // en question, on affiche les fiches correspondantes 

                                      if (($_SESSION['objMech']['usr_type'] == "chef electricien") && ($row['type_diagnostic'] == 'électrique')) {
                                        ?>

                              <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc.php?car_id=<?php echo $row['car_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Afficher la fiche de reception"><i class="fa fa-file-text-o"></i></a>
                              <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_piecechange_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>&type_diagnostic=<?php echo $row['type_diagnostic']; ?>" data-original-title="Consulter la fiche des pièces de rechange requis par le chef électricien"><i class="fa fa-file-text-o"></i></a>
                              <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_diagnostic_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>&type_diagnostic=<?php echo $row['type_diagnostic']; ?>" data-original-title="Consulter la fiche de diagnostic du véhicule du chef électricien"><i class="fa fa-file-text-o"></i></a>

                            <?php
                                      }
                                    } else {
                                      // Sinon, on affiche le bouton de création du formulaire de diagnostic
                                      ?>
                            <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc.php?car_id=<?php echo $row['car_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Afficher la fiche de reception"><i class="fa fa-file-text-o"></i></a>
                            <a class="btn btn-info" style="background-color:purple;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>mech_panel/mech_repaircar_diagnostic.php?add_car_id=<?php echo $row['add_car_id']; ?>&car_id=<?php echo $row['car_id']; ?>&mech_fonction=<?php echo $_SESSION['objMech']['usr_type']; ?>&vehicule_scanner_id=<?php echo $row['vehicule_scanner_id']; ?>&admin_ges_tel=<?php echo $row['admin_ges_tel']; ?>&recep_tel=<?php echo $row['recep_tel']; ?>&elec_tel=<?php echo $elec_tel; ?>&mech_tel=<?php echo $mech_tel; ?>&att_mecano_id=<?php echo $row['attribution_mecanicien_id']; ?>&att_electro_id=<?php echo $row['attribution_electricien_id']; ?>&make_name=<?php echo $row['make_name']; ?>&model_name=<?php echo $row['model_name']; ?>&VIN=<?php echo $row['VIN']; ?>" data-original-title="Créer le formulaire de diagnostic du véhicule pour le chef électricien"><i class="fa fa-plus"></i></a>
                          <?php }
                                } else {
                                  // Sinon, on affiche le bouton permettant au chef électricien de signaler sa disponibilité de faire
                                  // le diagnostic

                                  // On vérifie si le chef mécanicien n'a pas encore signalé sa disponibilité de faire son diagnostic
                                  if ($row['statut_action_mecanicien'] == 0) {
                                    ?>
                            <!-- <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#infos_vehicule_modal_<?php echo $row['car_id']; ?>').modal('show');" data-original-title="Accepter de faire le diagnostic électrique"><i class="fa fa-check"></i></a> -->
                            <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#infos_vehicule_modal_<?php echo $row['car_id']; ?>').modal('show');" data-original-title="Accepter de faire le diagnostic électrique"><i class="fa fa-check"></i></a>
                          <?php }
                                  ?>

                    <?php }
                        }
                      }


                      // Définition des variable de session
                      ?>
                  </td>
                </tr>
                <div id="infos_vehicule_modal_<?php echo $row['car_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <a class="close" data-dismiss="modal">×</a>
                        <h3>Formulaire d'acceptation du diagnostic</h3>
                      </div>
                      <form id="diagAcceptForm" name="diag_accept_form" role="form" enctype="multipart/form-data" method="POST" action="attri_mecano_process.php">
                        <div class="modal-body">

                          <div class="form-group row">
                            <label for="remarque_mecano" class="col-md-2 col-form-label">Remarque</label>
                            <div class="col-md-10" style="padding-left:0px;">
                              <textarea class="form-control" id="remarque_mecano" rows="4" name="remarque_mecano"></textarea>
                            </div>
                          </div>

                          <input type="hidden" value="<?php echo $row['statut_acceptation_electricien']; ?>" name="statut_acceptation_electricien" />
                          <input type="hidden" value="<?php echo $row['statut_acceptation_mecanicien']; ?>" name="statut_acceptation_mecanicien" />

                          <input type="hidden" value="<?php echo $row['make_name']; ?>" name="make_name" />
                          <input type="hidden" value="<?php echo $row['model_name']; ?>" name="model_name" />
                          <input type="hidden" value="<?php echo $row['VIN']; ?>" name="VIN" />

                          <input type="hidden" value="<?php echo $row['attrib_recep']; ?>" name="attrib_recep" />
                          <input type="hidden" value="<?php echo $row['car_id']; ?>" name="reception_id" />
                          <input type="hidden" value="<?php echo $row['attribution_mecanicien']; ?>" name="att_mecano" />
                          <input type="hidden" value="<?php echo $row['attribution_electricien']; ?>" name="att_electro" />
                          <input type="hidden" value="<?php echo $row['attribution_mecanicien_id']; ?>" name="att_mecano_id" />
                          <input type="hidden" value="<?php echo $row['attribution_electricien_id']; ?>" name="att_electro_id" />
                          <input type="hidden" value="<?php echo $row['chef_mech_elec_id']; ?>" name="chef_mech_elec_id" />
                          <input type="hidden" value="<?php echo $row['admin_ges_tel']; ?>" name="admin_ges_tel" />
                          <input type="hidden" value="<?php echo $_SESSION['objMech']['user_id']; ?>" name="chef_mec_elec_id" />
                          <input type="hidden" value="<?php echo $_SESSION['objMech']['name']; ?>" name="chef_mech_elec_name" />
                          <input type="hidden" value="<?php echo $_SESSION['objMech']['usr_type']; ?>" name="chef_mech_elec_type" />
                          <input type="hidden" value="<?php echo $row['recep_tel']; ?>" name="recep_tel" />

                          <?php
                            if ($_SESSION['objMech']['usr_type'] == "chef electricien") { ?>
                            <input type="hidden" value="<?php echo $mech_tel; ?>" name="mech_tel" />
                          <?php }
                            ?>
                          <?php
                            if ($_SESSION['objMech']['usr_type'] == "chef mecanicien") { ?>
                            <input type="hidden" value="<?php echo $elec_tel; ?>" name="elec_tel" />
                          <?php }
                            ?>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                          <button type="submit" class="btn btn-success" id="submit">Valider</button>
                        </div>

                      </form>
                    </div>
                  </div>
                <?php }
                ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <!-- <div class="box-footer clearfix"><a href="<?php echo WEB_URL; ?>cust_panel/cust_repaircar_diagnostic_devis_list.php" class="btn btn-sm btn-success btn-flat pull-right"><b><i class="fa fa-list"></i> &nbsp;Voir toute la liste</b></a> </div> -->
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-list"></i> Liste des véhicules en réparation</h3>
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

              if ($_SESSION['objMech']['usr_type'] == 'chef electricien') {

                // $result = $wms->getRecepCarListByChefElectricien($link);
                $result = $wms->getRecepCarListReparByElec($link);
              }

              if ($_SESSION['objMech']['usr_type'] == 'chef mecanicien') {

                // $result = $wms->getRecepCarListByChefMecanicien($link);
                $result = $wms->getRecepCarListReparByMech($link);
              }

              // $result = $wms->getAllRecepRepairCarListByMecanicien($link, $_SESSION['objMech']['user_id']);

              // var_dump($result);

              ?>

              <?php foreach ($result as $row) { ?>
                <tr>
                  <td><span class="label label-success"><?php echo $row['car_id']; ?></span></td>
                  <td><?php echo $row['num_matricule']; ?></td>
                  <?php
                    if ($_SESSION['login_type'] != "mechanics") { ?>
                    <td><?php echo $row['c_name']; ?></td>
                  <?php } ?>
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
                          echo "<span class='label label-success'>Reparation effectuée et terminée</span> <br/>";
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
                          echo "<span class='label label-success'>Reparation effectuée et terminée</span> <br/>";
                        }
                        ?>
                  </td>
                  <td>

                    <?php
                      // Pour chaque véhicule réceptionné, on vérifie si le véhicule en question a été attribué à la fois au chef
                      // mécanicien et électricien
                      // if (isset($row['attribution_mecanicien']) && isset($row['attribution_electricien'])) {

                      /*************************
                       * Cas du chef mécanicien
                       *************************/

                      if ($_SESSION['objMech']['usr_type'] == 'chef mecanicien') {

                        // Par défaut le chef mécanicien a accès aux actions
                        if ($row['mecano_action_reparation'] == null) {
                          if ($row['statut_reparation_mecanique'] == null) {
                            ?>
                          <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#diag_vehicule_modal_<?php echo $row['car_id']; ?>').modal('show');" data-original-title="Affecter un mécanicien à la réparation du véhicule"><i class="fa fa-user"></i></a>
                        <?php
                              } elseif ($row['statut_reparation_mecanique'] == 0) { ?>
                          <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/car_fin_reparation_process.php?recep_car_id=<?php echo $row['car_id']; ?>&chef_mech_elec_type=<?php echo $_SESSION['objMech']['usr_type']; ?>&admin_ges_tel=<?php echo $row['admin_ges_tel']; ?>&recep_tel=<?php echo $row['recep_tel']; ?>&make_name=<?php echo $row['make_name']; ?>&model_name=<?php echo $row['model_name']; ?>&VIN=<?php echo $row['VIN']; ?>" data-original-title="Terminer la réparation du véhicule"><i class="fa fa-car"></i></a>
                        <?php }
                            }
                          }

                          /**************************
                           * Cas du chef électricien
                           **************************/

                          if ($_SESSION['objMech']['usr_type'] == 'chef electricien') {

                            // Par défaut le chef électricien a accès aux actions
                            if ($row['electro_action_reparation'] == null) {
                              if ($row['statut_reparation_electrique'] == null) {
                                ?>
                          <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#diag_vehicule_modal_<?php echo $row['car_id']; ?>').modal('show');" data-original-title="Affecter un électricien à la réparation du véhicule"><i class="fa fa-user"></i></a>
                        <?php
                              } elseif ($row['statut_reparation_electrique'] == 0) { ?>
                          <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/car_fin_reparation_process.php?recep_car_id=<?php echo $row['car_id']; ?>&chef_mech_elec_type=<?php echo $_SESSION['objMech']['usr_type']; ?>&admin_ges_tel=<?php echo $row['admin_ges_tel']; ?>&recep_tel=<?php echo $row['recep_tel']; ?>&make_name=<?php echo $row['make_name']; ?>&model_name=<?php echo $row['model_name']; ?>&VIN=<?php echo $row['VIN']; ?>" data-original-title="Terminer la réparation du véhicule"><i class="fa fa-car"></i></a>
                    <?php }
                        }
                      }

                      ?>

                  </td>
                </tr>
                <div id="diag_vehicule_modal_<?php echo $row['car_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <a class="close" data-dismiss="modal">×</a>
                        <?php
                          if ($_SESSION['objMech']['usr_type'] == 'chef electricien') { ?>

                          <h3>Formulaire d'attribution de la réparation à un électricien</h3>
                        <?php  }
                          ?>
                        <?php
                          if ($_SESSION['objMech']['usr_type'] == 'chef mecanicien') { ?>
                          <h3>Formulaire d'attribution de la réparation à un mécanicien</h3>
                        <?php  }
                          ?>

                      </div>
                      <form id="devisVehiForm" name="devis_vehi" role="form" enctype="multipart/form-data" method="POST" action="attri_repar_mecano_process.php">
                        <div class="modal-body">

                          <?php
                            if ($_SESSION['objMech']['usr_type'] == "chef mecanicien") {
                              $mecanicien_list = $wms->getAllMechanicsList($link);
                              // var_dump($mecanicien_list);
                              ?>

                            <fieldset>
                              <legend>Sélection du mécanicien</legend>
                              <?php
                                  // var_dump($mecanicien_list);
                                  foreach ($mecanicien_list as $mrow) { ?>

                                <div class="form-group col-md-12">
                                  <div class="col-md-5 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="checkbox" name="mecano[<?php echo $i; ?>][nom_mecano]" id="mecano_<?php echo $i; ?>" value="<?php echo $mrow['per_name']; ?>">
                                    <label class="form-check-label"><?php echo $mrow['per_name']; ?></label>
                                  </div>
                                </div>

                              <?php
                                    $i++;
                                  }
                                  ?>
                            </fieldset>

                          <?php
                            }
                            ?>

                          <?php
                            if ($_SESSION['objMech']['usr_type'] == "chef electricien") {
                              $mecanicien_list = $wms->getAllElectroList($link);
                              ?>

                            <fieldset>
                              <legend>Sélection de l'électricien</legend>
                              <?php
                                  // var_dump($mecanicien_list);
                                  foreach ($mecanicien_list as $mrow) { ?>

                                <div class="form-group col-md-12">
                                  <div class="col-md-5 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="checkbox" name="mecano[<?php echo $i; ?>][nom_mecano]" id="mecano_<?php echo $i; ?>" value="<?php echo $mrow['per_name']; ?>">
                                    <label class="form-check-label"><?php echo $mrow['per_name']; ?></label>
                                  </div>
                                </div>

                              <?php
                                    $i++;
                                  }
                                  ?>
                            </fieldset>

                          <?php
                            }
                            ?>

                          <div class="form-group row">
                            <label for="remarque_mecano" class="col-md-2 col-form-label">Remarque</label>
                            <div class="col-md-10" style="padding-left:0px;">
                              <textarea class="form-control" id="remarque_mecano_repar" rows="4" name="remarque_mecano_repar"></textarea>
                            </div>
                          </div>

                          <input type="hidden" value="<?php echo $_SESSION['objMech']['usr_type']; ?>" name="chef_mech_elec_type" />
                          <input type="hidden" value="<?php echo $row['admin_ges_tel']; ?>" name="admin_ges_tel" />
                          <input type="hidden" value="<?php echo $row['recep_tel']; ?>" name="recep_tel" />

                          <input type="hidden" value="<?php echo $row['make_name']; ?>" name="make_name" />
                          <input type="hidden" value="<?php echo $row['model_name']; ?>" name="model_name" />
                          <input type="hidden" value="<?php echo $row['VIN']; ?>" name="VIN" />

                          <!-- <input type="hidden" value="<?php echo $row['attrib_recep']; ?>" name="attrib_recep" /> -->
                          <input type="hidden" value="<?php echo $row['car_id']; ?>" name="reception_id" />
                          <!-- <input type="hidden" value="<?php echo $row['attribution_mecanicien']; ?>" name="att_mecano" />
                                                                                                        <input type="hidden" value="<?php echo $row['attribution_electricien']; ?>" name="att_electro" />
                                                                                                        <input type="hidden" value="<?php echo $row['attribution_mecanicien_id']; ?>" name="att_mecano_id" />
                                                                                                        <input type="hidden" value="<?php echo $row['attribution_electricien_id']; ?>" name="att_electro_id" />
                                                                                                        <input type="hidden" value="<?php echo $row['chef_mech_elec_id']; ?>" name="chef_mech_elec_id" /> -->
                          <!-- <input type="hidden" value="<?php echo $row['admin_ges_tel']; ?>" name="admin_ges_tel" /> -->
                          <!-- <input type="hidden" value="<?php echo $_SESSION['objMech']['user_id']; ?>" name="chef_mec_elec_id" />
                                                                                                        <input type="hidden" value="<?php echo $_SESSION['objMech']['name']; ?>" name="chef_mech_elec_name" /> -->
                          <!-- <input type="hidden" value="<?php echo $row['recep_tel']; ?>" name="recep_tel" /> -->
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                          <button type="submit" class="btn btn-success" id="submit">Valider</button>
                        </div>

                      </form>
                    </div>
                  </div>
                <?php }
                ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <!-- <div class="box-footer clearfix"><a href="<?php echo WEB_URL; ?>cust_panel/cust_repaircar_diagnostic_devis_list.php" class="btn btn-sm btn-success btn-flat pull-right"><b><i class="fa fa-list"></i> &nbsp;Voir toute la liste</b></a> </div> -->
      </div>
    </div>
  </div>

  <?php

  if ($_SESSION['objMech']['usr_type'] == 'chef mecanicien') {  ?>
    <div class="row container-fluid">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title"><i class="fa fa-list"></i> Liste des devis mécaniques des véhicules</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table class="table sakotable table-bordered table-striped dt-responsive">
              <thead>
                <tr>
                  <th>ID Devis</th>
                  <th>Immatriculation</th>
                  <!-- <th>Client</th> -->
                  <!-- <th>Date reception</th> -->
                  <th>Date exp. assur</th>
                  <th>Date exp. vis. tech.</th>
                  <!-- <th>Statut validation devis mécanique</th>
                  <th>Statut validation devis électrique</th> -->
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php

                  $result = $wms->getRepairCarDiagnosticDevisMecanoClients($link);

                  foreach ($result as $row) {

                    ?>

                  <tr>
                    <td><span class="label label-success"><?php echo $row['devis_id']; ?></span></td>
                    <td><?php echo $row['VIN']; ?></td>
                    <!-- <td><?php echo $row['c_name']; ?></td> -->
                    <!-- <td><?php echo $row['add_date_recep_vehi']; ?></td> -->
                    <td><?php echo $row['add_date_assurance']; ?></td>
                    <td><?php echo $row['add_date_visitetech']; ?></td>
                    <!-- <td><?php
                                  if (!isset($row['statut_validation_devis_mecanique'])) {
                                    echo "";
                                  } else if ($row['statut_validation_devis_mecanique'] == null) {
                                    echo "<span class='label label-default'>En attente de validation</span> <br/>";
                                  } else if ($row['statut_validation_devis_mecanique'] == 1) {
                                    echo "<span class='label label-success'>Validation effectué par le client</span> <br/>";
                                  }
                                  ?></td>
                    <td><?php
                            if (!isset($row['statut_validation_devis_electrique'])) {
                              echo "";
                            } else if ($row['statut_validation_devis_electrique'] == null) {
                              echo "<span class='label label-default'>En attente de validation</span> <br/>";
                            } else if ($row['statut_validation_devis_electrique'] == 1) {
                              echo "<span class='label label-success'>Validation effectué par le client</span> <br/>";
                            }
                            ?></td> -->
                    <td>
                      <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_diagnostic_devis_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&devis_id=<?php echo $row['devis_id']; ?>" data-original-title="Consulter le devis du diagnostic mécanique du véhicule"><i class="fa fa-file-text-o"></i></a>
                      </a>
                    </td>
                  </tr>
                <?php }
                  // mysql_close($link); 
                  ?>
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
          <!-- <div class="box-footer clearfix"><a href="<?php echo WEB_URL; ?>cust_panel/cust_repaircar_diagnostic_devis_list.php" class="btn btn-sm btn-success btn-flat pull-right"><b><i class="fa fa-list"></i> &nbsp;Voir toute la liste</b></a> </div> -->
        </div>
      </div>
    </div>
  <?php }

  if ($_SESSION['objMech']['usr_type'] == 'chef electricien') {  ?>
    <div class="row container-fluid">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title"><i class="fa fa-list"></i> Liste des devis électriques des véhicules</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table class="table sakotable table-bordered table-striped dt-responsive">
              <thead>
                <tr>
                  <th>ID Devis</th>
                  <th>Immatriculation</th>
                  <!-- <th>Client</th> -->
                  <!-- <th>Date reception</th> -->
                  <th>Date exp. assur</th>
                  <th>Date exp. vis. tech.</th>
                  <!-- <th>Statut validation devis mécanique</th>
                  <th>Statut validation devis électrique</th> -->
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php

                  $result = $wms->getRepairCarDiagnosticDevisElectroClients($link);

                  foreach ($result as $row) {

                    ?>

                  <tr>
                    <td><span class="label label-success"><?php echo $row['devis_id']; ?></span></td>
                    <td><?php echo $row['VIN']; ?></td>
                    <!-- <td><?php echo $row['c_name']; ?></td> -->
                    <!-- <td><?php echo $row['add_date_recep_vehi']; ?></td> -->
                    <td><?php echo $row['add_date_assurance']; ?></td>
                    <td><?php echo $row['add_date_visitetech']; ?></td>
                    <!-- <td><?php
                                  if (!isset($row['statut_validation_devis_mecanique'])) {
                                    echo "";
                                  } else if ($row['statut_validation_devis_mecanique'] == null) {
                                    echo "<span class='label label-default'>En attente de validation</span> <br/>";
                                  } else if ($row['statut_validation_devis_mecanique'] == 1) {
                                    echo "<span class='label label-success'>Validation effectué par le client</span> <br/>";
                                  }
                                  ?></td>
                    <td><?php
                            if (!isset($row['statut_validation_devis_electrique'])) {
                              echo "";
                            } else if ($row['statut_validation_devis_electrique'] == null) {
                              echo "<span class='label label-default'>En attente de validation</span> <br/>";
                            } else if ($row['statut_validation_devis_electrique'] == 1) {
                              echo "<span class='label label-success'>Validation effectué par le client</span> <br/>";
                            }
                            ?></td> -->
                    <td>
                      <!-- <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_diagnostic_devis_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>" data-original-title="Consulter la devis de réparation du véhicule"><i class="fa fa-file-text-o"></i></a> -->
                      <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_diagnostic_devis_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&devis_id=<?php echo $row['devis_id']; ?>" data-original-title="Consulter le devis du diagnostic électrique du véhicule"><i class="fa fa-file-text-o"></i></a>
                      </a>
                    </td>
                  </tr>
                <?php }
                  // mysql_close($link); 
                  ?>
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
          <!-- <div class="box-footer clearfix"><a href="<?php echo WEB_URL; ?>cust_panel/cust_repaircar_diagnostic_devis_list.php" class="btn btn-sm btn-success btn-flat pull-right"><b><i class="fa fa-list"></i> &nbsp;Voir toute la liste</b></a> </div> -->
        </div>
      </div>
    </div>
  <?php }  ?>

  <?php

  if ($_SESSION['objMech']['usr_type'] == 'chef mecanicien' or $_SESSION['objMech']['usr_type'] == 'chef electricien') {  ?>
    <!-- <div class="row">
      <div class="col-md-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Liste des nouveaux véhicules réceptionnés</h3>
          </div>

          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                  <tr>
                    <th>ID Reception</th>
                    <th>Immatriculation du véhicule</th>
                    <th>Receptionné par</th>
                    <th>Statut attribution</th>
                    <th>Attribué à</th>
                    <th>Statut diagnostic</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                    $result = $wms->getAllRecepRepairCarListMech($link);

                    ?>

                  <?php foreach ($result as $row) { ?>
                    <tr>
                      <td><?php echo $row['car_id']; ?></td>
                      <td><?php echo $row['num_matricule']; ?></td>
                      <td><?php echo $row['recep_name']; ?></td>
                      <td><?php
                              if ($row['status_attribution_vehicule'] == null) {
                                echo "<span class='label label-default'>En attente d'attribution</span> <br/>";
                              } else if ($row['status_attribution_vehicule'] == 1) {
                                echo "<span class='label label-success'>Attribué</span> <br/>";
                              }
                              ?></td>
                      <td><?php echo $row['mech_name']; ?></td>
                      <td><?php
                              if ($row['status_diagnostic_vehicule'] == null) {
                                echo "<span class='label label-default'>En attente de diagnostic</span> <br/>";
                              } else if ($row['status_attribution_vehicule'] == 1) {
                                echo "<span class='label label-success'>Diagnostiqué</span> <br/>";
                              }
                              ?></td>
                      <td>
                        <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc.php?car_id=<?php echo $row['car_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Fiche de reception du véhicule"><i class="fa fa-file-text-o"></i></a>
                        <?php

                            // On récupère l'id du diagnostic du véhicule réceptionné à faire réparer 
                            $rows = $wms->getComparPrixPieceRechangeInfoByDiagId($link, $row['vehi_diag_id']);

                            // S'il y a des enregistrements correspondant à cet id existant déja en BDD
                            // On affiche l'icone de la fiche
                            if (!empty($rows)) { ?>
                          <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_diagnostic_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>" data-original-title="Consulter la fiche de diagnostic du véhicule"><i class="fa fa-file-text-o"></i></a>
                        <?php }

                            // Si le client et le receptionniste ont signé au dépot la fiche de reception du véhicule
                            if (isset($row['sign_cli_depot']) && isset($row['sign_recep_depot'])) { ?>

                          <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" href="<?php echo WEB_URL; ?>diagnostic/attribution_chef_mech_elec_process.php" data-original-title="S'attribuer le véhicule réceptionné pour diagnostic"><i class="fa fa-user"></i></a>

                        <?php } ?>

                      </td>
                    </tr>
                  <?php }
                    mysql_close($link); ?>

                </tbody>
              </table>
            </div>

          </div>

          <div class="box-footer clearfix"><a href="<?php echo WEB_URL; ?>mech_panel/mech_repaircar_reception_list.php" class="btn btn-sm btn-success btn-flat pull-right"><b><i class="fa fa-list"></i> &nbsp;Voir toute la liste</b></a> </div>

        </div>
      </div>
    </div> -->
  <?php  }
  ?>

</section>

<!-- /.content -->
<script type="text/javascript">
  
</script>
<?php include('../footer.php'); ?>