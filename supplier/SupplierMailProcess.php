<?php
include('../config.php');
include_once('../helper/common.php');

require '../vendor/autoload.php';

$wms = new wms_core();

// Récupération de l'email de l'administrateur
$result_settings = $wms->getWebsiteSettingsInformation($link);
if (!empty($result_settings)) {
    $admin_email = $result_settings['email'];
    // $admin_email = "aw.fidele@e-mitic.com";
}

if($_POST['email']) {
	$four = $_POST['four'];
    $toEmail = $_POST['email'];
    // $toEmail = "aw.fidele@e-mitic.com";
	$message = $_POST['message'];
	try {
		$mail = new \PHPMailer\PHPMailer\PHPMailer();
		$mail->AddAddress($toEmail);
		$mail->From = $admin_email;
		$mail->FromName = 'Luxury Admin';
		$mail->Subject = "E-mail de la fiche des pièces de rechange d'un véhicule";
		$body = "<table>
			<tr>
			<th colspan='2'>E-mail de la fiche des pièces de rechange d'un véhicule</th>
			</tr>			
			<tr>
			<td>Message : </td>
			<td>".$message."</td>
			</tr>
			<table>";
			$body = preg_replace('/\\\\/','', $body);
			$mail->MsgHTML($body);
			$mail->IsSendmail();
			$mail->AddReplyTo("admin@webdamn.com");
			$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
			$mail->WordWrap = 80;
			$mail->AddAttachment($_FILES['attachFile']['tmp_name'], $_FILES['attachFile']['name']);
			$mail->IsHTML(true);
			$mail->Send();
            $url = WEB_URL . 'supplier/sendEmailToSuppliers.php?success=1';
            header("Location: $url");
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}
?>