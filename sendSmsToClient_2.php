<?php



// importation du fichier de l'API SMS

require_once(ROOT_PATH . '/SmsApi.php');



// instanciation de la classe de l'API SMS

$smsApi = new SmsApi();



// $mobile_mech  = "02280768";



if (isset($_POST['ddlImma'])) {

	$immat_car = $_POST['ddlImma'];
}



if (isset($_POST['immat'])) {

	$immat_car = $_POST['immat'];
}



// Message d'alerte

$content_msg = $client_nom . ', votre véhicule ' . $make_name . ' ' . $model_name . ' ' . $immat_car . ' a bien été réceptionné';



// Exécution de la méthode d'envoi 

$resultSmsSent = $smsApi->isSmsapi($client_telephone, $content_msg);



// var_dump($resultSmsSent);

// die();



// On fait une redirection si le sms a été envoyé avec succès

if ($resultSmsSent == 'ok') {

	if (isset($_SESSION['objRecep']) && $_SESSION['login_type'] == "reception") {



		if ((int) $_POST['repair_car'] > 0) {

			$url = WEB_URL . 'recep_panel/recep_dashboard.php?m=up&sms=send_client_sms_succes&sms_mech_elec=' . $sms_mech_elec;

			header("Location: $url");

		} else {



			$url = WEB_URL . 'recep_panel/recep_dashboard.php?m=add&sms=send_client_sms_succes&sms_mech_elec=' . $sms_mech_elec;

			header("Location: $url");

		}

	} else {



		if ((int) $_POST['repair_car'] > 0) {

			$url = WEB_URL . 'reception/repaircar_reception_list.php?m=up&sms=send_client_sms_succes&sms_mech_elec=' . $sms_mech_elec;

			header("Location: $url");

		} else {



			$url = WEB_URL . 'reception/repaircar_reception_list.php?m=add&sms=send_client_sms_succes&sms_mech_elec=' . $sms_mech_elec;

			header("Location: $url");

		}

	}

} else {

	if (isset($_SESSION['objRecep']) && $_SESSION['login_type'] == "reception") {



		if ((int) $_POST['repair_car'] > 0) {

			$url = WEB_URL . 'recep_panel/recep_dashboard.php?m=up&sms=send_client_sms_failed&sms_mech_elec=' . $sms_mech_elec;

			header("Location: $url");

		} else {



			$url = WEB_URL . 'recep_panel/recep_dashboard.php?m=add&sms=send_client_sms_failed&sms_mech_elec=' . $sms_mech_elec;

			header("Location: $url");

		}

	} else {



		if ((int) $_POST['repair_car'] > 0) {

			$url = WEB_URL . 'reception/repaircar_reception_list.php?m=up&sms=send_client_sms_failed&sms_mech_elec=' . $sms_mech_elec;

			header("Location: $url");

		} else {



			$url = WEB_URL . 'reception/repaircar_reception_list.php?m=add&sms=send_client_sms_failed&sms_mech_elec=' . $sms_mech_elec;

			header("Location: $url");

		}

	}

}
