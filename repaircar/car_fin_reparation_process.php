<?php
include('../helper/common.php');
include_once('../config.php');

if ($_GET['chef_mech_elec_type'] == "chef mecanicien") {

    $query = "UPDATE tbl_recep_vehi_repar
        SET statut_reparation_mecanique=1,
        mecano_action_reparation = 0,
        electro_action_reparation = null
        WHERE car_id='" . (int) $_GET['recep_car_id'] . "'";

    $result = mysql_query($query, $link);

    // var_dump($result);

    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }
}

if ($_GET['chef_mech_elec_type'] == "chef electricien") {

    $query = "UPDATE tbl_recep_vehi_repar
        SET statut_reparation_electrique=1,
        mecano_action_reparation = null,
        electro_action_reparation = 0
        WHERE car_id='" . (int) $_GET['recep_car_id'] . "'";

    $result = mysql_query($query, $link);

    // var_dump($query);
    // var_dump($result);
    // die();

    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }
}

// On redirige vers le tableau de bord
header("Location: " . WEB_URL . "mech_panel/mech_dashboard.php");
// echo "<script type='text/javascript'> document.location.href='" . WEB_URL . "cust_panel/cust_dashboard.php'</script>";