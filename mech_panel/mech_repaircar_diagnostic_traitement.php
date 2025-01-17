<?php

include('../header.php');

// Inclusion de l'API SMS
require_once(ROOT_PATH . '/SmsApi.php');

// var_dump($_POST);
// die();

function uploadPJ_scanner()
{
    if ((!empty($_FILES["pj_scanner"])) && ($_FILES['pj_scanner']['error'] == 0)) {
        $filename = basename($_FILES['pj_scanner']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_scanner"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_scanner"]["type"] == 'image/png')
            || (($ext == "gif" || $ext == "GIF") && $_FILES["pj_scanner"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_scanner"]["type"] == 'application/pdf')
            || (($ext == "txt" || $ext == "TXT") && $_FILES["pj_scanner"]["type"] == 'text/plain')
            || ($ext == "docx" || $ext == "DOCX")
        ) {
            // $temp = explode(".", $_FILES["pj_scanner"]["name"]);
            // $filename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["pj_scanner"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $filename);
            return $filename;
        } else {
            return '';
        }
    }
    return '';
}

// Récupération des URL des pièces jointes
if ((!empty($_FILES["pj_scanner"])) && ($_FILES['pj_scanner']['error'] == 0)) {
    $_POST['pj_scanner'] = uploadPJ_scanner();
}

// échappement des chaines de caractères
$_POST['rapport_diagnostic'] = mysql_real_escape_string($_POST['rapport_diagnostic']);
$_POST['nom_client'] = mysql_real_escape_string($_POST['nom_client']);

// foreach($_POST['estimate_data'] as $key => $estimate_data){
//     $_POST['estimate_data'][$key] = mysql_real_escape_string($estimate_data['designation']);
// }

$rapport_diagnostic = nl2br($_POST['rapport_diagnostic']);

// Linéarisation de l'array des estimations pour le stocker en base de données
// $estimate_data = serialize($_POST['estimate_data']);
$estimate_data = json_encode($_POST['estimate_data'], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

// Si celui qui fait le diagnostic est le chef mécanicien, alors le diagnostic est de type mécanique
if ($_POST['mech_fonction'] == 'chef mecanicien' or $_POST['mech_fonction'] == 'mecanicien') {
    $type_diagnostic = 'mécanique';
}

// Si celui qui fait le diagnostic est le chef électronicien, alors le diagnostic est de type électronique
if ($_POST['mech_fonction'] == 'chef electricien' or $_POST['mech_fonction'] == 'electricien') {
    $type_diagnostic = 'électrique';
}

// Récupération de l'identifiant du mécanicien courant depuis la session
$mech_id = $_SESSION['objMech']['user_id'];

// var_dump($_POST);
// die();

if (isset($_POST['pj_scanner']) && $_POST['pj_scanner'] != "") {
    // Mise à jour du statut de scannage
    $query = "UPDATE tbl_vehicule_scanning SET statut_scannage=1 WHERE id='" . (int) $_POST['vehicule_scanner_id'] . "'";

    // Exécution de la requête
    $result = mysql_query($query, $link);

    // Vérification du résultat de la requête et affichage d'un message en cas d'erreur
    // if (!$result) {
    //     $message  = 'Invalid query: ' . mysql_error() . "\n";
    //     $message .= 'Whole query: ' . $query;
    //     die($message);
    // }
}

// Si celui qui fait le diagnostic est le chef electricien
if ($_POST['chef_mech_elec_type'] == "chef electricien") {

    // On enregistre un diagnostic en son nom
    $query = "INSERT INTO tbl_repaircar_diagnostic (nom_client, tel_wa_client, type_voiture, imma_vehicule, num_chasis_vehicule, rapport_diagnostic,
    estimate_data, duree_commande, duree_travaux, travaux_prevoir, date_creation_fiche_diag, car_id, type_diagnostic, mech_id, status_diagnostic_vehicule, 
    recep_car_id, pj_scanner, statut_diagnostic_electrique) 
    VALUES ('$_POST[nom_client]','$_POST[princ_tel]','$_POST[type_vehicule]','$_POST[imma_vehicule]','$_POST[num_chasis_vehicule]',
    '$rapport_diagnostic','$estimate_data','$_POST[duree_commande]','$_POST[duree_travaux]','$_POST[travaux_prevoir]',
    '$_POST[date_creation_fiche_diag]','$_POST[add_car_id]','$type_diagnostic','$mech_id', 1, '$_POST[recep_car_id]',
    '$_POST[pj_scanner]',1)";

    // Exécution et stockage du résultat de la requête sous forme de ressource
    $result = mysql_query($query, $link);

    // S'il y a eu une erreur lors de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

    // Si le chef électricien fini de faire son diagnostic, alors on annule le statut de son acceptation de faire le diagnostic
    $result_2 = $wms->updateStatutActionElectro($link, $_POST['recep_car_id']);

    // var_dump($_POST);
    // var_dump($result_2);
    // die();
}

// Si celui qui fait le diagnostic est le chef mécanicien
if ($_POST['chef_mech_elec_type'] == "chef mecanicien") {

    // On enregistre un diagnostic en son nom
    $query = "INSERT INTO tbl_repaircar_diagnostic (nom_client, tel_wa_client, type_voiture, imma_vehicule, num_chasis_vehicule, rapport_diagnostic,
    estimate_data, duree_commande, duree_travaux, travaux_prevoir, date_creation_fiche_diag, car_id, type_diagnostic, mech_id, status_diagnostic_vehicule, 
    recep_car_id, pj_scanner, statut_diagnostic_mecanique) 
    VALUES ('$_POST[nom_client]','$_POST[princ_tel]','$_POST[type_vehicule]','$_POST[imma_vehicule]','$_POST[num_chasis_vehicule]',
    '$rapport_diagnostic','$estimate_data','$_POST[duree_commande]','$_POST[duree_travaux]','$_POST[travaux_prevoir]',
    '$_POST[date_creation_fiche_diag]','$_POST[add_car_id]','$type_diagnostic','$mech_id', 1, '$_POST[recep_car_id]',
    '$_POST[pj_scanner]',1)";

    // Exécution et stockage du résultat de la requête sous forme de ressource
    $result = mysql_query($query, $link);

    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }

    // Si le chef mécanicien fini de faire son diagnostic, alors on annule le statut de son acceptation de faire le diagnostic
    $result_2 = $wms->updateStatutActionMecano($link, $_POST['recep_car_id']);

    // var_dump($result_2);
    // die();

}

/***********************************************
 * Envoi du SMS aux DG et DGA
 ***********************************************/

// require_once(ROOT_PATH . '/SmsApi.php');

// instanciation de la classe de l'API SMS
$smsApi = new SmsApi();

if ($_POST['chef_mech_elec_type'] == "chef mecanicien") {
    // Message d'alerte
    // $content_msg = $_SESSION['objMech']['name'] . ', a fait le diagnostic de la voiture réceptionnée ';
    $content_msg = 'Le chef mécanicien ' . $_SESSION['objMech']['name'] . ', a fait le diagnostic mécanique de la voiture réceptionnée ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'];
}

if ($_POST['chef_mech_elec_type'] == "chef electricien") {
    // Message d'alerte
    // $content_msg = $_SESSION['objMech']['name'] . ', a fait le diagnostic de la voiture réceptionnée ';
    $content_msg = 'Le chef électricien ' . $_SESSION['objMech']['name'] . ', a fait le diagnostic électrique de la voiture réceptionnée ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'];
}

$resultDGinfos = $wms->getDGInfos($link);

foreach ($resultDGinfos as $DGinfos) {

    // Exécution de la méthode d'envoi 
    $resultSmsSentToAdmin = $smsApi->isSmsapi($DGinfos['usr_tel'], $content_msg);
}

/**********************************
 * Envoi du SMS au service client
 **********************************/

if ($_POST['chef_mech_elec_type'] == "chef mecanicien") {
    // Message d'alerte
    // $content_msg = $_SESSION['objMech']['name'] . ', a fait le diagnostic de la voiture réceptionnée ';
    $content_msg = 'Le chef mécanicien ' . $_SESSION['objMech']['name'] . ', a fait le diagnostic mécanique de la voiture réceptionnée ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'];
}

if ($_POST['chef_mech_elec_type'] == "chef electricien") {
    // Message d'alerte
    // $content_msg = $_SESSION['objMech']['name'] . ', a fait le diagnostic de la voiture réceptionnée ';
    $content_msg = 'Le chef électricien ' . $_SESSION['objMech']['name'] . ', a fait le diagnostic électrique de la voiture réceptionnée ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'];
}

$resultServcliInfo = $wms->getServcliInfos($link);

foreach ($resultServcliInfo as $servcliInfo) {

    // Exécution de la méthode d'envoi 
    $resultServcliInfo = $smsApi->isSmsapi($servcliInfo['usr_tel'], $content_msg);
}

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($recep_tel, $content_msg);

/**********************************
 * Envoi du SMS au receptionniste
 **********************************/

// Récupération du numéro de téléphone du receptionniste
$recep_tel = $_POST['recep_tel'];
// $recep_tel  = "02280768";

if ($_POST['chef_mech_elec_type'] == "chef mecanicien") {
    // Message d'alerte
    // $content_msg = $_SESSION['objMech']['name'] . ', a fait le diagnostic de la voiture réceptionnée ';
    $content_msg = 'Le chef mécanicien ' . $_SESSION['objMech']['name'] . ', a fait le diagnostic mécanique de la voiture réceptionnée ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'];
}

if ($_POST['chef_mech_elec_type'] == "chef electricien") {
    // Message d'alerte
    // $content_msg = $_SESSION['objMech']['name'] . ', a fait le diagnostic de la voiture réceptionnée ';
    $content_msg = 'Le chef électricien ' . $_SESSION['objMech']['name'] . ', a fait le diagnostic électrique de la voiture réceptionnée ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'];
}

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($recep_tel, $content_msg);

/*****************************************************************
 * Envoi du SMS soit au chef mécanicien soit au chef électricien
 *****************************************************************/

// Si c'est le chef mécanicien qui est prêt à faire le diagnostic
// alors on envoi le SMS au chef électricien

if ($_POST['statut_acceptation_mecanicien'] == '1') {

    // On récupère le numéro de téléphone du chef électricien
    $queryChefElec = "SELECT usr_tel FROM tbl_add_mech WHERE usr_type = 'chef electricien'";

    // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
    $resultChefElec = mysql_query($queryChefElec, $link);

    // if (!$resultChefElec) {
    //     $message  = 'Invalid query: ' . mysql_error() . "\n";
    //     $message .= 'Whole query: ' .  $queryChefElec;
    //     die($message);
    // }

    $rowChefElec = mysql_fetch_assoc($resultChefElec);
    // $elec_tel = $_POST['elec_tel'];
    $elec_tel = $rowChefElec['usr_tel'];

    // $elec_tel = $_POST['elec_tel'];
    // $elec_tel = "02280768";

    // Message d'alerte
    $content_msg = 'Le chef mécanicien ' . $_SESSION['objMech']['name'] . ', a fait le diagnostic mécanique de la voiture réceptionnée ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'];

    // Exécution de la méthode d'envoi 
    $resultSmsSent = $smsApi->isSmsapi($elec_tel, $content_msg);
}

/*****************************************************************
 * Envoi du SMS soit au chef mécanicien soit au chef électricien
 *****************************************************************/

// Si c'est le chef électricien qui est prêt à faire le diagnostic
// alors on envoi le SMS au chef mécanicien
if ($_POST['statut_acceptation_electricien'] == '1') {

    // On récupère le numéro de téléphone du chef mécanicien
    $queryChefMecano = "SELECT usr_tel FROM tbl_add_mech WHERE usr_type = 'chef mecanicien'";

    // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
    $resultChefMecano = mysql_query($queryChefMecano, $link);

    // if (!$resultChefMecano) {
    //     $message  = 'Invalid query: ' . mysql_error() . "\n";
    //     $message .= 'Whole query: ' .  $queryChefMecano;
    //     die($message);
    // }

    $rowChefMecano = mysql_fetch_assoc($resultChefMecano);
    $mech_tel = $rowChefMecano['usr_tel'];

    // $mech_tel = $_POST['mech_tel'];
    // $elec_tel = "02280768";

    // Message d'alerte
    // $content_msg = $_SESSION['objMech']['name'] . ', a fait le diagnostic de la voiture réceptionnée ';
    $content_msg = 'Le chef électricien ' . $_SESSION['objMech']['name'] . ', a fait le diagnostic électrique de la voiture réceptionnée ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'];

    // Exécution de la méthode d'envoi 
    $resultSmsSent = $smsApi->isSmsapi($mech_tel, $content_msg);
}

// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
// if ($result) {

// Redirection vers la liste des diagnostic des véhicules
// $url = WEB_URL . 'reception/repaircar_diagnostic_list.php?m=add';
$url = WEB_URL . 'mech_panel/mech_dashboard.php';
header("Location: $url");
// }
