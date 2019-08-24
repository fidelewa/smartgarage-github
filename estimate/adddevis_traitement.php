
<?php

include('../config.php');
include("../helper/common.php");

$wms = new wms_core();

// var_dump($_POST);
// die();

$query = "INSERT INTO tbl_attri_devis_vehicule (nom_client, numero_tel_client, imma_vehi_client, marque_vehi_client, 
   model_vehi_client, devis_simulation_id
) 
VALUES('$_POST[ddlCustomerList]','$_POST[princ_tel_client_devis]','$_POST[immat]','$_POST[ddlMake]',
'$_POST[ddlModel]','$_GET[devis_simu_id]')";

// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
$result = mysql_query($query, $link);

// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
// if ($result) {
    // Redirection vers la liste des devis
    $url = WEB_URL . "estimate/repaircar_simu_devis_list.php?m=attrib_vehi&devis_simu_id=".$_GET['devis_simu_id']."&car_make=".$_POST['ddlMake']."&car_model=".$_POST['ddlModel']."&car_imma=".$_POST['immat'];
    header("Location: $url");
// }