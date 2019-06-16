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
$form_url = WEB_URL . "stock_piece/addpiece.php";
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

	$wms->saveUpdatePieceInfo($link, $_POST, $image_url);
	if ((int)$_POST['piece_id'] > 0) {
		$url = WEB_URL . 'stock_piece/piecestocklist.php?m=up';
		header("Location: $url");
	} else {
		$url = WEB_URL . 'stock_piece/piecestocklist.php?m=add';
		// $url = WEB_URL . 'invoice/invoice_parts_purchase.php?invoice_id=' . $_POST['invoice_id']; //invoice page
		header("Location: $url");
	}
	exit();
}

// if (isset($_GET['invoice_id']) && $_GET['invoice_id'] != '') {
// 	$row = $wms->getBuyPartsListByPartsId($link, $_GET['invoice_id']);
// 	if (!empty($row)) {
// 		$invoice_id = $row['invoice_id'];
// 		$parts_id = $row['parts_id'];
// 		$parts_names = $row['parts_name'];
// 		$sup_id = $row['supplier_id'];
// 		$maufacturer_id = $row['manufacturer_id'];
// 		$buyprice = $row['parts_buy_price'];
// 		$quantity = $row['parts_quantity'];
// 		$sku = $row['parts_sku'];
// 		$sellprice = $row['price'];
// 		$add_date = $wms->mySqlToDatePicker($row['parts_added_date']);
// 		$parts_condition = $row['parts_condition'];
// 		$parts_warranty = $row['parts_warranty'];
// 		if ($row['parts_image'] != '') {
// 			$image_cus = WEB_URL . 'img/upload/' . $row['parts_image'];
// 			$img_track = $row['parts_image'];
// 		}
// 		$total_price = $row['total_amount'];
// 		$given_price = $row['given_amount'];
// 		$pending_amount = $row['pending_amount'];
// 		$hdnid = $row['parts_id'];
// 		$title = 'Update Parts';
// 		$button_text = "Update";

// 		$queryx = $wms->getAllPartsFitDate($link, $row['parts_id']);
// 		if (!empty($queryx)) {
// 			$i = 0;
// 			foreach ($queryx as $frow) {
// 				$make_html = $wms->getmakeHtml($frow['make_id'], $i, $link);
// 				$model_html = $wms->getmodelHtml($frow['make_id'], $frow['model_id'], $i, $link);
// 				$year_html = $wms->getyearHtml($frow['make_id'], $frow['model_id'], $frow['year_id'], $i, $link);

// 				$mega_html .= "<tbody id='parts-row" . $i . "'><tr><td class='left'>" . $make_html . "</td><td class='left'>" . $model_html . "</td><td class='left'>" . $year_html . "</td><td class='left'><button class='btn btn-danger' title='Remove' data-toggle='tooltip' onclick=$('#parts-row" . $i . "').remove(); type='button'><i class='fa fa-minus-circle'></i></button> </td></tr></tbody>";
// 				$i++;
// 			}
// 			$row_val = $i;
// 		}
// 		//$successful_msg="Update Parts Successfully";
// 		//$form_url = WEB_URL . "parts_stock/parts_stock_list.php?id=".$_GET['id'];
// 	}

// 	//mysql_close($link);

// }

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
<form method="post" enctype="multipart/form-data">
	<section class="content">
		<!-- Full Width boxes (Stat box) -->
		<div class="row">
			<div class="col-md-12">
				<div class="box box-success">
					<div class="box-body">
						<div class="row">
							<div class="form-group col-md-6">
								<label for="code_piece"> Code:</label>
								<input type="text" name="code_piece" value="" id="code_piece" class="form-control" />
							</div>
							<div class="form-group col-md-6">
								<label for="txtCName"> Code barre:</label>
								<input type="text" name="code_barre_piece" value="" id="code_barre_piece" class="form-control" />
							</div>
							<div class="form-group col-md-12">
								<label for="lib_piece"> Libellé:</label>
								<input type="text" name="lib_piece" value="" id="lib_piece" class="form-control" />
							</div>
							<div class="form-group col-md-12">
								<label for="type_piece"> Type:</label>
								<select class='form-control' id="type_piece" name="type_piece">
									<option value="">--Sélectionner le type de l'article--</option>
									<option value="unité">Unité</option>
									<option value="litre">Litre</option>
								</select>
							</div>
							<div class="form-group col-md-12">
								<label for="famille_piece"> Famille:</label>
								<select class='form-control' id="famille_piece" name="famille_piece">
									<option value="">--Sélectionner la famille de l'article--</option>
									<option value="huile">Huile</option>
									<option value="mecanique">Mécanique</option>
									<option value="electrique">Electique</option>
									<option value="accessoire">Accessoire</option>
								</select>
							</div>
						</div>
						<div class="row">
							<fieldset>

								<!-- <div class="row"> -->
								<div class="form-group col-md-12">
									<legend>Général</legend>
									<label for="last_pa"> Dernier prix d'achat:</label>
									<input type="number" name="last_pa" value="0.00" id="last_pa" class="form-control" />
								</div>
								<div class="form-group col-md-12">
									<label for="mont_frais"> Frais:</label>
									<input type="number" name="mont_frais" value="0.00" id="mont_frais" class="form-control" />
								</div>
								<div class="form-group col-md-12">
									<label for="prix_revient"> Prix de revient:</label>
									<input type="number" name="prix_revient" value="0.00" id="prix_revient" class="form-control" />
								</div>
								<div class="form-group col-md-12">
									<label for="coeff"> Coefficient:</label>
									<input type="number" name="coeff" value="0" id="coeff" class="form-control" />
								</div>
								<div class="form-group col-md-12">
									<label for="prix_base_ht"> Prix de base HT:</label>
									<input type="number" name="prix_base_ht" value="0.00" id="prix_base_ht" class="form-control" />
								</div>
								<div class="form-group col-md-12">
									<label for="prix_base_ttc"> Prix de base TTC:</label>
									<input type="number" name="prix_base_ttc" value="0.00" id="prix_base_ttc" class="form-control" />
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
		<div class="pull-right">
			<button type="submit" class="btn btn-success btnsp"><i class="fa fa-save fa-2x"></i><br />
				<?php echo $button_text; ?></button>&emsp;
			<!-- <a class="btn btn-warning btnsp" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Retour"><i class="fa fa-reply  fa-2x"></i><br />
				Retour</a> -->
		</div>
</form>
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