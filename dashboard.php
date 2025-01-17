<?php include('header.php'); ?>
<?php
//security
// if ($_SESSION['login_type'] != 'admin') {
//   header("Location: " . WEB_URL . "logout.php");
//   die();
// }
?>
<?php
//dashboard widget data
$customer = $wms->getAllCustomerList($link);
$parts_stock = $wms->partsStockTotalQty($link);
$car_stock = $wms->getAllActiveCarList($link);
$personnel = $wms->getAllPersonnelList($link);
$settings = $wms->getWebsiteSettingsInformation($link);

$delinfo = 'none';
$addinfo = 'none';
$failedinfo = 'none';

$msg = '';
$addinfo = 'none';
if (isset($_GET['m']) && $_GET['m'] == 'msg_envoye') {
  $addinfo = 'block';
  $msg = "Ajout du véhicule réussi";
}

// var_dump($_SESSION);

$i = 0;

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
        <a href="<?php echo WEB_URL; ?>parts_stock/mouvstock.php" class="small-box-footer">Plus d'infos <i class="fa fa-arrow-circle-right"></i></a>
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
          <p><?php echo count($car_stock) > 1 ? 'VOITURES DES CLIENTS' : 'VOITURE DU CLIENT'; ?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/car.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>repaircar/carlist.php" class="small-box-footer">Plus d'infos <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col end -->
    <!-- col start -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?php echo count($personnel); ?></h3>
          <p><?php echo count($personnel) > 1 ? 'EMPLOYES' : 'EMPLOYE'; ?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/mechanic.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>user/listepersonnel.php" class="small-box-footer">Plus d'infos <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col end -->
  </div>
  <!-- /.row end -->

  <div>
    <?php

    if (isset($_GET['m']) && $_GET['m'] == 'exp_vistech_sms_succes') {
      $addinfo = 'block';
      $msg = "SMS de rappel de la visite technique envoyé avec succès";
    }

    if (isset($_GET['m']) && $_GET['m'] == 'av_exp_assur_sms_succes') {
      $addinfo = 'block';
      $msg = "SMS de rappel de l'assurance envoyé avec succès";
    }

    if (isset($_GET['m']) && $_GET['m'] == 'av_exp_vistech_sms_succes') {
      $addinfo = 'block';
      $msg = "SMS de rappel de la visite technique envoyé avec succès";
    }

    if (isset($_GET['m']) && $_GET['m'] == 'exp_assur_sms_failed') {
      $failedinfo = 'block';
      $msg = "L'envoi du SMS de rappel de l'assurance à échoué";
    }

    if (isset($_GET['m']) && $_GET['m'] == 'exp_vistech_sms_failed') {
      $failedinfo = 'block';
      $msg = "L'envoi du SMS de rappel de la visite technique à échoué";
    }

    if (isset($_GET['m']) && $_GET['m'] == 'av_exp_assur_sms_failed') {
      $failedinfo = 'block';
      $msg = "L'envoi du SMS de rappel de l'assurance à échoué";
    }

    if (isset($_GET['m']) && $_GET['m'] == 'av_exp_vistech_sms_failed') {
      $failedinfo = 'block';
      $msg = "L'envoi du SMS de rappel de la visite technique à échoué";
    }

    $url_reste_sms = "https://app.emisms.com/sms/api?action=check-balance&api_key=S2NnRmFuck5KZGJheEFBQUVoc2k=&response=json";
    // $curl = curl_init();
    // curl_setopt($curl, CURLOPT_URL, $url_reste_sms);
    // curl_exec($curl);
    // curl_close($curl);
    $reste_sms = file_get_contents($url_reste_sms);
    $reste_sms_list = json_decode($reste_sms, true);
    $reste_sms_2 = $reste_sms_list['balance'] / 30;
    echo "<p style='font-size:12pt;font-weigth:500'>Nombre de SMS restants : <span class='label label-success'>" .
      round($reste_sms_2, 0) . "</span></p>";
    ?>

    <div id="us" class="alert alert-danger alert-dismissable" style="display:<?php echo $failedinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <!-- <h4><i class="icon fa fa-ban"></i></h4> -->
      <?php echo $msg; ?>
    </div>
    <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <!-- <h4><i class="icon fa fa-ban"></i></h4> -->
      <?php echo $msg; ?>
    </div>
    <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <!-- <h4><i class="icon fa fa-check"></i> Success!</h4> -->
      <?php echo $msg; ?>
    </div>

  </div>

  <div class="row container-fluid">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-list"></i> Liste des derniers scanners enregistrés par véhicules</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table sakotable table-bordered table-striped dt-responsive">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nom client</th>
                <th>Personne ayant enregistré le client</th>
                <th>Téléphone du client</th>
                <th>Immatriculation</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Scanner mécanique</th>
                <th>Scanner électrique</th>
                <th>Frais de scanner</th>
                <th>Statut reçu scanner</th>
                <th>Statut scanner</th>
                <th>Statut reception</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $results = $wms->getCarScanning($link);
              foreach ($results as $row) {
                // $image = WEB_URL . 'img/no_image.jpg';
                // if(file_exists(ROOT_PATH . '/img/upload/' . $row['usr_image']) && $row['usr_image'] != ''){
                // 	$image = WEB_URL . 'img/upload/' . $row['usr_image'];
                // }
                ?>
                <tr>
                  <td><?php echo $row['id']; ?></td>
                  <td><?php echo $row['c_name']; ?></td>
                  <td><?php echo $row['usr_name']; ?></td>
                  <td><?php echo $row['princ_tel']; ?></td>
                  <td><?php echo $row['imma_vehi_client']; ?></td>
                  <td><?php echo $row['marque_vehi_client']; ?></td>
                  <td><?php echo $row['model_vehi_client']; ?></td>
                  <td><?php echo $row['scanner_mecanique']; ?></td>
                  <td><?php echo $row['scanner_electrique']; ?></td>
                  <td id="frais_scanner_<?php echo $i; ?>"><?php echo $row['frais_scanner']; ?></td>
                  <td><?php
                        if ($row['validation_recu_scanning'] == null) {
                          echo "<span class='label label-default'>Non validé</span> <br/>";
                        } else if ($row['validation_recu_scanning'] == 1) {
                          echo "<span class='label label-success'>validé</span> <br/>";
                        }
                        ?></td>
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
                    <?php if ($row['validation_recu_scanning'] != null) { ?>
                      <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>servcli_panel/recu_paiement_scanner.php?nbr_aleatoire=<?php echo $row['nbr_aleatoire']; ?>&recu_scanning_id=<?php echo $row['id']; ?>" data-original-title="Afficher le reçu de paiement du scanner">Visualiser le reçu de paiement du scanner</a>
                    <?php } ?>
                  </td>
                </tr>
              <?php
                $i++;
              }
              // On retourne la représentation JSON du tableau
              $scanner_data_json = json_encode($results, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
              ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>

  <div class="row container-fluid">
    <div class="col-lg-6 col-md-6 col-sm-6">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-list"></i> Liste des derniers véhicules attribués et diagnostiqués</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table sakotable table-bordered table-striped dt-responsive">
            <thead>
              <tr>
                <th>ID Diagnostic</th>
                <th>Immatriculation du véhicule</th>
                <th>Receptionné par</th>
                <th>Statut attribution</th>
                <th>Attribué à</th>
                <!-- <th>Statut diagnostic</th> -->
                <th>Statut diagnostic mécanique</th>
                <th>Statut diagnostic électrique</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php

              $result = $wms->getAllRecepRepairCarListTen($link);

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
                  <td><?php echo $row['vehi_diag_id']; ?></td>
                  <!-- <td><?php echo $row['car_id']; ?></td> -->
                  <td><?php echo $row['num_matricule']; ?></td>
                  <td><?php echo $row['recep_name']; ?></td>
                  <td><?php
                        if ($row['status_attribution_vehicule'] == null) {
                          echo "<span class='label label-default'>En attente d'attribution</span> <br/>";
                        } else if ($row['status_attribution_vehicule'] == 1) {
                          echo "<span class='label label-success'>Attribué</span> <br/>";
                        }
                        ?></td>
                  <!-- <td><?php echo $row['mech_name']; ?></td> -->
                  <td>
                    <?php if ($row['statut_diagnostic_mecanique'] == 1) {
                        echo $row['mecano_name'] . ' : ' . $row['attribution_mecanicien'];
                      } ?>
                    <?php if ($row['statut_diagnostic_electrique'] == 1) {
                        echo $row['electro_name'] . ' : ' . $row['attribution_electricien'];
                      } ?>
                  </td>
                  <!-- <td><?php
                              if ($row['status_diagnostic_vehicule'] == null) {
                                echo "<span class='label label-default'>En attente de diagnostic</span> <br/>";
                              } else if ($row['status_diagnostic_vehicule'] == 1) {
                                echo "<span class='label label-success'>Diagnostiqué</span> <br/>";
                              }
                              ?>
                                </td> -->
                  <td><?php

                        if (!isset($row['statut_diagnostic_mecanique'])) {
                          echo "";
                        } else if ($row['statut_diagnostic_mecanique'] == null) {
                          echo "<span class='label label-default'>En attente de diagnostic</span> <br/>";
                        } else if ($row['statut_diagnostic_mecanique'] == 1) {
                          echo "<span class='label label-success'>Diagnostic éffectué</span> <br/>";
                        }
                        ?>
                  </td>
                  <td><?php

                        if (!isset($row['statut_diagnostic_electrique'])) {
                          echo "";
                        } else if ($row['statut_diagnostic_electrique'] == null) {
                          echo "<span class='label label-default'>En attente de diagnostic</span> <br/>";
                        } else if ($row['statut_diagnostic_electrique'] == 1) {
                          echo "<span class='label label-success'>Diagnostic éffectué</span> <br/>";
                        }
                        ?>
                  </td>
                  <td>

                    <a class="btn btn-primary" style="background-color:purple;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/pj_car_recep_list.php?car_recep_id=<?php echo $row['car_id']; ?>" data-original-title="Afficher la liste des pièces jointes à la réception du véhicule"><i class="fa fa-paperclip"></i></a>
                    <!-- <a class="btn btn-info" style="background-color:purple;color:#ffffff;" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/repaircar_diagnostic.php?add_car_id=<?php echo $row['add_car_id']; ?>&car_id=<?php echo $row['car_id']; ?>" data-original-title="Créer le formulaire de diagnostic du véhicule"><i class="fa fa-plus"></i></a> -->
                    <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc_gene.php?car_id=<?php echo $row['car_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Fiche de reception du véhicule"><i class="fa fa-file-text-o"></i></a>
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

                      <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['car_id']; ?>').modal('show');" data-original-title="Attribuer le véhicule réceptionné à un mécanicien ou un électricien pour diagnostic"><i class="fa fa-user"></i></a>

                    <?php }

                      // On récupère l'id du diagnostic du véhicule réceptionné à faire réparer 
                      $rowsGetStatutEtatVehiSortie = $wms->getStatutEtatVehiSortie($link, $row['car_id']);

                      if (!empty($rowsGetStatutEtatVehiSortie)) { ?>
                      <a class="btn btn-primary" style="background-color:#021254;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/etat_vehicule_sortie.php?cid=<?php echo $row['car_id']; ?>" data-original-title="Définir l'état du véhicule à la sortie"><i class="fa fa-car"></i></a>
                    <?php } ?>

                    <!-- <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['car_id']; ?>').modal('show');" data-original-title="Attibuer à un mécanicien"><i class="fa fa-eye"></i></a> -->
                    <!-- <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/addcar.php?id=<?php echo $row['car_id']; ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a> -->
                    <!-- <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteCustomer(<?php echo $row['car_id']; ?>);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a> -->
                  </td>
                </tr>
                <div id="nurse_view_<?php echo $row['car_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <a class="close" data-dismiss="modal">×</a>
                        <h3>Formulaire d'attribution du véhicule réceptionné</h3>
                      </div>

                      <form id="avanceSalForm" name="avance_sal" role="form" enctype="multipart/form-data" method="POST" action="../diagnostic/attribution_mecanicien_traitement.php">

                        <div class="modal-body">

                          <div class="form-group">
                            <label for="txtCName"> Sélectionner un mécanicien ou un électricien :</label>
                            <div class="row">
                              <div class="col-md-12">
                                <select required class='form-control' id="mecanicienList" name="mecanicienList">
                                  <option selected value="">--Veuillez saisir ou sélectionner un mécanicien ou un électricien--</option>
                                  <?php
                                    $mecanicien_list = $wms->getAllMechanicsListByTitle($link);
                                    foreach ($mecanicien_list as $mrow) {
                                      // if ($cus_id > 0 && $cus_id == $mrow['customer_id']) {
                                      echo '<option value="' . $mrow['usr_id'] . '">' . $mrow['usr_name'] . ' - ' . $mrow['usr_type'] . '</option>';
                                      // } else {
                                      // echo '<option value="' . $mrow['customer_id'] . '">' . $mrow['c_name'] . '</option>';
                                      // }
                                    }
                                    ?>
                                </select>
                              </div>
                            </div>
                          </div>

                          <input type="hidden" value="<?php echo $row['add_car_id'] ?>" name="car_id" />
                          <input type="hidden" value="<?php echo $row['car_id'] ?>" name="reception_id" />
                          <input type="hidden" value="<?php echo $row['num_matricule'] ?>" name="imma_vehi" />
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                          <button type="submit" class="btn btn-success" id="submit">Valider</button>
                        </div>
                      </form>

                    </div>
                  </div>
                </div>
              <?php }
              ?>
            </tbody>
          </table>
        </div>
        <!-- <div class="box-footer clearfix"><a href="<?php echo WEB_URL; ?>reception/repaircar_reception_list.php" class="btn btn-sm btn-success btn-flat pull-right"><b><i class="fa fa-list"></i> &nbsp;Voir toute la liste</b></a> </div> -->
        <!-- /.box-body -->
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
                <th>Client</th>
                <th>Date reception</th>
                <th>Date exp. assur</th>
                <th>Date exp. vis. tech.</th>
                <th>Statut réparation mécanique</th>
                <th>Statut réparation électrique</th>
                <!-- <th>Action</th> -->
              </tr>
            </thead>
            <tbody>
              <?php

              $result = $wms->getRecepCarListRepar($link);

              foreach ($result as $row) { ?>
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
                  <!-- <td>
                                                  <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#infos_vehicule_modal_<?php echo $row['car_id']; ?>').modal('show');" data-original-title="Envoyer un message au client concernant le statut de réparation de son véhicule"><i class="fa fa-envelope-o"></i></a>
                                                </td> -->
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
                ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <!-- <div class="box-footer clearfix"><a href="<?php echo WEB_URL; ?>cust_panel/cust_repaircar_diagnostic_devis_list.php" class="btn btn-sm btn-success btn-flat pull-right"><b><i class="fa fa-list"></i> &nbsp;Voir toute la liste</b></a> </div> -->
      </div>
    </div>
  </div>

  <div class="row container-fluid">
    <div class="col-lg-6 col-md-6 col-sm-6">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-list"></i> Liste des devis validés par les clients</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table sakotable table-bordered table-striped dt-responsive">
            <thead>
              <tr>
                <th>ID Devis</th>
                <th>Immatriculation</th>
                <th>Client</th>
                <th>Date reception</th>
                <th>Date exp. assur</th>
                <th>Date exp. vis. tech.</th>
                <th>Statut validation du devis mécanique</th>
                <th>Statut validation du devis électrique</th>
                <th>Autorisation réparation mécanique</th>
                <th>Autorisation réparation électrique</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php

              $result = $wms->getAllValidatedDiagnosticDevisByClient($link);

              // var_dump($result);

              foreach ($result as $row) {

                ?>

                <tr>
                  <td><span class="label label-success"><?php echo $row['devis_id']; ?></span></td>
                  <td><?php echo $row['VIN']; ?></td>
                  <td><?php echo $row['c_name']; ?></td>
                  <td><?php echo $row['add_date_recep_vehi']; ?></td>
                  <td><?php echo $row['add_date_assurance']; ?></td>
                  <td><?php echo $row['add_date_visitetech']; ?></td>
                  <td><?php
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
                        ?></td>
                  <td><?php
                        if (!isset($row['statut_autorisation_reparation_mecanique'])) {
                          echo "";
                        } else if ($row['statut_autorisation_reparation_mecanique'] == null) {
                          echo "<span class='label label-default'>En attente d'autorisation</span> <br/>";
                        } else if ($row['statut_autorisation_reparation_mecanique'] == 1) {
                          echo "<span class='label label-success'>Autorisation accordée</span> <br/>";
                        }
                        ?></td>
                  <td><?php
                        if (!isset($row['statut_autorisation_reparation_electrique'])) {
                          echo "";
                        } else if ($row['statut_autorisation_reparation_electrique'] == null) {
                          echo "<span class='label label-default'>En attente d'autorisation</span> <br/>";
                        } else if ($row['statut_autorisation_reparation_electrique'] == 1) {
                          echo "<span class='label label-success'>Autorisation accordée</span> <br/>";
                        }
                        ?></td>
                  <td>
                    <?php
                      if ($row['statut_autorisation_reparation_mecanique'] == null && $row['type_diagnostic'] == 'mécanique') { ?>
                      <!-- <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>cust_panel/cust_repaircar_diagnostic_devis_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&devis_id=<?php echo $row['devis_id']; ?>" data-original-title="Consulter la devis de réparation du véhicule"><i class="fa fa-file-text-o"></i></a> -->
                      <a class="btn btn-info" style="background-color:#0029CE;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/car_debut_reparation_process.php?type_diagnostic=<?php echo $row['type_diagnostic']; ?>&recep_car_id=<?php echo $row['recep_car_id']; ?>&attribution_mecanicien=<?php echo $row['attribution_mecanicien']; ?>&attribution_electricien=<?php echo $row['attribution_electricien']; ?>&admin_ges_tel=<?php echo $row['admin_ges_tel']; ?>&make_name=<?php echo $row['make_name']; ?>&model_name=<?php echo $row['model_name']; ?>&VIN=<?php echo $row['VIN']; ?>&recep_tel=<?php echo $row['recep_tel']; ?>" data-original-title="Autoriser la réparation mécanique du véhicule"><i class="fa fa-car"></i></a>
                    <?php }
                      ?>
                    <?php
                      if ($row['statut_autorisation_reparation_electrique'] == null && $row['type_diagnostic'] == 'électrique') { ?>
                      <!-- <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>cust_panel/cust_repaircar_diagnostic_devis_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&devis_id=<?php echo $row['devis_id']; ?>" data-original-title="Consulter la devis de réparation du véhicule"><i class="fa fa-file-text-o"></i></a> -->
                      <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/car_debut_reparation_process.php?type_diagnostic=<?php echo $row['type_diagnostic']; ?>&recep_car_id=<?php echo $row['recep_car_id']; ?>&attribution_mecanicien=<?php echo $row['attribution_mecanicien']; ?>&attribution_electricien=<?php echo $row['attribution_electricien']; ?>&admin_ges_tel=<?php echo $row['admin_ges_tel']; ?>&make_name=<?php echo $row['make_name']; ?>&model_name=<?php echo $row['model_name']; ?>&VIN=<?php echo $row['VIN']; ?>&recep_tel=<?php echo $row['recep_tel']; ?>" data-original-title="Autoriser la réparation électrique du véhicule"><i class="fa fa-car"></i></a>
                    <?php }
                      ?>
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
    <div class="col-lg-6 col-md-6 col-sm-6">
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
              // $result = $wms->getCarListExpAssurVistech($link);
              // var_dump($result);

              // die();

              foreach ($result as $row) {

                // ENVOI D'ALERTE AUTOMATIQUE
                // VISITE TECHNIQUE
                // if (isset($row['add_date_visitetech'])) {

                //   include('sendAlerteAutoVistech.php');
                // }

                // ASSURANCE
                // if (isset($row['add_date_assurance']) && isset($row['add_date_assurance_fin'])) {

                //   include('sendAlerteAutoAssurance.php');
                // }

                $image = WEB_URL . 'img/no_image.jpg';
                $image_customer = WEB_URL . 'img/no_image.jpg';

                if (file_exists(ROOT_PATH . '/img/upload/' . $row['car_image']) && $row['car_image'] != '') {
                  $image = WEB_URL . 'img/upload/' . $row['car_image']; //car image
                }

                // On récupère les dates de visite technique
                if (isset($row['add_date_visitetech'])) {
                  $dateprochvistech = DateTime::createFromFormat('d/m/Y', $row['add_date_visitetech']);

                  // on calcul la période d'échéance en nombre de jour entre les dates de fin de la visite technique 
                  // et de l'assurance en fonction de la date d'aujourd'hui
                  $diffTodayDateprochvistech = $dateprochvistech->diff(new \DateTime())->format('%R%a');
                  $diffTodayDateprochvistech = (int) $diffTodayDateprochvistech;
                }

                // On récupère les dates d'assurance
                if (isset($row['add_date_assurance']) && isset($row['add_date_assurance_fin'])) {
                  $dateFinAssur = DateTime::createFromFormat('d/m/Y', $row['add_date_assurance_fin']);

                  $diffDateDebutFinAssur = $dateFinAssur->diff(new \DateTime())->format('%R%a');
                  $diffDateDebutFinAssur = (int) $diffDateDebutFinAssur;
                }

                // Si la période d'échéance en nombre de jours de la fin de la visite technique et/ou de l'assurance
                // est dans 14 jours ou moins

                if ((isset($diffDateDebutFinAssur) && $diffDateDebutFinAssur >= -14) || (isset($diffTodayDateprochvistech) && $diffTodayDateprochvistech >= -14)) {

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
                              $diffTodayDateprochvistech = (int) $diffTodayDateprochvistech;

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
                                $diffDateDebutFinAssur = (int) $diffDateDebutFinAssur;

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
                              $diffTodayDateprochvistech = (int) $diffTodayDateprochvistech;

                              if (($diffTodayDateprochvistech >= -14) && ($diffTodayDateprochvistech < 0)) { ?>
                            <a class="btn btn-primary" style="background-color:#FFD700;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>sendRappelAvExpVistechSms.php?remainingDays=<?php echo $diffTodayDateprochvistechStr_2 ?>&mobile_customer=<?php echo $row['princ_tel']; ?>&marque=<?php echo $row['make_name']; ?>&modele=<?php echo $row['model_name']; ?>&imma=<?php echo $row['VIN']; ?>&nom_client=<?php echo $row['c_name']; ?>" data-original-title="Envoyer un SMS de rappel au client concernant le statut de la visite technique du véhicule"><i class="fa fa-bell"></i>
                            <?php } elseif ($diffTodayDateprochvistech >= 0) { ?>
                              <a class="btn btn-primary" style="background-color:#FF4500;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>sendRappelExpVistechSms.php?mobile_customer=<?php echo $row['princ_tel']; ?>&marque=<?php echo $row['make_name']; ?>&modele=<?php echo $row['model_name']; ?>&imma=<?php echo $row['VIN']; ?>&nom_client=<?php echo $row['c_name']; ?>" data-original-title="Envoyer un SMS de rappel au client concernant le statut de la visite technique du véhicule"><i class="fa fa-bell"></i>
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
                                      $diffDateDebutFinAssur = (int) $diffDateDebutFinAssur;

                                      if (($diffDateDebutFinAssur >= -14) && ($diffDateDebutFinAssur < 0)) { ?>
                                <a class="btn btn-primary" style="background-color:#FFD700;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>sendRappelAvExpAssurSms.php?remainingDays=<?php echo $diffDateDebutFinAssurStr_2; ?>&mobile_customer=<?php echo $row['princ_tel']; ?>&marque=<?php echo $row['make_name']; ?>&modele=<?php echo $row['model_name']; ?>&imma=<?php echo $row['VIN']; ?>&nom_client=<?php echo $row['c_name']; ?>" data-original-title="Envoyer un SMS de rappel au client concernant le statut de l'assurance du véhicule"><i class="fa fa-bell"></i>
                                <?php } elseif ($diffDateDebutFinAssur >= 0) { ?>
                                  <a class="btn btn-primary" style="background-color:#FF4500;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>sendRappelExpAssurSms.php?mobile_customer=<?php echo $row['princ_tel']; ?>&marque=<?php echo $row['make_name']; ?>&modele=<?php echo $row['model_name']; ?>&imma=<?php echo $row['VIN']; ?>&nom_client=<?php echo $row['c_name']; ?>" data-original-title="Envoyer un SMS de rappel au client concernant le statut de l'assurance du véhicule"><i class="fa fa-bell"></i>
                              <?php }
                                    }
                                  }
                                  ?>
                    </td>
                  </tr>
              <?php }
                // mysql_close($link);
              }
              ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>

</section>
<!-- /.content -->
<script type="text/javascript">
  // Définition de la locale en français
  numeral.register('locale', 'fr', {
    delimiters: {
      thousands: ' ',
      decimal: ','
    },
    abbreviations: {
      thousand: 'k',
      million: 'm',
      billion: 'b',
      trillion: 't'
    },
    currency: {
      symbol: 'FCFA'
    }
  });

  // Sélection de la locale en français
  numeral.locale('fr');

  // Initialisation des variables
  var frais_scanner = "<?php echo $row['frais_scanner']; ?>";

  // analyse de la chaîne de caractères JSON et 
  // construction de la valeur JavaScript ou l'objet décrit par cette chaîne
  var scanner_data_obj = JSON.parse('<?= $scanner_data_json; ?>');

  // console.log(scanner_data_obj);

  // Déclaration et initialisation de l'objet itérateur
  var iterateur = scanner_data_obj.keys();

  // Déclaration et initialisation de l'indice ou compteur
  var row = iterateur.next().value;

  // Parcours du tableau d'objet
  for (const key of scanner_data_obj) {

    // Conversion en flottant
    key.frais_scanner = parseFloat(key.frais_scanner);

    // console.log(numeral(key.frais_scanner).format('0,0 $'));

    // Affectation des nouvelles valeurs
    $("#frais_scanner_" + row).html(numeral(key.frais_scanner).format('0,0 $'));

    // incrémentation du compteur
    row++;

  }

  // Conversion des variables en flottant
  frais_scanner = parseFloat(frais_scanner);

  // console.log(numeral(frais_scanner).format('0,0 $'));

  // console.log($("#salaire_base_scanner"));

  $("#frais_scanner").html(numeral(frais_scanner).format('0,0 $'));

  $(document).ready(function() {
    setTimeout(function() {
      $("#me").hide(300);
      $("#you").hide(300);
      $("#us").hide(300);
    }, 3000);
  });
</script>
<?php include('footer.php'); ?>