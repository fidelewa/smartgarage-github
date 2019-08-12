
<?php

include('../config.php');
include("../helper/common.php");

$wms = new wms_core();

// var_dump($_POST);
// die();

if ($_POST['scanner_electrique'] == null && $_POST['scanner_mecanique'] == null) {
    $url = WEB_URL . "repaircar/vehicule_scanning_list.php?m=scanner_error";
    header("Location: $url");
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
    if (!$resultListeMarques) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $queryMarque;
        die($message);
    }

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
    if (!$resultListeModeles) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $queryModele;
        die($message);
    }

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

        if (!$resultInsertMake) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $queryInsertMake;
            die($message);
        }

        // Récupération de l'id de la nouvelle marque pour faire l'insertion du modèle en BDD
        $queryGetMakeId = "SELECT make_id FROM tbl_make WHERE make_name='" . $marque_name_form . "'";

        // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
        $resultMakeId = mysql_query($queryGetMakeId, $link);

        if (!$resultMakeId) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $queryGetMakeId;
            die($message);
        }

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

        if (!$resultInsertModel) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $queryInsertModel;
            die($message);
        }

        // Récupération de l'id du nouveau modèle de voiture ajouté
        $queryGetModeleId = "SELECT model_id FROM tbl_model WHERE model_name='" . $modele_name_form . "'";

        // On exécute la requête
        $resultModeleId = mysql_query($queryGetModeleId, $link);

        // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
        if (!$resultModeleId) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $queryGetModeleId;
            die($message);
        }

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

    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }

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

    if (!$resultListeCar) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }

    // On retourne le nom de la marque dans un tableau associatif
    $rowCar = mysql_fetch_array($resultListeCar);

    // Si la voiture n'est pas encore enregistrée en BDD
    // On l'enregistre
    if (empty($rowCar)) {

        // Insertion dans la table des véhicules
        $wms->saveRepairCarScanningInfo($link, $_POST, $image_url);
    }

    // Insertion dans la table des véhicules à scanner

    $frais_scanner = (float) $_POST['frais_scanner'];

    // $nbr_aleatoire = rand();
    $nbr_aleatoire = substr(number_format(rand()), 0, 6);
    
    $query = "INSERT INTO tbl_vehicule_scanning (imma_vehi_client, marque_vehi_client, 
       model_vehi_client, scanner_mecanique, scanner_electrique, frais_scanner, customer_id, nbr_aleatoire
    )
    VALUES('$_POST[immat]','$make_name_str','$model_name_str','$_POST[scanner_mecanique]','$_POST[scanner_electrique]',
    '$frais_scanner','$_POST[customer_id]', $nbr_aleatoire)";

    // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
    $result = mysql_query($query, $link);

    // die('je usis ici');

    // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
    if (!$result) {
        // var_dump($data);
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }
    // Redirection vers la liste des devis
    // $url = WEB_URL . "repaircar/vehicule_scanning_list.php?m=add";
    $url = WEB_URL . "servcli_panel/recu_paiement_scanner.php?nb_aleatoire=".$nbr_aleatoire;
    header("Location: $url");
    // }

}
