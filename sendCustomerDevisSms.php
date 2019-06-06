<?php
include_once('config.php');

$vehi_diag_id = $_GET['vehi_diag_id'];
$devis_id = $_GET['devis_id'];
$mobile_customer = $_GET['mobile_customer'];

// Lien de confirmation du devis envoyé par e-mail
$url_devis = '<a href='.WEB_URL.'confirmDevisTraitement.php?confirm_devis=1&vehi_diag_id='.$_GET['vehi_diag_id'].'&devis_id='.$_GET['devis_id'].'>cliquer sur ce lien</a>';

// Message de confirmation du devis
$content_msg = 'Pour voir votre devis, vous pouvez '.$url_devis;

// $title = "Nouveau devis à confirmer";

// importation du fichier
require_once(ROOT_PATH . '/SmsApi.php');

// instanciation de la classe
$smsApi = new SmsApi();

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($mobile_customer, $content_msg);

if($resultSmsSent){
    // echo "SMS envoyé avec succès !";
    $url = WEB_URL.'confirmDevisSmsSent.php';
    header("Location: $url");
} else {
    echo "L'envoi du SMS a échoué !";
}
