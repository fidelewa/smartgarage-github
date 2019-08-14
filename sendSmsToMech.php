<?php
// importation du fichier de l'API SMS
require_once(ROOT_PATH . '/SmsApi.php');

// instanciation de la classe de l'API SMS
$smsApi = new SmsApi();

if ($_POST['mecanicienList'] == "chef mecanicien") {

    // Liste des chefs mécanicien et électricien
    $queryChefMechElec = "SELECT * FROM tbl_add_mech WHERE usr_type IN ('chef mecanicien')";

    // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
    $resultChefMechElec = mysql_query($queryChefMechElec, $link);

    if (!$resultChefMechElec) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' .  $$queryChefMechElec;
        die($message);
    }

    $rowChefMechElec = mysql_fetch_assoc($resultChefMechElec);

    $mobile_mech = $rowChefMechElec['usr_tel'];
    $mech_name = $rowChefMechElec['usr_name'];
    $send_sms_mecano = "";
}

if ($_POST['mecanicienList'] == "chef electricien") {

    // Liste des chefs mécanicien et électricien
    $queryChefMechElec = "SELECT * FROM tbl_add_mech WHERE usr_type IN ('chef electricien')";

    // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
    $resultChefMechElec = mysql_query($queryChefMechElec, $link);

    if (!$resultChefMechElec) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' .  $$queryChefMechElec;
        die($message);
    }

    $rowChefMechElec = mysql_fetch_assoc($resultChefMechElec);

    $mobile_mech = $rowChefMechElec['usr_tel'];
    $mech_name = $rowChefMechElec['usr_name'];
    $send_sms_electro = "";
}

// $mobile_mech  = "02280768";

// Message d'alerte
$content_msg = $mech_name . ', vous avez la charge de faire le diagnostic de la voiture ' . $voiture['make_name'] . ' ' . $voiture['model_name'] . ' ' . $voiture['VIN'];
// $content_msg = "Le véhicule d'identifiant " . $_POST['car_id'] . "vous a été attribué pour effectuer un diagnostic";

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($mobile_mech, $content_msg);

// var_dump($resultSmsSent);
// die();

// On fait une redirection si le sms a été envoyé avec succès
if ($resultSmsSent == "ok") {

    if (isset($send_sms_electro) && $send_sms_electro == "") {
        $send_sms_statut = "send_electro_sms_succes";
    }

    if (isset($send_sms_mecano) && $send_sms_mecano == "") {
        $send_sms_statut = "send_mech_sms_succes";
    }

    // Faire une rédirection vers la liste des véhicules réceptionnés avec un paramètre d'attribution
    header("Location: " . WEB_URL . "reception/repaircar_reception_list.php?att=attribution&sms=" . $send_sms_statut . "&car_id=" . $_POST['car_id'] . "&mecanicien_id=" . $_POST['mecanicienList'] . "&marque=" . $voiture['make_name'] . "&modele=" . $voiture['model_name'] . "&imma=" . $voiture['VIN'] . "&mech_name=" . $row['usr_name']);
} else {

    if (isset($send_sms_electro) && $send_sms_electro == "") {
        $send_sms_statut = "send_electro_sms_failed";
    }

    if (isset($send_sms_mecano) && $send_sms_mecano == "") {
        $send_sms_statut = "send_mech_sms_succes_failed";
    }

    echo "<script type='text/javascript'> document.location.href='" . WEB_URL . "reception/repaircar_reception_list.php?att=attribution&car_id=" . $_POST['car_id'] . "&mecanicien_id=" . $_POST['mecanicienList'] . "&marque=" . $voiture['make_name'] . "&modele=" . $voiture['model_name'] . "&imma=" . $voiture['VIN'] . "&mech_name=" . $row['usr_name'] . "&sms=" . $send_sms_statut . "'</script>";
}
