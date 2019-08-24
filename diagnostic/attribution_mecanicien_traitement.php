<?php
include('../helper/common.php');
include_once('../config.php');

// var_dump($_POST);
// die();

// Si les identifiants du mécanicien et du véhicule existe
if (isset($_POST['mecanicienList']) && isset($_POST['car_id'])) {

    // Instanciation de la classe wms_core
    $wms = new wms_core();

    $date_attr = date("d/m/Y");

    // var_dump($_POST);
    // die();

    // $mecanicienData = explode(",", $_POST['mecanicienList']);

    // $mech_id = $mecanicienData[0];
    // $mech_type = $mecanicienData[1];

    // On va vérifier si la voiture en question à déja été attribuée au mécanicien courant
    // à la date courante
    $rslt = $wms->getInfoAttriMechBydate($link, $mech_id, $_POST['car_id'], $date_attr);

    // if (empty($rslt)) { // Si non, on fait l'insertion

    // Un même véhicule peut être attribué à la fois à un mécanicien et à un électricien

    if ($_POST['mecanicienList'] == "chef mecanicien et electricien") {

        $query = "UPDATE tbl_recep_vehi_repar 
        SET attribution_mecanicien= 'chef mecanicien',
        attribution_electricien='chef electricien',
        admin_ges_tel='" . $_POST['admin_ges_tel'] . "'
        WHERE car_id='" . $_POST['reception_id'] . "'";
    }

    if ($_POST['mecanicienList'] == "chef mecanicien") {

        $query = "UPDATE tbl_recep_vehi_repar 
        SET attribution_mecanicien='" . $_POST['mecanicienList'] . "',
        -- status_attribution_vehicule=1,
        admin_ges_tel='" . $_POST['admin_ges_tel'] . "'
        WHERE car_id='" . $_POST['reception_id'] . "'";
    }

    if ($_POST['mecanicienList'] == "chef electricien") {

        $query = "UPDATE tbl_recep_vehi_repar 
        SET attribution_electricien='" . $_POST['mecanicienList'] . "',
        -- status_attribution_vehicule=1,
        admin_ges_tel='" . $_POST['admin_ges_tel'] . "'
        WHERE car_id='" . $_POST['reception_id'] . "'";
    }

    // // Enregistrement de l'historique des attributions des véhicules aux mécaniciens
    // $query_insert_attrib = "INSERT INTO tbl_histo_attribution (meca_elec_id, car_id, date_attr) 
    //     VALUES ('$mech_id','$_POST[car_id]','$date_attr')";

    // // On teste le résultat de la requête pour savoir si elle n'a pas déclenché des erreurs
    // $result_insert_attrib = mysql_query($query_insert_attrib, $link);

    // if (!$result_insert_attrib) {
    //     $message_insert_attrib  = 'Invalid query: ' . mysql_error() . "\n";
    //     $message_insert_attrib .= 'Whole query: ' . $query_insert_attrib;
    //     die($message_insert_attrib);
    // }

    // On teste le résultat de la requête pour savoir si elle n'a pas déclenché des erreurs
    $result = mysql_query($query, $link);

    // if (!$result) {
    //     $message  = 'Invalid query: ' . mysql_error() . "\n";
    //     $message .= 'Whole query: ' . $query;
    //     die($message);
    // }

    // Récupération des données du mécanicien
    $row = $wms->getMechanicsInfoByMechanicsId($link, $_POST['mech_id']);

    // Récupération des données de la voiture
    $voiture = $wms->getMarkModelListByImmaVehi($link, $_POST['imma_vehi']);

    // Si le véhicule à été attribué à la fois aux chefs électricien et mécanicien
    if ($_POST['mecanicienList'] == "chef mecanicien et electricien") {

        // On envoi un SMS d'attribution à tous les chefs mécaniciens et électriciens
        include(ROOT_PATH . '/sendSmsToChefMechElec.php');
    }

    // Si le véhicule à été attribué soit au chef électricien ou soit au chef mécanicien
    if ($_POST['mecanicienList'] == "chef mecanicien" || $_POST['mecanicienList'] == "chef electricien") {

        // var_dump($row);
        // var_dump($voiture);
        // die();

        // On envoi un SMS d'attribution à la personne indiquée
        include(ROOT_PATH . '/sendSmsToMech.php');
    }


    // } else { // Si oui, on ne fait pas d'insertion mais plutôt une redirection (javascript)
    // header("Location: " . WEB_URL . "reception/repaircar_reception_list.php?m=attribution_done&car_id=" . $_POST['car_id'] . "&mecanicien_id=" . $_POST['mecanicienList'] . "&marque=" . $voiture['make_name'] . "&modele=" . $voiture['model_name'] . "&imma=" . $voiture['VIN'] . "&mech_name=" . $row['usr_name'] . "&date_attrib=" . $date_attr);
    // Récupération des données du mécanicien
    // $row = $wms->getMechanicsInfoByMechanicsId($link, $mech_id);

    // Récupération des données de la voiture
    // $voiture = $wms->getMarkModelListByImmaVehi($link, $_POST['imma_vehi']);

    echo "<script type='text/javascript'> document.location.href='" . WEB_URL . "reception/repaircar_reception_list.php?sms_mech_elec=" . $sms_mech_elec . "&att=attribution_done&car_id=" . $_POST['car_id'] . "&mecanicien_id=" . $_POST['mecanicienList'] . "&marque=" . $voiture['make_name'] . "&modele=" . $voiture['model_name'] . "&imma=" . $voiture['VIN'] . "&mech_name=" . $row['usr_name'] . "&date_attrib=" . $date_attr . "'</script>";
    // }
}
