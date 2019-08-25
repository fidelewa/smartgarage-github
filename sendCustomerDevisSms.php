<?php
include_once('config.php');

$vehi_diag_id = $_GET['vehi_diag_id'];
$devis_id = $_GET['devis_id'];
$mobile_customer = $_GET['mobile_customer'];
// $mobile_customer = "02280768";

// Lien de confirmation du devis envoyé par e-mail
$url_devis = WEB_URL . 'confirmDevisTraitement.php?confirm_devis=1&vehi_diag_id=' . $_GET['vehi_diag_id'] . '&devis_id=' . $_GET['devis_id'];

if ($_GET['type_diagnostic'] == 'mécanique') {
    // Message de confirmation du devis
    $content_msg = 'Un devis mécanique vous a été envoyé pour validation. Pour voir ce devis, vous pouvez vous connecter à votre espace d\'administration ou aller à cette adresse ' . $url_devis;
}

if ($_GET['type_diagnostic'] == 'électrique') {
    // Message de confirmation du devis
    $content_msg = 'Un devis électrique vous a été envoyé pour validation. Pour voir ce devis, vous pouvez vous connecter à votre espace d\'administration ou aller à cette adresse ' . $url_devis;
}

// $title = "Nouveau devis à confirmer";

// importation du fichier
require_once(ROOT_PATH . '/SmsApi.php');

// instanciation de la classe
$smsApi = new SmsApi();

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($mobile_customer, $content_msg);

if ($resultSmsSent == "ok") {
    // echo "SMS envoyé avec succès !";
    $url = WEB_URL . 'confirmDevisSmsSent.php';
    header("Location: $url");
} else {
    echo "L'envoi du SMS a échoué !";
}
