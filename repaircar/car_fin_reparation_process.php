<?php
include('../helper/common.php');
include_once('../config.php');

if ($_GET['chef_mech_elec_type'] == "chef mecanicien") {

    $query = "UPDATE tbl_recep_vehi_repar
        SET statut_reparation_mecanique=1,
        mecano_action_reparation = 0,
        electro_action_reparation = null
        WHERE car_id='" . (int) $_GET['recep_car_id'] . "'";

    $result = mysql_query($query, $link);

    // var_dump($result);

    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }
}

if ($_GET['chef_mech_elec_type'] == "chef electricien") {

    $query = "UPDATE tbl_recep_vehi_repar
        SET statut_reparation_electrique=1,
        mecano_action_reparation = null,
        electro_action_reparation = 0
        WHERE car_id='" . (int) $_GET['recep_car_id'] . "'";

    $result = mysql_query($query, $link);

    // var_dump($query);
    // var_dump($result);
    // die();

    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }
}


/***********************************************
 * Envoi du SMS à l'administrateur gestionnaire
 ***********************************************/

require_once(ROOT_PATH . '/SmsApi.php');

// instanciation de la classe de l'API SMS
$smsApi = new SmsApi();

$admin_ges_tel = $_GET['admin_ges_tel'];
// $admin_ges_tel  = "02280768";

// var_dump($mecano);
// die();

if ($_GET['chef_mech_elec_type'] == "chef mecanicien") {

    // Message d'alerte
    $content_msg = ' La réparation mécanique du véhicule ' . $_GET['make_name'] . ' ' . $_GET['model_name'] . ' ' . $_GET['VIN'] . ' est terminée ';
}

if ($_GET['chef_mech_elec_type'] == "chef electricien") {

    // Message d'alerte
    $content_msg = ' La réparation électrique du véhicule ' . $_GET['make_name'] . ' ' . $_GET['model_name'] . ' ' . $_GET['VIN'] . ' est terminée ';
}

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($admin_ges_tel, $content_msg);

/***********************************************
 * Envoi du SMS au receptionniste
 ***********************************************/

$recep_tel = $_GET['recep_tel'];
// $recep_tel  = "02280768";

if ($_GET['chef_mech_elec_type'] == "chef mecanicien") {

    // Message d'alerte
    $content_msg = ' la réparation mécanique du véhicule ' . $_GET['make_name'] . ' ' . $_GET['model_name'] . ' ' . $_GET['VIN'] . ' est terminée ';
}

if ($_GET['chef_mech_elec_type'] == "chef electricien") {

    // Message d'alerte
    $content_msg = ' la réparation électrique du véhicule ' . $_GET['make_name'] . ' ' . $_GET['model_name'] . ' ' . $_GET['VIN'] . ' est terminée ';
}

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($recep_tel, $content_msg);


// On redirige vers le tableau de bord
header("Location: " . WEB_URL . "mech_panel/mech_dashboard.php");
// echo "<script type='text/javascript'> document.location.href='" . WEB_URL . "cust_panel/cust_dashboard.php'</script>";
