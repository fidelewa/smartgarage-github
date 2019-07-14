<?php

include('config.php');
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
	<link href="<?php echo WEB_URL; ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo WEB_URL; ?>pointage/css/jquery.signaturepad.css" rel="stylesheet">
	<link href="<?php echo WEB_URL; ?>pointage/css/style.css" rel="stylesheet">
	<!-- <script src="pointage/js/jquery-1.10.2.min.js"></script> -->
	<!-- <script src="<?php echo WEB_URL; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="<?php echo WEB_URL; ?>pointage/js/numeric-1.2.6.min.js"></script>
	<script src="<?php echo WEB_URL; ?>pointage/js/bezier.js"></script>
	<script src="<?php echo WEB_URL; ?>pointage/js/jquery.signaturepad.js"></script>
	<!-- <script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script> -->
	<script type='text/javascript' src="<?php echo WEB_URL; ?>pointage/js/html2canvas.js"></script>
	<script type="text/javascript" src="<?php echo WEB_URL; ?>pointage/js/date_heure.js"></script>
	<script src="<?php echo WEB_URL; ?>pointage/js/json2.min.js"></script>
	<script src="<?php echo WEB_URL; ?>dist/js/common.js"></script>
	<script type="text/javascript" src="<?php echo WEB_URL; ?>dist/js/typeahead.js"></script>

</head>

<body>

	<!-- Navigation -->
	<nav class="navbar navbar-light navbar-expand-sm fixed-top shadow-sm bg-white">
		<!-- <a href="index.html" class="navbar-brand">Bootstrap 101</a> -->
		<button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"><span class="navbar-toggler-icon"></span></button>
		<div id="navbarSupportedContent" class="collapse navbar-collapse">
			<ul class="navbar-nav ml-auto">
				<!-- <li class="nav-item"><a href="#" class="nav-link">About Us</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Features</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Testimonials</a></li> -->
			</ul>
			<div class="navbar-text ml-lg-3"> <a href="<?php echo WEB_URL; ?>admin.php" class="btn btn-primary text-white shadow">Se connecter</a></div>
		</div>
	</nav>

	<!-- Page Content -->
	<section class="bg-light">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">
					<!-- Affichage de la date et de l'heure en temps réel -->
					<div>
						<span id="date_heure" style="font-size:17pt;"></span>
					</div>

					<h1 class="mt-5">Formulaire de pointage</h1>
					<br>
					<div id="his">
					</div>
					<!-- <form id="pointageForm"> -->
					<div class="form-group row" style="display:flex;align-items:center;flex-direction: column;">
						<label for="phone_number"><span style="color:red;">*</span> N°téléphone :</label>
						<div class="col-sm-6">
							<input required type="text" maxlength="10" class="form-control" name="phone_number" value="" id="phone_number" placeholder="Saisissez votre numéro de téléphone" />
						</div>
					</div>
					<!-- <br> -->
					<div id="signArea" style="display:flex;align-items:center;flex-direction:column;justify-content:space-around;">
						<h2 class="tag-ingo">Signez ci-dessous,</h2>
						<div class="sig sigWrapper" style="height:auto;width:610px">
							<div class="typed"></div>
							<canvas id="sign-pad" width="600" height="300"></canvas>
						</div>
					</div>

					<button id="btnSaveSign">Enregistrer le pointage</button>
					<!-- <button type="submit" class="btn btn-success">Enregistrer Signature</button> -->

					<!-- <div class="sign-container">
						<?php
						$image_list = glob("./pointage/doc_signs/*.png");
						foreach ($image_list as $image) {
							//echo $image;
							?>
														<img src="<?php echo $image; ?>" class="sign-preview" />
						<?php

					}
					?>
					</div> -->
					<!-- </form> -->
				</div>

			</div>
		</div>
	</section>


	<!-- Bootstrap core JavaScript -->
	<!-- <script src="vendor/jquery/jquery.slim.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
	<script>
		$(document).ready(function() {
			$('#signArea').signaturePad({
				drawOnly: true,
				drawBezierCurves: true,
				lineTop: 0
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
						dataType: 'html',
						success: function(response) {

							$("#his").html(response);
							setTimeout(function() {
								$("#his").hide(300);;
							}, 3000);

						}
					});
				}
			});
		});

		window.onload = date_heure('date_heure');
	</script>

</body>

</html>