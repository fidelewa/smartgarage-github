<?php
include('../header.php');
$success = "none";
$s_name = '';
$s_email = '';
$s_address = '';
$ddlCountry = 0;
$ddlState = 0;
$phone_number = '';
$post_code = '';
$website_url = '';
$s_fax = '';
$s_password = '';
$title = 'Ajouter un nouveau fournisseur';
$button_text = "Enregistrer information";
$successful_msg = "Ajouter un fournisseur avec succès";
$form_url = WEB_URL . "supplier/addsupplier.php";
$id = "";
$hdnid = "0";
$image_sup = WEB_URL . 'img/no_image.jpg';
$img_track = '';
$manufacturerInfo = array();

$countries = $wms->getAllCountries($link);


/*#############################################################*/
if(isset($_POST) && !empty($_POST)) {

		$image_url = uploadImage();
		if (empty($image_url)) {
			$image_url = $_POST['img_exist'];
		}

		// var_dump($_POST);
		// die();

		$wms->saveUpdateSupplierInformation($link, $_POST, $image_url);
		if ((int)$_POST['supplier_id'] > 0) {
			$url = WEB_URL . 'supplier/supplierlist.php?m=up';
			header("Location: $url");
		} else {
			$url = WEB_URL . 'supplier/supplierlist.php?m=add';
			header("Location: $url");
		}
		exit();
}

if (isset($_GET['id']) && $_GET['id'] != '') {
	//view
	$row = $wms->getSupplierInfoBySupplierId($link, $_GET['id']);
	if (!empty($row)) {
		$s_name = $row['s_name'];
		$s_email = $row['s_email'];
		$s_address = $row['s_address'];
		$ddlCountry = $row['country_id'];
		$ddlState = $row['state_id'];
		$phone_number = $row['phone_number'];
		$s_fax = $row['fax_number'];
		$post_code = $row['post_code'];
		$website_url = $row['website_url'];
		$s_password = $row['s_password'];
		if ($row['image'] != '') {
			$image_sup = WEB_URL . 'img/upload/' . $row['image'];
			$img_track = $row['image'];
		}
		$hdnid = $_GET['id'];
		$title = 'Modification du fournisseur';
		$button_text = "Modification";
		$successful_msg = "Modification du fournisseur effectuée avec succès";
		$form_url = WEB_URL . "supplier/addsupplier.php?id=" . $_GET['id'];

		/*manuafcturer info*/
		$manufacturerInfo = $wms->getManufacturersForSupplier($link, $_GET['id']);
	}

	//mysql_close($link);
}

function supplierIdExist($supplierArray, $id)
{
	foreach ($supplierArray as $key) {
		if ($key['manufacturer_id'] == $id) {
			return true;
			break;
		}
	}
	return false;
}

//for image upload
function uploadImage()
{
	if ((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)) {
		$filename = basename($_FILES['uploaded_file']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if (($ext == "jpg" && $_FILES["uploaded_file"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["uploaded_file"]["type"] == 'image/png') || ($ext == "gif" && $_FILES["uploaded_file"]["type"] == 'image/gif')) {
			$temp = explode(".", $_FILES["uploaded_file"]["name"]);
			$newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], ROOT_PATH . '/img/upload/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}
function NewGuid()
{
	$s = strtoupper(md5(uniqid(rand(), true)));
	$guidText =
		substr($s, 0, 8) . '-' .
		substr($s, 8, 4) . '-' .
		substr($s, 12, 4) . '-' .
		substr($s, 16, 4) . '-' .
		substr($s, 20);
	return $guidText;
}

?>
<!-- Content Header (Page header) -->

<section class="content-header">
	<h1> <?php echo $title; ?> </h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Fournisseur</li>
		<li class="active">Ajouter un fournisseur</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<!-- Full Width boxes (Stat box) -->
	<div class="row">
		<div class="col-md-12">

			<div class="box box-success" id="box_model">
				<div class="box-body">
					<div class="form-group col-md-12" style="padding-top:10px;">
						<div class="pull-right">
							<button type="button" onclick=$("#fromsuplier").submit(); class="btn btn-success btnsp"><i class="fa fa-save fa-2x"></i><br />
								<?php echo $button_text; ?></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-warning btnsp" data-toggle="tooltip" href="<?php echo WEB_URL; ?>supplier/supplierlist.php" data-original-title="Retour"><i class="fa fa-reply  fa-2x"></i><br />
								Retour</a> </div>
					</div>
				</div>
			</div>
			<div class="box box-success">
				<!-- <div class="box-header">
        <h3 class="box-title">Supplier Entry Form</h3>
      </div> -->
				<form id="fromsuplier" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label for="txtSName"><span style="color:red;">*</span> Nom du fournisseur :</label>
							<input required type="text" name="txtSName" value="<?php echo $s_name; ?>" id="txtSName" class="form-control" />
						</div>
						<div class="form-group">
							<label for="txtSEmail"><span style="color:red;">*</span> Email :</label>
							<input required type="text" name="txtSEmail" value="<?php echo $s_email; ?>" id="txtSEmail" class="form-control" />
						</div>
						<div class="form-group">
							<label for="txtSAddress"><span style="color:red;">*</span> Addresse :</label>
							<textarea required name="txtSAddress" id="txtSAddress" class="form-control"><?php echo $s_address; ?></textarea>
						</div>
						<div class="form-group">
							<label for="txtPhonenumber"><span style="color:red;">*</span> Téléphone :</label>
							<input required type="text" maxlength="10" name="txtPhonenumber" value="<?php echo $phone_number; ?>" id="txtPhonenumber" class="form-control" />
						</div>
						<!-- <div class="form-group">
							<label for="txtWebsite">Liste de fabricants</label><br />
							<div class="ssbox">
								<?php
								$manufacturers = $wms->getAllManufacturerList($link);
								foreach ($manufacturers as $manufacturer) { ?>
									<div class="chkBoxStyle"><input <?php if (!empty($manufacturer) && supplierIdExist($manufacturerInfo, $manufacturer['id'])) {
																										echo 'checked';
																									} ?> type="checkbox" id="<?php echo $manufacturer['id']; ?>" name="manufacturer[]" value="<?php echo $manufacturer['id']; ?>"> <label for="<?php echo $manufacturer['id']; ?>"><?php echo $manufacturer['name']; ?></label>&nbsp;&nbsp;<img style="float:right;" class="img_small" src="<?php echo $manufacturer['image']; ?>" /></div>
								<?php } ?>
							</div>
						</div> -->
						<!-- <div class="form-group">
							<label for="txtSPassword"><span style="color:red;">*</span> Password :</label>
							<input type="password" name="txtSPassword" value="<?php echo $s_password; ?>" id="txtSPassword" class="form-control" />
						</div> -->
						<div class="form-group">
							<label for="Prsnttxtarea">Image :</label>
							<img class="form-control" src="<?php echo $image_sup; ?>" style="height:100px;width:100px;" id="output" />
							<input type="hidden" name="img_exist" value="<?php echo $img_track; ?>" />
						</div>
						<div class="form-group"> <span class="btn btn-file btn btn-primary">Uploader une image
								<input type="file" name="uploaded_file" onchange="loadFile(event)" />
							</span> </div>
					</div>
					<input type="hidden" value="<?php echo $hdnid; ?>" name="supplier_id" />
				</form>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
	<!-- /.row -->

	<!-- <script type="text/javascript">
		function validateMe() {
			if ($("#txtSName").val() == '') {
				alert("Nom du fournisseur est Obligatoire !!!");
				$("#txtSName").focus();
				return false;
			} else if ($("#txtSEmail").val() == '') {
				alert("Email est Obligatoire !!!");
				$("#txtSEmail").focus();
				return false;
			} else if ($("#txtSAddress").val() == '') {
				alert("Address est Obligatoire !!!");
				$("#txtSAddress").focus();
				return false;
			} else if ($("#ddlCountry").val() == '') {
				alert("Country est Obligatoire !!!");
				$("#ddlCountry").focus();
				return false;
			} else if ($("#ddlState").val() == '') {
				alert("State est Obligatoire !!!");
				$("#ddlState").focus();
				return false;
			} else if ($("#txtPhonenumber").val() == '') {
				alert("Phone est Obligatoire !!!");
				$("#txtPhonenumber").focus();
				return false;
			} else if ($("#txtPostcode").val() == '') {
				alert("Postcodess est Obligatoire !!!");
				$("#txtPostcode").focus();
				return false;
			} else if ($("#txtSPassword").val() == '') {
				alert("Password est Obligatoire !!!");
				$("#txtSPassword").focus();
				return false;
			} else if ($("#txtSPassword").val() == '') {
				alert("Password est Obligatoire !!!");
				$("#txtSPassword").focus();
				return false;
			} else {
				return true;
			}
		}
	</script> -->
	<script type="text/javascript">
		$(document).ready(function() {
			setTimeout(function() {
				$("#me").hide(300);
				$("#you").hide(300);
			}, 3000);
		});
	</script>

	<?php include('../footer.php'); ?>