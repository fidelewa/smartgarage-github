<?php
include("../config.php");
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

    // var_dump($_SERVER['HTTP_X_REQUESTED_WITH']);

    $html = '';
    $result = mysql_query("SELECT VIN FROM tbl_add_car WHERE VIN='" . $_POST["imma"] . "'", $link);

    if (mysql_num_rows($result) >= 1)
        $html = "<span style='color:#1A7917'><b>Cette immatriculation correspond à un véhicule</b></span>";
    else
        $html =  "<span style='color:#cc0000'><b>Aucun véhicule ne possède cette immatriculation, veuillez enregistrer un nouveau véhicule en cliquant sur le bouton d'ajout '+'</b></span>";

    header('Content-Type: text/html');
    echo $html;
    die();
} else {
    $url = WEB_URL . 'index.php';
    header("Location: $url");
    die();
}
