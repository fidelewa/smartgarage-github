<?php include('header.php') ?>
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

var_dump($_SESSION);
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><i class="fa fa-users"></i> Client </h1>
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
        <h4><i class="icon fa fa-ban"></i> Deleted!</h4>
        Supprimer les informations client réussies.
      </div>
      <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        <?php echo $msg; ?>
      </div>
      <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>customer/addcustomer.php" data-original-title="Add Customer"><i class="fa fa-plus"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a> </div>
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-list"></i> Liste de clients</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table sakotable table-bordered table-striped dt-responsive">
            <thead>
              <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <!-- <th>Travail Tel</th>
                <th>Mobile Tel</th> -->
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $result = $wms->getAllCustomerList($link);
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
                  <td>
                    <a class="btn btn-primary" style="background-color:purple;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>customer/pj_client_list.php?cid=<?php echo $row['customer_id']; ?>" data-original-title="Afficher la liste des pièces jointes au client"><i class="fa fa-paperclip"></i></a>
                    <a class="btn btn-primary" style="background-color:gray;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>customer/recep_vehi_client_list.php?cid=<?php echo $row['customer_id']; ?>" data-original-title="Afficher la liste des véhicules réceptionnés appartenant au client"><i class="fa fa-car"></i></a>
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
                            <h3 style="text-decoration:underline;">Details Information</h3>
                            <div class="row">
                              <div class="col-xs-12"> <b>Name :</b> <?php echo $row['c_name']; ?><br />
                                <b>Email :</b> <?php echo $row['c_email']; ?><br />
                                <b>Addresse :</b> <?php echo $row['c_address']; ?><br />
                                <b>Maison Tel :</b> <?php echo $row['c_home_tel']; ?><br />
                                <b>Travail Tel :</b> <?php echo $row['c_work_tel']; ?><br />
                                <b>Mobile Tel :</b> <?php echo $row['c_mobile']; ?> </div>
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
      var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer ce client? ?");
      if (iAnswer) {
        window.location = '<?php echo WEB_URL; ?>customer/customerlist.php?id=' + Id;
      }
    }

    $(document).ready(function() {
      setTimeout(function() {
        $("#me").hide(300);
        $("#you").hide(300);
      }, 3000);
    });
  </script>
  <?php include('footer.php'); ?>