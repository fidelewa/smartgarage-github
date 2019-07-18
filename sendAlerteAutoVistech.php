<?php

$dateprochvistech = DateTime::createFromFormat('d/m/Y', $row['add_date_visitetech']);

if ($dateprochvistech instanceof DateTime) {

  // Définition du statut de la visite technique
  $diffTodayDateprochvistech = $dateprochvistech->diff(new \DateTime())->format('%R%a');
  $diffTodayDateprochvistechStr = $dateprochvistech->diff(new \DateTime())->format(' %a jours');
  $diffTodayDateprochvistechStr_2 = $dateprochvistech->diff(new \DateTime())->format('%a');

  // Conversion en entier
  $diffTodayDateprochvistech = (int) $diffTodayDateprochvistech;

  if (($diffTodayDateprochvistech == -14) || ($diffTodayDateprochvistech == -3)) {

    $remainingDays = $diffTodayDateprochvistechStr_2;
    $marque = $row['make_name'];
    $modele = $row['model_name'];
    $imma = $row['VIN'];
    $nom_client = $row['c_name'];
    $mobile_customer = $row['princ_tel'];

    // Message de confirmation du devis
    $content_msg = 'Cher client ' . $nom_client . ', nous vous informons que la date de la visite technique de votre voiture ' . $marque . ' ' . $modele . ' ' . $imma . ' expire dans ' . $remainingDays . ' jours ! Pensez donc a la repasser merci !';

    // importation du fichier
    require_once(ROOT_PATH . '/SmsApi.php');

    // instanciation de la classe
    $smsApi = new SmsApi();

    // Exécution de la méthode d'envoi 
    $resultSmsSent = $smsApi->isSmsapi($mobile_customer, $content_msg);

    if ($resultSmsSent == "ok") {
      echo "<p><span class='label label-success'>SMS automatique de rappel de la visite technique envoyé avec succès !</p><span>";
      // $url = WEB_URL.'dashboard.php';
      // header("Location: $url");
    }
  } elseif ($diffTodayDateprochvistech == 0) {

    $marque = $row['make_name'];
    $modele = $row['model_name'];
    $imma = $row['VIN'];
    $nom_client = $row['c_name'];
    $mobile_customer = $row['princ_tel'];

    // Message de confirmation du devis
    $content_msg = 'Cher  client  ' . $nom_client . ', nous vous informons que la date de la visite technique de votre voiture' . $marque . ' ' . $modele . ' ' . $imma . ' est depassee ! Pensez donc a la repasser !';

    // importation du fichier
    require_once(ROOT_PATH . '/SmsApi.php');

    // instanciation de la classe
    $smsApi = new SmsApi();

    // Exécution de la méthode d'envoi 
    $resultSmsSent = $smsApi->isSmsapi($mobile_customer, $content_msg);

    if ($resultSmsSent == "ok") {
      echo "<p><span class='label label-success'>SMS automatique de rappel de la visite technique envoyé avec succès !</p><span>";
      // $url = WEB_URL.'dashboard.php';
      // header("Location: $url");
    }
  }
}