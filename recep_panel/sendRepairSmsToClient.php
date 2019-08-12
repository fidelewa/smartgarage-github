<?php
include('../header.php');
// var_dump($_POST);
// die();

// importation du fichier de l'API SMS
require_once(ROOT_PATH . '/SmsApi.php');

// instanciation de la classe de l'API SMS
$smsApi = new SmsApi();

$make_name = $_POST['make_name'];
$model_name = $_POST['model_name'];
$immatri = $_POST['immatri'];
$client_nom = $_POST['client_nom'];
$client_telephone = $_POST['client_telephone'];
// $client_telephone  = "02280768";

if ((int)$_POST['statut_reparation'] == 0) {

    // Message d'alerte
    // $content_msg = $client_nom . ', votre véhicule ' . $make_name . ' ' . $model_name . ' ' . $immatri . ' est en cours de réparation';
    $content_msg = $_POST['message_status_reparation'];
}

// $content_msg = "Le véhicule d'identifiant " . $_POST['car_id'] . "vous a été attribué pour effectuer un diagnostic";

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($client_telephone, $content_msg);

// On redirige vers le tableau de bord
header("Location: " . WEB_URL . "recep_panel/recep_dashboard.php?sms=send_client_sms_succes");
// echo "<script type='text/javascript'> document.location.href='" . WEB_URL . "mech_panel/mech_dashboard.php'</script>";
