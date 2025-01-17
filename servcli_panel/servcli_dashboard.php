<?php include('../header.php'); ?>
<?php

// var_dump($_SESSION);
$i = 0;

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
      <div align="right" style="margin-bottom:1%;">

        <!-- <a class="btn btn-success" style="background-color:orange;color:#ffffff;" data-toggle="tooltip" href="javascript:;" onClick="$('#infos_car_client_modal').modal('show');" data-original-title="Enregistrement du véhicule et du scanner">Délivrer un reçu</a> -->
        <a class="btn btn-success" style="background-color:orange;color:#ffffff;" data-toggle="tooltip" href="javascript:;" onClick="$('#infos_car_client_modal').modal('show');$('.espace_code_gratuite').hide()" data-original-title="Enregistrement du véhicule et du scanner">Délivrer un reçu</a>
        <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>customer/addcustomer.php" data-original-title="Enregistrer un nouveau client">Ajouter un nouveau client</a>
        <!-- <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a> -->
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title"><i class="fa fa-list"></i> Liste des derniers véhicules enregistrés pour scanner</h3>
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
                      <!-- <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>compta_panel/recu_paiement_scanner.php?nbr_aleatoire=<?php echo $row['nbr_aleatoire']; ?>" data-original-title="Afficher le reçu de paiement du scanner">Imprimer reçu de paiement du scanner</a> -->
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
                  <!-- <th>Date reception</th> -->
                  <th>Date exp. assur</th>
                  <th>Date exp. vis. tech.</th>
                  <th>Statut validation devis mécanique</th>
                  <th>Statut validation devis électrique</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php

                $result = $wms->getRepairCarDiagnosticDevisClients($link);

                foreach ($result as $row) {

                  ?>

                  <tr>
                    <td><span class="label label-success"><?php echo $row['devis_id']; ?></span></td>
                    <td><?php echo $row['VIN']; ?></td>
                    <td><?php echo $row['c_name']; ?></td>
                    <!-- <td><?php echo $row['add_date_recep_vehi']; ?></td> -->
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
                    <td>
                      <!-- <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_diagnostic_devis_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>" data-original-title="Consulter la devis de réparation du véhicule"><i class="fa fa-file-text-o"></i></a> -->
                      <?php if ($row['type_diagnostic'] == "électrique") { ?>
                        <!-- <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>cust_panel/cust_repaircar_diagnostic_devis_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&devis_id=<?php echo $row['devis_id']; ?>" data-original-title="Consulter le devis du diagnostic électrique du véhicule"><i class="fa fa-file-text-o"></i></a> -->
                        <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_diagnostic_devis_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&devis_id=<?php echo $row['devis_id']; ?>" data-original-title="Consulter le devis du diagnostic électrique du véhicule"><i class="fa fa-file-text-o"></i></a>
                        <?php
                            if ($row['statut_validation_devis_electrique'] == null) { ?>
                          <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>cust_panel/devis_client_validation.php?type_diagnostic=<?php echo $row['type_diagnostic']; ?>&vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&devis_id=<?php echo $row['devis_id']; ?>&nom_client=<?php echo $row['c_name']; ?>" data-original-title="valider le devis du diagnostic électrique"><i class="fa fa-check"></i></a>
                      <?php }
                        } ?>
                      <?php if ($row['type_diagnostic'] == "mécanique") { ?>
                        <!-- <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>cust_panel/cust_repaircar_diagnostic_devis_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&devis_id=<?php echo $row['devis_id']; ?>" data-original-title="Consulter le devis du diagnostic mécanique du véhicule"><i class="fa fa-file-text-o"></i></a> -->
                        <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_diagnostic_devis_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&devis_id=<?php echo $row['devis_id']; ?>" data-original-title="Consulter le devis du diagnostic mécanique du véhicule"><i class="fa fa-file-text-o"></i></a>
                        <?php
                            if ($row['statut_validation_devis_mecanique'] == null) { ?>
                          <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>cust_panel/devis_client_validation.php?type_diagnostic=<?php echo $row['type_diagnostic']; ?>&vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&devis_id=<?php echo $row['devis_id']; ?>&nom_client=<?php echo $row['c_name']; ?>" data-original-title="valider le devis du diagnostic mécanique"><i class="fa fa-check"></i></a>
                      <?php }
                        } ?>
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

      <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="box box-success">
          <div class="box-header">
            <!-- <h3 class="box-title"><i class="fa fa-list"></i> Voiture de réparation List</h3> -->
            <h3 class="box-title"><i class="fa fa-list"></i> Liste des derniers clients enregistrés</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table class="table sakotable table-bordered table-striped dt-responsive">
              <thead>
                <tr>
                  <th>Image</th>
                  <th>Nom</th>
                  <th>Email</th>
                  <th>Téléphone</th>
                  <!-- <th>Action</th> -->
                </tr>
              </thead>
              <tbody>
                <?php

                // $result = $wms->getAllRecepRepairCarListByRecepId($link, $_SESSION['objServiceClient']['user_id']);
                $result = $wms->getAllCustomerListByServcliIdTen($link);

                // var_dump($result);

                foreach ($result as $row) {
                  $image = WEB_URL . 'img/no_image.jpg';
                  if (file_exists(ROOT_PATH . '/img/upload/' . $row['image']) && $row['image'] != '') {
                    $image = WEB_URL . 'img/upload/' . $row['image'];
                  }
                  ?>

                  <tr>
                    <td><img class="photo_img_round" style="width:50px;height:50px;" src="<?php echo $image;  ?>" /></td>
                    <td><?php echo $row['c_name']; ?></td>
                    <td><?php echo $row['c_email']; ?></td>
                    <td><?php echo $row['princ_tel']; ?></td>
                    <!-- <td> -->
                    <!-- <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#infos_vehicule_modal_<?php echo $row['customer_id']; ?>').modal('show');" data-original-title="Enregistrement du véhicule et du scanner"><i class="fa fa-car"></i></a> -->
                    <!-- <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#infos_vehicule_modal_<?php echo $row['customer_id']; ?>').modal('show');" data-original-title="Enregistrement du véhicule et du scanner">Délivrer un reçu</a> -->
                    <!-- </td> -->
                  </tr>
                  <div id="infos_car_client_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <a class="close" data-dismiss="modal">×</a>
                          <h3>Formulaire d'enregistrement du véhicule et du scanner</h3>
                        </div>
                        <form id="scannerVehiForm" name="devis_vehi" role="form" method="POST" action="../repaircar/vehicule_scanning_traitement.php">
                          <div class="modal-body">

                            <fieldset>
                              <legend>Informations du véhicule</legend>
                              <div class="form-group">
                                <label> Immatriculation du véhicule :</label>
                                <!-- <input required type="text" name="immat" id="immat" class="form-control" placeholder="Saisissez l'immatriculation du véhicule"> -->
                                <input required onchange="loadMarqueModeleVoiture_2(this.value);" type="text" name="immat" id="immat" class="form-control" placeholder="Saisissez l'immatriculation du véhicule">
                              </div>

                              <!-- <div id="marque_modele_box"> -->
                              <div class="form-group">
                                <label>Marque du véhicule :</label>
                                <input require type="text" class='form-control' name="ddlMake" id="ddlMake" placeholder="Saisissez la marque du véhicule">
                              </div>

                              <div class="form-group">
                                <label>Modèle du véhicule :</label>
                                <input required type="text" class='form-control' name="ddlModel" id="ddl_model" placeholder="Saisissez le modèle du véhicule">
                              </div>

                              <div class="form-group" style="margin-bottom:50px">
                                <label>Client :</label><span style="color:red">Le nom du client à saisir doit être au format "nom_client//numero_téléphone". Exemple "roger//0101010101"</span>
                                <div class="row col-md-12">
                                  <div class="col-md-11" style="padding-left:0px">
                                    <input onkeyup="verifClient(this.value);" type="text" class='form-control' name="ddlCustomerList" id="ddlCustomerList" placeholder="Saisissez le nom du client s'il existe déja au format nom//numéro de téléphone" onfocus=""><span id="clientbox"></span>
                                  </div>
                                  <div class="col-md-1" id="client">
                                    <a class="btn btn-success" data-toggle="modal" href="<?php echo WEB_URL; ?>customer/addcustomer.php" data-original-title="Ajouter un nouveau client"><i class="fa fa-plus"></i></a>
                                  </div>
                                </div>
                              </div>

                              <!-- <div class="form-group">
                            <label for="fname">Client :</label>
                            <select class="form-control" name="cli" id="cli">
                              <option value=''>--Sélectionnez un client--</option>
                              <?php
                                $result = $wms->getAllCustomerList($link);
                                foreach ($result as $row) {
                                  echo "<option value='" . $row['customer_id'] . "'>" . $row['c_name'] . " - " . $row['princ_tel'] . "</option>";
                                }
                                ?>
                            </select>
                          </div> -->
                              <!-- </div> -->
                            </fieldset>

                            <fieldset>
                              <legend>Etat du véhicule à l'arrivée</legend>
                              <div class="form-group col-md-12">
                                <div class="col-md-5 form-check" style="padding-left:0px;">
                                  <input type="radio" id="etat_vehi_arrive_conduit" name="etat_vehi_arrive" value="conduit" required>
                                  <label class="form-check-label" for="scanner_electrique">Conduit</label>
                                </div>
                                <div class="col-md-5 form-check" style="padding-left:0px;">
                                  <input type="radio" id="etat_vehi_arrive_remorq" name="etat_vehi_arrive" value="remorque" required>
                                  <label class="form-check-label" for="scanner_mecanique">Remorqué</label>
                                </div>
                              </div>
                            </fieldset>

                            <fieldset>
                              <!-- <legend>Informations du scanner</legend> -->
                              <legend>Motifs d'enregistrement</legend>
                              <div class="form-group col-md-12">
                                <label for="scanner" class="col-md-2 col-form-label" style="padding-left:0px;">
                                  Motif :</label>
                                <div class="col-md-4 form-check" style="padding-left:0px;">
                                  <input class="form-check-input" type="checkbox" name="scanner_electrique" id="scanner_electrique" value="scanner electrique">
                                  <label class="form-check-label" for="scanner_electrique">Scanner électrique</label>
                                </div>
                                <div class="col-md-4 form-check" style="padding-left:0px;">
                                  <input class="form-check-input" type="checkbox" name="scanner_mecanique" id="scanner_mecanique" value="scanner mecanique">
                                  <label class="form-check-label" for="scanner_mecanique">Scanner mécanique</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                  <input class="form-check-input" type="checkbox" name="autres_motifs" id="autres_motifs" value="Autres motifs">
                                  <label class="form-check-label" for="scanner_mecanique">Autres</label>
                                </div>
                              </div>

                              <div class="form-group">
                                <!-- <label>Montant des frais du scanner :</label>
                                  <input required type="number" maxlength="6" class='form-control montant_scanner' name="frais_scanner" id="frais_scanner" placeholder="Saisissez le montant du scanner"> -->
                                <div class="row">
                                  <div class="col-md-12">
                                    <label>Montant des frais du scanner :</label>
                                    <input required type="number" maxlength="6" class='form-control montant_scanner' name="frais_scanner" id="frais_scanner" placeholder="Saisissez le montant du scanner">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-12">
                                    <label>Avance :</label>
                                    <input type="number" maxlength="6" class='form-control' name="avance_scanner" id="avance_scanner" placeholder="Saisissez le montant de l'avance du scanner">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-12">
                                    <label>Reste à payer :</label>
                                    <input type="number" maxlength="6" class='form-control' name="reste_payer_scanner" id="reste_payer_scanner" placeholder="Saisissez le reste à payer du scanner">
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="row">
                                  <div class="col-md-6">
                                    <input type="button" class='form-control btn btn-success' name="envoi_gratuite" id="envoi_gratuite" value="Envoi demande de gratuité">
                                  </div>
                                  <div class="col-md-6">
                                    <input type="button" class='form-control btn btn-info' name="btn_code_gratuite" id="btn_code_gratuite" value="Code gratuité">
                                  </div>
                                </div>
                              </div>
                              <div class="form-group espace_code_gratuite">
                                <div class="row">
                                  <div class="col-md-12">
                                    <label>Code pour la gratuité :</label>
                                    <input type="password" class='form-control code_gratuite' name="code_gratuite" id="code_gratuite" placeholder="Saisissez le code de gratuité">
                                  </div>
                                </div>

                              </div>

                            </fieldset>

                            <input type="hidden" value="<?php echo $row['customer_id']; ?>" name="customer_id" />

                            <input type="hidden" value="" name="model_hd" id="model_hd" />
                            <input type="hidden" value="" name="marque_hd" id="marque_hd" />
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-success" id="submit">Valider</button>
                          </div>

                        </form>
                      </div>
                    </div>
                  </div>
                <?php
                }
                mysql_close($link); ?>
              </tbody>
            </table>
            <div class="box-footer clearfix"><a href="<?php echo WEB_URL; ?>customer/customerlist.php" class="btn btn-sm btn-success btn-flat pull-right"><b><i class="fa fa-list"></i> &nbsp;Voir toute la liste</b></a> </div>
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

  // Après la saisie des frais du scanner
  $("#frais_scanner").change(function() {

    // On récupère la valeur des frais de scanner
    // Si le montant a été saisi
    if ($("#frais_scanner").val() != '') {

      frais_scanner = $("#frais_scanner").val();

      // On vérifie que les cases à cocher sont bien checké sinon, on déclenche une alerte
      if (elt_scanner_electrique.checked == false && elt_scanner_mecanique.checked == false) {
        alert("Veuillez cocher au moin un seul type de scanner SVP !!!");
      }
    }

  });

  $(document).ready(function() {
    $("#scannerVehiForm").submit(function(event) {
      // On récupère la valeur des frais de scanner
      // Si le montant a été saisi
      if ($("#frais_scanner").val() != '') {

        frais_scanner = $("#frais_scanner").val();

        // On vérifie que les cases à cocher sont bien checké sinon, on déclenche une alerte
        if (elt_scanner_electrique.checked == false && elt_scanner_mecanique.checked == false) {
          alert("Veuillez cocher au moin un seul type de scanner SVP !!!");
        }
      } else {
        alert("Veuillez saisir le montant des frais de scanner SVP !!!");
      }
    });

  });


  $(document).ready(function() {
    $('.espace_code_gratuite').hide();
    $('#btn_code_gratuite').click(function() {
      $('.espace_code_gratuite').show();
    });
    $('#envoi_gratuite').click(function() {
      $var_1 = $('#immat').val()
      $var_2 = $('#ddlMake').val()
      $var_3 = $('#ddl_model').val()
      $var_4 = $('#ddlCustomerList').val()
      $var_5 = $('#frais_scanner').val()
      $var_6 = $('#scanner_electrique').val()
      $var_7 = $('#scanner_mecanique').val()
      if ((($var_5 == 'undefined') || ($var_5 == 0)) && ($var_1 !== undefined) && ($var_3 != undefined) && ($var_4 != undefined) && ($var_6 != undefined) && ($var_7 != undefined) && ($var_2 != undefined)) {
        $.ajax({
          url: '../ajax/ajaxSendsmsToAdminCodFree.php',
          method: 'POST',
          data: {
            'montant': $var_5,
            'immat': $var_1,
            'ddlMake': $var_2,
            'ddl_model': $var_3,
            'ddlCustomerList': $var_4,
            'scanner_electrique': $var_6,
            'scanner_mecanique': $var_7,
          },
          dataType: 'JSON',
          success: function(data) {
            alert(data);
            if (data) {
              alert('Message envoyé');
            } else {
              alert("Message non envoyé");
            }
          }
        });
      }
    });
  });
</script>
<?php include('../footer.php'); ?>