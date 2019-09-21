<?php
// importation du fichier de l'API SMS
require_once(ROOT_PATH . '/SmsApi.php');

// instanciation de la classe de l'API SMS
$smsApi = new SmsApi();

// if ($_POST['mecanicienList'] == "chef electricien") {

    // Liste des chefs mécanicien et électricien
    $queryChefMechElec = "SELECT * FROM tbl_add_mech WHERE usr_type IN ('chef electricien')";

    // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
    $resultChefMechElec = mysql_query($queryChefMechElec, $link);

    $rowChefMechElec = mysql_fetch_assoc($resultChefMechElec);

    $mobile_mech = $rowChefMechElec['usr_tel'];
    $mech_name = $rowChefMechElec['usr_name'];
    $send_sms_electro = "";
// }

// $mobile_mech  = "02280768";

// Message d'alerte
$content_msg = $mech_name . ', vous avez la charge de faire le diagnostic de la voiture ' . $make_name . ' ' . $model_name . ' ' . $imma_vehi;
// $content_msg = "Le véhicule d'identifiant " . $_POST['car_id'] . "vous a été attribué pour effectuer un diagnostic";

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($mobile_mech, $content_msg);

// var_dump($resultSmsSent);
// die();

// On fait une redirection si le sms a été envoyé avec succès
if ($resultSmsSent == "ok") {

    if (isset($send_sms_electro) && $send_sms_electro == "") {
        $send_sms_statut = "send_electro_sms_succes";
    }

    // Faire une rédirection vers la liste des véhicules réceptionnés avec un paramètre d'attribution
    // header("Location: " . WEB_URL . "reception/repaircar_reception_list.php?att=attribution&sms=" . $send_sms_statut . "&car_id=" . $_POST['reception_id'] . "&mecanicien_id=" . $rowChefMechElec['usr_id'] . "&marque=" . $make_name . "&modele=" . $model_name . "&imma=" . $immat_vehi . "&mech_name=" . $mech_name);
} else {

    if (isset($send_sms_electro) && $send_sms_electro == "") {
        $send_sms_statut = "send_electro_sms_failed";
    }

    // echo "<script type='text/javascript'> document.location.href='" . WEB_URL . "reception/repaircar_reception_list.php?att=attribution&car_id=" . $_POST['reception_id'] . "&mecanicien_id=" . $rowChefMechElec['usr_id'] . "&marque=" . $make_name . "&modele=" . $model_name . "&imma=" . $immat_vehi . "&mech_name=" . $mech_name . "&sms=" . $send_sms_statut . "'</script>";
}
