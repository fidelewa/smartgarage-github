<?php
include_once('../header.php');
$delinfo = 'none';
$addinfo = 'none';
$msg = "";

//	add success
if (isset($_SESSION['token']) && $_SESSION['token'] == 'add') {
  $addinfo = 'block';
  $msg = "Informations de l'outil de travail ajouté avec succès";
  unset($_SESSION['token']);
}
//	update success
if (isset($_SESSION['token']) && $_SESSION['token'] == 'up') {
  $addinfo = 'block';
  $msg = "Informations de l'outil de travail modifiées avec succès";
  unset($_SESSION['token']);
}
if (isset($_GET['bcmde_id']) && $_GET['bcmde_id'] != '' && $_GET['bcmde_id'] > 0) {
  // $wms->deleteRepairCar($link, $_GET['id']);
  $wms->deleteBcmde($link, $_GET['bcmde_id']);
  $delinfo = 'block';
  $msg = "Informations de l'outil de travail supprimées avec succès";
}
// if (isset($_GET['m']) && $_GET['m'] == 'add') {
//   $_SESSION['token'] = 'add';
//   $url = WEB_URL . 'bon_cmde/boncmdeList.php';
//   header("Location: $url");
// }
// if (isset($_GET['m']) && $_GET['m'] == 'up') {
//   $_SESSION['token'] = 'up';
//   $url = WEB_URL . 'bon_cmde/boncmdeList.php';
//   header("Location: $url");
// }

$results = $wms->getWorktoolDataByEmploId($link, $_GET['per_id']);

// var_dump($results);
// die();

?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><i class="fa fa-list"></i> Liste des outils de travail de l'employé <?php
        if (isset($results) && !empty($results)) {
            echo "<b>".$results[0]['per_name']."</b>";
        }
        ?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Liste des outils de travail de l'employé</li>
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
        Suppression des informations de l'outil de travail réussi.
      </div>
      <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        <?php echo $msg; ?>
      </div>
      <div align="right" style="margin-bottom:1%;">
        <!-- <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>bon_cmde/addBonCmde.php" data-original-title="Ajouter un bon de commande"><i class="fa fa-plus"></i></a> -->
        <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>user/listepersonnel.php" data-original-title="Retour"><i class="fa fa-reply"></i></a>
      </div>
      <div class="box box-success">
        <!-- <div class="box-header">
          <h3 class="box-title">Liste des bons de commande crées</h3>
        </div> -->
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table sakotable table-bordered table-striped dt-responsive">
            <thead>
              <tr>
                <th>N° de l'outil</th>
                <th>Libelle</th>
                <th>Type d'outil</th>
                <th>Date d'enregistrement</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // $results = $wms->getAllBonCmdeDataByCarId($link, $_GET['car_id']);

              // var_dump($results);
              // die();

              foreach ($results as $row) {
                ?>
                <tr>
                  <td><?php echo $row['numero_tool']; ?></td>
                  <td><?php echo $row['libelle_tool']; ?></td>
                  <td><?php echo $row['type_tool']; ?></td>
                  <td><?php echo date_format(date_create($row['date_enregistrement']), 'd/m/Y'); ?></td>
                  <td>
                    <!-- <a class="btn btn-success" style="background-color:orange;color:#ffffff;" data-toggle="tooltip" href="javascript:;" onClick="$('#bcmd_article_modal_<?php echo $row['boncmde_id']; ?>').modal('show');" data-original-title="Voir la liste des articles commandés"><i class="fa fa-eye"></i></a>
                    <a class="btn btn-primary" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/bon_cmde_car.php?boncmde_id=<?php echo $row['boncmde_id']; ?>" data-original-title="Modifier le bon de commande"><i class="fa fa-pencil"></i></a>
                    <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['per_id']; ?>').modal('show');" data-original-title="View"><i class="fa fa-eye"></i></a> 
                    <a class="btn btn-primary" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>bon_cmde/bon_cmde_doc.php?boncmde_id=<?php echo $row['boncmde_id']; ?>" data-original-title="Consulter le bon de commande"><i class="fa fa-file-text-o"></i></a>
                    <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteSupplier(<?php echo $row['boncmde_id']; ?>,<?php echo $row['car_id']; ?>);" href="javascript:;" data-original-title="Supprimer le bon de commande"><i class="fa fa-trash-o"></i></a> -->
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
    function deleteSupplier(bcmde_id, car_id) {
      var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer ce outil de travail pour cet employé ?");
      if (iAnswer) {
        window.location = '<?php echo WEB_URL; ?>repaircar/liste_bcmde_vehicule.php?car_id=' + car_id+'&bcmde_id=' + bcmde_id;
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