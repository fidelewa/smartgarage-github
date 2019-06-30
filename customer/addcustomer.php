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
$c_type_client = '';
$c_civilite_client = '';
$c_princ_tel = '';
$c_tel_wa = '';
$c_tel_dom = '';
$title = 'Add New Customer';
$button_text = "Enregistrer information";
$successful_msg = "Add Customer Successfully";
$form_url = WEB_URL . "customer/addcustomer.php";
$id = "";
$hdnid = "0";
$image_cus = WEB_URL . 'img/no_image.jpg';
$img_track = '';
$wow = false;

/*#############################################################*/
if (isset($_POST['txtCName'])) {

	// var_dump($_FILES["pj_1"]);

	// Récupération des URL des pièces jointes
	if (isset($_FILES["pj_1"]) && !empty($_FILES["pj_1"])) {
		$_POST['pj1_url'] = uploadPJ_1();
	}
	if (isset($_FILES["pj_2"]) && !empty($_FILES["pj_2"])) {
		$_POST['pj2_url'] = uploadPJ_2();
	}
	if (isset($_FILES["pj_3"]) && !empty($_FILES["pj_3"])) {
		$_POST['pj3_url'] = uploadPJ_3();
	}
	if (isset($_FILES["pj_4"]) && !empty($_FILES["pj_4"])) {
		$_POST['pj4_url'] = uploadPJ_4();
	}
	if (isset($_FILES["pj_5"]) && !empty($_FILES["pj_5"])) {
		$_POST['pj5_url'] = uploadPJ_5();
	}
	if (isset($_FILES["pj_6"]) && !empty($_FILES["pj_6"])) {
		$_POST['pj6_url'] = uploadPJ_6();
	}
	if (isset($_FILES["pj_7"]) && !empty($_FILES["pj_7"])) {
		$_POST['pj7_url'] = uploadPJ_7();
	}
	if (isset($_FILES["pj_8"]) && !empty($_FILES["pj_8"])) {
		$_POST['pj8_url'] = uploadPJ_8();
	}
	if (isset($_FILES["pj_9"]) && !empty($_FILES["pj_9"])) {
		$_POST['pj9_url'] = uploadPJ_9();
	}
	if (isset($_FILES["pj_10"]) && !empty($_FILES["pj_10"])) {
		$_POST['pj10_url'] = uploadPJ_10();
	}
	if (isset($_FILES["pj_11"]) && !empty($_FILES["pj_11"])) {
		$_POST['pj11_url'] = uploadPJ_11();
	}
	if (isset($_FILES["pj_12"]) && !empty($_FILES["pj_12"])) {
		$_POST['pj12_url'] = uploadPJ_12();
	}

	// var_dump($_POST);

	// die();

	// A la soumission du formulaire
	// Affectation de la valeur du numéro de téléphone à la valeur du mot de passe
	$_POST['txtCPassword'] = $_POST['princ_tel'];

	// if(!$wms->checkCustomerEmailAddress($link, $_POST['txtCEmail'])) {
	$image_url = uploadImage();
	if (empty($image_url)) {
		$image_url = $_POST['img_exist'];
	}
	$wms->saveUpdateCustomerInformation($link, $_POST, $image_url);
	if ((int) $_POST['customer_id'] > 0) {
		$url = WEB_URL . 'customer/customerlist.php?m=up';
		header("Location: $url");
	} else {
		$url = WEB_URL . 'repaircar/addcar.php?m=add_customer';
		header("Location: $url");
	}
	exit();
	// } else {
	// 	$wow = true;
	// }
}

if (isset($_GET['id']) && $_GET['id'] != '') {
	$row = $wms->getCustomerInfoByCustomerId($link, $_GET['id']);

	// var_dump($row);

	if (!empty($row)) {
		$c_name = $row['c_name'];
		$c_email = $row['c_email'];
		$c_address = $row['c_address'];
		$c_home_tel = $row['c_home_tel'];
		$c_work_tel = $row['c_work_tel'];
		$c_mobile = $row['c_mobile'];
		$c_password = $row['c_password'];
		if ($row['image'] != '') {
			$image_cus = WEB_URL . 'img/upload/' . $row['image'];
			$img_track = $row['image'];
		}
		$c_type_client = $row['type_client'];
		$c_civilite_client = $row['civilite_client'];
		$c_princ_tel = $row['princ_tel'];
		$c_tel_wa = $row['tel_wa'];
		$c_tel_dom = $row['tel_dom'];
		$hdnid = $_GET['id'];
		$title = 'Update Customer';
		$button_text = "Modifier les informations";
		$successful_msg = "Update Customer Successfully";
		$form_url = WEB_URL . "customer/addcustomer.php?id=" . $_GET['id'];
	}
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

function uploadPJ_1()
{
	if ((!empty($_FILES["pj_1"])) && ($_FILES['pj_1']['error'] == 0)) {
		$filename = basename($_FILES['pj_1']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if (($ext == "jpg" && $_FILES["pj_1"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_1"]["type"] == 'image/png')
			|| ($ext == "gif" && $_FILES["pj_1"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_1"]["type"] == 'application/pdf') || ($ext == "docx")
		) {
			$temp = explode(".", $_FILES["pj_1"]["name"]);
			$newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_1"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_2()
{
	if ((!empty($_FILES["pj_2"])) && ($_FILES['pj_2']['error'] == 0)) {
		$filename = basename($_FILES['pj_2']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if (($ext == "jpg" && $_FILES["pj_2"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_2"]["type"] == 'image/png')
			|| ($ext == "gif" && $_FILES["pj_2"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_2"]["type"] == 'application/pdf') || ($ext == "docx")
		) {
			$temp = explode(".", $_FILES["pj_2"]["name"]);
			$newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_2"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_3()
{
	if ((!empty($_FILES["pj_3"])) && ($_FILES['pj_3']['error'] == 0)) {
		$filename = basename($_FILES['pj_3']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if (($ext == "jpg" && $_FILES["pj_3"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_3"]["type"] == 'image/png')
			|| ($ext == "gif" && $_FILES["pj_3"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_3"]["type"] == 'application/pdf') || ($ext == "docx")
		) {
			$temp = explode(".", $_FILES["pj_3"]["name"]);
			$newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_3"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_4()
{
	if ((!empty($_FILES["pj_4"])) && ($_FILES['pj_4']['error'] == 0)) {
		$filename = basename($_FILES['pj_4']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if (($ext == "jpg" && $_FILES["pj_4"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_4"]["type"] == 'image/png')
			|| ($ext == "gif" && $_FILES["pj_4"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_4"]["type"] == 'application/pdf') || ($ext == "docx")
		) {
			$temp = explode(".", $_FILES["pj_4"]["name"]);
			$newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_4"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_5()
{
	if ((!empty($_FILES["pj_5"])) && ($_FILES['pj_5']['error'] == 0)) {
		$filename = basename($_FILES['pj_5']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if (($ext == "jpg" && $_FILES["pj_5"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_5"]["type"] == 'image/png')
			|| ($ext == "gif" && $_FILES["pj_5"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_5"]["type"] == 'application/pdf') || ($ext == "docx")
		) {
			$temp = explode(".", $_FILES["pj_5"]["name"]);
			$newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_5"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_6()
{
	if ((!empty($_FILES["pj_6"])) && ($_FILES['pj_6']['error'] == 0)) {
		$filename = basename($_FILES['pj_6']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if (($ext == "jpg" && $_FILES["pj_6"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_6"]["type"] == 'image/png')
			|| ($ext == "gif" && $_FILES["pj_6"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_6"]["type"] == 'application/pdf') || ($ext == "docx")
		) {
			$temp = explode(".", $_FILES["pj_6"]["name"]);
			$newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_6"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_7()
{
	if ((!empty($_FILES["pj_7"])) && ($_FILES['pj_7']['error'] == 0)) {
		$filename = basename($_FILES['pj_7']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if (($ext == "jpg" && $_FILES["pj_7"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_7"]["type"] == 'image/png')
			|| ($ext == "gif" && $_FILES["pj_7"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_7"]["type"] == 'application/pdf') || ($ext == "docx")
		) {
			$temp = explode(".", $_FILES["pj_7"]["name"]);
			$newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_7"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_8()
{
	if ((!empty($_FILES["pj_8"])) && ($_FILES['pj_8']['error'] == 0)) {
		$filename = basename($_FILES['pj_8']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if (($ext == "jpg" && $_FILES["pj_8"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_8"]["type"] == 'image/png')
			|| ($ext == "gif" && $_FILES["pj_8"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_8"]["type"] == 'application/pdf') || ($ext == "docx")
		) {
			$temp = explode(".", $_FILES["pj_8"]["name"]);
			$newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_8"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_9()
{
	if ((!empty($_FILES["pj_9"])) && ($_FILES['pj_9']['error'] == 0)) {
		$filename = basename($_FILES['pj_9']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if (($ext == "jpg" && $_FILES["pj_9"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_9"]["type"] == 'image/png')
			|| ($ext == "gif" && $_FILES["pj_9"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_9"]["type"] == 'application/pdf') || ($ext == "docx")
		) {
			$temp = explode(".", $_FILES["pj_9"]["name"]);
			$newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_9"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_10()
{
	if ((!empty($_FILES["pj_10"])) && ($_FILES['pj_10']['error'] == 0)) {
		$filename = basename($_FILES['pj_10']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if (($ext == "jpg" && $_FILES["pj_10"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_10"]["type"] == 'image/png')
			|| ($ext == "gif" && $_FILES["pj_10"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_10"]["type"] == 'application/pdf') || ($ext == "docx")
		) {
			$temp = explode(".", $_FILES["pj_10"]["name"]);
			$newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_10"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_11()
{
	if ((!empty($_FILES["pj_11"])) && ($_FILES['pj_11']['error'] == 0)) {
		$filename = basename($_FILES['pj_11']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if (($ext == "jpg" && $_FILES["pj_11"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_11"]["type"] == 'image/png')
			|| ($ext == "gif" && $_FILES["pj_11"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_11"]["type"] == 'application/pdf') || ($ext == "docx")
		) {
			$temp = explode(".", $_FILES["pj_11"]["name"]);
			$newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_11"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_12()
{
	if ((!empty($_FILES["pj_12"])) && ($_FILES['pj_12']['error'] == 0)) {
		$filename = basename($_FILES['pj_12']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if (($ext == "jpg" && $_FILES["pj_12"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_12"]["type"] == 'image/png')
			|| ($ext == "gif" && $_FILES["pj_12"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_12"]["type"] == 'application/pdf') || ($ext == "docx")
		) {
			$temp = explode(".", $_FILES["pj_12"]["name"]);
			$newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_12"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

?>
<!-- Content Header (Page header) -->

<section class="content-header">
	<h1><i class="fa fa-users"></i> Client </h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo WEB_URL ?>customer.customerlist.php">Client</a></li>
		<li class="active">Add/Update Client</li>
	</ol>
</section>
<!-- Main content -->
<form onSubmit="return validateMe();" method="post" enctype="multipart/form-data">
	<section class="content">
		<!-- Full Width boxes (Stat box) -->
		<div class="row">
			<div class="col-md-12">

				<div class="box box-success">
					<div class="box-header">
						<h3 class="box-title"><i class="fa fa-plus"></i> Formulaire client</h3>
					</div>
					<div class="box-body">

						<div class="form-group">
							<label for="type_client"><span style="color:red;">*</span> Type de client :</label>
							<select required class='form-control' id="type_client" name="type_client">
								<option value="">--Sélectionner le type du client--</option>
								<?php if (isset($c_type_client) && ($c_type_client == "Société")) {
									echo "<option selected value='" . $c_type_client . "'>Société</option>";
									echo "<option value='Particulier'>Particulier</option>";
									echo "<option value='Autre'>Autre</option>";
								} elseif (isset($c_type_client) && ($c_type_client == "Particulier")) {
									echo "<option value='Société'>Société</option>";
									echo "<option selected value='" . $c_type_client . "'>Particulier</option>";
									echo "<option value='Autre'>Autre</option>";
								} elseif (isset($c_type_client) && ($c_type_client == "Autre")) {
									echo "<option value='Société'>Société</option>";
									echo "<option value='Particulier'>Particulier</option>";
									echo "<option selected value='" . $c_type_client . "'>Autre</option>";
								} else {
									echo "<option value='Société'>Société</option>";
									echo "<option value='Particulier'>Particulier</option>";
									echo "<option value='Autre'>Autre</option>";
								}
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="civilite_client"><span style="color:red;">*</span> Civilité du client (Sélectionner aucun pour une société) :</label>
							<select required class='form-control' id="civilite_client" name="civilite_client">
								<option value="<?php echo $c_civilite_client; ?>">--Sélectionner la civilité du client--</option>
								<?php if (isset($c_civilite_client) && ($c_civilite_client == "Monsieur")) {
									echo "<option selected value='" . $c_civilite_client . "'>Monsieur (M)</option>";
									echo "<option value='Madame'>Madame (Mme)</option>";
									echo "<option value='Mademoiselle'>Mademoiselle (Mlle)</option>";
									echo "<option value='Aucun'>Aucun</option>";
								} elseif (isset($c_civilite_client) && ($c_civilite_client == "Madame")) {
									echo "<option value='Monsieur'>Monsieur (M)</option>";
									echo "<option selected value='" . $c_civilite_client . "'>Madame (Mme)</option>";
									echo "<option value='Mademoiselle'>Mademoiselle (Mlle)</option>";
									echo "<option value='Aucun'>Aucun</option>";
								} elseif (isset($c_civilite_client) && ($c_civilite_client == "Mademoiselle")) {
									echo "<option value='Monsieur'>Monsieur (M)</option>";
									echo "<option value='Madame'>Madame (Mme)</option>";
									echo "<option selected value='" . $c_civilite_client . "'>Mademoiselle (Mlle)</option>";
									echo "<option value='Aucun'>Aucun</option>";
								} elseif (isset($c_civilite_client) && ($c_civilite_client == "Aucun")) {
									echo "<option value='Monsieur'>Monsieur (M)</option>";
									echo "<option value='Madame'>Madame (Mme)</option>";
									echo "<option value='Mademoiselle'>Mademoiselle (Mlle)</option>";
									echo "<option selected value='" . $c_civilite_client . "'>Aucun</option>";
								} else {
									echo "<option value='Monsieur'>Monsieur (M)</option>";
									echo "<option value='Madame'>Madame (Mme)</option>";
									echo "<option value='Mademoiselle'>Mademoiselle (Mlle)</option>";
									echo "<option value='Aucun'>Aucun</option>";
								}
								?>

							</select>
						</div>
						<div class="form-group">
							<label for="txtCName"><span style="color:red;">*</span> Nom & prenom:</label>
							<input required type="text" name="txtCName" value="<?php echo $c_name; ?>" id="txtCName" class="form-control" />
						</div>
						<div class="form-group">
							<label for="princ_tel"><span style="color:red;">*</span> Téléphone principal :<span style="color:red;">(ce numéro de téléphone est le mot de passe)</span></label>
							<input onkeyup="verifTelClient(this.value);" required type="text" name="princ_tel" value="<?php echo $c_princ_tel; ?>" id="princ_tel" class="form-control" placeholder="Saisissez votre numéro de téléphone principal" /><span id="telclibox"></span>
							<!-- <input onkeyup="verifTelClient(this.value);" type="text" name="princ_tel" maxlength="10" value="" id="princ_tel" class="form-control" placeholder="Saisissez votre numéro de téléphone principal" /> -->
							<!-- <input onkeyup="verifImma(this.value);" onchange="loadMarqueModeleVoiture(this.value);" type="text" name="immat" id="immat" class="form-control" placeholder="Rechercher un véhicule en saisissant son immatriculation"><span id="immabox"></span> -->
						</div>
						<div class="form-group">
							<label for="txtCEmail"> <span style="color:red;">*</span>E-mail (ou numéro de téléphone si vous n'avez pas d'adresse e-mail):</label>
							<input onkeyup="verifEmailClient(this.value);" required type="text" name="txtCEmail" value="<?php echo $c_email; ?>" id="txtCEmail" class="form-control" /><span id="emailclibox"></span>
						</div>
						<!-- Champ caché pour le mot de passe -->
						<input type="hidden" value="" name="txtCPassword" />
						<div class="form-group">
							<label for="txtCAddress"> Addresse :</label>
							<textarea name="txtCAddress" id="txtCAddress" class="form-control"><?php echo $c_address; ?></textarea>
						</div>
						<!-- <div class="form-group">
							<label for="txtCMobile"><span style="color:red;">*</span> Téléphone mobile :</label>
							<input type="text" name="txtCMobile" value="<?php echo $c_mobile; ?>" id="txtCMobile" class="form-control" placeholder="Saisissez votre numéro de téléphone mobile" />
						</div>
						<div class="form-group">
							<label for="tel_wa"><span style="color:red;">*</span> Téléphone mobile (whatsapp) :</label>
							<input required type="text" name="tel_wa" value="<?php echo $c_tel_wa; ?>" id="tel_wa" class="form-control" placeholder="Saisissez votre numéro de téléphone whatsapp" />
						</div>
						<div class="form-group">
							<label for="txtCHomeTel"> Téléphone domicile :</label>
							<input type="text" name="txtCHomeTel" value="<?php echo $c_tel_dom; ?>" id="txtCHomeTel" class="form-control" placeholder="Saisissez votre numéro de téléphone fixe de domicile" />
						</div>
						<div class="form-group">
							<label for="txtCWorkTel"> Téléphone professionnelle :</label>
							<input type="text" name="txtCWorkTel" value="<?php echo $c_work_tel; ?>" id="txtCWorkTel" class="form-control" placeholder="Saisissez votre numéro de téléphone fixe professionnel" />
						</div>
						<div class="form-group">
							<label for="Prsnttxtarea">Visualiser :</label>
							<img class="form-control" src="<?php echo $image_cus; ?>" style="height:100px;width:100px;" id="output" />
							<input type="hidden" name="img_exist" value="<?php echo $img_track; ?>" />
						</div>
						<div class="form-group"> <span class="btn btn-file btn btn-primary">Upload Image
								<input type="file" name="uploaded_file" onchange="loadFile(event)" />
							</span> </div> -->
						<fieldset>
							<legend>Ajouter des fichiers joints</legend>
							<div class="row">
								<div class="col-md-1 col-sm-1">
									<span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_1" onchange="loadFile(event)" />
									</span>
								</div>
								<div class="col-md-1 col-sm-1">
									<span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_2" onchange="loadFile(event)" />
									</span>
								</div>
								<div class="col-md-1 col-sm-1">
									<span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_3" onchange="loadFile(event)" />
									</span>
								</div>
								<div class="col-md-1 col-sm-1">
									<span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_4" onchange="loadFile(event)" />
									</span>
								</div>
								<div class="col-md-1 col-sm-1">
									<span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_5" onchange="loadFile(event)" />
									</span>
								</div>
								<div class="col-md-1 col-sm-1">
									<span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_6" onchange="loadFile(event)" />
									</span>
								</div>
								<div class="col-md-1 col-sm-1">
									<span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_7" onchange="loadFile(event)" />
									</span>
								</div>
								<div class="col-md-1 col-sm-1">
									<span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_8" onchange="loadFile(event)" />
									</span>
								</div>
								<div class="col-md-1 col-sm-1">
									<span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_9" onchange="loadFile(event)" />
									</span>
								</div>
								<div class="col-md-1 col-sm-1">
									<span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_10" onchange="loadFile(event)" />
									</span>
								</div>
								<div class="col-md-1 col-sm-1">
									<span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_11" onchange="loadFile(event)" />
									</span>
								</div>
								<div class="col-md-1 col-sm-1">
									<span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_12" onchange="loadFile(event)" />
									</span>
								</div>
							</div>
						</fieldset>
					</div>
					<input type="hidden" value="<?php echo $hdnid; ?>" name="customer_id" />

					<!-- /.box-body -->
				</div>
				<!-- /.box -->
				<!-- <div align="right" style="margin-bottom:1%;"> <button class="btn btn-success" type="submit" data-toggle="tooltip" href="javascript:;" data-original-title="<?php echo $button_text; ?>"><i class="fa fa-save fa-2x"></i></button> &nbsp;<a class="btn btn-warning" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/addcar_reception.php" data-original-title="Retour"><i class="fa fa-reply  fa-2x"></i></a> </div> -->
				<div class="pull-right">
					<button type="submit" class="btn btn-success btnsp"><i class="fa fa-save fa-2x"></i><br />
						<?php echo $button_text; ?></button>&emsp;
					<!-- <?php if (isset($_GET['id']) && $_GET['id'] != '') { ?>
								<button type="button" onclick="javascript:window.print();" class="btn btn-danger btnsp"><i class="fa fa-print fa-2x"></i><br />
									Imprimer</button>&emsp;
					<?php } ?> -->
					<a class="btn btn-warning btnsp" data-toggle="tooltip" href="<?php echo WEB_URL; ?>customer/customerlist.php" data-original-title="Retour"><i class="fa fa-reply  fa-2x"></i><br />
						Retour</a> </div>
			</div>
		</div>
		</div>
	</section>
</form>
<!-- /.row -->
<!-- <script type="text/javascript">
	function validateMe() {
		if ($("#txtCName").val() == '') {
			alert("Nom du client est Obligatoire !!!");
			$("#txtCName").focus();
			return false;
		} else if ($("#txtCEmail").val() == '') {
			alert("Email est Obligatoire !!!");
			$("#txtCEmail").focus();
			return false;
		} else if ($("#txtCAddress").val() == '') {
			alert("Address est Obligatoire !!!");
			$("#txtCAddress").focus();
			return false;
		} else if ($("#txtCHomeTel").val() == '') {
			alert("Home Tel Number est Obligatoire !!!");
			$("#txtCHomeTel").focus();
			return false;
		} else if ($("#txtCWorkTel").val() == '') {
			alert("Work Tel Number est Obligatoire !!!");
			$("#txtCWorkTel").focus();
			return false;
		} else if ($("#txtCMobile").val() == '') {
			alert("Mobile Tel Number est Obligatoire !!!");
			$("#txtCMobile").focus();
			return false;
		} else if ($("#txtCPassword").val() == '') {
			alert("Password est Obligatoire !!!");
			$("#txtCPassword").focus();
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