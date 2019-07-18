<?php

include_once('../header.php');

// var_dump($_POST);
// die();

if (isset($_POST['car_names'])) {

	// TRAITEMENT DES PIECES JOINTES

	// Récupération des URL des pièces jointes
	if (isset($_FILES["pj_1"]) && !empty($_FILES["pj_1"])) {
		$_POST['pj1_url'] = uploadPJ_1();
	}
	if (isset($_FILES["pj_2"]) && !empty($_FILES["pj_2"])) {
		$_POST['pj2_url'] = uploadPJ_2();
	}
	if (isset($_FILES["pj_3"]) && !empty($_FILES["pj_3"])) {
		$_POST['pj3_url'] = uploadPJ_3();
	}
	if (isset($_FILES["pj_4"]) && !empty($_FILES["pj_4"])) {
		$_POST['pj4_url'] = uploadPJ_4();
	}
	if (isset($_FILES["pj_5"]) && !empty($_FILES["pj_5"])) {
		$_POST['pj5_url'] = uploadPJ_5();
	}
	if (isset($_FILES["pj_6"]) && !empty($_FILES["pj_6"])) {
		$_POST['pj6_url'] = uploadPJ_6();
	}
	if (isset($_FILES["pj_7"]) && !empty($_FILES["pj_7"])) {
		$_POST['pj7_url'] = uploadPJ_7();
	}
	if (isset($_FILES["pj_8"]) && !empty($_FILES["pj_8"])) {
		$_POST['pj8_url'] = uploadPJ_8();
	}
	if (isset($_FILES["pj_9"]) && !empty($_FILES["pj_9"])) {
		$_POST['pj9_url'] = uploadPJ_9();
	}
	if (isset($_FILES["pj_10"]) && !empty($_FILES["pj_10"])) {
		$_POST['pj10_url'] = uploadPJ_10();
	}
	if (isset($_FILES["pj_11"]) && !empty($_FILES["pj_11"])) {
		$_POST['pj11_url'] = uploadPJ_11();
	}
	if (isset($_FILES["pj_12"]) && !empty($_FILES["pj_12"])) {
		$_POST['pj12_url'] = uploadPJ_12();
	}

	$image_url = uploadImage();
	if (empty($image_url)) {
		$image_url = $_POST['img_exist'];
	}

	// var_dump($_POST);
	// die();

	// Initialisation des variables

	// ETAPE 1
	$marque_name_form = $_POST['ddlMake'];
	$modele_name_form = $_POST['ddlModel'];
	$client_name_form = $_POST['ddlCustomerList'];
	$assurance_form = $_POST['assurance_vehi_recep'];
	$make_id = null;
	$modele_id = null;
	$client_id = null;
	$modeleMakeId  = null;
	$listeMarques = array();
	$listeModeles = array();
	$listeClient = array();
	$listeAssurance = array();
	$cptOccur = 0;

	// Marque
	// On converti la chaine de caractère de la marque en array et on récupère le premier caractère de cette valeur
	$arr_marque_name_form = str_split($marque_name_form);
	$arr_marque_name_form_str = $arr_marque_name_form[0];

	// Client
	// On converti la chaine de caractère de la marque en array et on récupère le premier caractère de cette valeur
	$arr_client_name_form = str_split($client_name_form);
	$arr_client_name_form_str = $arr_client_name_form[0];

	// Assurance
	// On converti la chaine de caractère de la marque en array et on récupère le premier caractère de cette valeur
	$arr_assurance_form = str_split($assurance_form);
	$arr_assurance_form_str = $arr_assurance_form[0];

	// print($arr_client_name_form_str);
	// die();

	// ETAPE 2

	// Assurance
	$queryAssur = "SELECT * FROM tbl_assurance_vehicule WHERE assur_vehi_libelle LIKE '" . $arr_assurance_form_str . "%'";

	// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
	$resultAssur = mysql_query($queryAssur, $link);

	if (!$resultAssur) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' .  $queryAssur;
		die($message);
	}

	// On récupère la liste des marques commençant par le même caractère que la valeur de la marque soumise via le formulaire
	while ($row = mysql_fetch_assoc($resultAssur)) {
		$listeAssurance[] = $row;
	}

	// var_dump($assurance_form);
	// var_dump($listeAssurance);

	// S'il y a en BDD des noms d'assurances correspondant à la valeur de l'assurance fournie via le formulaire
	foreach ($listeAssurance as $assurance) {
		if ($assurance_form == $assurance['assur_vehi_libelle']) {
			$cptOccur += 1; // On incrémente un compteur d'occurence
		}
	}

	// var_dump($cptOccur);
	// die();

	// Si le compteur d'occurences est égale à 0, on fait une insertion
	if ($cptOccur == 0) {
		// Insertion du nom de la marque dans la table des marques
		$queryInsertAssur = "INSERT INTO tbl_assurance_vehicule (assur_vehi_libelle) VALUES('$assurance_form')";

		// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
		$resultInsertAssur = mysql_query($queryInsertAssur, $link);

		if (!$resultInsertAssur) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $queryInsertAssur;
			die($message);
		}
	}

	// Client
	$queryClient = "SELECT customer_id, c_name FROM tbl_add_customer WHERE c_name LIKE '" . $arr_client_name_form_str . "%'";

	// On exécute la requête
	$resultListeClient = mysql_query($queryClient, $link);

	// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
	if (!$resultListeClient) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $queryClient;
		die($message);
	}

	// On récupère la liste des marques commençant par le même caractère que la valeur de la marque soumise via le formulaire
	while ($row = mysql_fetch_assoc($resultListeClient)) {
		$listeClient[] = $row;
	}

	// var_dump($client_name_form);
	// var_dump($listeClient);
	// die();

	// Marque
	$queryMarque = "SELECT * FROM tbl_make WHERE make_name LIKE '" . $arr_marque_name_form_str . "%'";

	// On exécute la requête
	$resultListeMarques = mysql_query($queryMarque, $link);

	// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
	if (!$resultListeMarques) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $queryMarque;
		die($message);
	}

	// On récupère la liste des marques commençant par le même caractère que la valeur de la marque soumise via le formulaire
	while ($row = mysql_fetch_assoc($resultListeMarques)) {
		$listeMarques[] = $row;
	}

	// var_dump($marque_name_form);
	// var_dump($listeMarques);
	// die();

	// Modèle

	// On converti la chaine de caractère du modèle en array et on récupère le premier caractère de cette valeur
	$arr_modele_name_form = str_split($modele_name_form);
	$arr_modele_name_form_str = $arr_modele_name_form[0];

	// Récupération du nom de la marque qui a pour id la valeur retourné par la variable $_POST['ddlMake']
	$queryModele = "SELECT * FROM tbl_model WHERE model_name LIKE '" . $arr_modele_name_form_str . "%'";

	// On exécute la requête
	$resultListeModeles = mysql_query($queryModele, $link);

	// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
	if (!$resultListeModeles) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $queryModele;
		die($message);
	}

	// On récupère la liste des modèles commençant par le même caractère que la valeur du modèle soumis via le formulaire
	while ($row = mysql_fetch_assoc($resultListeModeles)) {
		$listeModeles[] = $row;
	}

	// var_dump($listeModeles);

	// ETAPE 3
	// Parcours des marques
	foreach ($listeMarques as $marque) {
		if ($marque_name_form == $marque['make_name']) {
			$make_id = $marque['make_id'];
		}
	}

	// Parcours des modèles
	foreach ($listeModeles as $modele) {
		if ($modele_name_form == $modele['model_name']) {
			$modele_id = $modele['model_id'];
		}
	}

	// Parcours des clients
	foreach ($listeClient as $client) {
		if ($client_name_form == $client['c_name']) {
			$client_id = $client['customer_id'];
		}
	}

	// var_dump($make_id);
	// var_dump($modele_id);
	// var_dump($client_id);
	// die();

	// ETAPE 4

	// CLIENT
	// Si le nom du client soumis via le formulaire correspond à un nom de client existant en BDD
	// on récupère l'id de cet client en BDD que l'on affecte à la variable $_POST['ddlCustomerList']
	if ($client_id != null) {
		(int) $_POST['ddlCustomerList'] = (int) $client_id;
	}

	// MARQUE
	if ($make_id == null) {

		// Insertion du nom de la marque dans la table des marques
		$queryInsertMake = "INSERT INTO tbl_make (make_name) VALUES('$marque_name_form')";

		// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
		$resultInsertMake = mysql_query($queryInsertMake, $link);

		if (!$resultInsertMake) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $queryInsertMake;
			die($message);
		}

		// Récupération de l'id de la nouvelle marque pour faire l'insertion du modèle en BDD
		$queryGetMakeId = "SELECT make_id FROM tbl_make WHERE make_name='" . $marque_name_form . "'";

		// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
		$resultMakeId = mysql_query($queryGetMakeId, $link);

		if (!$resultMakeId) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $queryGetMakeId;
			die($message);
		}

		// On retourne les données de la marque référencée dans un tableau associatif
		$rowMakeId = mysql_fetch_assoc($resultMakeId);

		// affectation de la valeur de l'identifiant de la marque
		$modeleMakeId = (int) $rowMakeId['make_id'];
		// On rédéfini la valeur de l'identifiant de la marque qui sera persistée dans la table tbl_add_car
		$_POST['ddlMake'] = (int) $modeleMakeId;

		// var_dump($rowMakeId);
		// die();

	} else {
		// Si une marque exitant en BDD correspond à la valeur de la marque soumise via le formulaire de saisie
		//  On récupère la valeur de son id et on rédéfini la valeur de l'identifiant de la marque qui sera persistée dans la table tbl_add_car
		$modeleMakeId = (int) $make_id;
		$_POST['ddlMake'] = (int) $make_id;
		// var_dump($make_id);
	}

	// MODELE
	if ($modele_id == null) {

		// Insertion du nom du modele et de l'id de la marque dans la table des modèles
		$queryInsertModel = "INSERT INTO tbl_model (make_id, model_name) VALUES('$modeleMakeId','$modele_name_form')";

		// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
		$resultInsertModel = mysql_query($queryInsertModel, $link);

		if (!$resultInsertModel) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $queryInsertModel;
			die($message);
		}

		// Récupération de l'id du nouveau modèle de voiture ajouté
		$queryGetModeleId = "SELECT model_id FROM tbl_model WHERE model_name='" . $modele_name_form . "'";

		// On exécute la requête
		$resultModeleId = mysql_query($queryGetModeleId, $link);

		// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
		if (!$resultModeleId) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $queryGetModeleId;
			die($message);
		}

		// On retourne les données du modèle référencé dans un tableau associatif
		$rowModeleId = mysql_fetch_assoc($resultModeleId);

		// On rédéfini la valeur de l'identifiant du modèle qui sera persistée dans la table tbl_add_car
		$_POST['ddlModel'] = (int) $rowModeleId['model_id'];

		// var_dump($rowModeleId);
		// die();

	} else {
		// Si un modèle exitant en BDD correspond à la valeur du modèle soumis via le formulaire de saisie
		//  On récupère la valeur de son id et on rédéfini la valeur de l'identifiant du modèle qui sera persistée dans la table tbl_add_car
		$modele_id = (int) $modele_id;
		$_POST['ddlModel'] = (int) $modele_id;
		// var_dump($modele_id);
		// die();
	}

	// Récupération du nom de la marque qui a pour id la valeur retourné par le component $_POST['ddlMake']
	$query = "SELECT make_name FROM tbl_make WHERE make_id='" . (int) $_POST['ddlMake'] . "'";

	// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
	$result = mysql_query($query, $link);

	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $query;
		die($message);
	}

	// On retourne le nom de la marque dans un tableau associatif
	$row = mysql_fetch_array($result);

	// On affecte le nom de la marque à la variable $_POST['car_names']
	$_POST['car_names'] = $row['make_name'];

	$_POST['add_date_visitetech'] = $_POST['add_date_visitetech_car'];
	$_POST['add_date_assurance'] = $_POST['add_date_assurance_car'];

	// var_dump($_POST);
	// die();

	// var_dump($_SESSION);
	// die();

	// TRAITEMENT DE LA VISITE TECHNIQUE
	if (isset($_POST['add_date_visitetech'])) { // Si la date de la visite technique existe

		// On crée un objet Datetime à partir du format chaine de caractère de la date de la visite technique
		$dateprochvistech = DateTime::createFromFormat('d/m/Y', $_POST['add_date_visitetech']);

		if ($dateprochvistech instanceof DateTime) {

			// Définition du statut de la visite technique
			$diffTodayDateprochvistech = $dateprochvistech->diff(new \DateTime())->format('%R%a');

			$diffTodayDateprochvistechStr = $dateprochvistech->diff(new \DateTime())->format(' %a jours');

			// conversion en entier
			$diffTodayDateprochvistech = (int) $diffTodayDateprochvistech;
		}

		if ($diffTodayDateprochvistech < -14) {
			$_POST['statut_vistech'] = "valide";
		  }
	}

	// TRAITEMENT DE L'ASSURANCE
	if (isset($_POST['add_date_assurance']) && isset($_POST['add_date_assurance_fin'])) {

		$dateFinAssur = DateTime::createFromFormat('d/m/Y', $_POST['add_date_assurance_fin']);

		if ($dateFinAssur instanceof DateTime) {

			$diffDateDebutFinAssur = $dateFinAssur->diff(new \DateTime())->format('%R%a');
			$diffDateDebutFinAssurStr = $dateFinAssur->diff(new \DateTime())->format(' %a jours');

			// conversion en entier
			$diffDateDebutFinAssur = (int) $diffDateDebutFinAssur;
		}

		if ($diffDateDebutFinAssur < -14) {
			$_POST['statut_assurance'] = "valide";
		  }
	}

	// var_dump($_POST['statut_assurance']);
	// var_dump($_POST['statut_vistech']);
    // die();

    $result_car_model = $wms->getMarkModelListByImmaVehi($link, $_POST['vin']);

    // var_dump($result_car_model);
    // var_dump($_POST);
	// die();

	// On insère la nouvelle valeur de la colonne car_name en BDD
	$wms->saveUpdateRepairCarInformation($link, $_POST, $image_url);

}

$result_car_model = $wms->getMarkModelListByImmaVehi($link, $_POST['vin']);

// $result_car_model['customer_id'];
// $result_car_model['make_id'];
// $result_car_model['model_id'];
$_POST['ddlImma'] = $_POST['vin'];
$_POST['add_car_id'] = $result_car_model['car_id'];
// $_POST['ddlCustomerList'] = $_POST['customer_id'];
// $_POST['ddlMake'] = $_POST['car_make_id'];
// $_POST['ddlModel'] = $_POST['car_model_id'];

// var_dump($result_car_model);
// var_dump($_POST);
// die();