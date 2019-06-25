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
          <h3 class="box-title">Liste des pointages du personnel</h3>
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
              $results = $wms->getAllPersoPointage($link);

              var_dump($results);

              foreach ($results as $row) {
                $image = WEB_URL . 'img/no_image.jpg';
                // if(file_exists(ROOT_PATH . '/img/upload/' . $row['image']) && $row['image'] != ''){
                // 	$image = WEB_URL . 'img/upload/' . $row['image'];
                // }

                // var_dump($row);
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
                    <a class="btn btn-success" style="background-color:orange;color:#ffffff;" data-toggle="tooltip" href="javascript:;" onClick="$('#employe_info_modal').modal('show');" data-original-title="Voir la description de l'employé"><i class="fa fa-eye"></i></a>
                    <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>user/addpersonnel.php?id=<?php echo $row['per_id']; ?>" data-original-title="Modifier"><i class="fa fa-pencil"></i></a>
                    <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteSupplier(<?php echo $row['per_id']; ?>);" href="javascript:;" data-original-title="Supprimer"><i class="fa fa-trash-o"></i></a>
                    <!-- <a class="btn btn-success" style="background-color:orange;color:#ffffff;" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['per_id']; ?>').modal('show');" data-original-title="Voir l'historique des avances sur salaire de l'employé"><i class="fa fa-eye"></i></a> -->

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
  <div id="employe_info_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <a class="close" data-dismiss="modal">×</a>
          <h3>Détail des informations d'un employé</h3>
        </div>

        <div class="modal-body">
          <form id="devisVehiForm" name="devis_vehi" role="form" enctype="multipart/form-data" method="POST" action="">

            <div class="row">
              <div class="col-md-3"><b>Nom de l'employé :</b></div>
              <div class="col-md-9"><?php echo $row['per_name']; ?></div>
            </div>

            <div class="row">
              <div class="col-md-3"><b>N° téléphone :</b></div>
              <div class="col-md-9"><?php echo $row['per_telephone']; ?></div>
            </div>

            <div class="row">
              <div class="col-md-3"><b>Fonction :</b></div>
              <div class="col-md-9"><?php echo $row['per_fonction']; ?></div>
            </div>

            <div class="row">
              <div class="col-md-3"><b>Salaire de base :</b></div>
              <div class="col-md-9"><?php echo $row['per_sal']; ?></div>
            </div>

            <hr>

            <div class="form-group">
              <label for="txtCName"> Avance sur salaire :</label>
              <div class="row">
                <div class="col-md-9">
                  <input type="number" class='form-control' name="avance_sal" id="avance_sal" placeholder="Saisissez le montant de l'avance" onfocus="">
                </div>
                <div class="col-md-3">
                  <!-- <a class="btn btn-success" data-toggle="modal" data-target="#client-modal" data-original-title="Ajouter un nouveau client"><i class="fa fa-plus"></i></a> -->
                  <button class="btn btn-primary">Donner avance</button>
                </div>
              </div>
            </div>

          </form>
        </div>

      </div>
    </div>
  </div>
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