<?php
include('../helper/common.php');
include_once('../config.php');

// Si les identifiants du mécanicien et du véhicule existe
if (isset($_POST['mecanicienList']) && isset($_POST['car_id'])) {

    // Enregistrement de l'identifiant du mécanicien à qui à été attribué la fiche de réception du véhicule
    $query = "UPDATE tbl_recep_vehi_repar SET attribution_mecanicien='" . $_POST['mecanicienList'] . "' WHERE car_id='" . (int)$_POST['car_id'] . "'";

    // On teste le résultat de la requête pour savoir si elle n'a pas déclenché des erreurs
    $result = mysql_query($query, $link);

    // if (!$result) {
    //     $message  = 'Invalid query: ' . mysql_error() . "\n";
    //     $message .= 'Whole query: ' . $query;
    //     die($message);
    // }

    // Faire une rédirection vers la liste des véhicules réceptionnés avec un paramètre d'attribution
    header("Location: ".WEB_URL."reception/repaircar_reception_list.php?att=attribution&car_id=".$_POST['car_id']."&mecanicien_id=".$_POST['mecanicienList']);
} ?>