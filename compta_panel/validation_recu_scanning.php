<?php
include('../helper/common.php');
include_once('../config.php');

// var_dump($_GET);
// die();

    // Enregistrement de l'identifiant du mécanicien à qui à été attribué la fiche de réception du véhicule
    $query = "UPDATE tbl_vehicule_scanning
SET validation_recu_scanning=1
WHERE id='" . $_GET['recu_scanning_id'] . "'";

    // On teste le résultat de la requête pour savoir si elle n'a pas déclenché des erreurs
    $result = mysql_query($query, $link);

    // if (!$result) {
    //     $message  = 'Invalid query: ' . mysql_error() . "\n";
    //     $message .= 'Whole query: ' . $query;
    //     die($message);
    // }

// // Enregistrement de l'identifiant du mécanicien à qui à été attribué la fiche de réception du véhicule
// $query = "UPDATE tbl_add_devis 
//         SET statut_validation_devis=1
//         WHERE devis_id='" . $_GET['devis_id'] . "'";

// // On teste le résultat de la requête pour savoir si elle n'a pas déclenché des erreurs
// $result = mysql_query($query, $link);

// if (!$result) {
//     $message  = 'Invalid query: ' . mysql_error() . "\n";
//     $message .= 'Whole query: ' . $query;
//     die($message);
// }

// On redirige vers le tableau de bord
header("Location: " . WEB_URL . "repaircar/vehicule_scanning_list.php?m=recu_scanning_check");
// echo "<script type='text/javascript'> document.location.href='" . WEB_URL . "cust_panel/cust_dashboard.php'</script>";
