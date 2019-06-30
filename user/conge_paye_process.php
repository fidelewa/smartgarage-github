<?php

// On récupère le lien de connexion à la BDD
include("../config.php");
// On récupère la classe wms_core
include("../helper/common.php");

// On instancie le constructeur implicite de la classe wms_core
$wms = new wms_core();

// var_dump($_POST);
// die();

if (isset($_POST) && !empty($_POST)) {

    $result = $wms->updateCongePayeEmplo($link, $_POST);

    $url = WEB_URL . "user/salpersolist.php?m=nb_jour_conge_paye";
    header("Location: $url");
}
