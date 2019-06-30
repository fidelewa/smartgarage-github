<?php
include('../header.php');

$success = "none";
$id = "";
$parts_id = '';
$sup_id = 0;
$maufacturer_id = 0;
$c_make = 0;
$c_model = 0;
$c_year = 0;
$title = 'Add New Parts';
$button_text = "Enregistrer information";
$successful_msg = "Add Parts Successfully";
$form_url = WEB_URL . "parts_stock/buyparts.php";
$hdnid = "0";
$image_cus = WEB_URL . 'img/no_image.jpg';
$img_track = '';
$add_date = date('d/m/Y');
$sellprice = '0.00';
$sku = '';
$quantity = '';
$buyprice = '';
$parts_names = '';
$parts_warranty = '';
$parts_model = '';
$parts_condition = 'new';
$row_val = 0;
$mega_html = '';
$total_price = '0.00';
$given_price = '0.00';
$pending_amount = '0.00';
$pid = 0;
$existing_parts = array();

$code_piece = '';
$code_barre_piece = '';
$lib_piece = '';
$type_piece = '';
$famille_piece = '';
$dernier_prix_achat = 0.00;
$montant_frais = 0.00;
$prix_revient = 0.00;
$coefficient = 0;
$prix_base_ht = 0;
$prix_base_ttc = 0;

$invoice_id = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

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


/*#############################################################*/

if (isset($_POST) && !empty($_POST)) {

	$image_url = uploadImage();
	if (empty($image_url)) {
		$image_url = $_POST['img_exist'];
	}

	// Conversion d'ajustement des valeurs ou cast
	$_POST['last_pa'] = (float)$_POST['last_pa'];
	$_POST['mont_frais'] = (float)$_POST['mont_frais'];
	$_POST['prix_revient'] = (float)$_POST['prix_revient'];
	$_POST['coeff'] = (int)$_POST['coeff'];
	$_POST['prix_base_ht'] = (float)$_POST['prix_base_ht'];
	$_POST['prix_base_ttc'] = (float)$_POST['prix_base_ttc'];

	// var_dump($_POST);
	// die();

	// $wms->saveUpdatePieceInfo($link, $_POST, $image_url);

	if ((int)$_POST['piece_id'] > 0) { // Mise à jour ou modification

		// var_dump($_POST);
		// die();

		$wms->saveUpdateBuyPiecesInformation($link, $_POST, $image_url);
		$url = WEB_URL . 'parts_stock/partsstocklist.php?m=up';
		header("Location: $url");
	} else { // Insertion

		// on vérifie si la pièce courante existe dans la table tbl_piece_stock
		// à partir du code de la piece

		$rowPieceStockData = $wms->getPieceStockDataByCodePiece($link, $_POST['code_piece']);

		// var_dump($rowPieceStockData);
		// die();

		// Si ce n'est pas le cas, on l'insère dans les tables tbl_add_piece et tbl_piece_stock
		if (empty($rowPieceStockData) && count($rowPieceStockData) == 0) {
			$wms->saveUpdateBuyPiecesInformation($link, $_POST, $image_url);
			$url = WEB_URL . 'parts_stock/partsstocklist.php?m=add';
			// $url = WEB_URL . 'invoice/invoice_parts_purchase.php?invoice_id=' . $_POST['invoice_id']; //invoice page
			header("Location: $url");
		} else {
			$url = WEB_URL . 'parts_stock/partsstocklist.php?m=exiting_piece';
			// $url = WEB_URL . 'invoice/invoice_parts_purchase.php?invoice_id=' . $_POST['invoice_id']; //invoice page
			header("Location: $url");
		}
	}
	exit();
}

//exisitng work
// $parts = $wms->partsStockList($link);
if (isset($_GET['pid']) && $_GET['pid'] != '') {
	$pid = $_GET['pid'];
	$existing_parts = $wms->getPieceStockInfoByPieceId($link, $_GET['pid']);

	// var_dump($existing_parts);
	// die();

	if (!empty($existing_parts)) {

		$code_piece = $existing_parts['code_piece'];
		$code_barre_piece = $existing_parts['code_barre_piece '];
		$lib_piece = $existing_parts['lib_piece'];
		$type_piece = $existing_parts['type_piece'];
		$famille_piece = $existing_parts['famille_piece'];
		$dernier_prix_achat = $existing_parts['dernier_prix_achat'];
		$montant_frais = $existing_parts['montant_frais'];
		$prix_revient = $existing_parts['prix_revient'];
		$coefficient = $existing_parts['coefficient'];
		$prix_base_ht = $existing_parts['prix_base_ht'];
		$prix_base_ttc = $existing_parts['prix_base_ttc'];
		// $quantity = $existing_parts['coefficient'];
		// $sku = $existing_parts['part_no'];
		if ($existing_parts['image_url'] != '') {
			$image_cus = WEB_URL . 'img/upload/' . $existing_parts['image_url'];
			$img_track = $existing_parts['image_url'];
		}
		$hdnid = $existing_parts['add_piece_id'];
	}
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
	<h1><i class="fa fa-plus"></i> Stock des pièces - Créer article</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo WEB_URL ?>parts_stock/buypartslist.php">Créer article</a></li>
		<li class="active">Créer article</li>
	</ol>
</section>
<!-- Main content -->
<section class="container" style="margin-top:50px">
	<form onSubmit="return validateMe();" id="from_add_buy_parts" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">
		<!-- Full Width boxes (Stat box) -->
		<div class="row">
			<div class="col-md-12">
				<div class="box box-success">
					<div class="box-body">
						<div class="row">
							<div class="form-group col-md-6">
								<label for="code_piece"> Code:</label>
								<input type="text" name="code_piece" value="<?php echo $code_piece; ?>" id="code_piece" class="form-control" />
							</div>
							<div class="form-group col-md-6">
								<label for="txtCName"> Code barre:</label>
								<input type="text" name="code_barre_piece" value="<?php echo $code_barre_piece; ?>" id="code_barre_piece" class="form-control" />
							</div>
							<div class="form-group col-md-12">
								<label for="lib_piece"> Libellé:</label>
								<input type="text" name="lib_piece" value="<?php echo $lib_piece; ?>" id="lib_piece" class="form-control" />
							</div>
							<div class="form-group col-md-12">
								<label for="type_piece"> Type:</label>
								<select class='form-control' id="type_piece" name="type_piece">
									<option value="">--Sélectionner le type de l'article--</option>
									<?php
									if (isset($type_piece) && ($type_piece == "unité")) {
										echo "<option selected value='" . $type_piece . "'>Unité</option>";
										echo "<option value='litre'>Litre</option>";
									} elseif (isset($type_piece) && ($type_piece == "litre")) {
										echo "<option value='unité'>Unité</option>";
										echo "<option selected value='" . $type_piece . "'>Litre</option>";
									} else {
										echo "<option value='unité'>Unité</option>";
										echo "<option value='litre'>Litre</option>";
									} ?>
								</select>
							</div>
							<div class="form-group col-md-12">
								<label for="famille_piece"> Famille:</label>
								<select class='form-control' id="famille_piece" name="famille_piece">
									<option value="">--Sélectionner la famille de l'article--</option>
									<?php
									if (isset($famille_piece) && ($famille_piece == "huile")) {
										echo "<option selected value='" . $famille_piece . "'>Huile</option>";
										echo "<option value='mecanique'>Mécanique</option>";
										echo "<option value='electrique'>Electrique</option>";
										echo "<option value='accessoire'>Accessoire</option>";
									} elseif (isset($famille_piece) && ($famille_piece == "mecanique")) {
										echo "<option value='huile'>Huile</option>";
										echo "<option selected value='" . $famille_piece . "'>Mécanique</option>";
										echo "<option value='electrique'>Electrique</option>";
										echo "<option value='accessoire'>Accessoire</option>";
									} elseif (isset($famille_piece) && ($famille_piece == "electrique")) {
										echo "<option value='huile'>Huile</option>";
										echo "<option value='mecanique'>Mécanique</option>";
										echo "<option selected value='" . $famille_piece . "'>Electrique</option>";
										echo "<option value='accessoire'>Accessoire</option>";
									} elseif (isset($famille_piece) && ($famille_piece == "accessoire")) {
										echo "<option value='huile'>Huile</option>";
										echo "<option value='mecanique'>Mécanique</option>";
										echo "<option value='electrique'>Electrique</option>";
										echo "<option selected value='" . $famille_piece . "'>Accessoire</option>";
									} else {
										echo "<option value='huile'>Huile</option>";
										echo "<option value='mecanique'>Mécanique</option>";
										echo "<option value='electrique'>Electrique</option>";
										echo "<option value='accessoire'>Accessoire</option>";
									} ?>
								</select>
							</div>
						</div>
						<div class="row">
							<fieldset>

								<!-- <div class="row"> -->
								<div class="form-group col-md-12">
									<legend>Général</legend>
									<label for="last_pa"> Dernier prix d'achat:</label>
									<input type="number" name="last_pa" value="<?php echo $dernier_prix_achat; ?>" id="last_pa" class="form-control" />
								</div>
								<div class="form-group col-md-12">
									<label for="mont_frais"> Frais:</label>
									<input type="number" name="mont_frais" value="<?php echo $montant_frais ?>" id="mont_frais" class="form-control" />
								</div>
								<div class="form-group col-md-12">
									<label for="prix_revient"> Prix de revient:</label>
									<input type="number" name="prix_revient" value="<?php echo $prix_revient ?>" id="prix_revient" class="form-control" />
								</div>
								<div class="form-group col-md-12">
									<label for="coeff"> Coefficient:</label>
									<input type="number" name="coeff" value="<?php echo $coefficient ?>" id="coeff" class="form-control" />
								</div>
								<div class="form-group col-md-12">
									<label for="prix_base_ht"> Prix de base HT:</label>
									<input type="number" name="prix_base_ht" value="<?php echo $prix_base_ht ?>" id="prix_base_ht" class="form-control" />
								</div>
								<div class="form-group col-md-12">
									<label for="prix_base_ttc"> Prix de base TTC:</label>
									<input type="number" name="prix_base_ttc" value="<?php echo $prix_base_ttc ?>" id="prix_base_ttc" class="form-control" />
								</div>
								<!-- </div> -->
							</fieldset>
						</div>
						<div class="form-group col-md-12">
							<label for="Prsnttxtarea">Visualiser :</label>
							<img class="form-control" src="<?php echo $image_cus; ?>" style="height:125px;width:125px;" id="output" />
							<input type="hidden" name="img_exist" value="<?php echo $img_track; ?>" />
						</div>
						<div class="form-group col-md-12"> <span class="btn btn-file btn btn-primary">Ajouter une image
								<input type="file" name="uploaded_file" onchange="loadFile(event)" />
							</span> </div>
					</div>

				</div>
				<!-- /.box -->

			</div>
		</div>

		<input type="hidden" value="<?php echo $hdnid; ?>" name="piece_id" />
		<!-- <input type="hidden" value="<?php echo $quantity; ?>" name="old_qty" /> -->

		<div class="pull-right">
			<button type="submit" class="btn btn-success btnsp"><i class="fa fa-save fa-2x"></i><br />
				<?php echo $button_text; ?></button>&emsp;
			<!-- <a class="btn btn-warning btnsp" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Retour"><i class="fa fa-reply  fa-2x"></i><br />
				Retour</a> -->
		</div>
	</form>
</section>
<!-- /.row -->
<script type="text/javascript">
	// function validateMe() {
	// 	if ($("#parts_names").val() == '') {
	// 		alert("Nom des pièces est Obligatoire !!!");
	// 		$("#parts_names").focus();
	// 		return false;
	// 	} else if ($("#ddlMake").val() == '') {
	// 		alert("Parts Make est Obligatoire !!!");
	// 		$("#ddlMake").focus();
	// 		return false;
	// 	} else if ($("#ddl_model").val() == '') {
	// 		alert("Parts Model est Obligatoire !!!");
	// 		$("#ddl_model").focus();
	// 		return false;
	// 	} else if ($("#ddlYear").val() == '') {
	// 		alert("Parts Year est Obligatoire !!!");
	// 		$("#ddlYear").focus();
	// 		return false;
	// 	} else if ($("#ddl_supplier").val() == '') {
	// 		alert("Parts Supplier est Obligatoire !!!");
	// 		$("#ddl_supplier").focus();
	// 		return false;
	// 	} else if ($("#ddl_load_manufracturer").val() == '') {
	// 		alert("Manufacturer est Obligatoire !!!");
	// 		$("#ddl_load_manufracturer").focus();
	// 		return false;
	// 	} else if ($("#txtCondition").val() == '') {
	// 		alert("Condition est Obligatoire !!!");
	// 		$("#txtCondition").focus();
	// 		return false;
	// 	} else if ($("#buy_prie").val() == '') {
	// 		alert("Prix d'achat Date est Obligatoire !!!");
	// 		$("#buy_prie").focus();
	// 		return false;
	// 	} else if ($("#sell_price").val() == '') {
	// 		alert("Date de livraisonest Obligatoire !!!");
	// 		$("#sell_price").focus();
	// 		return false;
	// 	} else if ($("#parts_quantity").val() == '') {
	// 		alert("Quantity est Obligatoire !!!");
	// 		$("#parts_quantity").focus();
	// 		return false;
	// 	} else if ($("#parts_sell_price").val() == '') {
	// 		alert("Parts Prix de vente est Obligatoire !!!");
	// 		$("#parts_sell_price").focus();
	// 		return false;
	// 	} else if ($("#ddl_status").val() == '') {
	// 		alert("Parts Status est Obligatoire !!!");
	// 		$("#ddl_status").focus();
	// 		return false;
	// 	} else if ($("#parts_sku").val() == '') {
	// 		alert("Parts Model est Obligatoire !!!");
	// 		$("#parts_sku").focus();
	// 		return false;
	// 	} else {
	// 		return true;
	// 	}
	// }

	function prixRevientCalculate() {

		// Déclaration et initialisation des variables
		var prixRevient = 0;
		var prixAchat = 0;
		var montFrais = 0;

		// On récupère la valeur du prix d'achat
		if ($("#last_pa").val() != '') {
			prixAchat = $("#last_pa").val();
		}

		// On récupère la valeur du montant des frais
		if ($("#mont_frais").val() != '') {
			montFrais = $("#mont_frais").val();
		}

		// Calcul du prix de revient
		prixRevient = parseFloat(prixAchat) + parseFloat(montFrais);

		// Formatage et affichage du prix de revient 
		prixRevient = parseFloat(prixRevient).toFixed(2);
		$("#prix_revient").val(prixRevient);

	}

	function prixBaseHTCalculate() {

		// Déclaration et initialisation des variables
		var coeff = 0;
		var prixRevient = 0;
		var prixBaseHT = 0;

		// On récupère la valeur du coefficient
		if ($("#coeff").val() != '') {
			coeff = $("#coeff").val();
		}

		// On récupère la valeur du prix de revient
		if ($("#prix_revient").val() != '') {
			prixRevient = $("#prix_revient").val();
		}

		// Calcul du prix de base HT
		prixBaseHT = parseInt(coeff) * parseFloat(prixRevient);

		// Formatage et affichage du prix de base HT
		prixBaseHT = parseFloat(prixBaseHT).toFixed(2);
		$("#prix_base_ht").val(prixBaseHT);

	}

	function prixBaseTTCCalculate() {

		// Déclaration et initialisation des variables
		var tva = 0.18;
		var montantTVA = 0;
		var prixBaseHT = 0;
		var prixBaseTTC = 0;

		// On récupère la valeur du prix de base HT
		if ($("#prix_base_ht").val() != '') {
			prixBaseHT = $("#prix_base_ht").val();
		}

		// Calcul du montant de la TVA
		montantTVA = parseFloat(tva) * parseFloat(prixBaseHT);

		// Calcul du prix de base TTC
		prixBaseTTC = parseFloat(prixBaseHT) + parseFloat(montantTVA);

		// Formatage et affichage du prix de base TTC
		prixBaseTTC = parseFloat(prixBaseTTC).toFixed(2);
		$("#prix_base_ttc").val(prixBaseTTC);

	}

	$("#last_pa").keyup(function() {
		prixRevientCalculate();
	});

	$("#mont_frais").keyup(function() {
		prixRevientCalculate();
	});

	$("#coeff").keyup(function() {
		prixBaseHTCalculate();
		prixBaseTTCCalculate();
	});

	// $("#prix_base_ht").change(function() {
	// 	prixBaseTTCCalculate();
	// });
</script>
<?php include('../footer.php'); ?>