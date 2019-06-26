<?php
include_once('config.php');

// $remainingDays = $_GET['remainingDays'];
$marque = $_GET['marque'];
$modele = $_GET['modele'];
$imma = $_GET['imma'];
$nom_client = $_GET['nom_client'];
$mobile_customer = $_GET['mobile_customer'];

// Message de confirmation du devis
$content_msg = 'Cher client '.$nom_client.' nous vous informons que l\'assurance de votre voiture '.$marque.' '.$modele.' '.$imma.' a expire ! Pensez donc a la renouveler merci !';

// importation du fichier
require_once(ROOT_PATH . '/SmsApi.php');

// instanciation de la classe
$smsApi = new SmsApi();

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($mobile_customer, $content_msg);

if($resultSmsSent){
    // echo "SMS envoyé avec succès !";
    $url = WEB_URL.'repaircar/carlist.php?m=exp_assur_sms_succes';
    header("Location: $url");
} else {
    $url = WEB_URL.'repaircar/carlist.php?m=exp_assur_sms_failed';
    header("Location: $url");
}
