
<?php

include('../config.php');
include("../helper/common.php");
require_once(ROOT_PATH . '/SmsApi.php');

$wms = new wms_core();

// instanciation de la classe de l'API SMS
$smsApi = new SmsApi();

// var_dump($_POST);
// die();

// Si la valeur de la marque dans le champs de saisie n'est pas connu
if (!isset($_POST['ddlMake']) || $_POST['ddlMake'] == "") {
    $_POST['ddlMake'] = $_POST['marque_hd'];
}

// Si la valeur du modèle dans le champs de saisie n'est pas connu
if (!isset($_POST['ddlModel']) || $_POST['ddlModel'] == "") {
    $_POST['ddlModel'] = $_POST['model_hd'];
}

$clientData = explode("//", $_POST['ddlCustomerList']);

$client_nom = $clientData[0];
$client_num_tel = $clientData[1];

if (!isset($clientData[0]) || $clientData[0] == "") {
    $url = WEB_URL . "repaircar/vehicule_scanning_list.php?m=nom_client_incorrect_format";
    header("Location: $url");
    die();
}

if (!isset($clientData[1]) || $clientData[1] == "") {
    $url = WEB_URL . "repaircar/vehicule_scanning_list.php?m=nom_client_incorrect_format";
    header("Location: $url");
    die();
}

// Récupération de l'indentifiant du client à partir de son numéro de téléphone (qui a un index unique)
// $queryclient = "SELECT customer_id FROM tbl_add_customer WHERE princ_tel = '022807686'";

// $queryclient = mysql_real_escape_string($queryclient);

// var_dump($queryclient);

// On exécute la requête
$resultListeClients = mysql_query("SELECT customer_id FROM tbl_add_customer WHERE princ_tel = '" . $client_num_tel . "'", $link);

// var_dump($resultListeClients);

// // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
// if (!$resultListeClients) {
//     $message  = 'Invalid query: ' . mysql_error() . "\n";
//     $message .= 'Whole query: ' . $queryClient;
//     die($message);
// }

// On récupère la liste des modèles commençant par le même caractère que la valeur du modèle soumis via le formulaire
while ($row = mysql_fetch_assoc($resultListeClients)) {

    $client_id = (int) $row['customer_id'];
    // var_dump($row);
    // var_dump($client_id);
}

// if ($_POST['frais_scanner'] != '') {

// Si le montant des frais de scanner est
// supérieur ou égale à 100 000 FCFA

// var_dump($_POST);
// die();

$_POST['frais_scanner'] = (int) $_POST['frais_scanner'];

// var_dump($_POST);
// die();

// if ($_POST['frais_scanner'] >= 100000) {

//     if ($_POST['scanner_electrique'] == null || $_POST['scanner_mecanique'] == null) {
//         $url = WEB_URL . "repaircar/vehicule_scanning_list.php?m=scanner_error_deux";
//         header("Location: $url");
//     }

// } else if ((int)$_POST['frais_scanner'] >= 50000 && (int)$_POST['frais_scanner'] < 100000) {

//   // On vérifie que les cases à cocher sont bien checké sinon, on déclenche une alerte
//   if ($_POST['scanner_electrique'] == null && $_POST['scanner_mecanique'] == null) {
//     $url = WEB_URL . "repaircar/vehicule_scanning_list.php?m=scanner_error";
//     header("Location: $url");
// }

//   if (isset($_POST['scanner_electrique']) && isset($_POST['scanner_mecanique'])) {
//     $url = WEB_URL . "repaircar/vehicule_scanning_list.php?m=scanner_error_un";
//     header("Location: $url");
//   }

// } else {
//     $url = WEB_URL . "repaircar/vehicule_scanning_list.php?m=scanner_error_montant";
//     header("Location: $url");
// }
//   }

// var_dump($_POST);
// die();

if ($_POST['scanner_electrique'] == null && $_POST['scanner_mecanique'] == null) {

    // Si aucun des types de scanner n'est sélectionné alors
    // on fait une redirection vers la liste des véhicules scannés en déclenchant une erreur
    $url = WEB_URL . "repaircar/vehicule_scanning_list.php?m=scanner_error";
    header("Location: $url");
    die();
} else {

    if (isset($_POST['scanner_electrique'])) {
        $_POST['scanner_electrique'] = "OUI";
    } else {
        $_POST['scanner_electrique'] = null;
    }

    if (isset($_POST['scanner_mecanique'])) {
        $_POST['scanner_mecanique'] = "OUI";
    } else {
        $_POST['scanner_mecanique'] = null;
    }

    // var_dump($_POST);
    // die();

    // Initialisation des variables

    // ETAPE 1
    $marque_name_form = $_POST['ddlMake'];
    $modele_name_form = $_POST['ddlModel'];
    // Récupération de l'identifiant du client
    $_POST['ddlCustomerList'] = $_POST['customer_id'];
    // Récupération de l'immatriculation du véhicule
    $_POST['vin'] = $_POST['immat'];
    $make_name_str = $_POST['ddlMake'];
    $model_name_str = $_POST['ddlModel'];
    $cptOccur = 0;
    $make_id = null;
    $modele_id = null;
    $modeleMakeId  = null;
    $listeMarques = array();
    $listeModeles = array();
    $listeClient = array();

    // Marque
    // On converti la chaine de caractère de la marque en array et on récupère le premier caractère de cette valeur
    $arr_marque_name_form = str_split($marque_name_form);
    $arr_marque_name_form_str = $arr_marque_name_form[0];

    // Marque
    $queryMarque = "SELECT * FROM tbl_make WHERE make_name LIKE '" . $arr_marque_name_form_str . "%'";

    // On exécute la requête
    $resultListeMarques = mysql_query($queryMarque, $link);

    // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
    // if (!$resultListeMarques) {
    //     $message  = 'Invalid query: ' . mysql_error() . "\n";
    //     $message .= 'Whole query: ' . $queryMarque;
    //     die($message);
    // }

    // On récupère la liste des marques commençant par le même caractère que la valeur de la marque soumise via le formulaire
    while ($row = mysql_fetch_assoc($resultListeMarques)) {
        $listeMarques[] = $row;
    }

    // Modèle

    // On converti la chaine de caractère du modèle en array et on récupère le premier caractère de cette valeur
    $arr_modele_name_form = str_split($modele_name_form);
    $arr_modele_name_form_str = $arr_modele_name_form[0];

    // Récupération du nom de la marque qui a pour id la valeur retourné par la variable $_POST['ddlMake']
    $queryModele = "SELECT * FROM tbl_model WHERE model_name LIKE '" . $arr_modele_name_form_str . "%'";

    // On exécute la requête
    $resultListeModeles = mysql_query($queryModele, $link);

    // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
    // if (!$resultListeModeles) {
    //     $message  = 'Invalid query: ' . mysql_error() . "\n";
    //     $message .= 'Whole query: ' . $queryModele;
    //     die($message);
    // }

    // On récupère la liste des modèles commençant par le même caractère que la valeur du modèle soumis via le formulaire
    while ($row = mysql_fetch_assoc($resultListeModeles)) {
        $listeModeles[] = $row;
    }

    // ETAPE 3
    // Parcours des marques
    foreach ($listeMarques as $marque) {
        if ($marque_name_form == $marque['make_name']) {
            $make_id = $marque['make_id'];
            $make_name = $marque['make_name'];
        }
    }

    // Parcours des modèles
    foreach ($listeModeles as $modele) {
        if ($modele_name_form == $modele['model_name']) {
            $modele_id = $modele['model_id'];
            $model_name = $modele['model_name'];
        }
    }

    // MARQUE
    if ($make_id == null) {

        // Insertion du nom de la marque dans la table des marques
        $queryInsertMake = "INSERT INTO tbl_make (make_name) VALUES('$marque_name_form')";

        // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
        $resultInsertMake = mysql_query($queryInsertMake, $link);

        // if (!$resultInsertMake) {
        //     $message  = 'Invalid query: ' . mysql_error() . "\n";
        //     $message .= 'Whole query: ' . $queryInsertMake;
        //     die($message);
        // }

        // Récupération de l'id de la nouvelle marque pour faire l'insertion du modèle en BDD
        $queryGetMakeId = "SELECT make_id FROM tbl_make WHERE make_name='" . $marque_name_form . "'";

        // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
        $resultMakeId = mysql_query($queryGetMakeId, $link);

        // if (!$resultMakeId) {
        //     $message  = 'Invalid query: ' . mysql_error() . "\n";
        //     $message .= 'Whole query: ' . $queryGetMakeId;
        //     die($message);
        // }

        // On retourne les données de la marque référencée dans un tableau associatif
        $rowMakeId = mysql_fetch_assoc($resultMakeId);

        // affectation de la valeur de l'identifiant de la marque
        $modeleMakeId = (int) $rowMakeId['make_id'];
        // On rédéfini la valeur de l'identifiant de la marque qui sera persistée dans la table tbl_add_car
        $_POST['ddlMake'] = (int) $modeleMakeId;

        // var_dump($rowMakeId);
        // die();

    } else {
        // Si une marque exitant en BDD correspond à la valeur de la marque soumise via le formulaire de saisie
        //  On récupère la valeur de son id et on rédéfini la valeur de l'identifiant de la marque qui sera persistée dans la table tbl_add_car
        $modeleMakeId = (int) $make_id;
        $_POST['ddlMake'] = (int) $make_id;
        // var_dump($make_id);
    }

    // MODELE
    if ($modele_id == null) {

        // Insertion du nom du modele et de l'id de la marque dans la table des modèles
        $queryInsertModel = "INSERT INTO tbl_model (make_id, model_name) VALUES('$modeleMakeId','$modele_name_form')";

        // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
        $resultInsertModel = mysql_query($queryInsertModel, $link);

        // if (!$resultInsertModel) {
        //     $message  = 'Invalid query: ' . mysql_error() . "\n";
        //     $message .= 'Whole query: ' . $queryInsertModel;
        //     die($message);
        // }

        // Récupération de l'id du nouveau modèle de voiture ajouté
        $queryGetModeleId = "SELECT model_id FROM tbl_model WHERE model_name='" . $modele_name_form . "'";

        // On exécute la requête
        $resultModeleId = mysql_query($queryGetModeleId, $link);

        // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
        // if (!$resultModeleId) {
        //     $message  = 'Invalid query: ' . mysql_error() . "\n";
        //     $message .= 'Whole query: ' . $queryGetModeleId;
        //     die($message);
        // }

        // On retourne les données du modèle référencé dans un tableau associatif
        $rowModeleId = mysql_fetch_assoc($resultModeleId);

        // On rédéfini la valeur de l'identifiant du modèle qui sera persistée dans la table tbl_add_car
        $_POST['ddlModel'] = (int) $rowModeleId['model_id'];

        // var_dump($rowModeleId);
        // die();

    } else {
        // Si un modèle exitant en BDD correspond à la valeur du modèle soumis via le formulaire de saisie
        //  On récupère la valeur de son id et on rédéfini la valeur de l'identifiant du modèle qui sera persistée dans la table tbl_add_car
        $modele_id = (int) $modele_id;
        $_POST['ddlModel'] = (int) $modele_id;
        // var_dump($modele_id);
        // die();
    }

    // Récupération du nom de la marque qui a pour id la valeur retourné par le component $_POST['ddlMake']
    $query = "SELECT make_name FROM tbl_make WHERE make_id='" . (int) $_POST['ddlMake'] . "'";

    // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
    $result = mysql_query($query, $link);

    // if (!$result) {
    //     $message  = 'Invalid query: ' . mysql_error() . "\n";
    //     $message .= 'Whole query: ' . $query;
    //     die($message);
    // }

    // On retourne le nom de la marque dans un tableau associatif
    $row = mysql_fetch_array($result);

    // On affecte le nom de la marque à la variable $_POST['car_names']
    $_POST['car_names'] = $row['make_name'];

    if (!isset($image_url)) {
        $image_url = null;
    }

    // On vérifi si la voiture en question existe d&ja en BDD
    $queryCar = "SELECT * FROM tbl_add_car WHERE VIN = '" . $_POST['vin'] . "'";

    // var_dump($queryCar);
    // die();

    $resultListeCar = mysql_query($queryCar, $link);

    // if (!$resultListeCar) {
    //     $message  = 'Invalid query: ' . mysql_error() . "\n";
    //     $message .= 'Whole query: ' . $query;
    //     die($message);
    // }

    // On retourne le nom de la marque dans un tableau associatif
    $rowCar = mysql_fetch_array($resultListeCar);

    // $_POST['ddlCustomerList'] = (int)$_POST['cli'];

    $_POST['ddlCustomerList'] = (int) $client_id;

    // var_dump($_POST);
    // die();

    // $cli = (int)$_POST['cli'];

    // Si la voiture n'est pas encore enregistrée en BDD
    // On l'enregistre
    if (empty($rowCar)) {

        // Insertion dans la table des véhicules
        $wms->saveRepairCarScanningInfo($link, $_POST, $image_url);
    }

    // Insertion dans la table des véhicules à scanner

    $frais_scanner = (float) $_POST['frais_scanner'];

    // $nbr_aleatoire = rand();
    $nbr_aleatoire = substr(rand(), 0, 6);

    $createAt = date_format(date_create('now', new \DateTimeZone('Africa/Abidjan')), 'Y-m-d H:i:s');

    // Récupération des valeurs de l'avance et du reste à payer du scanner
    if ($_POST['avance_scanner'] == "") {
        $avance_scanner = 0;
    } else {
        $avance_scanner = $_POST['avance_scanner'];
    }

    if ($_POST['reste_payer_scanner'] == "") {
        $reste_payer = 0;
    } else {
        $reste_payer = $_POST['reste_payer_scanner'];
    }

    // var_dump($createAt);
    // die();

    $query = "INSERT INTO tbl_vehicule_scanning (imma_vehi_client, marque_vehi_client, 
       model_vehi_client, scanner_mecanique, scanner_electrique, frais_scanner, customer_id, nbr_aleatoire, created_at, autres_motifs,
       etat_vehi_arrive, avance_scanner, reste_payer
    )
    VALUES('$_POST[immat]','$make_name_str','$model_name_str','$_POST[scanner_mecanique]','$_POST[scanner_electrique]',
    '$frais_scanner','$_POST[ddlCustomerList]', $nbr_aleatoire, '$createAt','$_POST[autres_motifs]','$_POST[etat_vehi_arrive]',
    $avance_scanner,$reste_payer
    )";

    // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
    $result = mysql_query($query, $link);

    if (!$result) {
        // var_dump($data);
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }

    /*******************************
     *  GESTION DU SCANNER GRATUIT
     ******************************/

    // On récupère l'identifiant du dernier scanner enregistré
    $vehicule_scanning_id = mysql_insert_id();

    // var_dump($_POST['frais_scanner']);
    // var_dump($_POST['code_gratuite']);
    // var_dump($_POST['cod_free']);
    // die();

    // Exécution de la requête de validation du scanner gratos
    if (isset($_POST['code_gratuite']) && $_POST['code_gratuite'] != "" && $_POST['frais_scanner'] == 0) {

        // Si la valeur du code gratuit a été renseignée
        // On vérifie que le code de gratuité correspond au mot de passe de l'un des administrateurs
        $resultCheckAdminPwd = $wms->checkAdminPwd($link, $_POST['code_gratuite']);

        // Si c'est le cas, on valide directement le scanner gratuit du véhicule
        if (!empty($resultCheckAdminPwd)) {

            $query = "UPDATE tbl_vehicule_scanning
            SET validation_recu_scanning=1
            WHERE id='" . $vehicule_scanning_id . "'";

            // var_dump($query);
            // die();
            
            $result = mysql_query($query, $link);
        }
    }

    // var_dump($query);
    // die();

    // Lors de l'enregistrement du scanner, le service client doit préciser si le véhicule
    // est venu remorqué ou conduit
    $queryElec = "UPDATE tbl_recep_vehi_repar 
        SET etat_vehi_arrive_scanning= '" . (int) $_POST['etat_vehi_arrive'] . "'
		WHERE car_id='" . (int) $_POST['reception_id'] . "'";

    // var_dump($_POST['reception_id']);
    // var_dump($queryElec);
    // die();

    // Exécution de la requête
    mysql_query($queryElec, $link);

    // Après l'enregistrement du scanner d'un véhicule, envoyer un SMS aux DG et DGA

    $resultDGinfos = $wms->getDGInfos($link);

    if ($_POST['scanner_electrique'] == "OUI" && $_POST['scanner_mecanique'] == "") {
        $content_msg = "Un nouveau véhicule " . $make_name_str . " " . $model_name_str . " " . $_POST['immat'] . " vient d'être enregistré pour un scanner électrique";
    }

    if ($_POST['scanner_electrique'] == "" && $_POST['scanner_mecanique'] == "OUI") {
        $content_msg = "Un nouveau véhicule " . $make_name_str . " " . $model_name_str . " " . $_POST['immat'] . " vient d'être enregistré pour un scanner mécanique";
    }

    if ($_POST['scanner_electrique'] == "OUI" && $_POST['scanner_mecanique'] == "OUI") {
        $content_msg = "Un nouveau véhicule " . $make_name_str . " " . $model_name_str . " " . $_POST['immat'] . " vient d'être enregistré pour les scanners électriques et mécaniques";
    }

    foreach ($resultDGinfos as $DGinfos) {

        // Exécution de la méthode d'envoi 
        $resultSmsSent = $smsApi->isSmsapi($DGinfos['usr_tel'], $content_msg);
    }

    // Après l'enregistrement du scanner d'un véhicule, envoyer un SMS au caissier / comptable

    $resultComptainfos = $wms->getComptaInfos($link);

    foreach ($resultComptainfos as $comptaInfos) {

        // Exécution de la méthode d'envoi 
        $resultSmsSent = $smsApi->isSmsapi($comptaInfos['usr_tel'], $content_msg);
    }

    // Redirection vers la liste des devis
    // $url = WEB_URL . "repaircar/vehicule_scanning_list.php?m=add";
    // echo "<script type='text/javascript'> document.location.href='" . WEB_URL . "compta_panel/recu_paiement_scanner.php?nbr_aleatoire=" . $nbr_aleatoire . "'</script>";

    $url = WEB_URL . "servcli_panel/servcli_dashboard.php";
    header("Location: $url");
}
