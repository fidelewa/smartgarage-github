<?php
include('../config.php');
include_once('../helper/common.php');

require '../vendor/autoload.php';

$wms = new wms_core();

// Récupération de l'email de l'administrateur
$result_settings = $wms->getWebsiteSettingsInformation($link);
if (!empty($result_settings)) {
	$admin_email = $result_settings['email'];
	// $admin_email = "fiderlet07@gmail.com";
}

// var_dump($_POST);
// die();

$boncmde_date_emission = date('d/m/Y');
$query = "INSERT INTO tbl_boncmde_four (boncmde_id, supplier_id, boncmde_date_emission) VALUES('$_POST[boncmde_id]','$_POST[supplier_id]','$boncmde_date_emission')";

// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
$result = mysql_query($query, $link);

if (!$result) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $query;
	die($message);
}

// Définition du message et trraitement de l'envoi
if ($_POST['email']) {

	// $toEmail = $_POST['email'];
	$toEmail = "fiderlet07@gmail.com";
	$message = $_POST['message'];
	try {
		$mail = new \PHPMailer\PHPMailer\PHPMailer();
		$mail->AddAddress($toEmail);
		$mail->From = $admin_email;
		$mail->FromName = 'Luxury Garage';
		$mail->Subject = "E-mail du bon de commande";
		$body = "<table>
			<tr>
			<th colspan='2'>E-mail du bon de commande</th>
			</tr>			
			<tr>
			<td>Message : </td>
			<td>" . $message . "</td>
			</tr>
			<table>";
		$body = preg_replace('/\\\\/', '', $body);
		$mail->MsgHTML($body);
		$mail->IsSendmail();
		$mail->AddReplyTo($admin_email);
		$mail->AltBody = "Pour voir ce message, veuillez utiliser une application de messagerie compatible HTML!";
		$mail->WordWrap = 80;
		$mail->AddAttachment($_FILES['attachFile']['tmp_name'], $_FILES['attachFile']['name']);
		$mail->IsHTML(true);
		$mail->Send();
		$url = WEB_URL . 'bon_cmde/sendBonCmde.php?success=1';
		header("Location: $url");
	} catch (Exception $e) {
		echo "Le message ne peut pas être envoyé. Erreur: {$mail->ErrorInfo}";
	}
}
