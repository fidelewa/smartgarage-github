<?php
include_once('config.php');
include_once('helper/common.php');
$wms = new wms_core();

$devis_id = $_GET['devis_id'];
$facture_id = $_GET['facture_id'];
$date_facture = $_GET['date_facture'];
$email_customer = $_GET['email_customer'];
// $email_customer = "aw.fidele@e-mitic.com";

// Lien de confirmation de la facture envoyé par e-mail
$url_facture = '<a href='.WEB_URL.'confirmFactureTraitement.php?confirm_facture=1&devis_id='.$devis_id.'&facture_id='.$facture_id.'>cliquer sur ce lien</a>';

// Message de confirmation de la facture
$content_msg = 'Pour voir votre facture, vous pouvez '.$url_facture;

// titre du message de confirmation de la facture
$title = "Nouvelle facture à payer";

// $wms->setContactStatus($link, $_POST['contact_id']);
$result = $wms->sendCustomerDevisEmail($link, $email_customer, $title, $content_msg, $facture_id, $date_facture);

// On envoi ce même SMS aux DG et DGA
$resultDGinfos = $wms->getDGInfos($link);

foreach ($resultDGinfos as $DGinfos) {

    // Exécution de la méthode d'envoi 
    $resultSmsSentToAdmin = $smsApi->isSmsapi($DGinfos['usr_tel'], $content_msg);
}

// Redirection vers la page de confirmation de l'envoi du lien de la facture au client concerné
$url = WEB_URL.'confirmFactureEmailSent.php';
header("Location: $url");

?>