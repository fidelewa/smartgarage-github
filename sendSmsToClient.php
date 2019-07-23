<?php

// importation du fichier de l'API SMS
require_once(ROOT_PATH . '/SmsApi.php');

// instanciation de la classe de l'API SMS
$smsApi = new SmsApi();

$make_name = $modeleMarqueVehiDatas[0];
$model_name = $modeleMarqueVehiDatas[1];
$immatri = $modeleMarqueVehiDatas[2];
$client_nom = $_POST['client_nom'];
$client_telephone = $_POST['client_telephone'];
// $client_telephone  = "02280768";

// Message d'alerte
$content_msg = $client_nom . ', votre véhicule ' . $make_name . ' ' . $model_name . ' ' . $immatri . ' a bien été réceptionné';

// $content_msg = "Le véhicule d'identifiant " . $_POST['car_id'] . "vous a été attribué pour effectuer un diagnostic";

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($client_telephone, $content_msg);

// On fait une redirection si le sms a été envoyé avec succès
if ($resultSmsSent == "ok") {

	if (isset($_SESSION['objRecep']) && $_SESSION['login_type'] == "reception") {

		if ((int) $_POST['repair_car'] > 0) {
			$url = WEB_URL . 'recep_panel/recep_dashboard.php?m=up&sms=send_client_sms_succes';
			header("Location: $url");
		} else {

			$url = WEB_URL . 'recep_panel/recep_dashboard.php?m=add&sms=send_client_sms_succes';
			header("Location: $url");
		}
	} else {

		if ((int) $_POST['repair_car'] > 0) {
			$url = WEB_URL . 'reception/repaircar_reception_list.php?m=up&sms=send_client_sms_succes';
			header("Location: $url");
		} else {

			$url = WEB_URL . 'reception/repaircar_reception_list.php?m=add&sms=send_client_sms_succes';
			header("Location: $url");
		}
	}
} else {
	if (isset($_SESSION['objRecep']) && $_SESSION['login_type'] == "reception") {

		if ((int) $_POST['repair_car'] > 0) {
			$url = WEB_URL . 'recep_panel/recep_dashboard.php?m=up&sms=send_client_sms_failed';
			header("Location: $url");
		} else {

			$url = WEB_URL . 'recep_panel/recep_dashboard.php?m=add&sms=send_client_sms_failed';
			header("Location: $url");
		}
	} else {

		if ((int) $_POST['repair_car'] > 0) {
			$url = WEB_URL . 'reception/repaircar_reception_list.php?m=up&sms=send_client_sms_failed';
			header("Location: $url");
		} else {

			$url = WEB_URL . 'reception/repaircar_reception_list.php?m=add&sms=send_client_sms_failed';
			header("Location: $url");
		}
	}
}
