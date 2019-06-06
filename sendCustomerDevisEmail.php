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

// Message de confirmation du devis
$content_msg = 'Pour voir votre devis, vous pouvez '.$url_devis;

$title = "Nouveau devis à confirmer";

// $wms->setContactStatus($link, $_POST['contact_id']);
$result = $wms->sendCustomerDevisEmail($link, $email_customer, $title, $content_msg, $devis_id);

$url = WEB_URL.'confirmDevisEmailSent.php';
header("Location: $url");

?>