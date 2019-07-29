<?php

include('../mech_panel/header.php');

// var_dump($_POST);
// die();

// function NewGuid()
// {
//     $s = strtoupper(md5(uniqid(rand(), true)));
//     $guidText =
//         substr($s, 0, 8) . '-' .
//         substr($s, 8, 4) . '-' .
//         substr($s, 12, 4) . '-' .
//         substr($s, 16, 4) . '-' .
//         substr($s, 20);
//     return $guidText;
// }

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
    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }
}

$query = "INSERT INTO tbl_repaircar_diagnostic (nom_client, tel_wa_client, type_voiture, imma_vehicule, num_chasis_vehicule, rapport_diagnostic,
estimate_data, duree_commande, duree_travaux, travaux_prevoir, date_creation_fiche_diag, car_id, type_diagnostic, mech_id, status_diagnostic_vehicule, 
recep_car_id, pj_scanner) 
VALUES ('$_POST[nom_client]','$_POST[tel_wa_client]','$_POST[type_vehicule]','$_POST[imma_vehicule]','$_POST[num_chasis_vehicule]',
'$rapport_diagnostic','$estimate_data','$_POST[duree_commande]','$_POST[duree_travaux]','$_POST[travaux_prevoir]',
'$_POST[date_creation_fiche_diag]','$_POST[add_car_id]','$type_diagnostic','$mech_id', 1, '$_POST[recep_car_id]',
'$_POST[pj_scanner]')";

// Exécution et stockage du résultat de la requête sous forme de ressource
$result = mysql_query($query, $link);

// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
} else {

    // Redirection vers la liste des diagnostic des véhicules
    // $url = WEB_URL . 'reception/repaircar_diagnostic_list.php?m=add';
    $url = WEB_URL . 'mech_panel/mech_dashboard.php';
    header("Location: $url");
}
