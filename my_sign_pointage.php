<?php

include('config.php');

var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Formulaire de pointage</title>

	<!-- Bootstrap core CSS -->
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="pointage/css/jquery.signaturepad.css" rel="stylesheet">
	<!-- <script src="pointage/js/jquery-1.10.2.min.js"></script> -->
	<script src="<?php echo WEB_URL; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="pointage/js/numeric-1.2.6.min.js"></script>
	<script src="pointage/js/bezier.js"></script>
	<script src="pointage/js/jquery.signaturepad.js"></script>
	<!-- <script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script> -->
	<script type='text/javascript' src="pointage/js/html2canvas.js"></script>
	<script src="pointage/js/json2.min.js"></script>


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
			border: solid 1px #CFCFCF;
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

	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
		<div class="container">
			<!-- <a class="navbar-brand" href="#">Start Bootstrap</a> -->
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" href="<?php echo WEB_URL; ?>admin.php">Se connecter</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Page Content -->
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<h1 class="mt-5">Formulaire de pointage</h1>
				<br>
				<!-- <form id="pointageForm"> -->
					<div class="form-group row" style="display:flex;align-items:center;flex-direction: column;">
						<label for="phone_number"><span style="color:red;">*</span> N°Téléphone :</label>
						<div class="col-sm-6">
							<input required type="text" class="form-control" name="phone_number" value="" id="phone_number" placeholder="Saisissez votre numéro de téléphone" />
						</div>
					</div>
					<br>
					<div id="signArea">
						<h2 class="tag-ingo">Signez ci-dessous,</h2>
						<div class="sig sigWrapper" style="height:auto;">
							<div class="typed"></div>
							<canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
						</div>
					</div>

					<button id="btnSaveSign">Enregistrer Signature</button>
					<!-- <button type="submit" class="btn btn-success">Enregistrer Signature</button> -->

					<div class="sign-container">
						<?php
						$image_list = glob("./pointage/doc_signs/*.png");
						foreach ($image_list as $image) {
							//echo $image;
							?>
							<img src="<?php echo $image; ?>" class="sign-preview" />
						<?php

					}
					?>
					</div>
				<!-- </form> -->
			</div>
		</div>
	</div>

	<!-- Bootstrap core JavaScript -->
	<!-- <script src="vendor/jquery/jquery.slim.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
	<script>
		$(document).ready(function() {
			$('#signArea').signaturePad({
				drawOnly: true,
				drawBezierCurves: true,
				lineTop: 90
			});
		});

		$("#btnSaveSign").click(function(e) {
			
			html2canvas([document.getElementById('sign-pad')], {
				onrendered: function(canvas) {
					var canvas_img_data = canvas.toDataURL('image/png');
					var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
					var web_url = "<?php echo WEB_URL; ?>";
					var phone_number = document.getElementById('phone_number').value;

					//ajax call to save image inside folder
					$.ajax({
						url: 'pointage/traitement_pointage.php',
						data: {
							img_data: img_data,
							phone_number: phone_number
						},
						type: 'post',
						dataType: 'json',
						success: function(response) {
							// window.location.reload();
							window.location.href = web_url;
							console.log(response.msg);
						}
					});
				}
			});
		});
	</script>

</body>

</html>