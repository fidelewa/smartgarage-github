<?php include('../header.php') ?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
  $wms->deleteCustomer($link, $_GET['id']);
  $delinfo = 'block';
}
if (isset($_GET['m']) && $_GET['m'] == 'add') {
  $addinfo = 'block';
  $msg = "Ajout d'informations client avec succès";
}
if (isset($_GET['m']) && $_GET['m'] == 'up') {
  $addinfo = 'block';
  $msg = "Informations client mises à jour avec succès";
}

// Création de l'identifiant de réparation
$invoice_id = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <?php if ($_SESSION['login_type'] == 'service client') { ?>
  <h1><i class="fa fa-list"></i> Liste des clients enregistrés par <?php echo "<b>" . $_SESSION['objServiceClient']['name'] . "</b>" ?> </h1>
  <?php   } else { ?>
  <h1><i class="fa fa-list"></i> client - Liste des clients </h1>
  <?php } ?>

  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Client Liste</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Full Width boxes (Stat box) -->
  <div class="row">
    <div class="col-xs-12">
      <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
        <h4><i class="icon fa fa-ban"></i> Supprimé!</h4>
        Client supprimé avec succès.
      </div>
      <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
        <h4><i class="icon fa fa-check"></i> Réussi!</h4>
        <?php echo $msg; ?>
      </div>
      <!-- <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>customer/addcustomer.php" data-original-title="Add Customer"><i class="fa fa-plus"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a> </div> -->
      <div class="box box-success">
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table sakotable table-bordered table-striped dt-responsive">
            <thead>
              <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <?php if ($_SESSION['login_type'] != 'service client') { ?>
                <th>Action</th>
                <?php }  ?>
              </tr>
            </thead>
            <tbody>
              <?php

              if ($_SESSION['login_type'] == 'service client') {
                $result = $wms->getAllCustomerListByServcliId($link, $_SESSION['objServiceClient']['user_id']);
              } else {
                $result = $wms->getAllCustomerList($link);
              }

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
                <!-- <td><?php echo $row['c_home_tel']; ?></td>
                                            <td><?php echo $row['c_work_tel']; ?></td> -->
                <td><?php echo $row['princ_tel']; ?></td>

                <?php if ($_SESSION['login_type'] == 'admin') { ?>
                <td>
                  <a class="btn btn-primary" style="background-color:purple;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>customer/pj_client_list.php?cid=<?php echo $row['customer_id']; ?>" data-original-title="Afficher la liste des pièces jointes au client"><i class="fa fa-paperclip"></i></a>
                  <a class="btn btn-primary" style="background-color:gray;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>customer/recep_vehi_client_list.php?cid=<?php echo $row['customer_id']; ?>" data-original-title="Afficher la liste des véhicules appartenant au client"><i class="fa fa-car"></i></a>
                  <!-- <a class="btn btn-primary" style="background-color:black;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>customer/vehi_client_list.php?cid=<?php echo $row['customer_id']; ?>" data-original-title="Afficher la liste des véhicules du client"><i class="fa fa-car"></i></a> -->
                  <!-- <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/addcar.php?cid=<?php echo $row['customer_id']; ?>" data-original-title="Ajouter votre voiture"><i class="fa fa-car"></i></a>  -->
                  <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['customer_id']; ?>').modal('show');" data-original-title="Afficher le détails des informations du client"><i class="fa fa-eye"></i></a>
                  <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>customer/addcustomer.php?id=<?php echo $row['customer_id']; ?>" data-original-title="Modifier"><i class="fa fa-pencil"></i></a>
                  <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteCustomer(<?php echo $row['customer_id']; ?>);" href="javascript:;" data-original-title="Supprimer"><i class="fa fa-trash-o"></i></a>
                  <div id="nurse_view_<?php echo $row['customer_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header orange_header">
                          <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                          <h3 class="modal-title">Détails du client</h3>
                        </div>
                        <div class="modal-body model_view" align="center">&nbsp;
                          <div><img class="photo_img_round" style="width:100px;height:100px;" src="<?php echo $image;  ?>" /></div>
                          <div class="model_title"><?php echo $row['c_name']; ?></div>
                        </div>
                        <div class="modal-body">
                          <h3 style="text-decoration:underline;"></h3>
                          <div class="row">
                            <div class="col-xs-12"> <b>Nom du client :</b> <?php echo $row['c_name']; ?><br />
                              <b>Adresse e-mail :</b> <?php echo $row['c_email']; ?><br />
                              <b>Adresse géographique :</b> <?php echo $row['c_address']; ?><br />
                              <b>Téléphone :</b> <?php echo $row['princ_tel']; ?><br />
                              <b>Type de client :</b> <?php echo $row['type_client']; ?><br />
                              <b>Civilité du client :</b> <?php echo $row['civilite_client']; ?><br />
                            </div>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                    </div>
                </td>
                <?php }  ?>
                <?php if ($_SESSION['login_type'] == 'service client') { ?>
                <!-- <td>
                      <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#infos_vehicule_modal_<?php echo $row['customer_id']; ?>').modal('show');" data-original-title="Enregistrement du véhicule et du scanner">Délivrer un reçu</a>
                    </td> -->
                <?php }  ?>

              </tr>
              <div id="infos_vehicule_modal_<?php echo $row['customer_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <a class="close" data-dismiss="modal">×</a>
                      <h3>Formulaire d'enregistrement du véhicule et du scanner</h3>
                    </div>
                    <form id="devisVehiForm" name="devis_vehi" role="form" enctype="multipart/form-data" method="POST" action="../repaircar/vehicule_scanning_traitement.php">
                      <div class="modal-body">

                        <!-- <fieldset>
                            <legend>Informations du véhicule</legend>
                            <div class="form-group">
                              <label> Immatriculation du véhicule :</label>
                              
                              <input maxlength="15" type="text" name="immat" id="immat" class="form-control" placeholder="Saisissez l'immatriculation du véhicule">
                            </div>

                            <div class="form-group">
                              <label>Marque du véhicule :</label>
                              <input type="text" class='form-control' name="ddlMake" id="ddlMake" placeholder="Saisissez la marque du véhicule">
                            </div>

                            <div class="form-group">
                              <label>Modèle du véhicule :</label>
                              <input type="text" class='form-control' name="ddlModel" id="ddl_model" placeholder="Saisissez le modèle du véhicule">
                            </div>
                          </fieldset> -->

                        <fieldset>
                          <legend>Informations du véhicule</legend>
                          <div class="form-group">
                            <label> Immatriculation du véhicule :</label>
                            <!-- <input required type="text" name="immat" id="immat" class="form-control" placeholder="Saisissez l'immatriculation du véhicule"> -->
                            <input onchange="loadMarqueModeleVoiture_2(this.value);" type="text" name="immat" id="immat" class="form-control" placeholder="Saisissez l'immatriculation du véhicule">
                          </div>

                          <!-- <div id="marque_modele_box"> -->
                          <div class="form-group">
                            <label>Marque du véhicule :</label>
                            <input type="text" class='form-control' name="ddlMake" id="ddlMake" placeholder="Saisissez la marque du véhicule" value="">
                          </div>

                          <div class="form-group">
                            <label>Modèle du véhicule :</label>
                            <input type="text" class='form-control' name="ddlModel" id="ddl_model" placeholder="Saisissez le modèle du véhicule" value="">
                          </div>
                          <!-- </div> -->
                        </fieldset>

                        <fieldset>
                          <legend>Informations du scanner</legend>
                          <div class="form-group col-md-12">
                            <label for="scanner" class="col-md-2 col-form-label" style="padding-left:0px;">
                              Motif :</label>
                            <div class="col-md-5 form-check" style="padding-left:0px;">
                              <input class="form-check-input" type="checkbox" name="scanner_electrique" id="scanner_electrique" value="scanner electrique">
                              <label class="form-check-label" for="scanner_electrique">Scanner électrique</label>
                            </div>
                            <div class="col-md-5 form-check" style="padding-left:0px;">
                              <input class="form-check-input" type="checkbox" name="scanner_mecanique" id="scanner_mecanique" value="scanner mecanique">
                              <label class="form-check-label" for="scanner_mecanique">Scanner mécanique</label>
                            </div>
                          </div>

                          <div class="form-group">
                            <label>Montant des frais du scanner :</label>
                            <input type="number" class='form-control' name="frais_scanner" id="frais_scanner" placeholder="Saisissez le montant du scanner">
                          </div>

                        </fieldset>

                        <input type="hidden" value="<?php echo $row['customer_id']; ?>" name="customer_id" />
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-success" id="submit">Valider</button>
                      </div>

                      <input type="hidden" name="hfInvoiceId" value="<?php echo $invoice_id; ?>" />
                    </form>
                  </div>
                </div>
                <?php
                }
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
      var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer ce client? ?");
      if (iAnswer) {
        window.location = '<?php echo WEB_URL; ?>customer/customerlist.php?id=' + Id;
      }
    }

    $(document).ready(function() {
      setTimeout(function() {
        $("#me").hide(8000);
        $("#you").hide(8000);
      }, 8000);
    });
  </script>
  <?php include('../footer.php'); ?>