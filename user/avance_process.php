<?php

include("../config.php");
include("../helper/common.php");

$wms = new wms_core();

// var_dump($_POST);
// die();

if (isset($_POST) && !empty($_POST)) {

    $avance_sal = (float) $_POST['avance_sal'];
    $salaire_base = (float) $_POST['salaire_base_pers'];

    if ($avance_sal < $salaire_base) {

        $wms->saveAvancePerso($link, $_POST['avance_sal'], $_POST['avance_pers_id'], $_POST['avance_pers_telephone']);

        // Faire une rédirection vers la liste des véhicules réceptionnés avec un paramètre d'attribution
        $url = WEB_URL . "user/salpersolist.php?m=avance_perso";
        header("Location: " . $url);
    } else { 
        // Faire une rédirection vers la liste des véhicules réceptionnés avec un paramètre d'attribution
        $url = WEB_URL . "user/salpersolist.php?m=erreur_avance_perso";
        header("Location: " . $url);
    }

    exit();
}
