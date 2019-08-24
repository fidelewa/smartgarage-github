<?php

include_once('../header.php');

// var_dump($_POST);
// die();

$rapport_diagnostic = nl2br($_POST['rapport_diagnostic']);

// Linéarisation de l'array des estimations pour le stocker en base de données
// $estimate_data = serialize($_POST['estimate_data']);
$estimate_data = json_encode($_POST['estimate_data'], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

$query = "INSERT INTO tbl_repaircar_diagnostic (nom_client, tel_wa_client, type_voiture, imma_vehicule, num_chasis_vehicule, rapport_diagnostic,
estimate_data, duree_commande, duree_travaux, travaux_prevoir, date_creation_fiche_diag, car_id) VALUES ('$_POST[nom_client]','$_POST[tel_wa_client]','$_POST[type_vehicule]','$_POST[imma_vehicule]','$_POST[num_chasis_vehicule]',
'$rapport_diagnostic','$estimate_data','$_POST[duree_commande]','$_POST[duree_travaux]','$_POST[travaux_prevoir]',
'$_POST[date_creation_fiche_diag]','$_POST[add_car_id]')";

// Exécution et stockage du résultat de la requête sous forme de ressource
$result = mysql_query($query, $link);

// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
// if ($result) {

    // Redirection vers la liste des diagnostic des véhicules
    $url = WEB_URL . 'reception/repaircar_diagnostic_list.php?m=add';
    header("Location: $url");

// }