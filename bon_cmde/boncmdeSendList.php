<?php
include_once('../header.php');
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
  $wms->deleteBonCmdeInfo($link, $_GET['id']);
  $delinfo = 'block';
}
//	add success
if (isset($_SESSION['token']) && $_SESSION['token'] == 'add') {
  $addinfo = 'block';
  $msg = "Informations du bon de commande ajouté avec succès";
  unset($_SESSION['token']);
}
//	update success
if (isset($_SESSION['token']) && $_SESSION['token'] == 'up') {
  $addinfo = 'block';
  $msg = "Informations du bon de commande modifiées avec succès";
  unset($_SESSION['token']);
}
if (isset($_GET['m']) && $_GET['m'] == 'add') {
  $_SESSION['token'] = 'add';
  $url = WEB_URL . 'bon_cmde/boncmdeList.php';
  header("Location: $url");
}
if (isset($_GET['m']) && $_GET['m'] == 'up') {
  $_SESSION['token'] = 'up';
  $url = WEB_URL . 'bon_cmde/boncmdeList.php';
  header("Location: $url");
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> Liste des bons de commande envoyés </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Liste des bons de commande envoyé</li>
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
        Suppression des informations du bon de commande réussi.
      </div>
      <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        <?php echo $msg; ?>
      </div>
      <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>user/addpersonnel.php" data-original-title="Ajouter un bon de commande"><i class="fa fa-plus"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a> </div>
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Liste des bons de commande crées</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table sakotable table-bordered table-striped dt-responsive">
            <thead>
              <tr>
                <th>N° du bon de commande</th>
                <th>Code / désignation</th>
                <th>Quantité</th>
                <!-- <th>Prix unitaire HT</th>
                <th>Total HT</th> -->
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $results = $wms->getAllBonCmdeData($link);
              foreach ($results as $row) {
                $image = WEB_URL . 'img/no_image.jpg';
                // if(file_exists(ROOT_PATH . '/img/upload/' . $row['image']) && $row['image'] != ''){
                // 	$image = WEB_URL . 'img/upload/' . $row['image'];
                // }
                ?>
                <tr>
                  <td><?php echo $row['boncmde_num']; ?></td>
                  <td><?php echo $row['boncmde_designation']; ?></td>
                  <td><?php echo $row['boncmde_qte']; ?></td>
                  <!-- <td><?php echo $row['boncmde_pu_ht']; ?></td>
                  <td><?php echo $row['boncmde_total_ht']; ?></td> -->
                  <td>
                    <!-- <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['per_id']; ?>').modal('show');" data-original-title="View"><i class="fa fa-eye"></i></a>  -->
                    <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>bon_cmde/bon_cmde_doc.php?boncmde_id=<?php echo $row['boncmde_id']; ?>" data-original-title="Consulter le bon de commande"><i class="fa fa-file-text-o"></i></a>
                    <!-- <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteSupplier(<?php echo $row['per_id']; ?>);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a> -->
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
      var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer ce bon de commande ?");
      if (iAnswer) {
        window.location = '<?php echo WEB_URL; ?>bon_cmde/boncmdeList.php?id=' + Id;
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