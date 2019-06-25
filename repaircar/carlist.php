<?php include('../header.php') ?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
  $wms->deleteRepairCar($link, $_GET['id']);
  $delinfo = 'block';
  $msg = "Deleted Voiture de réparation information successfully";
}
if (isset($_GET['m']) && $_GET['m'] == 'add') {
  $addinfo = 'block';
  $msg = "Added Voiture de réparation Information Successfully";
}
if (isset($_GET['m']) && $_GET['m'] == 'up') {
  $addinfo = 'block';
  $msg = "Updated Voiture de réparation Information Successfully";
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> Liste des voitures des clients</h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Liste des voitures des clients</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Full Width boxes (Stat box) -->
  <div class="row">
    <div class="col-xs-12">
      <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
        <h4><i class="icon fa fa-ban"></i> Deleted!</h4>
        <?php echo $msg; ?>
      </div>
      <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        <?php echo $msg; ?>
      </div>
      <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/addcar.php" data-original-title="Add Voiture de réparation"><i class="fa fa-plus"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a> </div>
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-list"></i> Liste des voitures des clients</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table sakotable table-bordered table-striped dt-responsive">
            <thead>
              <tr>
                <th>Immatriculation</th>
                <th>Image</th>
                <th>Nom du client</th>
                <th>Statut visite technique</th>
                <th>Statut assurance</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $result = $wms->getAllRepairCarList($link);

              // var_dump($result);
              // die();

              foreach ($result as $row) {


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
                          <a class="btn btn-primary" style="background-color:#FFD700;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>sendRappelAvExpVistechSms.php?remainingDays=<?php echo $diffTodayDateprochvistechStr_2 ?>&=mobile_customer=<?php echo $row['princ_tel']; ?>&marque=<?php echo $row['make_name']; ?>&modele=<?php echo $row['model_name']; ?>&imma=<?php echo $row['VIN']; ?>&nom_client=<?php echo $row['c_name']; ?>" data-original-title="Envoyer un rappel au client par SMS concernant le statut de la visite technique du véhicule"><i class="fa fa-bell"></i>
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
                              <a class="btn btn-primary" style="background-color:#FFD700;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>sendRappelAvExpAssurSms.php?remainingDays=<?php echo $diffDateDebutFinAssurStr_2; ?>&=mobile_customer=<?php echo $row['princ_tel']; ?>&marque=<?php echo $row['make_name']; ?>&modele=<?php echo $row['model_name']; ?>&imma=<?php echo $row['VIN']; ?>&nom_client=<?php echo $row['c_name']; ?>" data-original-title="Envoyer un rappel au client par SMS concernant le statut de l'assurance du véhicule"><i class="fa fa-bell"></i>
                              <?php } elseif ($diffDateDebutFinAssur >= 0) { ?>
                                <a class="btn btn-primary" style="background-color:#FF4500;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>sendRappelExpAssurSms.php?mobile_customer=<?php echo $row['princ_tel']; ?>&marque=<?php echo $row['make_name']; ?>&modele=<?php echo $row['model_name']; ?>&imma=<?php echo $row['VIN']; ?>&nom_client=<?php echo $row['c_name']; ?>" data-original-title="Envoyer un rappel au client par SMS concernant le statut de l'assurance du véhicule"><i class="fa fa-bell"></i>
                                <?php }
                            }
                          }
                          ?>
                            <a class="btn btn-success" style="background-color:gray;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/histo_assur_vistech.php?car_id=<?php echo $row['car_id']; ?>" data-original-title="Voir l'historique des assurances et des visites techniques du véhicule"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['car_id']; ?>').modal('show');" data-original-title="Voir le détail des informations du véhicule"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/addcar.php?id=<?php echo $row['car_id']; ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteCustomer(<?php echo $row['car_id']; ?>);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                            <div id="nurse_view_<?php echo $row['car_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header orange_header">
                                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                                    <h3 class="modal-title">Détails des informations de la voiture</h3>
                                  </div>
                                  <div class="modal-body model_view" align="center">&nbsp;
                                    <div><img class="photo_img_round" style="width:100px;height:100px;" src="<?php echo $image;  ?>" /></div>
                                    <div class="model_title"><?php echo $row['car_name']; ?></div>
                                    <div style="color:#fff;font-size:15px;font-weight:bold;">Facture No: <?php echo $row['repair_car_id']; ?></div>
                                  </div>
                                  <div class="modal-body">
                                    <h3 style="text-decoration:underline;">Détails de la voiture Information</h3>
                                    <div class="row">
                                      <div class="col-xs-12">
                                        <b>Nom de la voiture :</b> <?php echo $row['car_name']; ?><br />
                                        <b>Réparation automobile ID :</b> <?php echo $row['repair_car_id']; ?><br />
                                        <b>Marque voiture :</b> <?php echo $row['make_name']; ?><br />
                                        <b>Modèle de voiture:</b> <?php echo $row['model_name']; ?><br />
                                        <b>Année :</b> <?php echo $row['year']; ?><br />
                                        <b>Chasis No :</b> <?php echo $row['chasis_no']; ?><br />
                                        <!-- <b>Enregistrement No :</b> <?php echo $row['car_reg_no']; ?><br /> -->
                                        <b>VIN No :</b> <?php echo $row['VIN']; ?><br />
                                        <b>Note :</b> <?php echo $row['note']; ?><br />
                                        <b> Date d'Ajout:</b> <?php echo date('d/m/Y h:m:s', strtotime($row['added_date'])); ?><br />
                                        <?php

                                        // Visite technique (par ans)

                                        if (isset($row['add_date_visitetech'])) {

                                          $dateprochvistech = DateTime::createFromFormat('d/m/Y', $row['add_date_visitetech']);
                                          if ($dateprochvistech instanceof DateTime) {
                                            echo '<b> Date de la prochaine visite technique </b> : ' . ($dateprochvistech->format('d/m/Y')) . '<br/>';
                                            // $dateprochvistech = $datetech->add(new \DateInterval("P1Y")); // La visite technique se fait chaque année
                                            // echo '<b> Date de la prochaine visite technique </b> : ' . ($dateprochvistech->format('d/m/Y')) . '<br/>';
                                            $remainingDaysVistech = $dateprochvistech->diff(new \DateTime())->format('j %R%a jours');
                                            echo '<b> Nombre de jours restants avant la prochaine visite technique </b> : ' . $remainingDaysVistech . '<br/>';

                                            // Définition du statut de la visite technique
                                            $diffTodayDateprochvistech = $dateprochvistech->diff(new \DateTime())->format('%R%a');

                                            // conversion en entier
                                            $diffTodayDateprochvistech = (int)$diffTodayDateprochvistech;

                                            if (($diffTodayDateprochvistech >= -14) && ($diffTodayDateprochvistech < 0)) {
                                              echo "<b> Statut de la visite technique </b> : <span class='label label-warning'>
                                      Votre visite technique expire dans" . $remainingDaysVistech . " !</span><br/>";
                                            } elseif ($diffTodayDateprochvistech >= 0) {
                                              echo "<b> Statut de la visite technique </b> : <span class='label label-danger'>Expirée ! Veuillez repasser la visite technique !</span><br/>";
                                            } else {
                                              echo "<b> Statut de la visite technique </b> : <span class='label label-success'>En cours de validité </span><br/>";
                                            }
                                          }
                                        }

                                        // Assurance (par délai prédéfini)

                                        // Traitement de l'assurance
                                        if (isset($row['add_date_assurance']) && isset($row['add_date_assurance_fin'])) {
                                          // Si la date de debut d'assurance et de fin d'assurance existe

                                          // On crée un objet Datetime à partir du format chaine de caractère de la date de début d'assurance
                                          // et de la date de fin d'assurance
                                          $dateDebutAssur_2 = DateTime::createFromFormat('d/m/Y', $row['add_date_assurance']);
                                          $dateFinAssur_2 = DateTime::createFromFormat('d/m/Y', $row['add_date_assurance_fin']);

                                          if (($dateDebutAssur_2 instanceof DateTime) && ($dateFinAssur_2 instanceof DateTime)) {

                                            echo "<b> Date du debut de l'assurance </b> : " . ($dateDebutAssur_2->format('d/m/Y')) . "<br/>";

                                            echo "<b> Date de la fin de l'assurance </b> : " . ($dateFinAssur_2->format('d/m/Y')) . "<br/>";

                                            $remainingDaysAssur = $dateFinAssur->diff(new \DateTime())->format('j %R%a jours');
                                            echo "<b> Nombre de jours restants avant la fin de l'assurance </b> : " . $remainingDaysAssur . "<br/>";

                                            // On détermine le nombre de jours restants avant la fin de l'assurance à partir de la date de début de l'assurance
                                            $diffDateDebutFinAssurStr_2 = $dateFinAssur_2->diff($dateDebutAssur_2)->format('%a jours');

                                            // On converti ce nombre de jour en entier
                                            $diffDateDebutFinAssur_2 = (int)$diffDateDebutFinAssurStr_2;

                                            if (($diffDateDebutFinAssur_2 >= -14) && ($diffDateDebutFinAssur_2 < 0)) {
                                              echo "<b> Statut de l'assurance </b> : <span class='label label-warning'>
                                      Votre assurance expire dans" . $remainingDaysAssur . " !</span> <br/>";
                                            } elseif ($diffDateDebutFinAssur_2 >= 0) {

                                              echo "<b> Statut de l'assurance </b> : <span class='label label-danger'>Expirée ! Veuillez renouveler votre assurance !</span>";
                                            } else {
                                              echo "<b> Statut de l'assurance </b> : <span class='label label-success'>En cours de validité</span> <br/>";
                                            }
                                          }
                                        }

                                        ?>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- /.modal-content -->
                                <div class="modal-content">
                                  <div class="modal-header orange_header">
                                    <h3 class="modal-title">Détails du client</h3>
                                  </div>
                                  <div class="modal-body model_view" align="center">&nbsp;
                                    <div><img class="photo_img_round" style="width:100px;height:100px;" src="<?php echo $image_customer;  ?>" /></div>
                                    <div class="model_title"><?php echo $row['c_name']; ?></div>
                                  </div>
                                  <div class="modal-body">
                                    <h3 style="text-decoration:underline;">Détails du client Information</h3>
                                    <div class="row">
                                      <div class="col-xs-12">
                                        <b>Nom du client :</b> <?php echo $row['c_name']; ?><br />
                                        <b> Email Client :</b> <?php echo $row['c_email']; ?><br />
                                        <b> Telephone Client :</b> <?php echo $row['c_mobile']; ?><br />

                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- /.modal-content -->
                              </div>
                            </div>
                  </td>
                </tr>
              <?php }
            mysql_close($link); ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  <script type="text/javascript">
    function deleteCustomer(Id) {
      var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer cette voiture ?");
      if (iAnswer) {
        window.location = '<?php echo WEB_URL; ?>repaircar/carlist.php?id=' + Id;
      }
    }

    $(document).ready(function() {
      setTimeout(function() {
        $("#me").hide(300);
        $("#you").hide(300);
      }, 3000);
    });
  </script>
  <?php include('../footer.php'); ?>