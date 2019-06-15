<?php include('../header.php');

$msg = '';
$addinfo = 'none';
if (isset($_GET['success']) && $_GET['success'] == 1) {
	$addinfo = 'block';
	$msg = "E-mail du bon de commande envoyé avec succès";
}

// Affectation des variables à la session
if (isset($_GET['boncmde_id'])) {
	$_SESSION['boncmde_id'] = $_GET['boncmde_id'];
}
if (isset($_GET['supplier_id'])) {
	$_SESSION['supplier_id'] = $_GET['supplier_id'];
}

// var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Formulaire d'envoi du bon de commande au fournisseur</title>
	<!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script> -->
	<!-- <script src="<?php echo WEB_URL; ?>supplier/validation.js"></script> -->
	<script type="text/javascript" src="<?php echo WEB_URL; ?>dist/js/typeahead.js"></script>
	<!-- <link rel="stylesheet" href="style.css"> -->
</head>

<body>
	<form action="supplierMailBcdeProcess.php" method="post" id="emailForm" enctype="multipart/form-data">
		<section class="content">
			<!-- Full Width boxes (Stat box) -->
			<div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
				<h4><i class="icon fa fa-check"></i> Success!</h4>
				<?php echo $msg; ?>
			</div>
			<div class="row">
				<div class="col-md-12">

					<div class="box box-success">
						<div class="box-header">
							<h1 class="box-title"> Fournisseur - Formulaire d'envoi du bon de commande aux fournisseurs</h1>
						</div>
						<div class="box-body">
							<div class="contact-form">
								<!-- <?php if (!empty($_GET['success']) && $_GET['success'] == 1) { ?>
															<div id="message" class="alert alert-danger alert-dismissible fade show">The message has been sent.</div>
								<?php } ?> -->
								<div class="form-group row">
									<label class="control-label col-sm-2" for="fname">Fournisseur:</label>
									<div class="col-sm-10" id="supplier_box">
										<input type="text" class="form-control" id="supplier" name="supplier">
										<!-- <select required class="form-control" name="four" id="four" onchange="loadSupplierEmail(this.value);">
											<option value=''>--Sélectionnez un fournisseur--</option>
											<?php
											$result = $wms->getAllSuppliers($link);
											foreach ($result as $row) {
												echo "<option value='" . $row['supplier_id'] . "'>" . $row['s_name'] . "</option>";
											}
											?>
										</select> -->
									</div>
								</div>
								<div class="form-group row">
									<label class="control-label col-sm-2" for="email">Email:</label>
									<div class="col-sm-10" id="email_supplier">
										<input type="email" class="form-control" id="email" name="email">
									</div>
								</div>
								<div class="form-group row">
									<label class="control-label col-sm-2" for="lname">Fichier joint:</label>
									<div class="col-sm-10">
										<span class="btn btn-file btn btn-primary">Ajouter le bon de commande en fichier joint<input required type="file" id="attachFile" name="attachFile" onchange="loadFile(event)" />
										</span>
									</div>
								</div>
								<div class="form-group">
									<label for="exampleInputFile">File input</label>
									<input type="file" id="exampleInputFile">
									<p class="help-block">Example block-level help text here.</p>
								</div>
								<div class="form-group row">
									<label class="control-label col-sm-2" for="comment">Message:</label>
									<div class="col-sm-10">
										<textarea class="form-control" rows="5" name="message" id="message"></textarea>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-default" name="sendEmail">Envoyer</button>
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" name="boncmde_id" value="<?php if (isset($_GET['boncmde_id']) || isset($_SESSION['boncmde_id'])) {
																			echo $_SESSION['boncmde_id'];
																		} ?>">
						<input type="hidden" name="supplier_id" id="supplier_id" value="<?php if (isset($_GET['supplier_id']) || isset($_SESSION['supplier_id'])) {
																							echo $_SESSION['supplier_id'];
																						} ?>">
						<!-- /.box-body -->
					</div>
					<!-- /.box -->

				</div>
			</div>
			</div>
		</section>
	</form>
</body>

<script type="text/javascript">
	function loadSupplierEmail(sid) {
		$.ajax({
			url: '../ajax/getstate.php',
			type: 'POST',
			data: 'sid=' + sid + '&token=getsupplier',
			dataType: 'html',
			success: function(data) {
				$("#email_supplier").html(data);
				// $("#ddlYear").val('data');
			}
		});
	}

	// Déclaration de la fonction
	function loadSupplier(sid) {
		console.log(sid);

		$.ajax({
			url: '../ajax/getstate.php',
			type: 'POST',
			data: 'sid=' + sid + '&token=getsuppliername',
			dataType: 'html',
			success: function(data) {
				$("#supplier_box").html(data);
			}
		});
	}

	$(document).ready(function() {
		setTimeout(function() {
			$("#me").hide(300);
			$("#you").hide(300);
		}, 3000);

		// déclaration de la variable
		var sid = "<?php echo $_SESSION['supplier_id']; ?>";
		// Appel de la fonction et passage du paramètre
		loadSupplier(sid);
		loadSupplierEmail(sid);
	});
</script>

</html>
<?php include('../footer.php'); ?>