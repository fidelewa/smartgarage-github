<?php 
include('../header.php');
$success = "none";
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
$author_name = '';
$title = 'Add Author';
$button_text="Save Author";
$id="";
$hdnid="0";


if(isset($_POST['author_name'])){
	$wms->saveUpdateAuthorInformation($link,$_POST);
	if((int)$_POST['author_id'] > 0){
		$url = WEB_URL . 'cms/author.php?m=up';
		header("Location: $url");
	} else {		
		$url = WEB_URL . 'cms/author.php?m=add';
		header("Location: $url");
	}
	exit();
}

/*=======================Delete=======================*/

if(isset($_GET['del_id']) && $_GET['del_id'] != '' && $_GET['del_id'] > 0){
	$wms->deleteAuthor($link, $_GET['del_id']);
	$delinfo = 'block';
}
if(isset($_GET['m']) && $_GET['m'] == 'add'){
	$addinfo = 'block';
	$msg = "Added Author Successfully";
}
if(isset($_GET['m']) && $_GET['m'] == 'up'){
	$addinfo = 'block';
	$msg = "Updated Author Successfully";
}

/*==============================================*/

if(isset($_GET['id']) && $_GET['id'] != ''){
	$data = $wms->getAuthorDataByAuthorId($link, $_GET['id']);
	if(!empty($data)){
		$author_name = $data['author_name'];
		$hdnid = $_GET['id'];
		$title = 'Update Author';
		$button_text="Update Author";
	}
}
	
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> Author </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Author</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <h4><i class="icon fa fa-ban"></i> Deleted!</h4>
      Deleted Author Successfully. </div>
	  
	<div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <h4><i class="icon fa fa-check"></i> Success!</h4>
      <?php echo $msg; ?> </div>
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" onclick="javascript:$('#frm_author').submit();" data-toggle="tooltip" href="javascript:;" data-original-title="<?php echo $button_text; ?>"><i class="fa fa-save"></i></a></div>
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title col-md-12"><?php echo $title; ?></h3>
      </div>
      <form onSubmit="return validateMe();" id="frm_author" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group col-md-12">
            <label for="author_name"><span style="color:red;">*</span>Author Name :</label>
            <div class="input-group col-md-12">
              <input type="text" placeholder="Enter Name" value="<?php echo $author_name; ?>" name="author_name" id="author_name" class="form-control" required/>
            </div>
          </div>
        </div>
        <input type="hidden" value="<?php echo $hdnid; ?>" name="author_id"/>
      </form>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title">Author List</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table sakotable table-bordered table-striped dt-responsive">
          <thead>
            <tr>
              <th>Author</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
				$results = $wms->getAuthorData($link);
				foreach($results as $row) {
				?>
            <tr>
              <td><?php echo $row['author_name']; ?></td>
              <td><a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL;?>cms/author.php?id=<?php echo $row['author_id']; ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteAuthor(<?php echo $row['author_id']; ?>);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a> </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->
<script type="text/javascript">
function deleteAuthor(Id){
  	var iAnswer = confirm("Are you sure you want to delete this author ?");
	if(iAnswer){
		window.location = '<?php echo WEB_URL; ?>cms/author.php?del_id=' + Id;
	}
  }
  
  $( document ).ready(function() {
	setTimeout(function() {
		  $("#me").hide(300);
		  $("#you").hide(300);
	}, 3000);
});
</script>
<script type="text/javascript">
function validateMe(){
	if($("#author_name").val() == ''){
		alert("Author name required!!!");
		$("#author_name").focus();
		return false;
	}	
	else{
		return true;
	}
}
</script>
<?php include('../footer.php'); ?>
