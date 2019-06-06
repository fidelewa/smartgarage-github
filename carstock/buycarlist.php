<?php include('../header.php'); include('../helper/calculation.php'); ?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if(isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0){
	$wms->deleteCarInformation($link, $_GET['id']);
	$delinfo = 'block';
	$msg = "Deleted Car information successfully";
}
if(isset($_GET['m']) && $_GET['m'] == 'add'){
	$addinfo = 'block';
	$msg = "Added Car Information Successfully";
}
if(isset($_GET['m']) && $_GET['m'] == 'up'){
	$addinfo = 'block';
	$msg = "Updated Car Information Successfully";
}

$wmscalc = new wms_calculation();

?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="fa fa-car"></i> Achats de Voitures </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Achats de Voitures List</li>
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
      <?php echo $msg; ?> </div>
    <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <h4><i class="icon fa fa-check"></i> Success!</h4>
      <?php echo $msg; ?> </div>
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>carstock/buycar.php" data-original-title="Add Parts"><i class="fa fa-plus"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a> </div>
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title">Voitures en stock</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table sakotable table-bordered table-striped dt-responsive">
          <thead>
            <tr>
              <th>Image</th>
              <th>Owner Name</th>
              <th>Nom de la voiture</th>
              <th>Condition</th>
              <th>Car Status</th>
              <th>Buy Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
				$results = $wms->getAllCarList($link);
				foreach($results as $row) {				
					$image = WEB_URL . 'img/no_image.jpg';
					if(file_exists(ROOT_PATH . '/img/upload/' . $row['car_image']) && $row['car_image'] != ''){
						$image = WEB_URL . 'img/upload/' . $row['car_image']; //car image
					}
				?>
            <tr>
              <td><img class="img_size" style="width:50px;height:50px;" src="<?php echo $image;  ?>" /></td>
              <td><?php echo $row['owner_name']; ?></td>
              <td><?php echo $row['car_name']; ?></td>
              <td align="center"><span class="label label-success" style="text-transform:uppercase;"><?php echo $row['car_condition']; ?></span></td>
              <td align="center"><?php if($row['car_status'] == '0'){echo '<span class="label label-success">Available</span>';} else {echo '<span class="label label-danger">Sold</span>';} ?></td>
              <td><?php echo $wms->mySqlToDatePicker($row['buy_date']); ?></td>
              <td><a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['buycar_id']; ?>').modal('show');" data-original-title="View"><i class="fa fa-eye"></i></a> <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL;?>carstock/buycar.php?id=<?php echo $row['buycar_id']; ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteCustomer(<?php echo $row['buycar_id']; ?>);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                <div id="nurse_view_<?php echo $row['buycar_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header orange_header">
                        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                        <h3 class="modal-title">Détails de la voiture</h3>
                      </div>
                      <div class="modal-body model_view" align="center">&nbsp;
                        <div><img class="photo_img_round" style="width:100px;height:100px;" src="<?php echo $image;  ?>" /></div>
                        <div class="model_title"><?php echo $row['car_name']; ?></div>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-xs-6">
                            <h3 style="text-decoration:underline;">Informations sur le propriétaire</h3>
                            <b>Owner Name :</b> <?php echo $row['owner_name']; ?><br/>
                            <b>Owner Mobile :</b> <?php echo $row['owner_mobile']; ?><br/>
                            <b>Email :</b> <?php echo $row['owner_email']; ?><br/>
                            <b>NID :</b> <?php echo $row['nid']; ?><br/>
                            <b>Nom de la compagnie :</b> <?php echo $row['company_name']; ?><br/>
                            <b>Licence commerciale de l'entreprise :</b> <?php echo $row['ctl']; ?><br/>
                            <b>Address :</b> <?php echo $row['owner_address']; ?><br/>
                          </div>
                          <div class="col-xs-6">
                            <h3 style="text-decoration:underline;">Informations sur la voiture</h3>
                            <b>Nom de la voiture :</b> <?php echo $row['car_name']; ?><br/>
                            <b>Condition :</b> <?php echo $row['car_condition']; ?><br/>
                            <b>Color :</b> <?php echo $row['color_name']; ?><br/>
                            <b>No de porte</b> <?php echo $row['door_name']; ?><br/>
                            <b>Marque :</b> <?php echo $row['make_name']; ?><br/>
                            <b>Model :</b> <?php echo $row['model_name']; ?><br/>
                            <b>Année :</b> <?php echo $row['year_name']; ?><br/>
                            <b>Numéro d'enregistrement :</b> <?php echo $row['car_reg_no']; ?><br/>
							<b>Date d'inscription :</b> <?php echo $row['car_reg_date']; ?><br/>
                            <b>Chasis No :</b> <?php echo $row['car_chasis_no']; ?><br/>
                            <b>Nom du moteur :</b> <?php echo $row['car_engine_name']; ?><br/>
                            <b>Kilométrage total de la voiture :</b> <?php echo $row['car_totalmileage']; ?><br/>
							<b>Siège de voiture :</b> <?php echo $row['car_sit']; ?><br/>
                          </div>
                          <div class="col-xs-12">
                            <h3 style="text-decoration:underline;">Buying Information</h3>
                            <b>Prix d'achat :</b> <?php echo $currency; ?><?php echo $row['buy_price']; ?><br/>
                            <b>Prix de vente :</b> <?php echo $currency; ?><?php echo $row['asking_price']; ?><br/>
                            <b>Prix donné :</b> <?php echo $currency; ?><?php echo $row['buy_given_amount']; ?><br/>
                            <b>Montant dû :</b> <?php echo $currency; ?><?php echo $wmscalc->getResultFromTwoValues($row['buy_price'],$row['buy_given_amount'],'-'); ?><br/>
                            <b>Date d'achat:</b> <?php echo $row['buy_date']; ?><br/>
                            <b>Note :</b> <?php echo $row['buy_note']; ?><br/>
                            <b>Car Status :</b>
                            <span class="label label-success"><?php if($row['car_status'] == '0'){echo 'Available';} else {echo 'Sold';} ?></span>
                            <br/>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div></td>
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
function deleteCustomer(Id){
  	var iAnswer = confirm("Are you sure you want to delete this Item ?");
	if(iAnswer){
		window.location = '<?php echo WEB_URL; ?>carstock/buycarlist.php?id=' + Id;
	}
  }
  
  $( document ).ready(function() {
	setTimeout(function() {
		  $("#me").hide(300);
		  $("#you").hide(300);
	}, 3000);
});
</script>
<?php include('../footer.php'); ?>
