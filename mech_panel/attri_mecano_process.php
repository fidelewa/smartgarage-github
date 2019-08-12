<?php
include('../helper/common.php');
include_once('../config.php');

// var_dump($_POST);
// die();

$_POST['remarque_mecano'] = mysql_real_escape_string(trim($_POST['remarque_mecano']));

if ($_POST['chef_mech_elec_type'] == "chef mecanicien") {

    // Enregistrement de l'identifiant du mécanicien à qui à été attribué la fiche de réception du véhicule
    $query = "UPDATE tbl_recep_vehi_repar 
    SET status_attribution_vehicule=1,
    statut_acceptation_mecanicien=1,
    statut_action_mecanicien=1,
    mecano_name='" . $_POST['chef_mech_elec_name'] . "',
    chef_mech_elec_id='" . $_POST['chef_mec_elec_id'] . "',
    msg_acceptation = '" . $_POST['remarque_mecano'] . "'
    WHERE car_id='" . $_POST['reception_id'] . "'";

    // On teste le résultat de la requête pour savoir si elle n'a pas déclenché des erreurs
    $result = mysql_query($query, $link);

    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }
}

if ($_POST['chef_mech_elec_type'] == "chef electricien") {

    // Enregistrement de l'identifiant du mécanicien à qui à été attribué la fiche de réception du véhicule
    $query = "UPDATE tbl_recep_vehi_repar 
    SET status_attribution_vehicule=1,
    statut_acceptation_electricien=1,
    statut_action_electricien=1,
    electro_name='" . $_POST['chef_mech_elec_name'] . "',
    chef_mech_elec_id='" . $_POST['chef_mec_elec_id'] . "',
    msg_acceptation = '" . $_POST['remarque_mecano'] . "'
    WHERE car_id='" . $_POST['reception_id'] . "'";

    // On teste le résultat de la requête pour savoir si elle n'a pas déclenché des erreurs
    $result = mysql_query($query, $link);

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

$admin_ges_tel = $_POST['admin_ges_tel'];
// $admin_ges_tel  = "02280768";

// Message d'alerte
$content_msg = $_POST['chef_mech_elec_name'] . ', est prêt à faire le diagnostic de la voiture réceptionnée ';

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($admin_ges_tel, $content_msg);

/***********************************************
 * Envoi du SMS au receptionniste
 ***********************************************/

$recep_tel = $_POST['recep_tel'];
// $recep_tel  = "02280768";

// Message d'alerte
$content_msg = $_POST['chef_mech_elec_name'] . ', est prêt à faire le diagnostic de la voiture réceptionnée ';

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($recep_tel, $content_msg);

/*****************************************************************
 * Envoi du SMS soit au chef mécanicien soit au chef électricien
 *****************************************************************/

// Si c'est le chef mécanicien qui est prêt à faire le diagnostic
// alors on envoi le SMS au chef électricien
if ($_POST['att_mecano_id'] == $_POST['chef_mec_elec_id']) {

    $elec_tel = $_POST['elec_tel'];
    // $elec_tel = "02280768";

    // Message d'alerte
    $content_msg = $_POST['chef_mech_elec_name'] . ', est prêt à faire le diagnostic de la voiture réceptionnée ';

    // Exécution de la méthode d'envoi 
    $resultSmsSent = $smsApi->isSmsapi($elec_tel, $content_msg);
}

/*****************************************************************
 * Envoi du SMS soit au chef mécanicien soit au chef électricien
 *****************************************************************/

// Si c'est le chef électricien qui est prêt à faire le diagnostic
// alors on envoi le SMS au chef mécanicien
if ($_POST['att_electro_id'] == $_POST['chef_mec_elec_id']) {

    $mech_tel = $_POST['mech_tel'];
    // $elec_tel = "02280768";

    // Message d'alerte
    $content_msg = $_POST['chef_mech_elec_name'] . ', est prêt à faire le diagnostic de la voiture réceptionnée ';

    // Exécution de la méthode d'envoi 
    $resultSmsSent = $smsApi->isSmsapi($mech_tel, $content_msg);
}

// On redirige vers le tableau de bord
// header("Location: " . WEB_URL . "mech_panel/mech_dashboard.php");
echo "<script type='text/javascript'> document.location.href='" . WEB_URL . "mech_panel/mech_dashboard.php'</script>";
