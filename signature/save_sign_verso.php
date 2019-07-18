<?php
include_once('../config.php');
include_once('../helper/common.php');
$wms = new wms_core();

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

	$result = array();
	$imagedata = base64_decode($_POST['img_data']);
	// $filename = md5(date("dmYhisA"));

	// Si c'est le client qui signe au dépot 
	if ($_POST['signataire'] == 'client') {

		// if ($_POST['etat'] == 'verso') {
			// Définition du nom du fichier image de la signature du client à la verso
			$filename = $_POST['contact'] . '_cli_' . $_POST['car_id'] . '_' . $_POST['etat'];

			// Chemin relatif vers l'emplacement des fichiers images des signature créés
			$file_name = '../img/signature/' . $filename . '.png';

			// Chemin relatif vers l'emplacement des fichiers images des signature créés
			// $file_name = './doc_signs/' . $filename . '.png';

			// Les fichiers image des signatures seront donc placés dans le dossier spécifié via son chemin
			$rslt_file_put_contents = file_put_contents($file_name, $imagedata);

			// Si l'insertion des images des signatures dans le fichier à réussi
			if ($rslt_file_put_contents != false) {

				$result['status'] = 1;
				$result['file_name'] = $file_name;
				echo json_encode($result);

				// On récupère la date de la signature du client à la verso
				$dateSignClientverso = date('d/m/Y');

				// On insère la date de la signature du client à la verso en BDD
				$wms->updateDateSignCliverso($link, $dateSignClientverso, (int) $_POST['car_id']);

			}
		// }
	}

	if ($_POST['signataire'] == 'tech') {

		// if ($_POST['etat'] == 'verso') {
			// Définition du nom du fichier image de la signature du réceptionniste à la verso
			$filename = $_POST['contact'] . '_tech_' . $_POST['car_id'] . '_' . $_POST['etat'];

			// Chemin relatif vers l'emplacement des fichiers images des signature créés
			$file_name = '../img/signature/' . $filename . '.png';

			// On défini le chemin de l'emplacement des fichiers images des signature créés
			// $file_name = './doc_signs/' . $filename . '.png';

			// Les fichiers image des signatures seront donc placés dans le dossier spécifié via son chemin
			$rslt_file_put_contents = file_put_contents($file_name, $imagedata);

			// Si l'insertion des images des signatures dans le fichier à réussi
			if ($rslt_file_put_contents != false) {

				// On récupère la date de la signature du réceptionniste à la verso
				$dateSignRecepverso = date('d/m/Y');

				$wms->updateDateSignTechverso($link, $dateSignRecepverso, (int) $_POST['car_id']);

				$result['status'] = 1;
				$result['file_name'] = $file_name;
				echo json_encode($result);
			}
		// }
	}
}
