<?php 
include('../header.php');
$success = "none";
$slider_text = "";
$slider_url = "";
$html_text = "";
$sort_id = "0";
$slider_status = "1";
$title = 'Setup Widget Box';
$button_text="Enregistrer information";
$id="";
$hdnid="0";
$image_sup = WEB_URL . 'img/no_image.jpg';  
$img_track = '';

if(isset($_POST['txtStext'])){
	$image_url = uploadImage();
	if(empty($image_url)) {
		$image_url = $_POST['img_exist'];
	}
	$wms->saveUpdateSliderInformation($link, $_POST, $image_url);
	if((int)$_POST['slider_id'] > 0){
		$url = WEB_URL.'cms/sliderlist.php?m=up';
		header("Location: $url");
	} else {		
		$url = WEB_URL.'cms/sliderlist.php?m=add';
		header("Location: $url");
	}
	exit();
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$row = $wms->getSliderInfoBySliderId($link, $_GET['id']);
	if(!empty($row)){
		$slider_text = $row['slider_text'];
		$slider_url = $row['slider_url'];
		$html_text = $row['html_text'];
		$sort_id = $row['sort_id'];		
		if($row['slider_image'] != ''){
			$image_sup = WEB_URL.'img/slider/'.$row['slider_image'];
			$img_track = $row['slider_image'];
		}
		$hdnid = $_GET['id'];
		$title = 'Update Slider';
		$button_text="Update Slider";
	}
}

//for image upload
function uploadImage(){
	if((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)) {
	  $filename = basename($_FILES['uploaded_file']['name']);
	  $ext = substr($filename, strrpos($filename, '.') + 1);
	  if(($ext == "jpg" && $_FILES["uploaded_file"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["uploaded_file"]["type"] == 'image/png') || ($ext == "gif" && $_FILES["uploaded_file"]["type"] == 'image/gif')){   
	  	$temp = explode(".",$_FILES["uploaded_file"]["name"]);
	  	$newfilename = NewGuid() . '.' .end($temp);
		move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], ROOT_PATH . '/img/slider/' . $newfilename);
		return $newfilename;
	  }
	  else{
	  	return '';
	  }
	}
	return '';
}
function NewGuid() { 
    $s = strtoupper(md5(uniqid(rand(),true))); 
    $guidText = 
        substr($s,0,8) . '-' . 
        substr($s,8,4) . '-' . 
        substr($s,12,4). '-' . 
        substr($s,16,4). '-' . 
        substr($s,20); 
    return $guidText;
}
	
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> <i class="fa fa-th-large"></i> Widget </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Edit Widget</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" onclick="javascript:$('#frm_slider').submit();" data-toggle="tooltip" href="javascript:;" data-original-title="<?php echo $button_text; ?>"><i class="fa fa-save"></i></a> &nbsp;<a class="btn btn-warning" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>cms/widgetlist.php" data-original-title="Back"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title col-md-12"><?php echo $title; ?></h3>
      </div>
      <form id="frm_slider" onSubmit="return validateMe();" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group col-md-12">
            <label for="txtStext">Widget Title :</label>
            <input type="text" name="txtWidgetTitle" value="" id="txtWidgetTitle" class="form-control" />
          </div>
		  <div class="form-group col-md-12">
            <label for="status">Status :</label>
            <select class="form-control" name="status" id="status">
              <option <?php if($slider_status == '1'){echo 'selected'; }?> value='1'>Enable</option>
              <option <?php if($slider_status == '0'){echo 'selected'; }?> value='0'>Disable</option>
            </select>
          </div>
        </div>
        <input type="hidden" value="<?php echo $hdnid; ?>" name="slider_id"/>
      </form>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->
<script type="text/javascript">
function validateMe(){
	if($("#txtStext").val() == ''){
		alert("Slider Alter Text est Obligatoire !!!");
		$("#txtStext").focus();
		return false;
	}	
	else{
		return true;
	}
}
</script>
<?php include('../footer.php'); ?>
