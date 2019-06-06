<?php 
include('../header.php');
include('../helper/calculation.php'); ?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if(isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0){
	$wms->deleteCarSellInformation($link, $_GET['id']);
	$delinfo = 'block';
	$msg = "Deleted Car information successfully";
}
if(isset($_GET['m']) && $_GET['m'] == 'up'){
	$addinfo = 'block';
	$msg = "Updated Car Information Successfully";
}
if(isset($_GET['rid']) && isset($_GET['rcarid'])){
	$wms->returnSellCarInformation($link, $_GET['rid'], $_GET['rcarid']);
	$delinfo = 'block';
	$msg = "Return car succsesfully";
}

$wmscalc = new wms_calculation();

?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><i class="fa fa-car"></i> Liste Voitures vendues </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Voitures en stock</li>
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
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title">Liste Voitures vendues</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table sakotable table-bordered table-striped dt-responsive">
          <thead>
            <tr>
              <th>Image</th>
			  <th>Invoice ID</th>
              <th>Nom de l'acheteur</th>
              <th>Nom de la voiture</th>
              <th>Condition</th>
			  <th>Sold Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
				$results = $wms->getSellCarInformationList($link);
				foreach($results as $row) {					
					$image = WEB_URL . 'img/no_image.jpg';
					if(file_exists(ROOT_PATH . '/img/upload/' . $row['car_image']) && $row['car_image'] != ''){
						$image = WEB_URL . 'img/upload/' . $row['car_image'];
					}
				?>
            <tr>
              <td><img class="img_size" style="width:50px;height:50px;" src="<?php echo $image;  ?>" /></td>
              <td><span class="label label-primary"><?php echo $row['invoice_id']; ?></span></td>
			  <td><?php echo $row['buyer_name']; ?></td>
              <td><?php echo $row['car_name']; ?></td>
              <td><span class="label label-success"><?php echo $row['car_condition']; ?></span></td> 
			  <td><span class="label label-danger"><?php echo $wms->mySqlToDatePicker($row['selling_date']); ?></span></td>
              <td><a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['carsell_id']; ?>').modal('show');" data-original-title="View"><i class="fa fa-eye"></i></a> <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>carstock/carsellform.php?sellid=<?php echo $row['carsell_id']; ?>&carid=<?php echo $row['car_id']; ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="javascript:;" onClick="returnCar(<?php echo $row['carsell_id']; ?>,<?php echo $row['car_id']; ?>);" data-original-title="Return Car"><i class="fa fa-car"></i></a> <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL . 'invoice/invoice_car_sell.php?invoice_id='. $row['invoice_id']; ?>" data-original-title="Invoice"><i class="fa fa-file-text-o"></i></a> <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteCustomer(<?php echo $row['carsell_id']; ?>);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                <div id="nurse_view_<?php echo $row['carsell_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                            <b>Nom de l'acheteur :</b> <?php echo $row['buyer_name']; ?><br/>
                            <b>Mobile :</b> <?php echo $row['buyer_mobile']; ?><br/>
                            <b>Email :</b> <?php echo $row['buyer_email']; ?><br/>
                            <b>NID :</b> <?php echo $row['sellernid']; ?><br/>
                            <b>Nom de la compagnie :</b> <?php echo $row['company_name']; ?><br/>
                            <b>Licence commerciale de l'entreprise :</b> <?php echo $row['ctl']; ?><br/>
                            <b>Adresse actuelle :</b> <?php echo $row['present_address']; ?><br/>
							<b>Adresse permanente :</b> <?php echo $row['permanent_address']; ?><br/>
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
                            <b>Chasis No :</b> <?php echo $row['car_chasis_no']; ?><br/>
                            <b>Nom du moteur :</b> <?php echo $row['car_engine_name']; ?><br/>
                            <b>Kilométrage total de la voiture :</b> <?php echo $row['car_totalmileage']; ?><br/>
                          </div>
                          <div class="col-xs-12">
                            <h3 style="text-decoration:underline;">Informations de vente</h3>
                            <b>Prix vendu :</b> <?php echo $currency; ?><?php echo $row['selling_price']; ?><br/>
							<b>Prix avancé :</b> <?php echo $currency; ?><?php echo $row['advance_amount']; ?><br/>
							<b>Montant dû :</b> <span class="label label-danger"><?php echo $currency; ?><?php echo $row['due_amount']; ?></span><br/>
                            <b>Date de vente: </b><span class="label label-info"><?php echo $row['selling_date']; ?></span><br/>
                            <b>Note de vente :</b> <?php echo $row['sell_note']; ?><br/>
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
		window.location = '<?php echo WEB_URL; ?>carstock/sellcarlist.php?id=' + Id;
	}
  }
  
  function returnCar(id,cid){
  	var iAnswer = confirm("Are you sure you want to return this car ?");
	if(iAnswer){
		window.location = '<?php echo WEB_URL; ?>carstock/sellcarlist.php?rid=' + id + '&rcarid=' + cid;
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
