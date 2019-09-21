<?php
include("../config.php");
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Formulaire de Signatures</title>
	<link href="./css/jquery.signaturepad.css" rel="stylesheet">
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
	<script src="./js/jquery-1.10.2.min.js"></script>
	<script src="./js/numeric-1.2.6.min.js"></script>
	<script src="./js/bezier.js"></script>
	<script src="./js/jquery.signaturepad.js"></script>
	<link href="<?php echo WEB_URL; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

	<!-- <script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script> -->
	<script type='text/javascript' src="./js/html2canvas.js"></script>
	<script src="./js/json2.min.js"></script>


	<style type="text/css">
		body {
			font-family: monospace;
			text-align: center;
		}

		#btnSaveSign {
			color: #fff;
			background: #f99a0b;
			padding: 5px;
			border: none;
			border-radius: 5px;
			font-size: 20px;
			margin-top: 10px;
		}

		#signArea {
			width: 304px;
			margin: 50px auto;
		}

		.sign-container {
			width: 60%;
			margin: auto;
		}

		.sign-preview {
			width: 150px;
			height: 50px;
			/* border: solid 1px #CFCFCF; */
			margin: 10px 5px;
		}

		.tag-ingo {
			font-family: cursive;
			font-size: 12px;
			text-align: left;
			font-style: oblique;
		}
	</style>
</head>

<body>

	<h2>Formulaire de Signature </h2>

	<div id="signArea" style="display:flex;align-items:center;flex-direction:column;justify-content:space-around;">
		<h2 class="tag-ingo">Signez ci-dessous,</h2>
		<div class="sig sigWrapper" style="height:auto;width:610px">
			<div class="typed"></div>
			<canvas id="sign-pad" width="600" height="300"></canvas>
		</div>
	</div>

	<!-- <button id="btnSaveSign">Enregistrer Signature</button> -->

	<div class="sign-container">
		<?php
		// Récupération de la liste de toutes les images de signatures enregistrées dans le dossier cible
		$image_list = glob("./doc_signs/*.png");
		// Déclaration et initialisation des variables des images des signatures du client et du receptionniste
		// $image_sign_client_depot = './doc_signs/' . $_GET['contact'] . '_cli_' . $_GET['car_id'] . '_' . $_GET['etat'] . '.png';
		// $image_sign_recep_depot = './doc_signs/' . $_GET['contact'] . '_recep_' . $_GET['car_id'] . '_' . $_GET['etat'] . '.png';
		// $image_sign_client_sortie = './doc_signs/' . $_GET['contact'] . '_cli_' . $_GET['car_id'] . '_' . $_GET['etat'] . '.png';
		// $image_sign_recep_sortie = './doc_signs/' . $_GET['contact'] . '_recep_' . $_GET['car_id'] . '_' . $_GET['etat'] . '.png';

		$image_sign_client_depot = '../img/signature/' . $_GET['contact'] . '_cli_' . $_GET['car_id'] . '_' . $_GET['etat'] . '.png';
		$image_sign_recep_depot = '../img/signature/' . $_GET['contact'] . '_recep_' . $_GET['car_id'] . '_' . $_GET['etat'] . '.png';
		$image_sign_client_sortie = '../img/signature/' . $_GET['contact'] . '_cli_' . $_GET['car_id'] . '_' . $_GET['etat'] . '.png';
		$image_sign_recep_sortie = '../img/signature/' . $_GET['contact'] . '_recep_' . $_GET['car_id'] . '_' . $_GET['etat'] . '.png';
		foreach ($image_list as $image) {
			// echo $image;
			// var_dump($image_list);
			?>
			<!-- <img src="<?php echo $image; ?>" class="sign-preview" /> -->
		<?php
		}
		?>
	</div>

	<!-- Si c'est le client qui signe au dépot -->
	<?php if ($_GET['sign'] == 'client' && $_GET['etat'] == 'depot') {

		?>

		<button id="btnSaveSignClientDepot" class="btn btn-primary btn-lg active" role="button">
			<!-- <a class="btn btn-primary btn-lg active" role="button" aria-pressed="true" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc_gene.php?car_id=<?php echo $_GET['car_id']; ?>&image=<?php echo $image_sign_client_depot; ?>&sign=<?php echo $_GET['sign']; ?>&etat=<?php echo $_GET['etat']; ?>"> -->
			Enregistrer la signature
			<!-- </a> -->
		</button>

	<?php } ?>

	<!-- Si c'est le client qui signe à la sortie -->
	<?php if ($_GET['sign'] == 'client' && $_GET['etat'] == 'sortie') {

		?>

		<button id="btnSaveSignClientSortie" class="btn btn-primary btn-lg active" role="button">
			<!-- <a class="btn btn-primary btn-lg active" role="button" aria-pressed="true" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc_gene.php?car_id=<?php echo $_GET['car_id']; ?>&image=<?php echo $image_sign_client_sortie; ?>&sign=<?php echo $_GET['sign']; ?>&etat=<?php echo $_GET['etat']; ?>"> -->
			Enregistrer la signature
			<!-- </a> -->
		</button>

	<?php } ?>

	<!-- Si c'est le réceptionniste qui signe au depot -->
	<?php if ($_GET['sign'] == 'recep' && $_GET['etat'] == 'depot') {

		?>

		<!-- A la soumission du bouton,  -->
		<button id="btnSaveSignRecepDepot" class="btn btn-primary btn-lg active" role="button">
			<!-- <a class="btn btn-primary btn-lg active" role="button" aria-pressed="true" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc_gene.php?car_id=<?php echo $_GET['car_id']; ?>&image=<?php echo $image_sign_recep_depot; ?>&sign=<?php echo $_GET['sign']; ?>&etat=<?php echo $_GET['etat'] ?>"> -->
			Enregistrer la signature
			<!-- </a> -->
		</button>

	<?php } ?>

	<!-- Si c'est le réceptionniste qui signe à la sortie -->
	<?php if ($_GET['sign'] == 'recep' && $_GET['etat'] == 'sortie') {

		?>

		<button id="btnSaveSignRecepSortie" class="btn btn-primary btn-lg active" role="button">
			<!-- <a class="btn btn-primary btn-lg active" role="button" aria-pressed="true" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc_gene.php?car_id=<?php echo $_GET['car_id']; ?>&image=<?php echo $image_sign_recep_sortie; ?>&sign=<?php echo $_GET['sign']; ?>&etat=<?php echo $_GET['etat']; ?>"> -->
			Enregistrer la signature
			<!-- </a> -->
		</button>

	<?php } ?>

	<script>
		$(document).ready(function() {
			$('#signArea').signaturePad({
				drawOnly: true,
				drawBezierCurves: true,
				lineTop: 0
			});
		});

		$("#btnSaveSignClientDepot").click(function(e) {
			html2canvas([document.getElementById('sign-pad')], {
				onrendered: function(canvas) {
					var canvas_img_data = canvas.toDataURL('image/png');
					var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
					// passage des variables 
					var contact = "<?php echo $_GET['contact']; ?>";
					var signataire = "<?php echo $_GET['sign']; ?>";
					var car_id = "<?php echo $_GET['car_id']; ?>";
					var add_car_id = "<?php echo $_GET['add_car_id']; ?>";
					var etat = "<?php echo $_GET['etat']; ?>";
					var immavehi = "<?php echo $_GET['immavehi']; ?>";
					var web_url = "<?php echo WEB_URL; ?>";
					var image_url = "<?php echo $image_sign_client_depot; ?>";
					var login_type = "<?php echo $_GET['login_type']; ?>";
					//ajax call to save image inside folder
					$.ajax({
						url: 'save_sign.php',
						data: {
							img_data: img_data,
							contact: contact,
							signataire: signataire,
							car_id: car_id,
							add_car_id: add_car_id,
							etat: etat,
							immavehi: immavehi
						},
						type: 'post',
						dataType: 'json',
						success: function(response) {
							window.location.href = web_url + "repaircar/repaircar_doc_gene.php?car_id=" + car_id + "&etat=" + etat + "&sign=" + signataire + "&image=" + image_url+ "&login_type=" + login_type;
						}
					});
				}
			});
		});

		$("#btnSaveSignClientSortie").click(function(e) {
			html2canvas([document.getElementById('sign-pad')], {
				onrendered: function(canvas) {
					var canvas_img_data = canvas.toDataURL('image/png');
					var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
					// passage des variables 
					var contact = "<?php echo $_GET['contact']; ?>";
					var signataire = "<?php echo $_GET['sign']; ?>";
					var car_id = "<?php echo $_GET['car_id']; ?>";
					var add_car_id = "<?php echo $_GET['add_car_id']; ?>";
					var etat = "<?php echo $_GET['etat']; ?>";
					var immavehi = "<?php echo $_GET['immavehi']; ?>";
					var web_url = "<?php echo WEB_URL; ?>";
					var image_url = "<?php echo $image_sign_client_sortie; ?>";
					var login_type = "<?php echo $_GET['login_type']; ?>";
					//ajax call to save image inside folder
					$.ajax({
						url: 'save_sign.php',
						data: {
							img_data: img_data,
							contact: contact,
							signataire: signataire,
							car_id: car_id,
							add_car_id: add_car_id,
							etat: etat,
							immavehi: immavehi
						},
						type: 'post',
						dataType: 'json',
						success: function(response) {
							window.location.href = web_url + "repaircar/repaircar_doc_gene.php?car_id=" + car_id + "&etat=" + etat + "&sign=" + signataire + "&image=" + image_url+ "&login_type=" + login_type;
						}
					});
				}
			});
		});

		$("#btnSaveSignRecepDepot").click(function(e) {
			html2canvas([document.getElementById('sign-pad')], {
				onrendered: function(canvas) {
					var canvas_img_data = canvas.toDataURL('image/png');
					var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
					// passage des variables 
					var contact = "<?php echo $_GET['contact']; ?>";
					var signataire = "<?php echo $_GET['sign']; ?>";
					var car_id = "<?php echo $_GET['car_id']; ?>";
					var add_car_id = "<?php echo $_GET['add_car_id']; ?>";
					var etat = "<?php echo $_GET['etat']; ?>";
					var immavehi = "<?php echo $_GET['immavehi']; ?>";
					var web_url = "<?php echo WEB_URL; ?>";
					var image_url = "<?php echo $image_sign_recep_depot; ?>";
					var login_type = "<?php echo $_GET['login_type']; ?>";
					//ajax call to save image inside folder
					$.ajax({
						url: 'save_sign.php',
						data: {
							img_data: img_data,
							contact: contact,
							signataire: signataire,
							car_id: car_id,
							add_car_id: add_car_id,
							etat: etat,
							immavehi: immavehi
						},
						type: 'post',
						dataType: 'json',
						success: function(response) {
							window.location.href = web_url + "repaircar/repaircar_doc_gene.php?car_id=" + car_id + "&etat=" + etat + "&sign=" + signataire + "&image=" + image_url+ "&login_type=" + login_type;
						}
					});
				}
			});
		});

		$("#btnSaveSignRecepSortie").click(function(e) {
			html2canvas([document.getElementById('sign-pad')], {
				onrendered: function(canvas) {
					var canvas_img_data = canvas.toDataURL('image/png');
					var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
					// passage des variables 
					var contact = "<?php echo $_GET['contact']; ?>";
					var signataire = "<?php echo $_GET['sign']; ?>";
					var car_id = "<?php echo $_GET['car_id']; ?>";
					var add_car_id = "<?php echo $_GET['add_car_id']; ?>";
					var etat = "<?php echo $_GET['etat']; ?>";
					var immavehi = "<?php echo $_GET['immavehi']; ?>";
					var web_url = "<?php echo WEB_URL; ?>";
					var image_url = "<?php echo $image_sign_recep_sortie; ?>";
					var login_type = "<?php echo $_GET['login_type']; ?>";
					//ajax call to save image inside folder
					$.ajax({
						url: 'save_sign.php',
						data: {
							img_data: img_data,
							contact: contact,
							signataire: signataire,
							car_id: car_id,
							add_car_id: add_car_id,
							etat: etat,
							immavehi: immavehi
						},
						type: 'post',
						dataType: 'json',
						success: function(response) {
							window.location.href = web_url + "repaircar/repaircar_doc_gene.php?car_id=" + car_id + "&etat=" + etat + "&sign=" + signataire + "&image=" + image_url+ "&login_type=" + login_type;
						}
					});
				}
			});
		});
	</script>


</body>

</html>