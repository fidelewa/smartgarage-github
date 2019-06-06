<?php
include('../header.php');

/*variables*/
$delinfo = 'none';
$addinfo = 'none';
$msg = '';
$del_msg = '';
$assur_vehi_lib = '';
$assurance_button_label = "Enregistrer l'assurance";
$assurance_vehi_post_token = 0;
//
if (isset($_POST['form_token'])) {
  if ($_POST['form_token'] == 'assurance_vehicule') {
    $wms->saveUpdateAssuranceVehicule($link, $_POST);
    if ($_POST['submit_token'] == '0') {
      $addinfo = 'block';
      $msg = "Assurance insérée avec succès";
      $url = WEB_URL . 'repaircar/addcar_reception.php?m=add_assurance';
      header("Location: $url");
    } else {
      $addinfo = 'block';
      $msg = "Assurance mis à jour avec succès";
    }
  }
}

/************************ Make edit and delete ***************************/
if (isset($_GET['avid']) && $_GET['avid'] != '') {
  // $row = $wms->getCarMakeDataByMakeId($link, $_GET['avid']);
  $row = $wms->getAssuranceDataByAssuranceId($link, $_GET['avid']);
  if (!empty($row)) {
    $assur_vehi_lib = $row['assur_vehi_libelle'];
  }
  $assurance_button_label = 'Assurance mis à jour';
  $assurance_vehi_post_token = $_GET['avid'];
}
if (isset($_GET['avdelid']) && $_GET['avdelid'] != '') {
  // $wms->deleteMakeData($link, $_GET['avdelid']);
  $wms->deleteAssuranceData($link, $_GET['avdelid']);
  $delinfo = 'block';
  $del_msg = "Assurance supprimée avec succès";
}
/**************************************************************/

?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> Paramètrage des assurances des véhicules</h1>
  <!-- <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Car Setting</li>
    <li class="active">Make/Model/Year</li>
  </ol> -->
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
      <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>setting/car_assurance_setting_reception.php" data-original-title="Rafraichir la page"><i class="fa fa-refresh"></i></a> <a class="btn btn-warning" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/addcar_reception.php" data-original-title="Retour"><i class="fa fa-reply"></i></a></div>
      <div class="box box-success">
        <form method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="box-header">
              <h3 class="box-title">Ajout de l'assurance</h3>
            </div>
            <div class="form-group col-md-10">
              <input type="text" placeholder="Libellé de l'assurance" value="<?php echo $assur_vehi_lib; ?>" name="txtAssurVehiLib" id="txtAssurVehiLib" class="form-control" required />
            </div>
            <div class="form-group col-md-2">
              <input type="submit" name="submit" class="btn btn-success" value="<?php echo $assurance_button_label; ?>" />
            </div>
            <br>
            <br>
            <br>
            <br>
            <div>
              <table class="table sakotable table-bordered table-striped dt-responsive">
                <thead>
                  <tr>
                    <th>Assurance</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $result = $wms->get_all_assurance_vehicule_list($link);
                  foreach ($result as $row) { ?>
                    <tr>
                      <td><?php echo $row['assur_vehi_libelle']; ?></td>
                      <td>
                      <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>setting/car_assurance_setting.php?avid=<?php echo $row['assur_vehi_id']; ?>" data-original-title="Modifier l'assurance"><i class="fa fa-edit"></i></a> 
                      <a class="btn btn-danger" data-toggle="tooltip" onClick=deleteMe("<?php echo WEB_URL; ?>setting/car_assurance_setting.php?avdelid=<?php echo $row['assur_vehi_id']; ?>"); href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a></td>
                    </tr>
                  <?php } 
                ?>
                </tbody>
              </table>
            </div>
          </div>
          <input type="hidden" value="assurance_vehicule" name="form_token" />
          <input type="hidden" value="<?php echo $assurance_vehi_post_token; ?>" name="submit_token" />
        </form>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
  <!-- /.row -->
  <?php include('../footer.php'); ?>