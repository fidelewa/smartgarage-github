<?php
include_once('config.php');
include_once('helper/common.php');


$wms = new wms_core();

$vehi_diag_id = $_GET['vehi_diag_id'];
$devis_id = $_GET['devis_id'];
$email_customer = $_GET['email_customer'];
// $email_customer = "aw.fidele@e-mitic.com";

// Lien de confirmation du devis envoyé par e-mail
$url_devis = '<a href='.WEB_URL.'confirmDevisTraitement.php?confirm_devis=1&vehi_diag_id='.$_GET['vehi_diag_id'].'&devis_id='.$_GET['devis_id'].'>cliquer sur ce lien</a>';

if ($_GET['type_diagnostic'] == 'mécanique') {
    // Message de confirmation du devis
    $content_msg = 'Un devis électrique vous a été envoyé pour validation. Pour voir ce devis, vous pouvez ' . $url_devis;
}

if ($_GET['type_diagnostic'] == 'électrique') {
    // Message de confirmation du devis
    $content_msg = 'Un devis électrique vous a été envoyé pour validation. Pour voir ce devis, vous pouvez ' . $url_devis;
}

$title = "Nouveau devis à confirmer";

// $wms->setContactStatus($link, $_POST['contact_id']);
$result = $wms->sendCustomerDevisEmail($link, $email_customer, $title, $content_msg, $devis_id);

// On envoi ce même SMS aux DG et DGA
$resultDGinfos = $wms->getDGInfos($link);

foreach ($resultDGinfos as $DGinfos) {

    // Exécution de la méthode d'envoi 
    $resultSmsSentToAdmin = $smsApi->isSmsapi($DGinfos['usr_tel'], $content_msg);
}

$url = WEB_URL.'confirmDevisEmailSent.php';
header("Location: $url");

?>