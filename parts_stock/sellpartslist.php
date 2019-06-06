<?php include('../header.php'); include('../helper/calculation.php'); ?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if(isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0){
	$wms->deletePartsSoldItem($link, $_GET['id']);
	$delinfo = 'block';
	$msg = "Deleted parts information successfully";
}
if(isset($_GET['m']) && $_GET['m'] == 'add'){
	$addinfo = 'block';
	$msg = "Added Parts Information Successfully";
}
if(isset($_GET['m']) && $_GET['m'] == 'up'){
	$addinfo = 'block';
	$msg = "Mise à jour des informations sur les pièces";
}

/*if(isset($_GET['rid']) && isset($_GET['rcarid'])){
	$sqlx= "UPDATE tbl_parts_sell SET is_return = 1 WHERE parts_sell_id = ".$_GET['rid'];
	mysql_query($sqlx,$link); 
	$sqlcar= "UPDATE tbl_parts_stock SET car_status = 0 WHERE parts_id = ".$_GET['rcarid'];
	mysql_query($sqlcar,$link); 
	$delinfo = 'block';
	$msg = "Return car succsesfully";
}*/

$wmscalc = new wms_calculation();

?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> Vendre une liste de pièces </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Vendre une liste de pièces</li>
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
        <h3 class="box-title">Vendre une liste de pièces</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table sakotable table-bordered table-striped dt-responsive">
          <thead>
            <tr>
              <th>Facture No</th>
			  <th>Nom de l'acheteur</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Quantité</th>
			  <th>Total Price</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
				$results = $wms->getSoldPartsInformation($link);
				foreach($results as $result){					
				?>
            <tr>
              <td><span class="label label-success"><?php echo $result['invoice_id']; ?></span></td>
              <td><?php echo $result['customer_name']; ?></td>
              <td><?php echo $result['email']; ?></td>
              <td><?php echo $result['telephone']; ?></td>
			  <td><span class="label label-danger"><?php echo $result['total_parts']; ?></span></td>
			  <td><span class="label label-info"><?php echo $currency. $result['grand_total']; ?></span></td>
			  <td><span class="label label-primary"><?php echo $wms->mySqlToDatePicker($result['invoice_date']); ?></span></td>                     
              <td><a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL;?>invoice/invoice_parts_sell.php?invoice_id=<?php echo $result['invoice_id']; ?>" data-original-title="Invoice"><i class="fa fa-file-text-o"></i></a> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>parts_stock/partsselledit.php?sold_id=<?php echo $result['sold_id']; ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteSoldItem(<?php echo $result['sold_id']; ?>);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
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
function deleteSoldItem(Id){
  	var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer ceci ?");
	if(iAnswer){
		window.location = '<?php echo WEB_URL; ?>parts_stock/sellpartslist.php?id=' + Id;
	}
  }
  
  function returnCar(id,cid){
  	var iAnswer = confirm("Êtes-vous sûr de vouloir rendre cette voiture ?");
	if(iAnswer){
		window.location = '<?php echo WEB_URL; ?>parts_stock/sellpartslist.php?rid=' + id + '&rcarid=' + cid;
	}
  }
</script>
<?php include('../footer.php'); ?>
