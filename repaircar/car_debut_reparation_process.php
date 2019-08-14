<?php
include('../helper/common.php');
include_once('../config.php');

// var_dump($_POST['devis_id']);
// die();

// Enregistrement de l'identifiant du mécanicien à qui à été attribué la fiche de réception du véhicule
$query = "UPDATE tbl_recep_vehi_repar
        SET statut_autorisation_reparation=1, 
        statut_emplacement_vehicule=1
        WHERE car_id='" . $_POST['recep_car_id'] . "'";

// On teste le résultat de la requête pour savoir si elle n'a pas déclenché des erreurs
$result = mysql_query($query, $link);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

/***********************************************
 * Envoi du SMS à l'administrateur gestionnaire
 ***********************************************/

require_once(ROOT_PATH . '/SmsApi.php');

// instanciation de la classe de l'API SMS
$smsApi = new SmsApi();

$admin_ges_tel = $_POST['admin_ges_tel'];
// $admin_ges_tel  = "02280768";

if ($_POST['chef_mech_elec_type'] == "chef mecanicien") {

    // Message d'alerte
    $content_msg = ' La réparation mécanique du véhicule ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'] . ' a commencé ';
}

if ($_POST['chef_mech_elec_type'] == "chef electricien") {

    // Message d'alerte
    $content_msg = ' La réparation électrique du véhicule ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'] . ' a commencé ';
}

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($admin_ges_tel, $content_msg);

/***********************************************
 * Envoi du SMS au receptionniste
 ***********************************************/

$recep_tel = $_POST['recep_tel'];
// $recep_tel  = "02280768";

if ($_POST['chef_mech_elec_type'] == "chef mecanicien") {

    // Message d'alerte
    $content_msg = ' La réparation mécanique du véhicule ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'] . ' a commencé ';
}

if ($_POST['chef_mech_elec_type'] == "chef electricien") {

    // Message d'alerte
    $content_msg = ' La réparation électrique du véhicule ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'] . ' a commencé ';
}

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($recep_tel, $content_msg);


// On redirige vers le tableau de bord
header("Location: " . WEB_URL . "dashboard.php");
// echo "<script type='text/javascript'> document.location.href='" . WEB_URL . "cust_panel/cust_dashboard.php'</script>";
