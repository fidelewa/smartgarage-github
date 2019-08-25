<?php
include("../config.php");
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

    // var_dump($_SERVER['HTTP_X_REQUESTED_WITH']);

    $html = '';

    $keyword = strval($_POST["client"]);
    $query = "SELECT * FROM tbl_add_customer where c_name LIKE '%" . $keyword . "%'";
    $result = mysql_query($query, $link);

    if (!mysql_num_rows($result) >= 1)
    $html =  "<span style='color:#cc0000'><b>Aucun client ne possède ce nom, veuillez saisir le nom d'un client déjà enregistré ou créer un nouveau client SVP !!!</b></span>";
        
    header('Content-Type: text/html');
    echo $html;
    die();
} else {
    $url = WEB_URL . 'index.php';
    header("Location: $url");
    die();
}
