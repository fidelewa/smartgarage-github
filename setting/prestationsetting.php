<?php
include('../header.php');

/*variables*/
$delinfo = 'none';
$addinfo = 'none';
$msg = '';
$del_msg = '';
$presta_serv_name = '';
$prix_presta_serv = '';
$presta_serv_id = 0;
$make_id_year = 0;
$model_id = 0;
$year_name = '';
$prestation_button_label = 'Enregistrer la prestation';
$prix_prestation_button_label = 'Enregistrer le prix de la prestation';
$year_button_label = 'Enregistrer  Année';
$prestation_post_token = 0;
$prix_prestation_post_token = 0;
$year_post_token = 0;
//
if (isset($_POST['form_token'])) {
  if ($_POST['form_token'] == 'prestation_service') {
    $wms->saveUpdatePrestationService($link, $_POST);
    if ($_POST['submit_token'] == '0') {
      $addinfo = 'block';
      $msg = "Prestation de services insérée avec succès";
    } else {
      $addinfo = 'block';
      $msg = "Prestation de services mis à jour avec succès";
    }
  } else if ($_POST['form_token'] == 'prix_prestation') {
    $wms->saveUpdatePrixPrestationService($link, $_POST);
    if ($_POST['submit_token'] == '0') {
      $addinfo = 'block';
      $msg = "Prix de la prestation de services insérée avec succès";
    } else {
      $addinfo = 'block';
      $msg = "Prix de la prestation de services mis à jour avec succès";
    }
  }
}


/************************ Make edit and delete ***************************/
if (isset($_GET['psid']) && $_GET['psid'] != '') {
  // $row = $wms->getCarMakeDataByMakeId($link, $_GET['psid']);
  $row = $wms->getPrestationDataByPrestationId($link, $_GET['psid']);
  if (!empty($row)) {
    $presta_serv_name = $row['presta_serv_name'];
  }
  $prestation_button_label = 'Update Prestation';
  $prestation_post_token = $_GET['psid'];
}
if (isset($_GET['psdelid']) && $_GET['psdelid'] != '') {
  // $wms->deleteMakeData($link, $_GET['psdelid']);
  $wms->deletePrestationData($link, $_GET['psdelid']);
  $delinfo = 'block';
  $del_msg = "Prestation de services supprimée avec succès";
}

/************************ Model edit and delete ***************************/
if (isset($_GET['ppsid']) && $_GET['ppsid'] != '') {
  //view
  // $row = $wms->getCarModelDataByModelId($link, $_GET['ppsid']);
  $row = $wms->getPrixPrestationDataByPrixPrestationId($link, $_GET['ppsid']);
  if (!empty($row)) {
    // $make_id = $row['make_id'];
    // $presta_serv_id = $row['presta_serv_id'];
    // $model_name = $row['model_name'];
    $prix_presta_serv = $row['prix_presta_serv'];
  }
  $prix_prestation_button_label = 'Update Prix Prestation';
  $prix_prestation_post_token = $_GET['ppsid'];
  //mysql_close($link);
}

if (isset($_GET['ppsdelid']) && $_GET['ppsdelid'] != '') {
  // $wms->deleteModelData($link, $_GET['ppsdelid']);
  $wms->deletePrixPrestationData($link, $_GET['ppsdelid']);
  $delinfo = 'block';
  $del_msg = "Prix de la prestation de services supprimée avec succès";
}
/**************************************************************/

?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> Paramètrage des prestations de services propre au garage</h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Car Setting</li>
    <li class="active">Make/Model/Year</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Full Width boxes (Stat box) -->
  <div class="row">
    <div class="col-md-12">
      <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
        <h4><i class="icon fa fa-ban"></i> Deleted!</h4>
        <?php echo $del_msg; ?>
      </div>
      <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        <?php echo $msg; ?>
      </div>
      <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>setting/carsetting.php" data-original-title="Refresh Page"><i class="fa fa-refresh"></i></a> </div>
      <div class="box box-success">
        <form method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="box-header">
              <h3 class="box-title">Ajout d'une prestation de services</h3>
            </div>
            <div class="form-group col-md-10">
              <input type="text" placeholder="Libellé de la prestation" value="<?php echo $presta_serv_name; ?>" name="txtPrestaServName" id="txtPrestaServName" class="form-control" required />
            </div>
            <div class="form-group col-md-2">
              <input type="submit" name="submit" class="btn btn-success" value="<?php echo $prestation_button_label; ?>" />
            </div>
            <br>
            <br>
            <br>
            <br>
            <div>
              <table class="table sakotable table-bordered table-striped dt-responsive">
                <thead>
                  <tr>
                    <th>Prestation de services</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $result = $wms->get_all_prestation_list($link);
                  foreach ($result as $row) { ?>
                    <tr>
                      <td><?php echo $row['presta_serv_name']; ?></td>
                      <td>
                      <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>setting/prestationsetting.php?psid=<?php echo $row['presta_serv_id']; ?>" data-original-title="Modifier la prestation de services"><i class="fa fa-edit"></i></a> 
                      <a class="btn btn-danger" data-toggle="tooltip" onClick=deleteMe("<?php echo WEB_URL; ?>setting/prestationsetting.php?psdelid=<?php echo $row['presta_serv_id']; ?>"); href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a></td>
                    </tr>
                  <?php } 
                ?>
                </tbody>
              </table>
            </div>
          </div>
          <input type="hidden" value="prestation_service" name="form_token" />
          <input type="hidden" value="<?php echo $prestation_post_token; ?>" name="submit_token" />
        </form>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <div class="box box-success" id="box_model">
        <form method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="box-header">
              <h3 class="box-title">Ajout du prix d'une prestation de service</h3>
            </div>
            <div class="form-group col-md-4">
              <select class="form-control" name="ddlPresta" required>
                <option value=''>--Sélectionnez une prestation de services--</option>
                <?php
                $result = $wms->get_all_prestation_list($link);
                foreach ($result as $row) {
                  if ($presta_serv_id > 0 && $presta_serv_id == $row['presta_serv_id']) {
                    echo "<option selected value='" . $row['presta_serv_id'] . "'>" . $row['presta_serv_name'] . "</option>";
                  } else {
                    echo "<option value='" . $row['presta_serv_id'] . "'>" . $row['presta_serv_name'] . "</option>";
                  }
                } ?>
              </select>
            </div>
            <div class="form-group col-md-4">
              <input type="text" placeholder="Prix de la prestation" name="txtPrixPrestaServ" id="txtPrixPrestaServ" value="<?php echo $prix_presta_serv; ?>" class="form-control" required />
            </div>
            <div class="form-group col-md-4">
              <input type="submit" name="submit" class="btn btn-success" value="<?php echo $prix_prestation_button_label; ?>" />
            </div>
            <br>
            <br>
            <br>
            <br>
            <div>
              <table class="table sakotable table-bordered table-striped dt-responsive">
                <thead>
                  <tr>
                    <th>Prestation de services</th>
                    <th>Prix de la prestation de services</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $result = $wms->get_all_prix_prestation_list($link);
                  foreach ($result as $row) { ?>
                    <tr>
                      <td><?php echo $row['presta_serv_name']; ?></td>
                      <td><?php echo $row['prix_presta_serv']; ?></td>
                      <td>
                      <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>setting/prestationsetting.php?ppsid=<?php echo $row['prix_presta_serv_id']; ?>#box_model" data-original-title="Modifier le prix de la prestation"><i class="fa fa-edit"></i></a> 
                      <a class="btn btn-danger" data-toggle="tooltip" onClick=deleteMe("<?php echo WEB_URL; ?>setting/prestationsetting.php?ppsdelid=<?php echo $row['prix_presta_serv_id']; ?>"); href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a></td>
                    </tr>
                  <?php } 
                ?>
                </tbody>
              </table>
            </div>
          </div>
          <input type="hidden" value="prix_prestation" name="form_token" />
          <input type="hidden" value="<?php echo $prix_prestation_post_token; ?>" name="submit_token" />
        </form>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
  <!-- /.row -->
  <?php include('../footer.php'); ?>