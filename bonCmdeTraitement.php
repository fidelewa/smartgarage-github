<?php
include_once('config.php');
include_once('helper/common.php');
$wms = new wms_core();

// Récupération de l'email de l'administrateur
$result_settings = $wms->getWebsiteSettingsInformation($link);
if (!empty($result_settings)) {
    // $admin_email = $result_settings['email'];
    $admin_email = "aw.fidele@e-mitic.com";
}

// initialisation des variables
$vehi_diag_id = $_GET['vehi_diag_id'];
$devis_id = $_GET['devis_id'];
$nom_client = $_GET['nom_client'];

$date_boncmde = date('d/m/Y');

// Création et persistance du bon de commande en BDD
$bcmd_query_insert = "INSERT INTO tbl_add_boncmde (devis_id, date_boncmde) VALUES ('$devis_id', '$date_boncmde')";
mysql_query($bcmd_query_insert, $link);

// Un bon de commande concerne un et un seul devis
$row = $wms->getBonCmdeByDevisId($link, $devis_id);

// Si un bon de commande correspond au devis courant
if (!empty($row)) {

    // $mech_email = $row['m_email'];
    $mech_email = "aw.fidele@e-mitic.com";
    
    // Lien d'apercu du bon de commande à envoyer par e-mail
    // $url_boncmde = '<a href=' . WEB_URL . 'confirmDevis.php?confirm_devis=1&vehi_diag_id=' . $vehi_diag_id . '&devis_id=' . $devis_id . '>cliquer sur ce lien</a>';

    // Objet de l'email
    $title = "Nouveau bon de commande ajouté";
    
    // Message de création du bon de commande
    $content_msg = 'Le client ' . $nom_client . ' a confirm&eacute; le devis n&deg;' . $devis_id . ', en cr&eacute;ant le bon de commande n&deg;' . $row['boncmde_id'];

    // Envoi du message de création du bon de commande du client par e-mail à l'administration
    $result = $wms->sendAdminBoncmdeEmail($link, $admin_email, $title, $content_msg);

    // Envoi du message de création du bon de commande du client par e-mail au mécanicien
    $result = $wms->sendMechBoncmdeEmail($link, $mech_email, $title, $content_msg);

    // Initialisation du statut de la réparation
    $statut_reparation = "En cours";

    // Lorsque le bon de commande est créé, la réparation démarre
    $query = "UPDATE tbl_add_devis SET statut_reparation='" . $statut_reparation . "' WHERE devis_id='" . (int)$devis_id . "'";

    // Exécution de la requête
    $result = mysql_query($query, $link);

    // Vérification du résultat de la requête et affichage d'un message en cas d'erreur
    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }

    // Redirection vers la page de confirmation de l'envoi du courrier de création du non de commande
    $url = WEB_URL . 'confirmBoncmdeEmailSent.php';
    header("Location: $url");
} else { // Sinon on fait une redirection vers le tableau de bord
    $url = WEB_URL . 'cust_panel/cust_dashboard.php';
    header("Location: $url");
}
