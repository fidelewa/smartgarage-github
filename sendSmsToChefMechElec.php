<?php

// importation du fichier de l'API SMS
require_once(ROOT_PATH . '/SmsApi.php');

// instanciation de la classe de l'API SMS
$smsApi = new SmsApi();

$listeChefMechElec = array();

// Liste des chefs mécanicien et électricien
$queryChefMechElec = "SELECT * FROM tbl_add_mech WHERE usr_type IN ('chef mecanicien','chef electricien')";

// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
$resultChefMechElec = mysql_query($queryChefMechElec, $link);

if (!$resultChefMechElec) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' .  $$queryChefMechElec;
    die($message);
}

// On récupère la liste des chefs mécaniciens et électriciens
while ($rowChefMechElec = mysql_fetch_assoc($resultChefMechElec)) {

    // On envoi le message d'attribution à chacun des chefs mécanicien et électricien 
    // Message d'alerte
    $content_msg = 'Un véhicule, ' . $voiture['make_name'] . ' ' . $voiture['model_name'] . ' ' . $voiture['VIN'] .
        ' appartenant au client ' . $voiture['c_name'] . ' vient d\'être réceptionné, veuillez signaler votre disponibilité pour diagnostic.';

    $resultSmsSent = $smsApi->isSmsapi($rowChefMechElec['usr_tel'], $content_msg);
}

if ($resultSmsSent == "ok") {
    $sms_mech_elec = 'send_mech_elec_sms_succes';
} else {
    $sms_mech_elec = 'send_mech_elec_sms_failed';
}

