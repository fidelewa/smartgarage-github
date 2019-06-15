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

$result = $wms->getAllRepairCarListByCustomer($link, $_GET['cid']);

// var_dump($result);

// die();

?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> Liste des voitures d'un client </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Liste des voitures d'un client</li>
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
          <h3 class="box-title"><i class="fa fa-list"></i> Liste des voitures du client <?php
                                                                                        if (isset($result) && !empty($result)) {
                                                                                          echo $result[0]['c_name'];
                                                                                        }
                                                                                        ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table sakotable table-bordered table-striped dt-responsive">
            <thead>
              <tr>
                <th>Repair ID</th>
                <th>Image</th>
                <th>Nom de la voiture</th>
                <th>Nom du client</th>
                <!-- <th>Marque</th>
                <th>Modèle</th>
                <th>Année</th> -->
                <th>Chasis No</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // $result = $wms->getAllRepairCarList($link);
              //   $result = $wms->getAllRepairCarListByCustomer($link, $_GET['cid']);

              foreach ($result as $row) {


                $image = WEB_URL . 'img/no_image.jpg';
                // $image_customer = WEB_URL . 'img/no_image.jpg';

                if (file_exists(ROOT_PATH . '/img/upload/' . $row['car_image']) && $row['car_image'] != '') {
                  $image = WEB_URL . 'img/upload/' . $row['car_image']; //car image
                }
                // if (file_exists(ROOT_PATH . '/img/upload/' . $row['customer_image']) && $row['customer_image'] != '') {
                //   $image_customer = WEB_URL . 'img/upload/' . $row['customer_image']; //customer iamge
                // }

                ?>
                <tr>
                  <td><span class="label label-success"><?php echo $row['repair_car_id']; ?></span></td>
                  <td><img class="photo_img_round" style="width:50px;height:50px;" src="<?php echo $image;  ?>" /></td>
                  <td><?php echo $row['car_name']; ?></td>
                  <td><?php echo $row['c_name']; ?></td>
                  <!-- <td><?php echo $row['make_name']; ?></td>
                    <td><?php echo $row['model_name']; ?></td>
                    <td><?php echo $row['year_name']; ?></td> -->
                  <td><span class="label label-danger"><?php echo $row['chasis_no']; ?></span></td>
                  <td>
                    <a class="btn btn-success" style="background-color:gray;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/histo_assur_vistech.php?car_id=<?php echo $row['car_id']; ?>" data-original-title="Voir l'historique des assurances et des visites techniques du véhicule"><i class="fa fa-eye"></i></a>
                    <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['car_id']; ?>').modal('show');" data-original-title="Voir le détail des informations du véhicule"><i class="fa fa-eye"></i></a>
                    <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/addcar.php?id=<?php echo $row['car_id']; ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                    <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteCustomer(<?php echo $row['car_id']; ?>);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                    <div id="nurse_view_<?php echo $row['car_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header orange_header">
                            <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                            <h3 class="modal-title">Repair Détails de la voiture</h3>
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
                                <b>Année :</b> <?php echo $row['year_name']; ?><br />
                                <b>Chasis No :</b> <?php echo $row['chasis_no']; ?><br />
                                <b>Enregistrement No :</b> <?php echo $row['car_reg_no']; ?><br />
                                <b>VIN No :</b> <?php echo $row['VIN']; ?><br />
                                <b>Note :</b> <?php echo $row['note']; ?><br />
                                <b> Date d'Ajout:</b> <?php echo date('d/m/Y h:m:s', strtotime($row['added_date'])); ?><br />
                                <?php

                                // Visite technique (par ans)

                                if (isset($row['add_date_visitetech'])) {

                                  $datetech = DateTime::createFromFormat('d/m/Y', $row['add_date_visitetech']);
                                  if ($datetech instanceof DateTime) {
                                    echo '<b> Date de la dernière visite technique </b> : ' . ($datetech->format('d/m/Y')) . '<br/>';
                                    $dateprochvistech = $datetech->add(new \DateInterval("P1Y")); // La visite technique se fait chaque année
                                    echo '<b> Date de la prochaine visite technique </b> : ' . ($dateprochvistech->format('d/m/Y')) . '<br/>';
                                    $remainingDaysVistech = $dateprochvistech->diff(new \DateTime())->format('j %R%a jours');
                                    echo '<b> Nombre de jours restants avant la prochaine visite technique </b> : ' . $remainingDaysVistech . '<br/>';

                                    // Définition du statut de la visite technique
                                    $diffTodayDateprochvistech = $dateprochvistech->diff(new \DateTime())->format('%R%a');

                                    if ($diffTodayDateprochvistech >= -14) {
                                      echo "<b> Statut de la visite technique </b> : <span class='label label-alert'>
                                      Votre visite technique expire dans" . $remainingDaysVistech . " !</span> <br/>";
                                    } elseif ($diffTodayDateprochvistech >= 0) {
                                      echo "<b> Statut de la visite technique </b> : <span class='label label-alert'>Expirée ! Veuillez repasser la visite technique !</span> <br/>";
                                    } else {
                                      echo "<b> Statut de la visite technique </b> : <span class='label label-success'>En cours de validité</span> <br/>";
                                    }
                                  }
                                }

                                // Assurance (par délai prédéfini)

                                if (isset($row['add_date_assurance']) && isset($row['duree_assurance'])) {

                                  $dateassur = DateTime::createFromFormat('d/m/Y', $row['add_date_assurance']);
                                  if ($dateassur instanceof DateTime) {
                                    echo '<b> Date de la dernière assurance </b> : ' . ($dateassur->format('d/m/Y')) . '<br/>';
                                    $dateprochassur = $dateassur->add(new \DateInterval($row['duree_assurance']));
                                    echo '<b> Date de la prochaine assurance </b> : ' . ($dateprochassur->format('d/m/Y')) . '<br/>';
                                    $remainingDaysAssur = $dateprochassur->diff(new \DateTime())->format('j %R%a jours');
                                    echo '<b> Nombre de jours restants avant la prochaine assurance </b> : ' . $remainingDaysAssur . '<br/>';

                                    // Définition du statut de l'assurance
                                    $diffTodayDateprochassur = $dateprochassur->diff(new \DateTime())->format('%R%a');

                                    if ($diffTodayDateprochassur >= -14) {
                                      echo "<b> Statut de l'assurance </b> : <span class='label label-alert'>
                                      Votre assurance expire dans" . $remainingDaysAssur . " !</span> <br/>";
                                    } elseif ($diffTodayDateprochassur >= 0) {
                                      echo "<b> Statut de l'assurance </b> : <span class='label label-alert'>Expirée ! Veuillez renouveler votre assurance !</span> <br/>";
                                    } else {
                                      echo "<b> Statut de l'assurance </b> : <span class='label label-success'>En cours de validité</span> <br/>";
                                    }
                                  }
                                }

                                // Contrôle technique (par délai prédéfini)

                                if (isset($row['add_date_ctr_tech']) && isset($row['delai_ctr_tech'])) {

                                  $datectrtech = DateTime::createFromFormat('d/m/Y', $row['add_date_ctr_tech']);
                                  if ($datectrtech instanceof DateTime) {
                                    echo '<b> Date du dernier contrôle technique </b> : ' . ($datectrtech->format('d/m/Y')) . '<br/>';

                                    $dateprochctrtech = $datectrtech->add(new \DateInterval($row['delai_ctr_tech']));
                                    echo '<b> Date du prochain contrôle technique </b> : ' . ($dateprochctrtech->format('d/m/Y')) . '<br/>';
                                    $remainingDaysCtrtech = $dateprochctrtech->diff(new \DateTime())->format('j %R%a jours');
                                    echo '<b> Nombre de jours restants avant le prochain contrôle technique </b> : ' . $remainingDaysCtrtech . '<br/>';

                                    // Définition du statut du contrôle technique
                                    $diffTodayDateprochctrtech = $dateprochctrtech->diff(new \DateTime())->format('%R%a');

                                    if ($diffTodayDateprochctrtech >= -14) {
                                      echo "<b> Statut du contrôle technique </b> : <span class='label label-alert'>
                                      Votre contrôle technique expire dans" . $remainingDaysCtrtech . " !</span> <br/>";
                                    } elseif ($diffTodayDateprochctrtech >= 0) {
                                      echo "<b> Statut du contrôle technique </b> : <span class='label label-alert'>Expirée ! Veuillez refaire le contrôle technique !</span> <br/>";
                                    } else {
                                      echo "<b> Statut du contrôle technique </b> : <span class='label label-success'>En cours de validité</span> <br/>";
                                    }
                                  }
                                }

                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                        <!-- <div class="modal-content">
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
                        </div> -->
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