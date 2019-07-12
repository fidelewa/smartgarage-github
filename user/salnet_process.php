<?php

include("../config.php");
include("../helper/common.php");

$wms = new wms_core();

if (isset($_POST) && !empty($_POST)) {
    $wms->saveSalnetPerso($link, $_POST['montant_salnet'], $_POST['salnet_pers_id'], $_POST['salnet_pers_telephone']);

    // Faire une rédirection vers la liste des véhicules réceptionnés avec un paramètre d'attribution
    $url = WEB_URL . "user/salpersolist.php?m=salnet_perso";

    header("Location: " . $url);
}
