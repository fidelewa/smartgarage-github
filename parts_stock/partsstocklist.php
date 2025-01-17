<?php include('../header.php'); ?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$warninginfo = 'none';
$msg = "";
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
  $wms->deleteStockPartsInformation($link, $_GET['id']);
  $delinfo = 'block';
  $msg = "Article supprimé avec succès";
}
if (isset($_GET['m']) && $_GET['m'] == 'up') {
  $addinfo = 'block';
  $msg = "Article modifié avec succès";
}
if (isset($_GET['m']) && $_GET['m'] == 'add') {
  $addinfo = 'block';
  $msg = "Article ajouté avec succès";
}
if (isset($_GET['m']) && $_GET['m'] == 'exiting_piece') {
  $warninginfo = 'block';
  $msg = "Un article possède déjà cet identifiant, veuillez simplement le modifier à partir de cette liste";
}

?>
<!-- Content Header (Page header) -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
  </style>
  
</head>

<body>

  <section class="content-header">
    <h1> Stock des pièces - Liste des articles</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Liste des articles</li>
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
          <?php echo $msg; ?>
        </div>
        <div id="me" class="alert alert-warning alert-dismissable" style="display:<?php echo $warninginfo; ?>">
          <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
          <h4><i class="icon fa fa-ban"></i></h4>
          <?php echo $msg; ?>
        </div>
        <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
          <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
          <h4><i class="icon fa fa-check"></i> Success!</h4>
          <?php echo $msg; ?>
        </div>
        <div align="right" style="margin-bottom:1%;">
          <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>parts_stock/buyparts.php" data-original-title="Créer un article"><i class="fa fa-plus"></i></a>
          <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a> </div>
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">Liste des articles</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="list_piece" class="table sakotable table-bordered table-striped dt-responsive">
              <thead>
                <tr>
                  <th>Image</th>
                  <th>Code</th>
                  <th>Libellé</th>
                  <th>Type</th>
                  <th>Famille</th>
                  <th>Prix base TTC</th>
                  <th>Coefficient</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php

                // On récupère la liste de toutes les pièce de véhicule en stock
                $resultsPieceStockData = $wms->getAllPieceInfo($link);

                foreach ($resultsPieceStockData as $row) {

                  // var_dump($resultsPieceStockData);
                  // die();

                  $image = WEB_URL . 'img/no_image.jpg';

                  if (file_exists(ROOT_PATH . '/img/upload/' . $row['image_url']) && $row['image_url'] != '') {
                    $image = WEB_URL . 'img/upload/' . $row['image_url']; //car image
                  }

                  ?>
                  <tr>
                    <td><img class="photo_img_round" style="width:50px;height:50px;" src="<?php echo $image;  ?>" /></td>
                    <td><?php echo $row['code_piece']; ?></td>
                    <td><?php echo $row['lib_piece']; ?></td>
                    <td><?php echo $row['type_piece']; ?></td>
                    <td><?php echo $row['famille_piece']; ?></td>
                    <td><?php echo $row['prix_base_ttc']; ?></td>
                    <td><?php echo $row['coefficient']; ?></td>
                    <td>
                      <!-- <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['per_id']; ?>').modal('show');" data-original-title="View"><i class="fa fa-eye"></i></a>  -->
                      <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>parts_stock/buyparts.php?pid=<?php echo $row['add_piece_id']; ?>" data-original-title="Modifier l'article"><i class="fa fa-pencil"></i></a>
                      <a class="btn btn-danger" data-toggle="tooltip" onClick="deletePartStock(<?php echo $row['add_piece_id']; ?>);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                    </td>
                  </tr>
                <?php
                } ?>
              </tbody>
              <tfoot>
                <tr>
                  <th></th>
                  <th>Code</th>
                  <th>Libellé</th>
                  <th>Type</th>
                  <th>Famille</th>
                  <th>Prix base TTC</th>
                  <th>Coefficient</th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>

  <script type="text/javascript">
    function deletePartStock(Id) {
      var iAnswer = confirm("Êtes-vous sûr de bien vouloir supprimer cet élément?");
      if (iAnswer) {
        window.location = '<?php echo WEB_URL; ?>parts_stock/partsstocklist.php?id=' + Id;
      }
    }

    $(document).ready(function() {
      setTimeout(function() {
        $("#me").hide(300);
        $("#you").hide(300);
      }, 3000);

      // Setup - add a text input to each footer cell
      $('#list_piece tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Recherche ' + title + '" />');
      });

      // DataTable
      var table = $('#list_piece').DataTable();

      // Apply the search
      table.columns().every(function() {
        var that = this;

        $('input', this.footer()).on('keyup change', function() {
          if (that.search() !== this.value) {
            that
              .search(this.value)
              .draw();
          }
        });
      });

    });
  </script>

</body>

</html>

<?php include('../footer.php'); ?>