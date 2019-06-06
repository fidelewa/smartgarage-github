<?php

include('../config.php');

$keyword = strval($_POST["immat"]);

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
mysql_close($link);
