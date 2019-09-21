<?php

// importation du fichier de l'API SMS
require_once(ROOT_PATH . '/SmsApi.php');

// instanciation de la classe de l'API SMS
$smsApi = new SmsApi();

$resultDGinfos = $wms->getDGInfos($link);

$content_msg = 'Un véhicule, ' . $make_name . ' ' . $model_name . ' ' . $imma_vehi .
    ' appartenant au client ' . $client_nom . ' vient d\'être réceptionné.';

foreach ($resultDGinfos as $DGinfos) {

    // Exécution de la méthode d'envoi 
    $resultSmsSentToAdmin = $smsApi->isSmsapi($DGinfos['usr_tel'], $content_msg);
}

if ($resultSmsSentToAdmin == "ok") {
    $sms_sent_to_admin = 'send_admin_sms_succes';
} else {
    $sms_sent_to_admin = 'send_admin_sms_failed';
}
