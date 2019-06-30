<?php
include("../config.php");
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

    // var_dump($_SERVER['HTTP_X_REQUESTED_WITH']);

    $html = '';
    $result = mysql_query("SELECT * FROM tbl_add_customer WHERE princ_tel='" . $_POST["telcli"] . "'", $link);

    $row = mysql_fetch_assoc($result);

    // var_dump($row);

    if (mysql_num_rows($result) >= 1)
        $html = "<span style='color:#cc0000'>Ce numéro de téléphone appartient déjà à <b>" . $row["c_name"] . "</b></span>";
    else
        $html =  "<span style='color:#1A7917'><b> Ce numéro de téléphone est libre</b></span>";

    header('Content-Type: text/html');
    echo $html;
    die();
} else {
    $url = WEB_URL . 'dashboard.php';
    header("Location: $url");
    die();
}
