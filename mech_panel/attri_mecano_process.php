<?php
include('../helper/common.php');
include_once('../config.php');
include_once('../session.php');

// var_dump($_POST);
// die();

$_POST['remarque_mecano'] = mysql_real_escape_string(trim($_POST['remarque_mecano']));

if ($_POST['chef_mech_elec_type'] == "chef mecanicien") {

    $dateAcceptationDiagnostic = date_format(date_create('now', new \DateTimeZone('Africa/Abidjan')), 'Y-m-d H:i:s');

    // Enregistrement de l'identifiant du mécanicien à qui à été attribué la fiche de réception du véhicule
    $query = "UPDATE tbl_recep_vehi_repar 
    SET status_attribution_vehicule=1,
    statut_acceptation_mecanicien=1,
    statut_action_mecanicien=1,
    mecano_name='" . $_POST['chef_mech_elec_name'] . "',
    chef_mech_elec_id='" . $_POST['chef_mec_elec_id'] . "',
    msg_acceptation = '" . $_POST['remarque_mecano'] . "',
    date_acceptation_diagnostic = '" . $dateAcceptationDiagnostic . "'
    WHERE car_id='" . $_POST['reception_id'] . "'";

    // On teste le résultat de la requête pour savoir si elle n'a pas déclenché des erreurs
    $result = mysql_query($query, $link);

    // if (!$result) {
    //     $message  = 'Invalid query: ' . mysql_error() . "\n";
    //     $message .= 'Whole query: ' . $query;
    //     die($message);
    // }
}

if ($_POST['chef_mech_elec_type'] == "chef electricien") {

    $dateAcceptationDiagnostic = date_format(date_create('now', new \DateTimeZone('Africa/Abidjan')), 'Y-m-d H:i:s');

    // Enregistrement de l'identifiant du mécanicien à qui à été attribué la fiche de réception du véhicule
    $query = "UPDATE tbl_recep_vehi_repar 
    SET status_attribution_vehicule=1,
    statut_acceptation_electricien=1,
    statut_action_electricien=1,
    electro_name='" . $_POST['chef_mech_elec_name'] . "',
    chef_mech_elec_id='" . $_POST['chef_mec_elec_id'] . "',
    msg_acceptation = '" . $_POST['remarque_mecano'] . "',
    date_acceptation_diagnostic = '" . $dateAcceptationDiagnostic . "'
    WHERE car_id='" . $_POST['reception_id'] . "'";

    // On teste le résultat de la requête pour savoir si elle n'a pas déclenché des erreurs
    $result = mysql_query($query, $link);

    // if (!$result) {
    //     $message  = 'Invalid query: ' . mysql_error() . "\n";
    //     $message .= 'Whole query: ' . $query;
    //     die($message);
    // }
}

/***********************************************
 * Envoi du SMS à l'administrateur gestionnaire
 ***********************************************/

require_once(ROOT_PATH . '/SmsApi.php');

// instanciation de la classe de l'API SMS
$smsApi = new SmsApi();

$admin_ges_tel = $_POST['admin_ges_tel'];
// $admin_ges_tel  = "02280768";

// Message d'alerte
// $content_msg = $_POST['chef_mech_elec_name'] . ', est prêt à faire le diagnostic de la voiture réceptionnée ';
// $content_msg = $_POST['chef_mech_elec_name'] . ', est prêt à faire le diagnostic de la voiture ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'] . ' nouvellement réceptionnée';

if ($_POST['chef_mech_elec_type'] == "chef mecanicien") {
    // Message d'alerte
    $content_msg = 'Le mécanicien ' . $_POST['chef_mech_elec_name'] . ', est prêt à faire le diagnostic mécanique de la voiture ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'] . ' nouvellement réceptionnée';
}

if ($_POST['chef_mech_elec_type'] == "chef electricien") {
    // Message d'alerte
    $content_msg = 'L\'électricien ' . $_POST['chef_mech_elec_name'] . ', est prêt à faire le diagnostic électrique de la voiture ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'] . ' nouvellement réceptionnée';
}

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($admin_ges_tel, $content_msg);

/***********************************************
 * Envoi du SMS au receptionniste
 ***********************************************/

$recep_tel = $_POST['recep_tel'];
// $recep_tel  = "02280768";

// Message d'alerte
// $content_msg = $_POST['chef_mech_elec_name'] . ', est prêt à faire le diagnostic de la voiture réceptionnée ';

if ($_POST['chef_mech_elec_type'] == "chef mecanicien") {
    // Message d'alerte
    $content_msg = 'Le mécanicien ' . $_POST['chef_mech_elec_name'] . ', est prêt à faire le diagnostic mécanique de la voiture ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'] . ' nouvellement réceptionnée';
}

if ($_POST['chef_mech_elec_type'] == "chef electricien") {
    // Message d'alerte
    $content_msg = 'L\'électricien ' . $_POST['chef_mech_elec_name'] . ', est prêt à faire le diagnostic électrique de la voiture ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'] . ' nouvellement réceptionnée';
}

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($recep_tel, $content_msg);

/*****************************************************************
 * Envoi du SMS soit au chef mécanicien soit au chef électricien
 *****************************************************************/

// Si c'est le chef mécanicien qui est prêt à faire le diagnostic
// alors on envoi le SMS au chef électricien

// if ($_POST['att_mecano_id'] == $_POST['chef_mec_elec_id']) {
// if ($_POST['statut_acceptation_mecanicien'] == 1) {
if ($_POST['chef_mech_elec_type'] == "chef mecanicien") {

    // On récupère le numéro de téléphone du chef électricien
    $queryChefElec = "SELECT usr_tel FROM tbl_add_mech WHERE usr_type = 'chef electricien'";

    // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
    $resultChefElec = mysql_query($queryChefElec, $link);

    // if (!$resultChefElec) {
    //     $message  = 'Invalid query: ' . mysql_error() . "\n";
    //     $message .= 'Whole query: ' .  $queryChefElec;
    //     die($message);
    // }

    $rowChefElec = mysql_fetch_assoc($resultChefElec);
    // $elec_tel = $_POST['elec_tel'];
    $elec_tel = $rowChefElec['usr_tel'];

    // Message d'alerte
    // $content_msg = $_POST['chef_mech_elec_name'] . ', est prêt à faire le diagnostic de la voiture réceptionnée ';
    $content_msg = 'Le mécanicien ' . $_POST['chef_mech_elec_name'] . ', est prêt à faire le diagnostic mécanique de la voiture ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'] . ' nouvellement réceptionnée, le chef électricien est donc prié de patienter';

    // Exécution de la méthode d'envoi 
    $resultSmsSent = $smsApi->isSmsapi($elec_tel, $content_msg);
}

/*****************************************************************
 * Envoi du SMS soit au chef mécanicien soit au chef électricien
 *****************************************************************/

// Si c'est le chef électricien qui est prêt à faire le diagnostic
// alors on envoi le SMS au chef mécanicien
// if ($_POST['att_electro_id'] == $_POST['chef_mec_elec_id']) {
// if ($_POST['statut_acceptation_electricien'] == 1) {
if ($_POST['chef_mech_elec_type'] == "chef electricien") {

    // On récupère le numéro de téléphone du chef mécanicien
    $queryChefMecano = "SELECT usr_tel FROM tbl_add_mech WHERE usr_type = 'chef mecanicien'";

    // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
    $resultChefMecano = mysql_query($queryChefMecano, $link);

    // if (!$resultChefMecano) {
    //     $message  = 'Invalid query: ' . mysql_error() . "\n";
    //     $message .= 'Whole query: ' .  $queryChefMecano;
    //     die($message);
    // }

    $rowChefMecano = mysql_fetch_assoc($resultChefMecano);
    $mech_tel = $rowChefMecano['usr_tel'];

    // $mech_tel = $_POST['mech_tel'];
    // $elec_tel = "02280768";

    // Message d'alerte
    $content_msg = 'L\'électricien ' . $_POST['chef_mech_elec_name'] . ', est prêt à faire le diagnostic électrique de la voiture ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'] . ' nouvellement réceptionnée, le chef mécanicien est donc prié de patienter';

    // Exécution de la méthode d'envoi 
    $resultSmsSent = $smsApi->isSmsapi($mech_tel, $content_msg);
}

// On redirige vers le tableau de bord
// header("Location: " . WEB_URL . "mech_panel/mech_dashboard.php");
echo "<script type='text/javascript'> document.location.href='" . WEB_URL . "mech_panel/mech_dashboard.php'</script>";
