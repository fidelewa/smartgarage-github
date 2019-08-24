<?php
include('../helper/common.php');
include_once('../config.php');

// var_dump($_POST);
// die();

$_POST['remarque_mecano_repar'] = mysql_real_escape_string(trim($_POST['remarque_mecano_repar']));

$mecano = $_POST['mecano'];

// On linéarise la liste des mécaniciens qui doivent travailler sur le véhicule
$mecano_data = json_encode($mecano, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

if ($_POST['chef_mech_elec_type'] == "chef mecanicien") {

    $query = "UPDATE tbl_recep_vehi_repar 
        SET mecano_action_reparation = null,
        electro_action_reparation = 0,
        statut_reparation_mecanique= 0,
        mecano_data= '" . $mecano_data . "'
        WHERE car_id='" . (int) $_POST['reception_id'] . "'";

    $result = mysql_query($query, $link);

    // var_dump($query);
    // var_dump($result);
    // die();
}

if ($_POST['chef_mech_elec_type'] == "chef electricien") {

    $query = "UPDATE tbl_recep_vehi_repar 
        SET electro_action_reparation = null,
        mecano_action_reparation = 0,
        statut_reparation_electrique= 0,
        mecano_data= '" . $mecano_data . "'
        WHERE car_id='" . (int) $_POST['reception_id'] . "'";

    $result = mysql_query($query, $link);
}


/***********************************************
 * Envoi du SMS à l'administrateur gestionnaire
 ***********************************************/

require_once(ROOT_PATH . '/SmsApi.php');

// instanciation de la classe de l'API SMS
$smsApi = new SmsApi();

$admin_ges_tel = $_POST['admin_ges_tel'];
// $admin_ges_tel  = "02280768";

// var_dump($mecano);
// die();

foreach ($mecano as $mrow) {

    if ($_POST['chef_mech_elec_type'] == "chef mecanicien") {
        // Message d'alerte
        $content_msg = 'Le mécanicien' . $mrow['nom_mecano'] . ', est entrain de travailler sur le véhicule ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'];
    }

    if ($_POST['chef_mech_elec_type'] == "chef mecanicien") {
        // Message d'alerte
        $content_msg = 'l\'électricien' . $mrow['nom_mecano'] . ', est entrain de travailler sur le véhicule ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'];
    }



    // Exécution de la méthode d'envoi 
    $resultSmsSent = $smsApi->isSmsapi($admin_ges_tel, $content_msg);
}

/***********************************************
 * Envoi du SMS au receptionniste
 ***********************************************/

$recep_tel = $_POST['recep_tel'];
// $recep_tel  = "02280768";

foreach ($mecano as $mrow) {

    if ($_POST['chef_mech_elec_type'] == "chef mecanicien") {
        // Message d'alerte
        $content_msg = 'Le mécanicien' . $mrow['nom_mecano'] . ', est entrain de travailler sur le véhicule ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'];
    }

    if ($_POST['chef_mech_elec_type'] == "chef mecanicien") {
        // Message d'alerte
        $content_msg = 'l\'électricien' . $mrow['nom_mecano'] . ', est entrain de travailler sur le véhicule ' . $_POST['make_name'] . ' ' . $_POST['model_name'] . ' ' . $_POST['VIN'];
    }

    // Exécution de la méthode d'envoi 
    $resultSmsSent = $smsApi->isSmsapi($recep_tel, $content_msg);
}

// On redirige vers le tableau de bord
// header("Location: " . WEB_URL . "mech_panel/mech_dashboard.php");
echo "<script type='text/javascript'> document.location.href='" . WEB_URL . "mech_panel/mech_dashboard.php'</script>";
