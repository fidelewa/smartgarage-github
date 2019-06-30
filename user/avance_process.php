<?php

include("../config.php");
include("../helper/common.php");

$wms = new wms_core();

// var_dump($_POST);
// die();

if (isset($_POST) && !empty($_POST)) {
    $wms->saveAvancePerso($link, $_POST['avance_sal'], $_POST['avance_pers_id']);

    // Faire une rédirection vers la liste des véhicules réceptionnés avec un paramètre d'attribution
    $url = WEB_URL . "user/listepersonnel.php?m=avance_perso";
    header("Location: " . $url);
}
