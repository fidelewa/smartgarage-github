<?php

// importation du fichier de l'API SMS
require_once(ROOT_PATH . '/SmsApi.php');

// instanciation de la classe de l'API SMS
$smsApi = new SmsApi();

/************************************
 * Envoi du SMS au chef électricien
 ***********************************/

// On récupère le numéro de téléphone du chef électricien
$queryChefElec = "SELECT usr_tel FROM tbl_add_mech WHERE usr_type = 'chef electricien'";

// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
$resultChefElec = mysql_query($queryChefElec, $link);

if (!$resultChefElec) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' .  $queryChefElec;
    die($message);
}

$rowChefElec = mysql_fetch_assoc($resultChefElec);
// $elec_tel = $_POST['elec_tel'];
$elec_tel = $rowChefElec['usr_tel'];

// On envoi le message d'attribution à chacun des chefs mécanicien et électricien 
// Message d'alerte
$content_msg = 'Un véhicule, ' . $make_name . ' ' . $model_name . ' ' . $imma_vehi .
    ' appartenant au client ' . $client_nom . ' vient d\'être réceptionné.';

$resultSmsSentElec = $smsApi->isSmsapi($elec_tel, $content_msg);

/************************************
 * Envoi du SMS au chef mécanicien
 ***********************************/

// On récupère le numéro de téléphone du chef mécanicien
$queryChefMecano = "SELECT usr_tel FROM tbl_add_mech WHERE usr_type = 'chef mecanicien'";

// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
$resultChefMecano = mysql_query($queryChefMecano, $link);

if (!$resultChefMecano) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' .  $queryChefMecano;
    die($message);
}

$rowChefMecano = mysql_fetch_assoc($resultChefMecano);
$mech_tel = $rowChefMecano['usr_tel'];

// On envoi le message d'attribution à chacun des chefs mécanicien et électricien 
// Message d'alerte
$content_msg = 'Un véhicule, ' . $make_name . ' ' . $model_name . ' ' . $imma_vehi .
    ' appartenant au client ' . $client_nom . ' vient d\'être réceptionné.';

$resultSmsSentMech = $smsApi->isSmsapi($mech_tel, $content_msg);

if ($$resultSmsSentElec == "ok" && $resultSmsSentMech == "ok") {
    $sms_mech_elec = 'send_mech_elec_sms_succes';
} else {
    $sms_mech_elec = 'send_mech_elec_sms_failed';
}
