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

    // On va vérifier si la voiture en question à déja été attribuée au mécanicien courant
    // à la date courante
    $rslt = $wms->getInfoAttriMechBydate($link, $_POST['mecanicienList'], $_POST['car_id'], $date_attr);

    if (empty($rslt)) { // Si non, on fait l'insertion

        // Enregistrement de l'identifiant du mécanicien à qui à été attribué la fiche de réception du véhicule
        $query = "UPDATE tbl_recep_vehi_repar 
        SET attribution_mecanicien='" . $_POST['mecanicienList'] . "',
        status_attribution_vehicule=1
        WHERE car_id='" . $_POST['reception_id'] . "'";

        // Enregistrement de l'historique des attributions des véhicules aux mécaniciens
        $query_insert_attrib = "INSERT INTO tbl_histo_attribution (meca_elec_id, car_id, date_attr) 
        VALUES ('$_POST[mecanicienList]','$_POST[car_id]','$date_attr')";

        // On teste le résultat de la requête pour savoir si elle n'a pas déclenché des erreurs
        $result_insert_attrib = mysql_query($query_insert_attrib, $link);

        if (!$result_insert_attrib) {
            $message_insert_attrib  = 'Invalid query: ' . mysql_error() . "\n";
            $message_insert_attrib .= 'Whole query: ' . $query_insert_attrib;
            die($message_insert_attrib);
        }

        // On teste le résultat de la requête pour savoir si elle n'a pas déclenché des erreurs
        $result = mysql_query($query, $link);

        if (!$result) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $query;
            die($message);
        }

        // Récupération des données du mécanicien
        $row = $wms->getMechanicsInfoByMechanicsId($link, $_POST['mecanicienList']);

        // Récupération des données de la voiture
        $voiture = $wms->getMarkModelListByImmaVehi($link, $_POST['imma_vehi']);

        // var_dump($voiture);
        // die();

        // importation du fichier de l'API SMS
        require_once(ROOT_PATH . '/SmsApi.php');

        // instanciation de la classe de l'API SMS
        $smsApi = new SmsApi();

        $mobile_mech = $row['usr_email'];
        // $mobile_mech  = "02280768";

        // Message d'alerte
        $content_msg = $row['usr_name'] . ', vous avez la charge de faire le diagnostic de la voiture ' . $voiture['make_name'] . ' ' . $voiture['model_name'] . ' ' . $voiture['VIN'];
        // $content_msg = "Le véhicule d'identifiant " . $_POST['car_id'] . "vous a été attribué pour effectuer un diagnostic";

        // Exécution de la méthode d'envoi 
        $resultSmsSent = $smsApi->isSmsapi($mobile_mech, $content_msg);

        // On fait une redirection si le sms a été envoyé avec succès
        if ($resultSmsSent) {
            // Faire une rédirection vers la liste des véhicules réceptionnés avec un paramètre d'attribution
            header("Location: " . WEB_URL . "reception/repaircar_reception_list.php?m=attribution&car_id=" . $_POST['car_id'] . "&mecanicien_id=" . $_POST['mecanicienList'] . "&marque=" . $voiture['make_name'] . "&modele=" . $voiture['model_name'] . "&imma=" . $voiture['VIN'] . "&mech_name=" . $row['usr_name']);
        } else {
            echo "L'envoi du SMS a échoué !";
        }
    } else { // Si oui, on ne fait pas d'insertionmais plutôt une redirection (javascript)
        // header("Location: " . WEB_URL . "reception/repaircar_reception_list.php?m=attribution_done&car_id=" . $_POST['car_id'] . "&mecanicien_id=" . $_POST['mecanicienList'] . "&marque=" . $voiture['make_name'] . "&modele=" . $voiture['model_name'] . "&imma=" . $voiture['VIN'] . "&mech_name=" . $row['usr_name'] . "&date_attrib=" . $date_attr);
        // Récupération des données du mécanicien
        $row = $wms->getMechanicsInfoByMechanicsId($link, $_POST['mecanicienList']);

        // Récupération des données de la voiture
        $voiture = $wms->getMarkModelListByImmaVehi($link, $_POST['imma_vehi']);
        
        echo "<script type='text/javascript'> document.location.href='". WEB_URL ."reception/repaircar_reception_list.php?m=attribution_done&car_id=". $_POST['car_id'] ."&mecanicien_id=". $_POST['mecanicienList'] ."&marque=". $voiture['make_name'] ."&modele=". $voiture['model_name'] ."&imma=". $voiture['VIN'] ."&mech_name=". $row['usr_name'] ."&date_attrib=". $date_attr ."'</script>";
    }
}
