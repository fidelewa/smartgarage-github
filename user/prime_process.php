<?php

include("../config.php");
include("../helper/common.php");

$wms = new wms_core();

// var_dump($_POST);
// die();

if (isset($_POST) && !empty($_POST)) {
    $wms->savePrimePerso($link, $_POST['prime_sal'], $_POST['prime_pers_id'], $_POST['prime_pers_telephone']);

    // Faire une rédirection vers la liste des véhicules réceptionnés avec un paramètre d'attribution
    $url = WEB_URL . "user/salpersolist.php?m=prime_perso";

    header("Location: " . $url);
}
