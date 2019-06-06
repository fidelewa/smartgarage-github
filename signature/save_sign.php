<?php
include_once('../config.php');
include_once('../helper/common.php');
$wms = new wms_core();

$result = array();
$imagedata = base64_decode($_POST['img_data']);
// $filename = md5(date("dmYhisA"));

// Si c'est le client qui signe au dépot 
if ($_POST['signataire'] == 'client') {

	if ($_POST['etat'] == 'depot') {
		// Définition du nom du fichier image de la signature du client au dépot
		$filename = $_POST['contact'] . '_cli_' . $_POST['car_id'] . '_' . $_POST['etat'];

		// Emplacement des fichiers images des signature créés
		$file_name = './doc_signs/' . $filename . '.png';

		// Les fichiers image des signatures seront donc placés dans le dossier spécifié via son chemin
		$rslt_file_put_contents = file_put_contents($file_name, $imagedata);

		// Si l'insertion des images des signatures dans le fichier à réussi
		// if ($rslt_file_put_contents != false) {

			$result['status'] = 1;
			$result['file_name'] = $file_name;
			echo json_encode($result);

			// On récupère la date de la signature du client au dépot
			$dateSignClientDepot = date('d/m/Y');

			$wms->updateDateSignCliDepot($link, $dateSignClientDepot, (int)$_POST['car_id']);

			// Déclaration et initialisation de la variable d'emplacement du véhicule
			$emplacement_vehi = "au garage";

			$rows = $wms->getHistoEmplVehi($link, $dateSignClientDepot, $emplacement_vehi, $_POST['immavehi'], (int)$_POST['add_car_id']);

			// if (empty($rows)) {
				$wms->saveHistoEmplVehi($link, $dateSignClientDepot, $emplacement_vehi, $_POST['immavehi'], (int)$_POST['add_car_id']);

				// Mise à jour du dernier statu de l'emplacement du véhicule
				$query = "UPDATE tbl_recep_vehi_repar SET stat_empla_vehi='" . $emplacement_vehi . "' WHERE add_car_id='" . (int)$_POST['add_car_id'] . "' AND car_id='" . (int)$_POST['car_id'] . "'";

				// Exécution de la requête
				$result_stat_empla_vehi = mysql_query($query, $link);

				// Vérification du résultat de la requête et affichage d'un message en cas d'erreur
				if (!$result_stat_empla_vehi) {
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					$message .= 'Whole query: ' . $query;
					die($message);
				}
			// }
		// }
	}

	if ($_POST['etat'] == 'sortie') {
		// Définition du nom du fichier image de la signature du client à la sortie
		$filename = $_POST['contact'] . '_cli_' . $_POST['car_id'] . '_' . $_POST['etat'];

		// On défini le chemin de l'emplacement des fichiers images des signature créés
		$file_name = './doc_signs/' . $filename . '.png';

		// Les fichiers image des signatures seront donc placés dans le dossier spécifié via son chemin
		$rslt_file_put_contents = file_put_contents($file_name, $imagedata);

		// Si l'insertion des images des signatures dans le fichier à réussi
		// if ($rslt_file_put_contents != false) {

			$result['status'] = 1;
			$result['file_name'] = $file_name;
			echo json_encode($result);

			// On récupère la date de la signature du client à la sortie
			$dateSignClientSortie = date('d/m/Y');

			// On insère la date de la signature du client à la sortie en BDD
			$wms->updateDateSignCliSortie($link, $dateSignClientSortie, (int)$_POST['car_id']);

			// Déclaration et initialisation de la variable d'emplacement du véhicule
			$emplacement_vehi = "hors du garage";

			$rows = $wms->getHistoEmplVehi($link, $dateSignClientSortie, $emplacement_vehi, $_POST['immavehi'], (int)$_POST['add_car_id']);

			// if (empty($rows)) {
				$wms->saveHistoEmplVehi($link, $dateSignClientSortie, $emplacement_vehi, $_POST['immavehi'], (int)$_POST['add_car_id']);

				// Mise à jour du dernier statu de l'emplacement du véhicule
				$query = "UPDATE tbl_recep_vehi_repar SET stat_empla_vehi='" . $emplacement_vehi . "' WHERE add_car_id='" . (int)$_POST['add_car_id'] . "' AND car_id='" . (int)$_POST['car_id'] . "'";

				// Exécution de la requête
				$result_stat_empla_vehi = mysql_query($query, $link);

				// Vérification du résultat de la requête et affichage d'un message en cas d'erreur
				if (!$result_stat_empla_vehi) {
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					$message .= 'Whole query: ' . $query;
					die($message);
				}
			// }
		// }
	}
}

if ($_POST['signataire'] == 'recep') {

	if ($_POST['etat'] == 'depot') {
		// Définition du nom du fichier image de la signature du réceptionniste au dépot
		$filename = $_POST['contact'] . '_recep_' . $_POST['car_id'] . '_' . $_POST['etat'];

		// On défini le chemin de l'emplacement des fichiers images des signature créés
		$file_name = './doc_signs/' . $filename . '.png';

		// Les fichiers image des signatures seront donc placés dans le dossier spécifié via son chemin
		$rslt_file_put_contents = file_put_contents($file_name, $imagedata);

		// Si l'insertion des images des signatures dans le fichier à réussi
		// if ($rslt_file_put_contents != false) {

			$result['status'] = 1;
			$result['file_name'] = $file_name;
			echo json_encode($result);

			// On récupère la date de la signature du réceptionniste au dépot
			$dateSignRecepDepot = date('d/m/Y');

			$wms->updateDateSignRecepDepot($link, $dateSignRecepDepot, (int)$_POST['car_id']);
		// }
	}

	if ($_POST['etat'] == 'sortie') {
		// Définition du nom du fichier image de la signature du réceptionniste à la sortie
		$filename = $_POST['contact'] . '_recep_' . $_POST['car_id'] . '_' . $_POST['etat'];

		// On défini le chemin de l'emplacement des fichiers images des signature créés
		$file_name = './doc_signs/' . $filename . '.png';

		// Les fichiers image des signatures seront donc placés dans le dossier spécifié via son chemin
		$rslt_file_put_contents = file_put_contents($file_name, $imagedata);

		// Si l'insertion des images des signatures dans le fichier à réussi
		// if ($rslt_file_put_contents != false) {

			$result['status'] = 1;
			$result['file_name'] = $file_name;
			echo json_encode($result);

			// On récupère la date de la signature du réceptionniste à la sortie
			$dateSignRecepSortie = date('d/m/Y');

			$wms->updateDateSignRecepSortie($link, $dateSignRecepSortie, (int)$_POST['car_id']);
		// }
	}
}
