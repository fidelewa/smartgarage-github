<?php include('../header.php');?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if(isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0){
	$wms->deleteBuyPartsInformation($link, $_GET['id']);
	$delinfo = 'block';
	$msg = "Deleted Achat de pièces information successfully";
}
if(isset($_GET['m']) && $_GET['m'] == 'add'){
	$addinfo = 'block';
	$msg = "Purchased Parts Successfully";
}
if(isset($_GET['m']) && $_GET['m'] == 'up'){
	$addinfo = 'block';
	$msg = "Updated Achat de pièces Information Successfully";
}

?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><i class="fa fa-shopping-cart"></i> Achat de pièces </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Achat de pièces Liste</li>
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
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>parts_stock/buyparts.php" data-original-title="Add Buy Parts"><i class="fa fa-plus"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a> </div>
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title">Achat de pièces Liste</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table sakotable table-bordered table-striped dt-responsive">
          <thead>
            <tr>
              <th>Date</th>
			  <th>Facture</th>
			  <th>Nom</th>
			  <th>Condition</th>
			  <th>Quantite</th>
			  <th>Garantie</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
        <?php
				$result = $wms->buyPartsList($link);
				foreach($result as $row) {				
					$image = WEB_URL . 'img/no_image.jpg';
					if(file_exists(ROOT_PATH . '/img/upload/' . $row['parts_image']) && $row['parts_image'] != ''){
						$image = WEB_URL . 'img/upload/' . $row['parts_image']; //car image
					}
				?>
            <tr>
            <td><span class="label label-default"><?php echo $wms->mySqlToDatePicker($row['parts_added_date']); ?></span></td>
			<td><span class="label label-success"><?php echo $row['invoice_id']; ?></span></td>
            <td><?php echo $row['parts_name']; ?></td>
			<td><span class="label label-danger"><?php echo $row['parts_condition']; ?></span></td>
			<td><span class="label label-info"><?php echo $row['parts_quantity']; ?></span></td>
			<td><?php echo !empty($row['parts_warranty']) ? '<span class="label label-primary">'.$row['parts_warranty'].'</span>' : ''; ?></td>
            <td>
              <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL;?>invoice/invoice_parts_purchase.php?invoice_id=<?php echo $row['invoice_id']; ?>" data-original-title="Invoice"><i class="fa fa-file-text-o"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['invoice_id']; ?>').modal('show');" data-original-title="View"><i class="fa fa-eye"></i></a>  <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL;?>parts_stock/buyparts.php?invoice_id=<?php echo $row['invoice_id']; ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteCustomer(<?php echo $row['invoice_id']; ?>);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
            <div id="nurse_view_<?php echo $row['invoice_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header orange_header">
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                    <h3 class="modal-title">Détails des pièces</h3>
                  </div>
                  <div class="modal-body model_view" align="center">&nbsp;
                    <div><img class="photo_img_round" style="width:100px;height:100px;" src="<?php echo $image;  ?>" /></div>
                    <div class="model_title"><?php echo $row['parts_name']; ?></div>
                  </div>
				  <div class="modal-body">
                    <h3 style="text-decoration:underline;">Informations sur l'achat de pièces</h3>
                    <div class="row">
                      <div class="col-xs-12">
                        <b>Nom des pièces :</b> <?php echo $row['parts_name']; ?><br/>
						<b>Nom du fournisseur :</b> <?php echo $row['s_name']; ?><br/>
						<b>Manufacturer Name :</b> <span class="label label-success"><?php echo $row['manufacturer_name']; ?></span><br/>
						<b>Prix d'achat :</b> <?php echo $currency.$row['parts_buy_price']; ?><br/>
						<b>Quantite :</b> <span class="label label-success"><?php echo $row['parts_quantity']; ?></span><br/>
						<b>Pièce no :</b> <?php echo $row['parts_sku']; ?><br/>
						<b>Condition :</b> <span class="label label-danger"><?php echo $row['parts_condition']; ?></span><br/>
						<b>Date Ajout :</b> <?php echo $wms->mySqlToDatePicker($row['parts_added_date']); ?>
                      </div>
                    </div>
                  </div>				  
                </div>
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
function deleteCustomer(Id){
  	var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer cette Facture d'achat ?");
	if(iAnswer){
		window.location = '<?php echo WEB_URL; ?>parts_stock/buypartslist.php?id=' + Id;
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
