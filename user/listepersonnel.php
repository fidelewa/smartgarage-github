<?php
include_once('../header.php');
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
  $wms->deletePersoInfo($link, $_GET['id']);
  $delinfo = 'block';
}
//	add success
if (isset($_SESSION['token']) && $_SESSION['token'] == 'add') {
  $addinfo = 'block';
  $msg = "Informations d'un membre du personnel ajouté avec succès";
  unset($_SESSION['token']);
}
//	update success
if (isset($_SESSION['token']) && $_SESSION['token'] == 'up') {
  $addinfo = 'block';
  $msg = "Informations d'un membre du personnel modifiées avec succès";
  unset($_SESSION['token']);
}
if (isset($_GET['m']) && $_GET['m'] == 'add') {
  $_SESSION['token'] = 'add';
  $url = WEB_URL . 'user/listepersonnel.php';
  header("Location: $url");
}
if (isset($_GET['m']) && $_GET['m'] == 'up') {
  $_SESSION['token'] = 'up';
  $url = WEB_URL . 'user/listepersonnel.php';
  header("Location: $url");
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> Liste du personnel </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Liste du personnel</li>
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
        Suppression des informations du personnel réussi.
      </div>
      <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        <?php echo $msg; ?>
      </div>
      <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>user/addpersonnel.php" data-original-title="Ajouter un membre du personnel"><i class="fa fa-plus"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a> </div>
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Liste du personnel</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table sakotable table-bordered table-striped dt-responsive">
            <thead>
              <tr>
                <th>N° maticule</th>
                <th>Nom</th>
                <th>Téléphone</th>
                <th>Fonction</th>
                <th>Salaire</th>
                <th>Type de contrat</th>
                <th>Date d'embauche</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $results = $wms->getAllPersoData($link);
              foreach ($results as $row) {
                $image = WEB_URL . 'img/no_image.jpg';
                // if(file_exists(ROOT_PATH . '/img/upload/' . $row['image']) && $row['image'] != ''){
                // 	$image = WEB_URL . 'img/upload/' . $row['image'];
                // }
                ?>
                <tr>
                  <td><?php echo $row['per_mat']; ?></td>
                  <td><?php echo $row['per_name']; ?></td>
                  <td><?php echo $row['per_telephone']; ?></td>
                  <td><?php echo $row['per_fonction']; ?></td>
                  <td><?php echo $row['per_sal']; ?></td>
                  <td><?php echo $row['per_type_contrat']; ?></td>
                  <td><?php echo $row['per_date_emb']; ?></td>
                  <td>
                    <!-- <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['per_id']; ?>').modal('show');" data-original-title="View"><i class="fa fa-eye"></i></a>  -->
                    <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>user/addpersonnel.php?id=<?php echo $row['per_id']; ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                    <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteSupplier(<?php echo $row['per_id']; ?>);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                    <div id="nurse_view_<?php echo $row['per_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header orange_header">
                            <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                            <h3 class="modal-title">Détail d'un membre du personnel</h3>
                          </div>
                          <div class="modal-body model_view" align="center">&nbsp;
                            <div><img class="photo_img_round" style="width:100px;height:100px;" src="<?php echo $image;  ?>" /></div>
                            <div class="model_title"><?php echo $row['r_name']; ?></div>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-xs-6">
                                <h3 style="text-decoration:underline;">Details Information</h3>
                                <b>Name :</b> <?php echo $row['r_name']; ?><br />
                                <b>Email :</b> <?php echo $row['r_email']; ?><br />
                                <!-- <div class="col-xs-6">
                                    <h3 style="text-decoration:underline;">Manufacturer Information</h3>
                                    <?php foreach ($manufacturerInfo as $manufacturer) { ?>
                                            <div class="chkBoxStyle">
                                              <label><?php echo $manufacturer['name']; ?></label>
                                              &nbsp;&nbsp;<img style="float:right;" class="img_small" src="<?php echo $manufacturer['image']; ?>" /></div>
                                    <?php } ?>
                                  </div> -->
                              </div>
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                      </div>
                  </td>
                </tr>
              <?php } ?>
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
    function deleteSupplier(Id) {
      var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer ce personnel ?");
      if (iAnswer) {
        window.location = '<?php echo WEB_URL; ?>user/listepersonnel.php?id=' + Id;
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