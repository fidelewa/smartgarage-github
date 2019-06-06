<?php include('../header.php')?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if(isset($_GET['delid']) && $_GET['delid'] != '' && $_GET['delid'] > 0){
	$wms->deleteService($link, $_GET['delid']);
	$delinfo = 'block';
}
if(isset($_GET['m']) && $_GET['m'] == 'add'){
	$addinfo = 'block';
	$msg = "Added service Successfully";
}
if(isset($_GET['m']) && $_GET['m'] == 'up'){
	$addinfo = 'block';
	$msg = "Updated service Successfully";
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> Our Service </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Our Service List</li>
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
      Deleted service successfully. </div>
    <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <h4><i class="icon fa fa-check"></i> Success!</h4>
      <?php echo $msg; ?> </div>
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>cms/addservice.php" data-original-title="Add Slider"><i class="fa fa-plus"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a> </div>
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title">Our Service List</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table sakotable table-bordered table-striped dt-responsive">
          <thead>
            <tr>
              <th>Image</th>
              <th>Title</th>
			  <th>Sort Order</th>
			  <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
        <?php
			$services = $wms->getServiceList($link);
			foreach($services as $row) {
				$image = WEB_URL . 'img/no_image.jpg';	
				if(file_exists(ROOT_PATH . '/img/service/' . $row['image_url']) && $row['image_url'] != ''){
					$image = WEB_URL . 'img/service/' . $row['image_url'];
				}
			?>
            <tr>
            <td><img class="photo_img_round" src="<?php echo $image;  ?>" /></td>
			<td><?php echo $row['service_name']; ?></td>
            <td><?php echo $row['sort_order']; ?></td>
			<td><?php if($row['status'] == 1){echo "Enable";} else {echo "Disable";} ?></td>			
            <td>
            <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL;?>cms/addservice.php?id=<?php echo $row['service_id']; ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteme(<?php echo $row['service_id']; ?>);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>            
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
	function deleteme(Id){
  		var iAnswer = confirm("Are you sure you want to delete this service ?");
		if(iAnswer){window.location = '<?php echo WEB_URL; ?>cms/servicelist.php?delid=' + Id;}
	}
  
	$( document ).ready(function() {
		setTimeout(function() {
			  $("#me").hide(300);
			  $("#you").hide(300);
		}, 3000);
	});
</script>
<?php include('../footer.php'); ?>
