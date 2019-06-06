<?php
include_once('config.php');

$devis_id = $_GET['devis_id'];
$facture_id = $_GET['facture_id'];
$date_facture = $_GET['date_facture'];
$mobile_customer = $_GET['mobile_customer'];

// Lien de confirmation de la facture envoyé par e-mail
$url_facture = '<a href='.WEB_URL.'confirmFactureTraitement.php?confirm_facture=1&devis_id='.$devis_id.'&facture_id='.$facture_id.'>cliquer sur ce lien</a>';

// Message de confirmation de la facture
$content_msg = 'Pour voir votre facture, vous pouvez '.$url_facture;

// importation du fichier
require_once(ROOT_PATH . '/SmsApi.php');

// instanciation de la classe
$smsApi = new SmsApi();

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($mobile_customer, $content_msg);

if($resultSmsSent){
    // echo "SMS envoyé avec succès !";
    $url = WEB_URL.'confirmFactureSmsSent.php';
    header("Location: $url");
} else {
    echo "L'envoi du SMS a échoué !";
}
