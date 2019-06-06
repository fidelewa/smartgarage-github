<?php

include('../mech_panel/header.php');

// var_dump($_POST);
// die();

// échappement des chaines de caractères
$_POST['rapport_diagnostic'] = mysql_real_escape_string($_POST['rapport_diagnostic']);
$_POST['nom_client'] = mysql_real_escape_string($_POST['nom_client']);

// foreach($_POST['estimate_data'] as $key => $estimate_data){
//     $_POST['estimate_data'][$key] = mysql_real_escape_string($estimate_data['designation']);
// }

$rapport_diagnostic = nl2br($_POST['rapport_diagnostic']);

// Linéarisation de l'array des estimations pour le stocker en base de données
$estimate_data = serialize($_POST['estimate_data']);

// Si celui qui fait le diagnostic est le chef mécanicien, alors le diagnostic est de type mécanique
if(isset($_POST['mech_fonction']) && $_POST['mech_fonction'] == 'Chef mecanicien') {
    $type_diagnostic = 'mécanique';
}

// Si celui qui fait le diagnostic est le chef électronicien, alors le diagnostic est de type électronique
if(isset($_POST['mech_fonction']) && $_POST['mech_fonction'] == 'Chef electronicien') {
    $type_diagnostic = 'électronique';
}

// Récupération de l'identifiant du mécanicien courant depuis la session
$mech_id = $_SESSION['objMech']['user_id'];

$query = "INSERT INTO tbl_repaircar_diagnostic (nom_client, tel_wa_client, type_voiture, imma_vehicule, num_chasis_vehicule, rapport_diagnostic,
estimate_data, duree_commande, duree_travaux, travaux_prevoir, date_creation_fiche_diag, car_id, type_diagnostic, mech_id) 
VALUES ('$_POST[nom_client]','$_POST[tel_wa_client]','$_POST[type_vehicule]','$_POST[imma_vehicule]','$_POST[num_chasis_vehicule]',
'$rapport_diagnostic','$estimate_data','$_POST[duree_commande]','$_POST[duree_travaux]','$_POST[travaux_prevoir]',
'$_POST[date_creation_fiche_diag]','$_POST[add_car_id]','$type_diagnostic','$mech_id')";

// Exécution et stockage du résultat de la requête sous forme de ressource
$result = mysql_query($query, $link);

// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
} else {

    // Redirection vers la liste des diagnostic des véhicules
    // $url = WEB_URL . 'reception/repaircar_diagnostic_list.php?m=add';
    $url = WEB_URL . 'mech_panel/mech_dashboard.php';
    header("Location: $url");

}