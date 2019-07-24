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

		$image_sign_client_verso = '../img/signature/' . $_GET['contact'] . '_cli_' . $_GET['car_id'] . '_' . $_GET['etat'] . '.png';
		$image_sign_tech_verso = '../img/signature/' . $_GET['contact'] . '_tech_' . $_GET['car_id'] . '_' . $_GET['etat'] . '.png';
		?>
	</div>

	<!-- Si c'est le client qui signe au verso -->
	<?php if ($_GET['sign'] == 'client' && $_GET['etat'] == 'verso') {

		?>

		<button id="btnSaveSignClientverso" class="btn btn-primary btn-lg active" role="button">
			Enregistrer la signature
		</button>

	<?php } ?>

	<!-- Si c'est le réceptionniste qui signe à la verso -->
	<?php if ($_GET['sign'] == 'tech' && $_GET['etat'] == 'verso') {

		?>

		<button id="btnSaveSignTechverso" class="btn btn-primary btn-lg active" role="button">
			Enregistrer la signature
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

		$("#btnSaveSignClientverso").click(function(e) {
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
					var image_url = "<?php echo $image_sign_client_verso; ?>";
					var login_type = "<?php echo $_GET['login_type']; ?>";
					//ajax call to save image inside folder
					$.ajax({
						url: 'save_sign_verso.php',
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
							window.location.href = web_url + "repaircar/repaircar_doc_verso.php?car_id=" + car_id + "&etat=" + etat + "&sign=" + signataire + "&image=" + image_url+ "&login_type=" + login_type;;
						}
					});
				}
			});
		});

		$("#btnSaveSignTechverso").click(function(e) {
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
					var image_url = "<?php echo $image_sign_tech_verso; ?>";
					var login_type = "<?php echo $_GET['login_type']; ?>";
					//ajax call to save image inside folder
					$.ajax({
						url: 'save_sign_verso.php',
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
							window.location.href = web_url + "repaircar/repaircar_doc_verso.php?car_id=" + car_id + "&etat=" + etat + "&sign=" + signataire + "&image=" + image_url+ "&login_type=" + login_type;
						}
					});
				}
			});
		});
	</script>


</body>

</html>