
<?php

include('../config.php');
include("../helper/common.php");

$wms = new wms_core();

// var_dump($_POST);
// die();

// Récupération de l'identifiant du véhicule correspondant à l'immatriculation fournie
$vehiData = $wms->getVehiDataByImmaVehi($link, $_POST['immat']);

// var_dump($vehiData);
// die();

// Mise à jour de l'attribution du véhicule dans la table des devis
$query = "UPDATE tbl_add_devis_simulation SET attribution_vehicule=" . (int)$vehiData['car_id'] . " WHERE devis_id=" .(int)$_GET['devis_simu_id'];

// Exécution de la requête
$result = mysql_query($query, $link);

// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
if (!$result) {
    var_dump($data);
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
} else {
    // Redirection vers la liste des devis
    $url = WEB_URL . "estimate/repaircar_simu_devis_list.php?m=attrib_vehi&devis_simu_id=".$_GET['devis_simu_id']."&car_name=".$vehiData['car_name']."&car_imma=".$vehiData['VIN'];
    header("Location: $url");
}