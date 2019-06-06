<?php 
include('../header.php');
$success = "none";
$c_name = '';
$c_email = '';
$c_address = '';
$c_home_tel = '';
$c_work_tel = '';
$c_mobile = '';
$c_password = '';
$title = 'Ajouter un nouveau client';
$button_text="Enregistrer information";
$successful_msg="Ajout client avec réuissi";
$form_url = WEB_URL . "customer/addcustomer.php";
$id="";
$hdnid="0";
$image_cus = WEB_URL . 'img/no_image.jpg';
$img_track = '';

if(isset($_POST['txtCName'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){
	$c_password = $_POST['txtCPassword'];
	$image_url = uploadImage();
	$sql = "INSERT INTO tbl_add_customer(c_name,c_email, c_address, c_home_tel,c_work_tel,c_mobile,c_password,image) values('$_POST[txtCName]','$_POST[txtCEmail]','$_POST[txtCAddress]','$_POST[txtCHomeTel]','$_POST[txtCWorkTel]','$_POST[txtCMobile]','$c_password','$image_url')";
	mysql_query($sql,$link);
	mysql_close($link);
	$url = WEB_URL . 'customer/customerlist.php?m=add';
	header("Location: $url");
	
}
else{
	$c_password = $_POST['txtCPassword'];
	$image_url = uploadImage();
	if($image_url == ''){
		$image_url = $_POST['img_exist'];
	}
	$sql = "UPDATE `tbl_add_customer` SET `c_name`='".$_POST['txtCName']."',`c_email`='".$_POST['txtCEmail']."',`c_address`='".$_POST['txtCAddress']."',`c_home_tel`='".$_POST['txtCHomeTel']."',`c_work_tel`='".$_POST['txtCWorkTel']."',`c_mobile`='".$_POST['txtCMobile']."',`c_password`='".$c_password."',`image`='".$image_url."' WHERE customer_id='".$_GET['id']."'";
	mysql_query($sql,$link);
	$url = WEB_URL . 'customer/customerlist.php?m=up';
	header("Location: $url");
}

$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysql_query("SELECT * FROM tbl_add_customer where customer_id = '" . $_GET['id'] . "'",$link);
	while($row = mysql_fetch_array($result)){
		
		$c_name = $row['c_name'];
		$c_email = $row['c_email'];
		$c_address = $row['c_address'];
		$c_home_tel = $row['c_home_tel'];
		$c_work_tel = $row['c_work_tel'];
		$c_mobile = $row['c_mobile'];
		$c_password = $row['c_password'];
		if($row['image'] != ''){
			$image_cus = WEB_URL . 'img/upload/' . $row['image'];
			$img_track = $row['image'];
		}
		$hdnid = $_GET['id'];
		$title = 'Update Customer';
		$button_text="Update";
		$successful_msg="Update Customer Successfully";
		$form_url = WEB_URL . "customer/addcustomer.php?id=".$_GET['id'];
	}
	
	//mysql_close($link);

}

//for image upload
function uploadImage(){
	if((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)) {
	  $filename = basename($_FILES['uploaded_file']['name']);
	  $ext = substr($filename, strrpos($filename, '.') + 1);
	  if(($ext == "jpg" && $_FILES["uploaded_file"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["uploaded_file"]["type"] == 'image/png') || ($ext == "gif" && $_FILES["uploaded_file"]["type"] == 'image/gif')){   
	  	$temp = explode(".",$_FILES["uploaded_file"]["name"]);
	  	$newfilename = NewGuid() . '.' .end($temp);
		move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], ROOT_PATH . '/img/upload/' . $newfilename);
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
  <h1> Ajouter un nouveau client </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Client</li>
    <li class="active">Ajouter  Client</li>
  </ol>
</section>
<!-- Main content -->
<form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">
  <section class="content">
    <!-- Full Width boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info" id="box_model">
          <div class="box-body">
            <div class="form-group col-md-12" style="padding-top:10px;">
              <div class="pull-right">
                <button type="submit" class="btn btn-success btnsp"><i class="fa fa-save fa-2x"></i><br/>
                Enregistrer information</button>&emsp;
                <a class="btn btn-warning btnsp" data-toggle="tooltip" href="<?php echo WEB_URL; ?>customer/customerlist.php" data-original-title="Back"><i class="fa fa-reply  fa-2x"></i><br/>
                Back</a> </div>
            </div>
          </div>
        </div>
        <div class="box box-info">
          <div class="box-header">
            <h3 class="box-title">Formulaire d'inscription client</h3>
          </div>
          <div class="box-body">
            <div class="form-group">
              <label for="txtCName"><span style="color:red;">*</span> Nom :</label>
              <input type="text" name="txtCName" value="<?php echo $c_name;?>" id="txtCName" class="form-control" />
            </div>
            <div class="form-group">
              <label for="txtCEmail"><span style="color:red;">*</span> Email :</label>
              <input type="text" name="txtCEmail" value="<?php echo $c_email;?>" id="txtCEmail" class="form-control" />
            </div>
            <div class="form-group">
              <label for="txtCAddress"><span style="color:red;">*</span> Addresse :</label>
              <textarea name="txtCAddress" id="txtCAddress" class="form-control"><?php echo $c_address;?></textarea>
            </div>
            <div class="form-group">
              <label for="txtCHomeTel"><span style="color:red;">*</span> Maison Tel :</label>
              <input type="text" name="txtCHomeTel" value="<?php echo $c_home_tel;?>" id="txtCHomeTel" class="form-control" />
            </div>
            <div class="form-group">
              <label for="txtCWorkTel"><span style="color:red;">*</span> Travail Tel :</label>
              <input type="text" name="txtCWorkTel" value="<?php echo $c_work_tel;?>" id="txtCWorkTel" class="form-control" />
            </div>
            <div class="form-group">
              <label for="txtCMobile"><span style="color:red;">*</span> Mobile Tel :</label>
              <input type="text" name="txtCMobile" value="<?php echo $c_mobile;?>" id="txtCMobile" class="form-control" />
            </div>
            <div class="form-group">
              <label for="txtCPassword"><span style="color:red;">*</span> Mot de passe :</label>
              <input type="text" name="txtCPassword" value="<?php echo $c_password;?>" id="txtCPassword" class="form-control" />
            </div>
            <div class="form-group">
              <label for="Prsnttxtarea">Visualiser :</label>
              <img class="form-control" src="<?php echo $image_cus; ?>" style="height:100px;width:100px;" id="output"/>
              <input type="hidden" name="img_exist" value="<?php echo $img_track; ?>" />
            </div>
            <div class="form-group"> <span class="btn btn-file btn btn-primary">Upload Image
              <input type="file" name="uploaded_file" onchange="loadFile(event)" />
              </span> </div>
          </div>
          <input type="hidden" value="<?php echo $hdnid; ?>" name="hdn"/>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
    </div>
  </section>
</form>
<!-- /.row -->
<script type="text/javascript">
function validateMe(){
	if($("#txtCName").val() == ''){
		alert("Nom du client est Obligatoire !!!");
		$("#txtCName").focus();
		return false;
	}
	else if($("#txtCEmail").val() == ''){
		alert("Email est Obligatoire !!!");
		$("#txtCEmail").focus();
		return false;
	}
	else if($("#txtCAddress").val() == ''){
		alert("Address est Obligatoire !!!");
		$("#txtCAddress").focus();
		return false;
	}
	else if($("#txtCHomeTel").val() == ''){
		alert("Home Tel Number est Obligatoire !!!");
		$("#txtCHomeTel").focus();
		return false;
	}
	else if($("#txtCWorkTel").val() == ''){
		alert("Work Tel Number est Obligatoire !!!");
		$("#txtCWorkTel").focus();
		return false;
	}
	else if($("#txtCMobile").val() == ''){
		alert("Mobile Tel Number est Obligatoire !!!");
		$("#txtCMobile").focus();
		return false;
	}
	else if($("#txtCPassword").val() == ''){
		alert("Password est Obligatoire !!!");
		$("#txtCPassword").focus();
		return false;
	}
	else{
		return true;
	}
}
</script>
<?php include('../footer.php'); ?>
