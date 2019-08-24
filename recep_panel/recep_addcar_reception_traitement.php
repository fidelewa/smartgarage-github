<?php

include_once('header.php');

// var_dump($_POST);
// die();

if (isset($_POST['car_names'])) {

    // TRAITEMENT DES PIECES JOINTES

    // Récupération des URL des pièces jointes
    if (isset($_FILES["pj_1"]) && !empty($_FILES["pj_1"])) {
        $_POST['pj1_url'] = uploadPJ_1();
    }
    if (isset($_FILES["pj_2"]) && !empty($_FILES["pj_2"])) {
        $_POST['pj2_url'] = uploadPJ_2();
    }
    if (isset($_FILES["pj_3"]) && !empty($_FILES["pj_3"])) {
        $_POST['pj3_url'] = uploadPJ_3();
    }
    if (isset($_FILES["pj_4"]) && !empty($_FILES["pj_4"])) {
        $_POST['pj4_url'] = uploadPJ_4();
    }
    if (isset($_FILES["pj_5"]) && !empty($_FILES["pj_5"])) {
        $_POST['pj5_url'] = uploadPJ_5();
    }
    if (isset($_FILES["pj_6"]) && !empty($_FILES["pj_6"])) {
        $_POST['pj6_url'] = uploadPJ_6();
    }
    if (isset($_FILES["pj_7"]) && !empty($_FILES["pj_7"])) {
        $_POST['pj7_url'] = uploadPJ_7();
    }
    if (isset($_FILES["pj_8"]) && !empty($_FILES["pj_8"])) {
        $_POST['pj8_url'] = uploadPJ_8();
    }
    if (isset($_FILES["pj_9"]) && !empty($_FILES["pj_9"])) {
        $_POST['pj9_url'] = uploadPJ_9();
    }
    if (isset($_FILES["pj_10"]) && !empty($_FILES["pj_10"])) {
        $_POST['pj10_url'] = uploadPJ_10();
    }
    if (isset($_FILES["pj_11"]) && !empty($_FILES["pj_11"])) {
        $_POST['pj11_url'] = uploadPJ_11();
    }
    if (isset($_FILES["pj_12"]) && !empty($_FILES["pj_12"])) {
        $_POST['pj12_url'] = uploadPJ_12();
    }

    $image_url = uploadImage();
    if (empty($image_url)) {
        $image_url = $_POST['img_exist'];
    }

    // var_dump($_POST);
    // die();

    // Initialisation des variables

    // ETAPE 1
    $marque_name_form = $_POST['ddlMake'];
    $modele_name_form = $_POST['ddlModel'];
    $client_name_form = $_POST['ddlCustomerList'];
    $assurance_form = $_POST['assurance_vehi_recep'];
    $make_id = null;
    $modele_id = null;
    $client_id = null;
    $modeleMakeId  = null;
    $listeMarques = array();
    $listeModeles = array();
    $listeClient = array();
    $listeAssurance = array();
    $cptOccur = 0;

    // Marque
    // On converti la chaine de caractère de la marque en array et on récupère le premier caractère de cette valeur
    $arr_marque_name_form = str_split($marque_name_form);
    $arr_marque_name_form_str = $arr_marque_name_form[0];

    // Client
    // On converti la chaine de caractère de la marque en array et on récupère le premier caractère de cette valeur
    $arr_client_name_form = str_split($client_name_form);
    $arr_client_name_form_str = $arr_client_name_form[0];

    // Assurance
    // On converti la chaine de caractère de la marque en array et on récupère le premier caractère de cette valeur
    $arr_assurance_form = str_split($assurance_form);
    $arr_assurance_form_str = $arr_assurance_form[0];

    // print($arr_client_name_form_str);
    // die();

    // ETAPE 2

    // Assurance
    $queryAssur = "SELECT * FROM tbl_assurance_vehicule WHERE assur_vehi_libelle LIKE '" . $arr_assurance_form_str . "%'";

    // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
    $resultAssur = mysql_query($queryAssur, $link);

    // if (!$resultAssur) {
    //     $message  = 'Invalid query: ' . mysql_error() . "\n";
    //     $message .= 'Whole query: ' .  $queryAssur;
    //     die($message);
    // }

    // On récupère la liste des marques commençant par le même caractère que la valeur de la marque soumise via le formulaire
    while ($row = mysql_fetch_assoc($resultAssur)) {
        $listeAssurance[] = $row;
    }

    // var_dump($assurance_form);
    // var_dump($listeAssurance);

    // S'il y a en BDD des noms d'assurances correspondant à la valeur de l'assurance fournie via le formulaire
    foreach ($listeAssurance as $assurance) {
        if ($assurance_form == $assurance['assur_vehi_libelle']) {
            $cptOccur += 1; // On incrémente un compteur d'occurence
        }
    }

    // var_dump($cptOccur);
    // die();

    // Si le compteur d'occurences est égale à 0, on fait une insertion
    if ($cptOccur == 0) {
        // Insertion du nom de la marque dans la table des marques
        $queryInsertAssur = "INSERT INTO tbl_assurance_vehicule (assur_vehi_libelle) VALUES('$assurance_form')";

        // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
        $resultInsertAssur = mysql_query($queryInsertAssur, $link);

        // if (!$resultInsertAssur) {
        //     $message  = 'Invalid query: ' . mysql_error() . "\n";
        //     $message .= 'Whole query: ' . $queryInsertAssur;
        //     die($message);
        // }
    }

    // Client
    $queryClient = "SELECT customer_id, c_name FROM tbl_add_customer WHERE c_name LIKE '" . $arr_client_name_form_str . "%'";

    // On exécute la requête
    $resultListeClient = mysql_query($queryClient, $link);

    // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
    // if (!$resultListeClient) {
    //     $message  = 'Invalid query: ' . mysql_error() . "\n";
    //     $message .= 'Whole query: ' . $queryClient;
    //     die($message);
    // }

    // On récupère la liste des marques commençant par le même caractère que la valeur de la marque soumise via le formulaire
    while ($row = mysql_fetch_assoc($resultListeClient)) {
        $listeClient[] = $row;
    }

    // var_dump($client_name_form);
    // var_dump($listeClient);
    // die();

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

    // var_dump($marque_name_form);
    // var_dump($listeMarques);
    // die();

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

    // var_dump($listeModeles);

    // ETAPE 3
    // Parcours des marques
    foreach ($listeMarques as $marque) {
        if ($marque_name_form == $marque['make_name']) {
            $make_id = $marque['make_id'];
        }
    }

    // Parcours des modèles
    foreach ($listeModeles as $modele) {
        if ($modele_name_form == $modele['model_name']) {
            $modele_id = $modele['model_id'];
        }
    }

    // Parcours des clients
    foreach ($listeClient as $client) {
        if ($client_name_form == $client['c_name']) {
            $client_id = $client['customer_id'];
        }
    }

    // var_dump($make_id);
    // var_dump($modele_id);
    // var_dump($client_id);
    // die();

    // ETAPE 4

    // CLIENT
    // Si le nom du client soumis via le formulaire correspond à un nom de client existant en BDD
    // on récupère l'id de cet client en BDD que l'on affecte à la variable $_POST['ddlCustomerList']
    if ($client_id != null) {
        (int)$_POST['ddlCustomerList'] = (int)$client_id;
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
        $modeleMakeId = (int)$rowMakeId['make_id'];
        // On rédéfini la valeur de l'identifiant de la marque qui sera persistée dans la table tbl_add_car
        $_POST['ddlMake'] = (int)$modeleMakeId;

        // var_dump($rowMakeId);
        // die();

    } else {
        // Si une marque exitant en BDD correspond à la valeur de la marque soumise via le formulaire de saisie
        //  On récupère la valeur de son id et on rédéfini la valeur de l'identifiant de la marque qui sera persistée dans la table tbl_add_car
        $modeleMakeId = (int)$make_id;
        $_POST['ddlMake'] = (int)$make_id;
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
        $_POST['ddlModel'] = (int)$rowModeleId['model_id'];

        // var_dump($rowModeleId);
        // die();

    } else {
        // Si un modèle exitant en BDD correspond à la valeur du modèle soumis via le formulaire de saisie
        //  On récupère la valeur de son id et on rédéfini la valeur de l'identifiant du modèle qui sera persistée dans la table tbl_add_car
        $modele_id = (int)$modele_id;
        $_POST['ddlModel'] = (int)$modele_id;
        // var_dump($modele_id);
        // die();
    }

    // Récupération du nom de la marque qui a pour id la valeur retourné par le component $_POST['ddlMake']
    $query = "SELECT make_name FROM tbl_make WHERE make_id='" . (int)$_POST['ddlMake'] . "'";

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

    $_POST['add_date_visitetech'] = $_POST['add_date_visitetech_car'];
    $_POST['add_date_assurance'] = $_POST['add_date_assurance_car'];

    // var_dump($_POST);
    // die();

    // On insère la nouvelle valeur de la colonne car_name en BDD
    $wms->saveUpdateRepairCarInformation($link, $_POST, $image_url);

    // var_dump($_POST);
    // die();

}

if (isset($_POST['vin'])) {
    $result_car_model = $wms->getMarkModelListByImmaVehi($link, $_POST['vin']);
    $_POST['ddlImma'] = $_POST['vin'];
    $_POST['add_car_id'] = $result_car_model['car_id'];
}

if (isset($_POST['immat'])) {
    $_POST['add_car_id'] = $_POST['car_id'];
    $_POST['ddlCustomerList'] = $_POST['customer_id'];
    $_POST['ddlMake'] = $_POST['car_make_id'];
    $_POST['ddlModel'] = $_POST['car_model_id'];
    $_POST['ddlImma'] = $_POST['immat'];
}

// var_dump($result_car_model);
// var_dump($_POST);
// die();

// Affectation des dates de l'assurance et de la visite technique du formulaire de création d'un véhicule
// aux variables $_POST des dates de l'assurance et de la visite technique du formulaire de réception d'un véhicule

// Structure de contrôle sur les clés "nullable" de la variable superglobale $_POST
if (empty($_POST['cle_recep_vehi'])) {
    $_POST['cle_recep_vehi'] = "";
}
if (empty($_POST['carte_grise_recep_vehi'])) {
    $_POST['carte_grise_recep_vehi'] = "";
}
if (empty($_POST['assur_recep_vehi'])) {
    $_POST['assur_recep_vehi'] = "";
}
if (empty($_POST['visitetech_recep_vehi'])) {
    $_POST['visitetech_recep_vehi'] = "";
}
if (empty($_POST['cric_levage_recep_vehi'])) {
    $_POST['cric_levage_recep_vehi'] = "";
}
if (empty($_POST['rallonge_roue_recep_vehi'])) {
    $_POST['rallonge_roue_recep_vehi'] = "";
}
if (empty($_POST['anneau_remorquage_recep_vehi'])) {
    $_POST['anneau_remorquage_recep_vehi'] = "";
}
if (empty($_POST['scanner_recep_vehi'])) {
    $_POST['scanner_recep_vehi'] = "";
}
if (empty($_POST['elec_recep_vehi'])) {
    $_POST['elec_recep_vehi'] = "";
}
if (empty($_POST['meca_recep_vehi'])) {
    $_POST['meca_recep_vehi'] = "";
}
if (empty($_POST['pb_meca_recep_vehi'])) {
    $_POST['pb_meca_recep_vehi'] = "";
}
if (empty($_POST['pb_electro_recep_vehi'])) {
    $_POST['pb_electro_recep_vehi'] = "";
}
if (empty($_POST['pb_demar_recep_vehi'])) {
    $_POST['pb_demar_recep_vehi'] = "";
}
if (empty($_POST['conf_cle_recep_vehi'])) {
    $_POST['conf_cle_recep_vehi'] = "";
}
if (empty($_POST['sup_adblue_recep_vehi'])) {
    $_POST['sup_adblue_recep_vehi'] = "";
}
if (empty($_POST['sup_fil_parti_recep_vehi'])) {
    $_POST['sup_fil_parti_recep_vehi'] = "";
}
if (empty($_POST['sup_vanne_egr_recep_vehi'])) {
    $_POST['sup_vanne_egr_recep_vehi'] = "";
}
if (empty($_POST['voy_alum_recep_vehi'])) {
    $_POST['voy_alum_recep_vehi'] = "";
}
if (empty($_POST['arriv_remarq_recep_vehi'])) {
    $_POST['arriv_remarq_recep_vehi'] = "";
}
if (empty($_POST['acc_recep_veh'])) {
    $_POST['acc_recep_veh'] = "";
}
if (empty($_POST['repare'])) {
    $_POST['repare'] = "";
}
if (empty($_POST['non_repare'])) {
    $_POST['non_repare'] = "";
}
if (empty($_POST['propre_sortie'])) {
    $_POST['propre_sortie'] = "";
}
if (empty($_POST['poussiereuse_sortie'])) {
    $_POST['poussiereuse_sortie'] = "";
}
if (empty($_POST['sortie_remarq_recep_vehi'])) {
    $_POST['sortie_remarq_recep_vehi'] = "";
}
// $image_url = $_POST['img_exist'];

// Echappement des caractères spéciaux

// Remarque sur la voiture à son arrivée
if (!empty($_POST['arriv_remarq_recep_vehi_text'])) {
    $_POST['arriv_remarq_recep_vehi_text'] = mysql_real_escape_string($_POST['arriv_remarq_recep_vehi_text']);
}

// Nom du client
if (!empty($_POST['ddlCustomerList'])) {
    $_POST['ddlCustomerList'] = mysql_real_escape_string($_POST['ddlCustomerList']);
}

// Nom du véhicule
if (!empty($_POST['car_names'])) {
    $_POST['car_names'] = mysql_real_escape_string($_POST['car_names']);
}

// Clé du véhicule
if (!empty($_POST['cle_recep_vehi_text'])) {
    $_POST['cle_recep_vehi_text'] = mysql_real_escape_string($_POST['cle_recep_vehi_text']);
}

// Travaux à effectuer
if (!empty($_POST['travo_effec'])) {
    $_POST['travo_effec'] = mysql_real_escape_string($_POST['travo_effec']);
}

// Autres observations
if (!empty($_POST['autres_obs'])) {
    $_POST['autres_obs'] = mysql_real_escape_string($_POST['autres_obs']);
}

// Remarque sur la voiture à sa sortie
if (!empty($_POST['sortie_remarq_recep_vehi_text'])) {
    $_POST['sortie_remarq_recep_vehi_text'] = mysql_real_escape_string($_POST['sortie_remarq_recep_vehi_text']);
}

// Récupération des URL des pièces jointes
if (isset($_FILES["pj_1"]) && !empty($_FILES["pj_1"])) {
    $_POST['pj1_url'] = uploadPJ_1();
}
if (isset($_FILES["pj_2"]) && !empty($_FILES["pj_2"])) {
    $_POST['pj2_url'] = uploadPJ_2();
}
if (isset($_FILES["pj_3"]) && !empty($_FILES["pj_3"])) {
    $_POST['pj3_url'] = uploadPJ_3();
}
if (isset($_FILES["pj_4"]) && !empty($_FILES["pj_4"])) {
    $_POST['pj4_url'] = uploadPJ_4();
}
if (isset($_FILES["pj_5"]) && !empty($_FILES["pj_5"])) {
    $_POST['pj5_url'] = uploadPJ_5();
}
if (isset($_FILES["pj_6"]) && !empty($_FILES["pj_6"])) {
    $_POST['pj6_url'] = uploadPJ_6();
}
if (isset($_FILES["pj_7"]) && !empty($_FILES["pj_7"])) {
    $_POST['pj7_url'] = uploadPJ_7();
}
if (isset($_FILES["pj_8"]) && !empty($_FILES["pj_8"])) {
    $_POST['pj8_url'] = uploadPJ_8();
}
if (isset($_FILES["pj_9"]) && !empty($_FILES["pj_9"])) {
    $_POST['pj9_url'] = uploadPJ_9();
}
if (isset($_FILES["pj_10"]) && !empty($_FILES["pj_10"])) {
    $_POST['pj10_url'] = uploadPJ_10();
}
if (isset($_FILES["pj_11"]) && !empty($_FILES["pj_11"])) {
    $_POST['pj11_url'] = uploadPJ_11();
}
if (isset($_FILES["pj_12"]) && !empty($_FILES["pj_12"])) {
    $_POST['pj12_url'] = uploadPJ_12();
}
if (isset($_FILES["pj_13"]) && !empty($_FILES["pj_13"])) {
    $_POST['pj13_url'] = uploadPJ_13();
}
if (isset($_FILES["pj_14"]) && !empty($_FILES["pj_14"])) {
    $_POST['pj14_url'] = uploadPJ_14();
}
if (isset($_FILES["pj_15"]) && !empty($_FILES["pj_15"])) {
    $_POST['pj15_url'] = uploadPJ_15();
}
if (isset($_FILES["pj_16"]) && !empty($_FILES["pj_16"])) {
    $_POST['pj16_url'] = uploadPJ_16();
}

// Fonction d'upload des pièces jointes
function uploadPJ_1()
{
    if ((!empty($_FILES["pj_1"])) && ($_FILES['pj_1']['error'] == 0)) {
        $filename = basename($_FILES['pj_1']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpg" && $_FILES["pj_1"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_1"]["type"] == 'image/png')
            || ($ext == "gif" && $_FILES["pj_1"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_1"]["type"] == 'application/pdf') || ($ext == "docx")
        ) {
            $temp = explode(".", $_FILES["pj_1"]["name"]);
            $newfilename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["pj_1"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
            return $newfilename;
        } else {
            return '';
        }
    }
    return '';
}

function uploadPJ_2()
{
    if ((!empty($_FILES["pj_2"])) && ($_FILES['pj_2']['error'] == 0)) {
        $filename = basename($_FILES['pj_2']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpg" && $_FILES["pj_2"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_2"]["type"] == 'image/png')
            || ($ext == "gif" && $_FILES["pj_2"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_2"]["type"] == 'application/pdf') || ($ext == "docx")
        ) {
            $temp = explode(".", $_FILES["pj_2"]["name"]);
            $newfilename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["pj_2"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
            return $newfilename;
        } else {
            return '';
        }
    }
    return '';
}

function uploadPJ_3()
{
    if ((!empty($_FILES["pj_3"])) && ($_FILES['pj_3']['error'] == 0)) {
        $filename = basename($_FILES['pj_3']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpg" && $_FILES["pj_3"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_3"]["type"] == 'image/png')
            || ($ext == "gif" && $_FILES["pj_3"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_3"]["type"] == 'application/pdf') || ($ext == "docx")
        ) {
            $temp = explode(".", $_FILES["pj_3"]["name"]);
            $newfilename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["pj_3"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
            return $newfilename;
        } else {
            return '';
        }
    }
    return '';
}

function uploadPJ_4()
{
    if ((!empty($_FILES["pj_4"])) && ($_FILES['pj_4']['error'] == 0)) {
        $filename = basename($_FILES['pj_4']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpg" && $_FILES["pj_4"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_4"]["type"] == 'image/png')
            || ($ext == "gif" && $_FILES["pj_4"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_4"]["type"] == 'application/pdf') || ($ext == "docx")
        ) {
            $temp = explode(".", $_FILES["pj_4"]["name"]);
            $newfilename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["pj_4"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
            return $newfilename;
        } else {
            return '';
        }
    }
    return '';
}

function uploadPJ_5()
{
    if ((!empty($_FILES["pj_5"])) && ($_FILES['pj_5']['error'] == 0)) {
        $filename = basename($_FILES['pj_5']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpg" && $_FILES["pj_5"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_5"]["type"] == 'image/png')
            || ($ext == "gif" && $_FILES["pj_5"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_5"]["type"] == 'application/pdf') || ($ext == "docx")
        ) {
            $temp = explode(".", $_FILES["pj_5"]["name"]);
            $newfilename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["pj_5"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
            return $newfilename;
        } else {
            return '';
        }
    }
    return '';
}

function uploadPJ_6()
{
    if ((!empty($_FILES["pj_6"])) && ($_FILES['pj_6']['error'] == 0)) {
        $filename = basename($_FILES['pj_6']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpg" && $_FILES["pj_6"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_6"]["type"] == 'image/png')
            || ($ext == "gif" && $_FILES["pj_6"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_6"]["type"] == 'application/pdf') || ($ext == "docx")
        ) {
            $temp = explode(".", $_FILES["pj_6"]["name"]);
            $newfilename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["pj_6"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
            return $newfilename;
        } else {
            return '';
        }
    }
    return '';
}

function uploadPJ_7()
{
    if ((!empty($_FILES["pj_7"])) && ($_FILES['pj_7']['error'] == 0)) {
        $filename = basename($_FILES['pj_7']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpg" && $_FILES["pj_7"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_7"]["type"] == 'image/png')
            || ($ext == "gif" && $_FILES["pj_7"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_7"]["type"] == 'application/pdf') || ($ext == "docx")
        ) {
            $temp = explode(".", $_FILES["pj_7"]["name"]);
            $newfilename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["pj_7"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
            return $newfilename;
        } else {
            return '';
        }
    }
    return '';
}

function uploadPJ_8()
{
    if ((!empty($_FILES["pj_8"])) && ($_FILES['pj_8']['error'] == 0)) {
        $filename = basename($_FILES['pj_8']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpg" && $_FILES["pj_8"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_8"]["type"] == 'image/png')
            || ($ext == "gif" && $_FILES["pj_8"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_8"]["type"] == 'application/pdf') || ($ext == "docx")
        ) {
            $temp = explode(".", $_FILES["pj_8"]["name"]);
            $newfilename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["pj_8"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
            return $newfilename;
        } else {
            return '';
        }
    }
    return '';
}

function uploadPJ_9()
{
    if ((!empty($_FILES["pj_9"])) && ($_FILES['pj_9']['error'] == 0)) {
        $filename = basename($_FILES['pj_9']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpg" && $_FILES["pj_9"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_9"]["type"] == 'image/png')
            || ($ext == "gif" && $_FILES["pj_9"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_9"]["type"] == 'application/pdf') || ($ext == "docx")
        ) {
            $temp = explode(".", $_FILES["pj_9"]["name"]);
            $newfilename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["pj_9"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
            return $newfilename;
        } else {
            return '';
        }
    }
    return '';
}

function uploadPJ_10()
{
    if ((!empty($_FILES["pj_10"])) && ($_FILES['pj_10']['error'] == 0)) {
        $filename = basename($_FILES['pj_10']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpg" && $_FILES["pj_10"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_10"]["type"] == 'image/png')
            || ($ext == "gif" && $_FILES["pj_10"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_10"]["type"] == 'application/pdf') || ($ext == "docx")
        ) {
            $temp = explode(".", $_FILES["pj_10"]["name"]);
            $newfilename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["pj_10"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
            return $newfilename;
        } else {
            return '';
        }
    }
    return '';
}

function uploadPJ_11()
{
    if ((!empty($_FILES["pj_11"])) && ($_FILES['pj_11']['error'] == 0)) {
        $filename = basename($_FILES['pj_11']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpg" && $_FILES["pj_11"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_11"]["type"] == 'image/png')
            || ($ext == "gif" && $_FILES["pj_11"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_11"]["type"] == 'application/pdf') || ($ext == "docx")
        ) {
            $temp = explode(".", $_FILES["pj_11"]["name"]);
            $newfilename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["pj_11"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
            return $newfilename;
        } else {
            return '';
        }
    }
    return '';
}

function uploadPJ_12()
{
    if ((!empty($_FILES["pj_12"])) && ($_FILES['pj_12']['error'] == 0)) {
        $filename = basename($_FILES['pj_12']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpg" && $_FILES["pj_12"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_12"]["type"] == 'image/png')
            || ($ext == "gif" && $_FILES["pj_12"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_12"]["type"] == 'application/pdf') || ($ext == "docx")
        ) {
            $temp = explode(".", $_FILES["pj_12"]["name"]);
            $newfilename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["pj_12"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
            return $newfilename;
        } else {
            return '';
        }
    }
    return '';
}

function uploadPJ_13()
{
    if ((!empty($_FILES["pj_13"])) && ($_FILES['pj_13']['error'] == 0)) {
        $filename = basename($_FILES['pj_13']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpg" && $_FILES["pj_13"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_13"]["type"] == 'image/png')
            || ($ext == "gif" && $_FILES["pj_13"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_13"]["type"] == 'application/pdf') || ($ext == "docx")
        ) {
            $temp = explode(".", $_FILES["pj_13"]["name"]);
            $newfilename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["pj_13"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
            return $newfilename;
        } else {
            return '';
        }
    }
    return '';
}

function uploadPJ_14()
{
    if ((!empty($_FILES["pj_14"])) && ($_FILES['pj_14']['error'] == 0)) {
        $filename = basename($_FILES['pj_14']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpg" && $_FILES["pj_14"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_14"]["type"] == 'image/png')
            || ($ext == "gif" && $_FILES["pj_14"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_14"]["type"] == 'application/pdf') || ($ext == "docx")
        ) {
            $temp = explode(".", $_FILES["pj_14"]["name"]);
            $newfilename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["pj_14"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
            return $newfilename;
        } else {
            return '';
        }
    }
    return '';
}

function uploadPJ_15()
{
    if ((!empty($_FILES["pj_15"])) && ($_FILES['pj_15']['error'] == 0)) {
        $filename = basename($_FILES['pj_15']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpg" && $_FILES["pj_15"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_15"]["type"] == 'image/png')
            || ($ext == "gif" && $_FILES["pj_15"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_15"]["type"] == 'application/pdf') || ($ext == "docx")
        ) {
            $temp = explode(".", $_FILES["pj_15"]["name"]);
            $newfilename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["pj_15"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
            return $newfilename;
        } else {
            return '';
        }
    }
    return '';
}

function uploadPJ_16()
{
    if ((!empty($_FILES["pj_16"])) && ($_FILES['pj_16']['error'] == 0)) {
        $filename = basename($_FILES['pj_16']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpg" && $_FILES["pj_16"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_16"]["type"] == 'image/png')
            || ($ext == "gif" && $_FILES["pj_16"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_16"]["type"] == 'application/pdf') || ($ext == "docx")
        ) {
            $temp = explode(".", $_FILES["pj_16"]["name"]);
            $newfilename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["pj_16"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
            return $newfilename;
        } else {
            return '';
        }
    }
    return '';
}

// Traitement sur l'upload de l'image

function NewGuid()
{
    $s = strtoupper(md5(uniqid(rand(), true)));
    $guidText =
        substr($s, 0, 8) . '-' .
        substr($s, 8, 4) . '-' .
        substr($s, 12, 4) . '-' .
        substr($s, 16, 4) . '-' .
        substr($s, 20);
    return $guidText;
}

//for image upload
function uploadImage()
{
    if ((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)) {
        $filename = basename($_FILES['uploaded_file']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpg" && $_FILES["uploaded_file"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["uploaded_file"]["type"] == 'image/png') || ($ext == "gif" && $_FILES["uploaded_file"]["type"] == 'image/gif')) {
            $temp = explode(".", $_FILES["uploaded_file"]["name"]);
            $newfilename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], ROOT_PATH . '/img/upload/' . $newfilename);
            return $newfilename;
        } else {
            return '';
        }
    }
    return '';
}

$image_url = uploadImage();
if (empty($image_url)) {
    $image_url = $_POST['img_exist'];
}

$_POST['recep_id'] = (int)$_POST['recep_id'];
// var_dump($_POST);
// die();

// Exécution de la réquête et redirection vers la liste des voitures à faire réparer
$wms->saveRecepRepairCarInformation($link, $_POST, $image_url);
if ((int)$_POST['repair_car'] > 0) {
    $url = WEB_URL . 'recep_panel/recep_repaircar_reception_list.php?m=up';
    header("Location: $url");
} else {

    $url = WEB_URL . 'recep_panel/recep_repaircar_reception_list.php?m=add';
    header("Location: $url");
}
