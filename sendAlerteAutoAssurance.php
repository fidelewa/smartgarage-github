<?php

include_once('config.php');
include_once('helper/common.php');
$wms = new wms_core();

$result = $wms->getAllRepairCarList($link);

foreach ($result as $row) {

    $dateFinAssur = DateTime::createFromFormat('d/m/Y', $row['add_date_assurance_fin']);

    if ($dateFinAssur instanceof DateTime) {

        $diffDateDebutFinAssur = $dateFinAssur->diff(new \DateTime())->format('%R%a');
        $diffDateDebutFinAssurStr = $dateFinAssur->diff(new \DateTime())->format(' %a jours');
        $diffDateDebutFinAssurStr_2 = $dateFinAssur->diff(new \DateTime())->format('%a');

        // conversion en entier
        $diffDateDebutFinAssur = (int) $diffDateDebutFinAssur;

        if (($diffDateDebutFinAssur == -14) || ($diffDateDebutFinAssur == -3)) {

            $remainingDays = $diffDateDebutFinAssurStr_2;
            $marque = $row['make_name'];
            $modele = $row['model_name'];
            $imma = $row['VIN'];
            $nom_client = $row['c_name'];
            $mobile_customer = $row['princ_tel'];

            // Message de confirmation du devis
            $content_msg = 'Cher client ' . $nom_client . ', nous vous informons que l\'assurance de votre voiture ' . $marque . ' ' . $modele . ' ' . $imma . ' expire dans ' . $remainingDays . ' jours ! Pensez donc à la renouveler merci !';

            // importation du fichier
            require_once(ROOT_PATH . '/SmsApi.php');

            // instanciation de la classe
            $smsApi = new SmsApi();

            // Exécution de la méthode d'envoi 
            $resultSmsSent = $smsApi->isSmsapi($mobile_customer, $content_msg);

            if ($resultSmsSent == "ok") {
                echo "<p><span class='label label-success'>SMS automatique de rappel de l'assurance envoyé avec succès !</p><span>";
            }
        } elseif ($diffDateDebutFinAssur == 0) {

            $marque = $row['make_name'];
            $modele = $row['model_name'];
            $imma = $row['VIN'];
            $nom_client = $row['c_name'];
            $mobile_customer = $row['princ_tel'];

            // Message de confirmation du devis
            $content_msg = 'Cher client ' . $nom_client . ' nous vous informons que l\'assurance de votre voiture ' . $marque . ' ' . $modele . ' ' . $imma . ' à expirée ! Pensez donc à la renouveler merci !';

            // importation du fichier
            require_once(ROOT_PATH . '/SmsApi.php');

            // instanciation de la classe
            $smsApi = new SmsApi();

            // Exécution de la méthode d'envoi 
            $resultSmsSent = $smsApi->isSmsapi($mobile_customer, $content_msg);

            if ($resultSmsSent == 'ok') {
                echo "<p><span class='label label-success'>SMS automatique de rappel de l'assurance envoyé avec succès !</p><span>";
                // $url = WEB_URL.'dashboard.php';
                // header("Location: $url");
            }
        }
    }
}

mysql_close($link);