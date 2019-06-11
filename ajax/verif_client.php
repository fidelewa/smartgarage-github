<?php

include('../config.php');

// Recherche du nom du client
if ($_POST['client'] != "") {
	$keyword = strval($_POST["client"]);

	$query = "SELECT * FROM tbl_add_customer where c_name LIKE '" . $keyword . "%'";

	// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
	$result = mysql_query($query, $link);

	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' .  $query;
		die($message);
	}

	// On récupère la liste des marques commençant par le même caractère que la valeur de la marque soumise via le formulaire

	if (mysql_num_rows($result) > 0) {
		while ($row = mysql_fetch_assoc($result)) {
			$countryResult[] = $row["c_name"];
		}
		echo json_encode($countryResult);
	}
}

// Recherche du numéro de téléphone du client
if ($_POST['tel_client'] != "") {
	$keyword = strval($_POST["tel_client"]);

	$query = "SELECT * FROM tbl_add_customer where princ_tel LIKE '" . $keyword . "%'";

	// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
	$result = mysql_query($query, $link);

	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' .  $query;
		die($message);
	}

	// On récupère la liste des marques commençant par le même caractère que la valeur de la marque soumise via le formulaire

	if (mysql_num_rows($result) > 0) {
		while ($row = mysql_fetch_assoc($result)) {
			$countryResult[] = $row["princ_tel"];
		}
		echo json_encode($countryResult);
	}
}

mysql_close($link);
