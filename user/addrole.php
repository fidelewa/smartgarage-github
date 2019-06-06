<?php
include('../header.php');

$title = "Gérer les droits d'accès aux menus par rôles";
$button_text = "Enregistrer information";
$successful_msg = "Ajouter un réceptionniste avec succès";
$form_url = WEB_URL . "user/addDroitAccessRoleProcess.php";

// Récupération des valeurs des variables de session définies
if (isset($_SESSION['mech_elec_droit_acces']) && !empty($_SESSION['mech_elec_droit_acces'])) {
    $mech_elec_droit_acces = $_SESSION['mech_elec_droit_acces'];
}

if (isset($_SESSION['recep_droit_acces']) && !empty($_SESSION['recep_droit_acces'])) {
    $recep_droit_acces = $_SESSION['recep_droit_acces'];
}

if (isset($_SESSION['client_droit_acces']) && !empty($_SESSION['client_droit_acces'])) {
    $client_droit_acces = $_SESSION['client_droit_acces'];
}

if (isset($_SESSION['compta_droit_acces']) && !empty($_SESSION['compta_droit_acces'])) {
    $compta_droit_acces = $_SESSION['compta_droit_acces'];
}

// Droit menu mécanicien et électricien
$resultDroitMenuMechElec = $wms->getDroitMenuMechElecInfo($link, $mech_elec_droit_acces);

// var_dump($_SESSION);
// var_dump($resultDroitMenuMechElec);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion des droits d'accès des menus par rôles</title>
    <style>
        /* Echaffaudage #2 */
        /* [class*="col-"] {
            border: 1px dotted rgb(0, 0, 0);
            border-radius: 1px;
        } */
    </style>
</head>

<body>
    <section class="content">
        <!-- Full Width boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="box-header">
                    <h1 class="box-title"> <?php echo $title; ?></h1>
                </div>
                <div class="box box-success">

                    <form action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">

                        <div class="box-body">

                            <fieldset>

                                <legend>
                                    <input type="checkbox" id="mech_elec_droit_acces" name="mech_elec_droit_acces" value="role_mecano_eletro">
                                    Mécanicien & électricien
                                </legend>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="mech_elec_all_droit_acces" name="mech_elec_all_droit_acces" value="Tout sélectionner">
                                                <label for="mech_elec_droit_all_acces">Tout sélectionner</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9" id="role_mecano_eletro_box">

                                        <?php if (empty($resultDroitMenuMechElec)) { // Si le droit du role mecano electro n'existe pas en BDD
                                            // On affiche les drois par défaut
                                            ?>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="mech_elec_droit_acces_menu_client" name="role_data['role_mecano_eletro'][droit_acces_menu_client]" value="O">
                                                    <label for="mech_elec_droit_acces_menu_client">Menu client</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="mech_elec_droit_acces_menu_recep_vehi" name="role_data['role_mecano_eletro'][droit_acces_menu_recep_vehi]" value="O">
                                                    <label for="mech_elec_droit_acces_menu_recep_vehi">Menu réception de véhicules</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="mech_elec_droit_acces_menu_vehi" name="role_data['role_mecano_eletro'][droit_acces_menu_vehi]" value="O">
                                                    <label for="mech_elec_droit_acces_menu_vehi">Menu véhicule</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="mech_elec_droit_acces_menu_devis" name="role_data['role_mecano_eletro'][droit_acces_menu_devis]" value="O">
                                                    <label for="mech_elec_droit_acces_menu_devis">Menu dévis</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="mech_elec_droit_acces_menu_facture" name="role_data['role_mecano_eletro'][droit_acces_menu_facture]" value="O">
                                                    <label for="mech_elec_droit_acces_menu_devis">Menu facture</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="mech_elec_droit_acces_menu_stock_piece" name="role_data['role_mecano_eletro'][droit_acces_menu_stock_piece]" value="O">
                                                    <label for="mech_elec_droit_acces_menu_stock_piece">Menu stock de pièces</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="mech_elec_droit_acces_menu_four" name="role_data['role_mecano_eletro'][droit_acces_menu_four]" value="O">
                                                    <label for="mech_elec_droit_acces_menu_four">Menu fournisseur</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="mech_elec_droit_acces_menu_personnel" name="role_data['role_mecano_eletro'][droit_acces_menu_personnel]" value="O">
                                                    <label for="mech_elec_droit_acces_menu_personnel">Menu personnel</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="mech_elec_droit_acces_menu_ges_user" name="role_data['role_mecano_eletro'][droit_acces_menu_ges_user]" value="O">
                                                    <label for="mech_elec_droit_acces_menu_ges_user">Menu gestion des utilisateurs</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="mech_elec_droit_acces_menu_contact" name="role_data['role_mecano_eletro'][droit_acces_menu_contact]" value="O">
                                                    <label for="mech_elec_droit_acces_menu_contact">Menu contact</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="mech_elec_droit_acces_menu_rapport" name="role_data['role_mecano_eletro'][droit_acces_menu_rapport]" value="O">
                                                    <label for="mech_elec_droit_acces_menu_rapport">Menu rapport</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="mech_elec_droit_acces_menu_setting" name="role_data['role_mecano_eletro'][droit_acces_menu_setting]" value="O">
                                                    <label for="mech_elec_droit_acces_menu_setting">Menu paramètrage</label>
                                                </div>
                                            </div>

                                        <?php } else { // Si le droit du role mecano electro existe en BDD
                                        // On récupère les données du droit en BDD

                                        if ($resultDroitMenuMechElec['menu_client'] == 'O') { ?>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="checkbox" id="mech_elec_droit_acces_menu_client" name="role_data['role_mecano_eletro'][droit_acces_menu_client]" value="O" checked>
                                                        <label for="mech_elec_droit_acces_menu_client">Menu client</label>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="checkbox" id="mech_elec_droit_acces_menu_client" name="role_data['role_mecano_eletro'][droit_acces_menu_client]" value="O">
                                                        <label for="mech_elec_droit_acces_menu_client">Menu client</label>
                                                    </div>
                                                </div>
                                            <?php }
                                        if ($resultDroitMenuMechElec['menu_recep_vehi'] == 'O') { ?>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="mech_elec_droit_acces_menu_recep_vehi" name="role_data['role_mecano_eletro'][droit_acces_menu_recep_vehi]" value="O" checked>
                                                    <label for="mech_elec_droit_acces_menu_client">Menu réception véhicule</label>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="mech_elec_droit_acces_menu_recep_vehi" name="role_data['role_mecano_eletro'][droit_acces_menu_recep_vehi]" value="O">
                                                    <label for="mech_elec_droit_acces_menu_recep_vehi">Menu réception véhicule</label>
                                                </div>
                                            </div>
                                        <?php }
                                        if ($resultDroitMenuMechElec['menu_vehi'] == 'O') { ?>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="mech_elec_droit_acces_menu_vehi" name="role_data['role_mecano_eletro'][droit_acces_menu_vehi]" value="O" checked>
                                                    <label for="mech_elec_droit_acces_menu_client">Menu réception véhicule</label>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="mech_elec_droit_acces_menu_vehi" name="role_data['role_mecano_eletro'][droit_acces_menu_vehi]" value="O">
                                                    <label for="mech_elec_droit_acces_menu_vehi">Menu réception véhicule</label>
                                                </div>
                                            </div>
                                        <?php }
                                    } ?>

                                    </div>

                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>
                                    <input type="checkbox" id="recep_droit_acces" name="recep_droit_acces" value="role_recep">
                                    Réceptionniste
                                </legend>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="recep_all_droit_acces" name="recep_all_droit_acces" value="Tout sélectionner">
                                                <label for="recep_all_droit_acces">Tout sélectionner</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="recep_droit_acces_menu_client" name="role_data['role_recep'][droit_acces_menu_client]" value="O">
                                                <label for="recep_droit_acces_menu_client">Menu client</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="recep_droit_acces_menu_recep_vehi" name="role_data['role_recep'][droit_acces_menu_recep_vehi]" value="O">
                                                <label for="recep_droit_acces_menu_recep_vehi">Menu réception de véhicules</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="recep_droit_acces_menu_vehi" name="role_data['role_recep'][droit_acces_menu_vehi]" value="O">
                                                <label for="recep_droit_acces_menu_vehi">Menu véhicule</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="recep_droit_acces_menu_devis" name="role_data['role_recep'][droit_acces_menu_devis]" value="O">
                                                <label for="recep_droit_acces_menu_devis">Menu dévis</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="recep_droit_acces_menu_facture" name="role_data['role_recep'][droit_acces_menu_facture]" value="O">
                                                <label for="recep_droit_acces_menu_devis">Menu facture</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="recep_droit_acces_menu_stock_piece" name="role_data['role_recep'][droit_acces_menu_stock_piece]" value="O">
                                                <label for="recep_droit_acces_menu_stock_piece">Menu stock de pièces</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="recep_droit_acces_menu_four" name="role_data['role_recep'][droit_acces_menu_four]" value="O">
                                                <label for="recep_droit_acces_menu_four">Menu fournisseur</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="recep_droit_acces_menu_personnel" name="role_data['role_recep'][droit_acces_menu_personnel]" value="O">
                                                <label for="recep_droit_acces_menu_personnel">Menu personnel</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="recep_droit_acces_menu_ges_user" name="role_data['role_recep'][droit_acces_menu_ges_user]" value="O">
                                                <label for="recep_droit_acces_menu_ges_user">Menu gestion des utilisateurs</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="recep_droit_acces_menu_contact" name="role_data['role_recep'][droit_acces_menu_contact]" value="O">
                                                <label for="recep_droit_acces_menu_contact">Menu contact</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="recep_droit_acces_menu_rapport" name="role_data['role_recep'][droit_acces_menu_rapport]" value="O">
                                                <label for="recep_droit_acces_menu_rapport">Menu rapport</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="recep_droit_acces_menu_setting" name="role_data['role_recep'][droit_acces_menu_setting]" value="O">
                                                <label for="recep_droit_acces_menu_setting">Menu paramètrage</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>
                                    <input type="checkbox" id="client_droit_acces" name="client_droit_acces" value="role_client">
                                    Client
                                </legend>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="client_all_droit_acces" name="client_all_droit_acces" value="Tout sélectionner">
                                                <label for="client_all_droit_acces">Tout sélectionner</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="client_droit_acces_menu_client" name="role_data['role_client'][droit_acces_menu_client]" value="O">
                                                <label for="client_droit_acces_menu_client">Menu client</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="client_droit_acces_menu_recep_vehi" name="role_data['role_client'][droit_acces_menu_recep_vehi]" value="O">
                                                <label for="client_droit_acces_menu_recep_vehi">Menu réception de véhicules</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="client_droit_acces_menu_vehi" name="role_data['role_client'][droit_acces_menu_vehi]" value="O">
                                                <label for="client_droit_acces_menu_vehi">Menu véhicule</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="client_droit_acces_menu_devis" name="role_data['role_client'][droit_acces_menu_devis]" value="O">
                                                <label for="client_droit_acces_menu_devis">Menu dévis</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="client_droit_acces_menu_facture" name="role_data['role_client'][droit_acces_menu_facture]" value="O">
                                                <label for="client_droit_acces_menu_devis">Menu facture</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="client_droit_acces_menu_stock_piece" name="role_data['role_client'][droit_acces_menu_stock_piece]" value="O">
                                                <label for="client_droit_acces_menu_stock_piece">Menu stock de pièces</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="client_droit_acces_menu_four" name="role_data['role_client'][droit_acces_menu_four]" value="O">
                                                <label for="client_droit_acces_menu_four">Menu fournisseur</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="client_droit_acces_menu_personnel" name="role_data['role_client'][droit_acces_menu_personnel]" value="O">
                                                <label for="client_droit_acces_menu_personnel">Menu personnel</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="client_droit_acces_menu_ges_user" name="role_data['role_client'][droit_acces_menu_ges_user]" value="O">
                                                <label for="client_droit_acces_menu_ges_user">Menu gestion des utilisateurs</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="client_droit_acces_menu_contact" name="role_data['role_client'][droit_acces_menu_contact]" value="O">
                                                <label for="client_droit_acces_menu_contact">Menu contact</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="client_droit_acces_menu_rapport" name="role_data['role_client'][droit_acces_menu_rapport]" value="O">
                                                <label for="client_droit_acces_menu_rapport">Menu rapport</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="client_droit_acces_menu_setting" name="role_data['role_client'][droit_acces_menu_setting]" value="O">
                                                <label for="client_droit_acces_menu_setting">Menu paramètrage</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </fieldset>
                            <fieldset>
                                <legend>
                                    <input type="checkbox" id="compta_droit_acces" name="compta_droit_acces" value="role_comptable">
                                    Comptable
                                </legend>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="compta_all_droit_acces" name="compta_all_droit_acces" value="Tout sélectionner">
                                                <label for="compta_all_droit_acces">Tout sélectionner</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="compta_droit_acces_menu_client" name="role_data['role_comptable'][droit_acces_menu_client]" value="O">
                                                <label for="compta_droit_acces_menu_client">Menu client</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="compta_droit_acces_menu_recep_vehi" name="role_data['role_comptable'][droit_acces_menu_recep_vehi]" value="O">
                                                <label for="compta_droit_acces_menu_recep_vehi">Menu réception de véhicules</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="compta_droit_acces_menu_vehi" name="role_data['role_comptable'][droit_acces_menu_vehi]" value="O">
                                                <label for="compta_droit_acces_menu_vehi">Menu véhicule</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="compta_droit_acces_menu_devis" name="role_data['role_comptable'][droit_acces_menu_devis]" value="O">
                                                <label for="compta_droit_acces_menu_devis">Menu dévis</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="compta_droit_acces_menu_facture" name="role_data['role_comptable'][droit_acces_menu_facture]" value="O">
                                                <label for="compta_droit_acces_menu_devis">Menu facture</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="compta_droit_acces_menu_stock_piece" name="role_data['role_comptable'][droit_acces_menu_stock_piece]" value="O">
                                                <label for="compta_droit_acces_menu_stock_piece">Menu stock de pièces</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="compta_droit_acces_menu_four" name="role_data['role_comptable'][droit_acces_menu_four]" value="O">
                                                <label for="compta_droit_acces_menu_four">Menu fournisseur</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="compta_droit_acces_menu_personnel" name="role_data['role_comptable'][droit_acces_menu_personnel]" value="O">
                                                <label for="compta_droit_acces_menu_personnel">Menu personnel</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="compta_droit_acces_menu_ges_user" name="role_data['role_comptable'][droit_acces_menu_ges_user]" value="O">
                                                <label for="compta_droit_acces_menu_ges_user">Menu gestion des utilisateurs</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="compta_droit_acces_menu_contact" name="role_data['role_comptable'][droit_acces_menu_contact]" value="O">
                                                <label for="compta_droit_acces_menu_contact">Menu contact</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="compta_droit_acces_menu_rapport" name="role_data['role_comptable'][droit_acces_menu_rapport]" value="O">
                                                <label for="compta_droit_acces_menu_rapport">Menu rapport</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="compta_droit_acces_menu_setting" name="role_data['role_comptable'][droit_acces_menu_setting]" value="O">
                                                <label for="compta_droit_acces_menu_setting">Menu paramètrage</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </fieldset>
                        </div>

                        <!-- <input type="hidden" value="<?php echo $hdnid; ?>" name="reception_id" /> -->
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success btnsp"><i class="fa fa-save fa-2x"></i><br />
                                <?php echo $button_text; ?></button>&emsp;
                            <a class="btn btn-warning btnsp" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/receptionnistelist.php" data-original-title="Retour"><i class="fa fa-reply  fa-2x"></i><br />
                                Retour</a> </div>
                    </form>

                </div>


                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </div>
        </div>
        <!-- /.row -->
    </section>

    <script type="text/javascript">
        // Déclaration des variables
        var y, i;
        // mecanicien et électricien
        const elt_mech_elec_all_droit_acces = document.getElementById('mech_elec_all_droit_acces');
        const elt_mech_elec_droit_acces = document.getElementById('mech_elec_droit_acces');
        // receptionniste
        const elt_recep_all_droit_acces = document.getElementById('recep_all_droit_acces');
        const elt_recep_droit_acces = document.getElementById('recep_droit_acces');
        // Client
        const elt_client_all_droit_acces = document.getElementById('client_all_droit_acces');
        const elt_client_droit_acces = document.getElementById('client_droit_acces');
        // Compable
        const elt_compta_all_droit_acces = document.getElementById('compta_all_droit_acces');
        const elt_compta_droit_acces = document.getElementById('compta_droit_acces');
        y = document.getElementsByTagName("input");

        // Au chargement du DOM
        $(document).ready(function() {

            // Tous les checkbox sont désactivés
            for (i = 0; i < y.length; i++) {

                if (y[i].type == "checkbox") {

                    if (y[i].id == "mech_elec_droit_acces") {

                        // Si c'est le cas, on le coche automatiquement
                        y[i].disabled = false;

                    } else if (y[i].id == "recep_droit_acces") {

                        // Si c'est le cas, on le coche automatiquement
                        y[i].disabled = false;

                    } else if (y[i].id == "client_droit_acces") {

                        // Si c'est le cas, on le coche automatiquement
                        y[i].disabled = false;

                    } else if (y[i].id == "compta_droit_acces") {

                        // Si c'est le cas, on le coche automatiquement
                        y[i].disabled = false;

                    } else { // Traitement des champs de type checkbox

                        y[i].disabled = true;

                    }

                }
            }

            // MECANICIEN & ELECTRICIEN
            elt_mech_elec_droit_acces.addEventListener('click', function() { // On écoute l'événement click sur cet élément

                // On vérifie que l'élément ayant cet id est bien checked
                if (elt_mech_elec_droit_acces.checked == true) {

                    // Cette boucle vérifie chaque champ input du formulaire courant
                    for (i = 0; i < y.length; i++) {

                        if (y[i].type == "checkbox") { // Traitement des champs de type checkbox


                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_all_droit_acces") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_client") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_recep_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_devis") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_facture") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_stock_piece") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_four") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_personnel") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            if (y[i].id == "mech_elec_droit_acces_menu_ges_user") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            if (y[i].id == "mech_elec_droit_acces_menu_contact") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            if (y[i].id == "mech_elec_droit_acces_menu_rapport") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            if (y[i].id == "mech_elec_droit_acces_menu_setting") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                        }
                    }

                } else {
                    // Cette boucle vérifie chaque champ input du formulaire courant
                    for (i = 0; i < y.length; i++) {

                        if (y[i].type == "checkbox") { // Traitement des champs de type checkbox

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_all_droit_acces") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_client") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_recep_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_devis") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_facture") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_stock_piece") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_four") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_personnel") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            if (y[i].id == "mech_elec_droit_acces_menu_ges_user") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            if (y[i].id == "mech_elec_droit_acces_menu_contact") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            if (y[i].id == "mech_elec_droit_acces_menu_rapport") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            if (y[i].id == "mech_elec_droit_acces_menu_setting") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                        }
                    }
                }
            });

            elt_mech_elec_all_droit_acces.addEventListener('click', function() { // On écoute l'événement click sur cet élément

                // On vérifie que l'élément ayant cet id est bien checked
                if (elt_mech_elec_all_droit_acces.checked == true) {

                    // Cette boucle vérifie chaque champ input du formulaire courant
                    for (i = 0; i < y.length; i++) {

                        if (y[i].type == "checkbox") { // Traitement des champs de type checkbox

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_client") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_recep_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_devis") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_facture") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_stock_piece") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_four") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_personnel") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            if (y[i].id == "mech_elec_droit_acces_menu_ges_user") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            if (y[i].id == "mech_elec_droit_acces_menu_contact") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            if (y[i].id == "mech_elec_droit_acces_menu_rapport") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            if (y[i].id == "mech_elec_droit_acces_menu_setting") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                        }
                    }

                } else {
                    // Cette boucle vérifie chaque champ input du formulaire courant
                    for (i = 0; i < y.length; i++) {

                        if (y[i].type == "checkbox") { // Traitement des champs de type checkbox

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_client") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_recep_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_devis") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_facture") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_stock_piece") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_four") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "mech_elec_droit_acces_menu_personnel") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            if (y[i].id == "mech_elec_droit_acces_menu_ges_user") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            if (y[i].id == "mech_elec_droit_acces_menu_contact") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            if (y[i].id == "mech_elec_droit_acces_menu_rapport") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            if (y[i].id == "mech_elec_droit_acces_menu_setting") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                        }
                    }
                }
            });

            // RECEPTIONNISTE
            elt_recep_droit_acces.addEventListener('click', function() { // On écoute l'événement click sur cet élément

                // On vérifie que l'élément ayant cet id est bien checked
                if (elt_recep_droit_acces.checked == true) {

                    // Cette boucle vérifie chaque champ input du formulaire courant
                    for (i = 0; i < y.length; i++) {

                        if (y[i].type == "checkbox") { // Traitement des champs de type checkbox

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_all_droit_acces") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_client") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_recep_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_devis") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_facture") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_stock_piece") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_four") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_personnel") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            if (y[i].id == "recep_droit_acces_menu_ges_user") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            if (y[i].id == "recep_droit_acces_menu_contact") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            if (y[i].id == "recep_droit_acces_menu_rapport") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            if (y[i].id == "recep_droit_acces_menu_setting") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                        }
                    }

                } else {
                    // Cette boucle vérifie chaque champ input du formulaire courant
                    for (i = 0; i < y.length; i++) {

                        if (y[i].type == "checkbox") { // Traitement des champs de type checkbox

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_all_droit_acces") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_client") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_recep_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_devis") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_facture") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_stock_piece") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_four") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_personnel") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            if (y[i].id == "recep_droit_acces_menu_ges_user") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            if (y[i].id == "recep_droit_acces_menu_contact") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            if (y[i].id == "recep_droit_acces_menu_rapport") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            if (y[i].id == "recep_droit_acces_menu_setting") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                        }
                    }
                }
            });

            elt_recep_all_droit_acces.addEventListener('click', function() { // On écoute l'événement click sur cet élément

                // On vérifie que l'élément ayant cet id est bien checked
                if (elt_recep_all_droit_acces.checked == true) {

                    // Cette boucle vérifie chaque champ input du formulaire courant
                    for (i = 0; i < y.length; i++) {

                        if (y[i].type == "checkbox") { // Traitement des champs de type checkbox

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_client") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_recep_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_devis") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_facture") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_stock_piece") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_four") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_personnel") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            if (y[i].id == "recep_droit_acces_menu_ges_user") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            if (y[i].id == "recep_droit_acces_menu_contact") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            if (y[i].id == "recep_droit_acces_menu_rapport") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            if (y[i].id == "recep_droit_acces_menu_setting") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                        }
                    }

                } else {
                    // Cette boucle vérifie chaque champ input du formulaire courant
                    for (i = 0; i < y.length; i++) {

                        if (y[i].type == "checkbox") { // Traitement des champs de type checkbox

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_client") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_recep_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_devis") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_facture") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_stock_piece") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_four") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "recep_droit_acces_menu_personnel") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            if (y[i].id == "recep_droit_acces_menu_ges_user") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            if (y[i].id == "recep_droit_acces_menu_contact") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            if (y[i].id == "recep_droit_acces_menu_rapport") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            if (y[i].id == "recep_droit_acces_menu_setting") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                        }
                    }
                }
            });

            // CLIENT
            elt_client_droit_acces.addEventListener('click', function() { // On écoute l'événement click sur cet élément

                // On vérifie que l'élément ayant cet id est bien checked
                if (elt_client_droit_acces.checked == true) {

                    // Cette boucle vérifie chaque champ input du formulaire courant
                    for (i = 0; i < y.length; i++) {

                        if (y[i].type == "checkbox") { // Traitement des champs de type checkbox

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_all_droit_acces") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_client") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_recep_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_devis") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_facture") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_stock_piece") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_four") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_personnel") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            if (y[i].id == "client_droit_acces_menu_ges_user") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            if (y[i].id == "client_droit_acces_menu_contact") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            if (y[i].id == "client_droit_acces_menu_rapport") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            if (y[i].id == "client_droit_acces_menu_setting") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                        }
                    }

                } else {
                    // Cette boucle vérifie chaque champ input du formulaire courant
                    for (i = 0; i < y.length; i++) {

                        if (y[i].type == "checkbox") { // Traitement des champs de type checkbox

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_all_droit_acces") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_client") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_recep_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_devis") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_facture") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_stock_piece") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_four") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_personnel") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            if (y[i].id == "client_droit_acces_menu_ges_user") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            if (y[i].id == "client_droit_acces_menu_contact") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            if (y[i].id == "client_droit_acces_menu_rapport") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            if (y[i].id == "client_droit_acces_menu_setting") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                        }
                    }
                }
            });

            elt_client_all_droit_acces.addEventListener('click', function() { // On écoute l'événement click sur cet élément

                // On vérifie que l'élément ayant cet id est bien checked
                if (elt_client_all_droit_acces.checked == true) {

                    // Cette boucle vérifie chaque champ input du formulaire courant
                    for (i = 0; i < y.length; i++) {

                        if (y[i].type == "checkbox") { // Traitement des champs de type checkbox

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_client") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_recep_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_devis") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_facture") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_stock_piece") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_four") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_personnel") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            if (y[i].id == "client_droit_acces_menu_ges_user") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            if (y[i].id == "client_droit_acces_menu_contact") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            if (y[i].id == "client_droit_acces_menu_rapport") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            if (y[i].id == "client_droit_acces_menu_setting") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                        }
                    }

                } else {
                    // Cette boucle vérifie chaque champ input du formulaire courant
                    for (i = 0; i < y.length; i++) {

                        if (y[i].type == "checkbox") { // Traitement des champs de type checkbox

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_client") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_recep_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_devis") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_facture") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_stock_piece") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_four") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "client_droit_acces_menu_personnel") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            if (y[i].id == "client_droit_acces_menu_ges_user") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            if (y[i].id == "client_droit_acces_menu_contact") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            if (y[i].id == "client_droit_acces_menu_rapport") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            if (y[i].id == "client_droit_acces_menu_setting") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                        }
                    }
                }
            });

            // COMPTALE
            elt_compta_droit_acces.addEventListener('click', function() { // On écoute l'événement click sur cet élément

                // On vérifie que l'élément ayant cet id est bien checked
                if (elt_compta_droit_acces.checked == true) {

                    // Cette boucle vérifie chaque champ input du formulaire courant
                    for (i = 0; i < y.length; i++) {

                        if (y[i].type == "checkbox") { // Traitement des champs de type checkbox

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_all_droit_acces") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_client") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_recep_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_devis") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_facture") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_stock_piece") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_four") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_personnel") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            if (y[i].id == "compta_droit_acces_menu_ges_user") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            if (y[i].id == "compta_droit_acces_menu_contact") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            if (y[i].id == "compta_droit_acces_menu_rapport") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                            if (y[i].id == "compta_droit_acces_menu_setting") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = false;

                            }

                        }
                    }

                } else {
                    // Cette boucle vérifie chaque champ input du formulaire courant
                    for (i = 0; i < y.length; i++) {

                        if (y[i].type == "checkbox") { // Traitement des champs de type checkbox

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_all_droit_acces") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_client") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_recep_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_devis") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_facture") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_stock_piece") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_four") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_personnel") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            if (y[i].id == "compta_droit_acces_menu_ges_user") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            if (y[i].id == "compta_droit_acces_menu_contact") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            if (y[i].id == "compta_droit_acces_menu_rapport") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                            if (y[i].id == "compta_droit_acces_menu_setting") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].disabled = true;

                            }

                        }
                    }
                }
            });

            elt_compta_all_droit_acces.addEventListener('click', function() { // On écoute l'événement click sur cet élément

                // On vérifie que l'élément ayant cet id est bien checked
                if (elt_compta_all_droit_acces.checked == true) {

                    // Cette boucle vérifie chaque champ input du formulaire courant
                    for (i = 0; i < y.length; i++) {

                        if (y[i].type == "checkbox") { // Traitement des champs de type checkbox

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_client") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_recep_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_devis") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_facture") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_stock_piece") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_four") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_personnel") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            if (y[i].id == "compta_droit_acces_menu_ges_user") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            if (y[i].id == "compta_droit_acces_menu_contact") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            if (y[i].id == "compta_droit_acces_menu_rapport") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                            if (y[i].id == "compta_droit_acces_menu_setting") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = true;

                            }

                        }
                    }

                } else {
                    // Cette boucle vérifie chaque champ input du formulaire courant
                    for (i = 0; i < y.length; i++) {

                        if (y[i].type == "checkbox") { // Traitement des champs de type checkbox

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_client") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_recep_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_vehi") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_devis") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_facture") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_stock_piece") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_four") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            // On vérifie si l'id de l'élément courant correspond à l'id recherché
                            if (y[i].id == "compta_droit_acces_menu_personnel") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            if (y[i].id == "compta_droit_acces_menu_ges_user") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            if (y[i].id == "compta_droit_acces_menu_contact") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            if (y[i].id == "compta_droit_acces_menu_rapport") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                            if (y[i].id == "compta_droit_acces_menu_setting") {

                                // Si c'est le cas, on le coche automatiquement
                                y[i].checked = false;

                            }

                        }
                    }
                }
            });

        });
    </script>

</body>

</html>

<?php include('../footer.php'); ?>