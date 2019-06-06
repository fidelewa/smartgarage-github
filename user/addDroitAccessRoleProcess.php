<?php

include('../header.php');

// Déclaration et initialisation des variables
$listeDroitMenuRole = array();
$listKeys = array();

// var_dump($_POST);
// die();

if (!isset($_POST['role_data'])) { // Si aucun droit sur les menus n'a été défini

    // MECANICIEN & ELECTRICIEN
    if (isset($_POST['mech_elec_droit_acces'])) { // Définition des droits d'accès des roles mécaniciens et électriciens

        // On vérifie que l'enregistrement du droit d'accès par role courant exsite déja en BDD
        $querySelDroitMenuRole = "SELECT droit_menu_role_id, role_name FROM tbl_droit_menu_role WHERE role_name = '" . $_POST['mech_elec_droit_acces'] . "'";

        // On exécute la requête
        $resultSelDroitMenuRole = mysql_query($querySelDroitMenuRole, $link);

        // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
        if (!$resultSelDroitMenuRole) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $querySelDroitMenuRole;
            die($message);
        }

        // On récupère le jeu de résultat de la requête
        $listeDroitMenuRole = mysql_fetch_assoc($resultSelDroitMenuRole);

        // var_dump($listeDroitMenuRole);
        // die();

        // Si l'array est vide, alors aucun enregistrement ne correspond à la sélection
        // Dans ce cas, on fait une insertion
        if (empty($listeDroitMenuRole)) {

            $query = "INSERT INTO tbl_droit_menu_role (role_name, menu_client, menu_recep_vehi, menu_vehi, menu_devis,
        menu_facture, menu_stock_piece, menu_four, menu_ges_personnel, menu_ges_user, menu_contact,
        menu_rapport, menu_setting) 
        VALUES('$_POST[mech_elec_droit_acces]',null,null, null, null, null,null,null,null,null,null,null,null
        )";

            // On exécute la requête
            $result = mysql_query($query, $link);
        } else { // Sinon on fait une modification au cas où un enregistrement correspond à la sélection

            $query = "UPDATE tbl_droit_menu_role
				SET `role_name`='" . $_POST['mech_elec_droit_acces'] . "',
                `menu_client`= null,
				`menu_recep_vehi`= null, 
                `menu_vehi`= null,
                `menu_devis`= null,
                `menu_facture`= null,
                `menu_stock_piece`= null,
                `menu_four`= null,
                `menu_ges_personnel`= null,
                `menu_ges_user`= null,
                `menu_contact`= null,
                `menu_rapport`= null,
                `menu_setting`= null
                WHERE droit_menu_role_id='" . $listeDroitMenuRole['droit_menu_role_id'] . "'";

            // On exécute la requête
            $result = mysql_query($query, $link);
        }

        // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
        if (!$result) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $query;
            die($message);
        }
    }

    // RECEPTIONNISTE
    if (isset($_POST['recep_droit_acces'])) { // Définition des droits d'accès du role receptionniste

        // On vérifie que l'enregistrement du droit d'accès par role courant exsite déja en BDD
        $querySelDroitMenuRole = "SELECT droit_menu_role_id, role_name FROM tbl_droit_menu_role WHERE role_name = '" . $_POST['recep_droit_acces'] . "'";

        // On exécute la requête
        $resultSelDroitMenuRole = mysql_query($querySelDroitMenuRole, $link);

        // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
        if (!$resultSelDroitMenuRole) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $querySelDroitMenuRole;
            die($message);
        }

        // On récupère le jeu de résultat de la requête
        $listeDroitMenuRole = mysql_fetch_assoc($resultSelDroitMenuRole);

        // Si l'array est vide, alors aucun enregistrement ne correspond à la sélection
        // Dans ce cas, on fait une insertion
        if (empty($listeDroitMenuRole)) {

            $query = "INSERT INTO tbl_droit_menu_role (role_name, menu_client, menu_recep_vehi, menu_vehi, menu_devis,
        menu_facture, menu_stock_piece, menu_four, menu_ges_personnel, menu_ges_user, menu_contact,
        menu_rapport, menu_setting) 
        VALUES('$_POST[recep_droit_acces]',null,null, null, null, null,null,null,null,null,null,null,null
        )";

            // On exécute la requête
            $result = mysql_query($query, $link);
        } else { // Sinon on fait une modification au cas où un enregistrement correspond à la sélection

            $query = "UPDATE tbl_droit_menu_role
				SET `role_name`='" . $_POST['recep_droit_acces'] . "',
                `menu_client`= null,
				`menu_recep_vehi`= null, 
                `menu_vehi`= null,
                `menu_devis`= null,
                `menu_facture`= null,
                `menu_stock_piece`= null,
                `menu_four`= null,
                `menu_ges_personnel`= null,
                `menu_ges_user`= null,
                `menu_contact`= null,
                `menu_rapport`= null,
                `menu_setting`= null
                WHERE droit_menu_role_id='" . $listeDroitMenuRole['droit_menu_role_id'] . "'";

            // On exécute la requête
            $result = mysql_query($query, $link);
        }

        // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
        if (!$result) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $query;
            die($message);
        }
    }

    // CLIENT
    if (isset($_POST['client_droit_acces'])) { // Définition des droits d'accès du role client

        // On vérifie que l'enregistrement du droit d'accès par role courant exsite déja en BDD
        $querySelDroitMenuRole = "SELECT droit_menu_role_id, role_name FROM tbl_droit_menu_role WHERE role_name = '" . $_POST['client_droit_acces'] . "'";

        // On exécute la requête
        $resultSelDroitMenuRole = mysql_query($querySelDroitMenuRole, $link);

        // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
        if (!$resultSelDroitMenuRole) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $querySelDroitMenuRole;
            die($message);
        }

        // On récupère le jeu de résultat de la requête
        $listeDroitMenuRole = mysql_fetch_assoc($resultSelDroitMenuRole);

        // Si l'array est vide, alors aucun enregistrement ne correspond à la sélection
        // Dans ce cas, on fait une insertion
        if (empty($listeDroitMenuRole)) {

            $query = "INSERT INTO tbl_droit_menu_role (role_name, menu_client, menu_recep_vehi, menu_vehi, menu_devis,
        menu_facture, menu_stock_piece, menu_four, menu_ges_personnel, menu_ges_user, menu_contact,
        menu_rapport, menu_setting) 
        VALUES('$_POST[client_droit_acces]',null,null, null, null, null,null,null,null,null,null,null,null
        )";

            $result = mysql_query($query, $link);
        } else { // Sinon on fait une modification au cas où un enregistrement correspond à la sélection

            $query = "UPDATE tbl_droit_menu_role
				SET `role_name`='" . $_POST['client_droit_acces'] . "',
                `menu_client`= null,
				`menu_recep_vehi`= null, 
                `menu_vehi`= null,
                `menu_devis`= null,
                `menu_facture`= null,
                `menu_stock_piece`= null,
                `menu_four`= null,
                `menu_ges_personnel`= null,
                `menu_ges_user`= null,
                `menu_contact`= null,
                `menu_rapport`= null,
                `menu_setting`= null
                WHERE droit_menu_role_id='" . $listeDroitMenuRole['droit_menu_role_id'] . "'";

            // On exécute la requête
            $result = mysql_query($query, $link);
        }

        // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
        if (!$result) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $query;
            die($message);
        }
    }

    // COMPTABLE
    if (isset($_POST['compta_droit_acces'])) { // Définition des droits d'accès du role comptable

        // On vérifie que l'enregistrement du droit d'accès par role courant exsite déja en BDD
        $querySelDroitMenuRole = "SELECT droit_menu_role_id, role_name FROM tbl_droit_menu_role WHERE role_name = '" . $_POST['compta_droit_acces'] . "'";

        // On exécute la requête
        $resultSelDroitMenuRole = mysql_query($querySelDroitMenuRole, $link);

        // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
        if (!$resultSelDroitMenuRole) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $querySelDroitMenuRole;
            die($message);
        }

        // On récupère le jeu de résultat de la requête
        $listeDroitMenuRole = mysql_fetch_assoc($resultSelDroitMenuRole);

        // Si l'array est vide, alors aucun enregistrement ne correspond à la sélection
        // Dans ce cas, on fait une insertion
        if (empty($listeDroitMenuRole)) {

            $query = "INSERT INTO tbl_droit_menu_role (role_name, menu_client, menu_recep_vehi, menu_vehi, menu_devis,
        menu_facture, menu_stock_piece, menu_four, menu_ges_personnel, menu_ges_user, menu_contact,
        menu_rapport, menu_setting) 
        VALUES('$_POST[compta_droit_acces]',null,null, null, null, null,null,null,null,null,null,null,null
        )";

            // On exécute la requête 
            $result = mysql_query($query, $link);
        } else { // Sinon on fait une modification au cas où un enregistrement correspond à la sélection

            $query = "UPDATE tbl_droit_menu_role
				SET `role_name`='" . $_POST['compta_droit_acces'] . "',
                `menu_client`= null,
				`menu_recep_vehi`= null, 
                `menu_vehi`= null,
                `menu_devis`= null,
                `menu_facture`= null,
                `menu_stock_piece`= null,
                `menu_four`= null,
                `menu_ges_personnel`= null,
                `menu_ges_user`= null,
                `menu_contact`= null,
                `menu_rapport`= null,
                `menu_setting`= null
                WHERE droit_menu_role_id='" . $listeDroitMenuRole['droit_menu_role_id'] . "'";

            // On exécute la requête
            $result = mysql_query($query, $link);
        }

        // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
        if (!$result) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $query;
            die($message);
        }
    }
} else { // Si au moins un droit sur les menus a été défini

    // On parcours la liste de tous les droits
    foreach ($_POST['role_data'] as $key => $droitAccessRole) {

        // Enlever de la clé la quote supplémentaire 
        $key = str_replace("'", "", $key);

        // Définir à aucun valeur les entrées vide
        if (empty($droitAccessRole['droit_acces_menu_client'])) {
            $droitAccessRole['droit_acces_menu_client'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_recep_vehi'])) {
            $droitAccessRole['droit_acces_menu_recep_vehi'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_vehi'])) {
            $droitAccessRole['droit_acces_menu_vehi'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_devis'])) {
            $droitAccessRole['droit_acces_menu_devis'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_facture'])) {
            $droitAccessRole['droit_acces_menu_facture'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_stock_piece'])) {
            $droitAccessRole['droit_acces_menu_stock_piece'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_four'])) {
            $droitAccessRole['droit_acces_menu_four'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_personnel'])) {
            $droitAccessRole['droit_acces_menu_personnel'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_ges_user'])) {
            $droitAccessRole['droit_acces_menu_ges_user'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_contact'])) {
            $droitAccessRole['droit_acces_menu_contact'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_rapport'])) {
            $droitAccessRole['droit_acces_menu_rapport'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_setting'])) {
            $droitAccessRole['droit_acces_menu_setting'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_client'])) {
            $droitAccessRole['droit_acces_menu_client'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_recep_vehi'])) {
            $droitAccessRole['droit_acces_menu_recep_vehi'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_vehi'])) {
            $droitAccessRole['droit_acces_menu_vehi'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_devis'])) {
            $droitAccessRole['droit_acces_menu_devis'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_facture'])) {
            $droitAccessRole['droit_acces_menu_facture'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_stock_piece'])) {
            $droitAccessRole['droit_acces_menu_stock_piece'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_four'])) {
            $droitAccessRole['droit_acces_menu_four'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_personnel'])) {
            $droitAccessRole['droit_acces_menu_personnel'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_ges_user'])) {
            $droitAccessRole['droit_acces_menu_ges_user'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_contact'])) {
            $droitAccessRole['droit_acces_menu_contact'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_rapport'])) {
            $droitAccessRole['droit_acces_menu_rapport'] = null;
        }
        if (empty($droitAccessRole['droit_acces_menu_setting'])) {
            $droitAccessRole['droit_acces_menu_setting'] = null;
        }

        // Si se sont les droits d'accès des profils mécanicien et électricien qui sont définis
        // MECANICIEN & ELECTRICIEN
        if ($key == "role_mecano_eletro") {

            // echo "je suis dans role_mecano_electro";
            // var_dump($key);
            // var_dump($droitAccessRole);
            // die();

            // On vérifie que l'enregistrement du droit d'accès par role courant exsite déja en BDD
            $querySelDroitMenuRole = "SELECT droit_menu_role_id, role_name FROM tbl_droit_menu_role WHERE role_name = '" . $_POST['mech_elec_droit_acces'] . "'";

            // On exécute la requête
            $resultSelDroitMenuRole = mysql_query($querySelDroitMenuRole, $link);

            // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
            if (!$resultSelDroitMenuRole) {
                $message  = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $querySelDroitMenuRole;
                die($message);
            }

            // On récupère le jeu de résultat de la requête
            $listeDroitMenuRole = mysql_fetch_assoc($resultSelDroitMenuRole);

            // var_dump($listeDroitMenuRole);
            // die();

            // Si l'array est vide, alors aucun enregistrement ne correspond à la sélection
            // Dans ce cas, on fait une insertion
            if (empty($listeDroitMenuRole)) {

                $query = "INSERT INTO tbl_droit_menu_role (role_name, menu_client, menu_recep_vehi, menu_vehi, menu_devis,
                menu_facture, menu_stock_piece, menu_four, menu_ges_personnel, menu_ges_user, menu_contact,
                menu_rapport, menu_setting) 
                VALUES('$_POST[mech_elec_droit_acces]','$droitAccessRole[droit_acces_menu_client]',
                '$droitAccessRole[droit_acces_menu_recep_vehi]', '$droitAccessRole[droit_acces_menu_vehi]', '$droitAccessRole[droit_acces_menu_devis]',
                '$droitAccessRole[droit_acces_menu_facture]','$droitAccessRole[droit_acces_menu_stock_piece]','$droitAccessRole[droit_acces_menu_four]',
                '$droitAccessRole[droit_acces_menu_personnel]','$droitAccessRole[droit_acces_menu_ges_user]','$droitAccessRole[droit_acces_menu_contact]',
                '$droitAccessRole[droit_acces_menu_rapport]','$droitAccessRole[droit_acces_menu_setting]'
                )";

                // Exécution de la requête
                $result = mysql_query($query, $link);
            } else { // Sinon on fait une modification au cas où un enregistrement correspond à la sélection

                $query = "UPDATE tbl_droit_menu_role
				SET `role_name`='" . $_POST['mech_elec_droit_acces'] . "',
                `menu_client`='" . $droitAccessRole['droit_acces_menu_client'] . "',
				`menu_recep_vehi`='" . $droitAccessRole['droit_acces_menu_recep_vehi'] . "', 
                `menu_vehi`='" . $droitAccessRole['droit_acces_menu_vehi'] . "',
                `menu_devis`='" . $droitAccessRole['droit_acces_menu_devis'] . "',
                `menu_facture`='" . $droitAccessRole['droit_acces_menu_facture'] . "',
                `menu_stock_piece`='" . $droitAccessRole['droit_acces_menu_stock_piece'] . "',
                `menu_four`='" . $droitAccessRole['droit_acces_menu_four'] . "',
                `menu_ges_personnel`='" . $droitAccessRole['droit_acces_menu_personnel'] . "',
                `menu_ges_user`='" . $droitAccessRole['droit_acces_menu_ges_user'] . "',
                `menu_contact`='" . $droitAccessRole['droit_acces_menu_contact'] . "',
                `menu_rapport`='" . $droitAccessRole['droit_acces_menu_rapport'] . "',
                `menu_setting`='" . $droitAccessRole['droit_acces_menu_setting'] . "'
                WHERE droit_menu_role_id='" . $listeDroitMenuRole['droit_menu_role_id'] . "'";

                // exécution de la requête
                $result = mysql_query($query, $link);
            }

            // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
            if (!$result) {
                $message  = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $query;
                die($message);
            }
        }

        // RECEPTIONNISTE
        // Si se sont les droits d'accès du profil réceptionniste qui sont définis
        if ($key == 'role_recep') {

            // echo "je suis dans role_recep";

            // var_dump($key);
            // var_dump($droitAccessRole);
            // die();

            // On vérifie que l'enregistrement du droit d'accès par role courant exsite déja en BDD
            $querySelDroitMenuRole = "SELECT droit_menu_role_id, role_name FROM tbl_droit_menu_role WHERE role_name = '" . $_POST['recep_droit_acces'] . "'";

            // On exécute la requête
            $resultSelDroitMenuRole = mysql_query($querySelDroitMenuRole, $link);

            // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
            if (!$resultSelDroitMenuRole) {
                $message  = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $querySelDroitMenuRole;
                die($message);
            }

            // On récupère le jeu de résultat de la requête
            $listeDroitMenuRole = mysql_fetch_assoc($resultSelDroitMenuRole);

            // var_dump($listeDroitMenuRole);
            // die();

            // Si l'array est vide, alors aucun enregistrement ne correspond à la sélection
            // Dans ce cas, on fait une insertion
            if (empty($listeDroitMenuRole)) {

                // Insertion du nom de la marque dans la table des marques
                $query = "INSERT INTO tbl_droit_menu_role (role_name, menu_client, menu_recep_vehi, menu_vehi, menu_devis,
                menu_facture, menu_stock_piece, menu_four, menu_ges_personnel, menu_ges_user, menu_contact,
                menu_rapport, menu_setting) 
                VALUES('$_POST[recep_droit_acces]','$droitAccessRole[droit_acces_menu_client]',
                '$droitAccessRole[droit_acces_menu_recep_vehi]', '$droitAccessRole[droit_acces_menu_vehi]', '$droitAccessRole[droit_acces_menu_devis]',
                '$droitAccessRole[droit_acces_menu_facture]','$droitAccessRole[droit_acces_menu_stock_piece]','$droitAccessRole[droit_acces_menu_four]',
                '$droitAccessRole[droit_acces_menu_personnel]','$droitAccessRole[droit_acces_menu_ges_user]','$droitAccessRole[droit_acces_menu_contact]',
                '$droitAccessRole[droit_acces_menu_rapport]','$droitAccessRole[droit_acces_menu_setting]'
                )";

                // On exécute la requête
                $result = mysql_query($query, $link);
            } else { // Sinon on fait une modification au cas où un enregistrement correspond à la sélection

                $query = "UPDATE tbl_droit_menu_role
				SET `role_name`='" . $_POST['recep_droit_acces'] . "',
                `menu_client`='" . $droitAccessRole['droit_acces_menu_client'] . "',
				`menu_recep_vehi`='" . $droitAccessRole['droit_acces_menu_recep_vehi'] . "', 
                `menu_vehi`='" . $droitAccessRole['droit_acces_menu_vehi'] . "',
                `menu_devis`='" . $droitAccessRole['droit_acces_menu_devis'] . "',
                `menu_facture`='" . $droitAccessRole['droit_acces_menu_facture'] . "',
                `menu_stock_piece`='" . $droitAccessRole['droit_acces_menu_stock_piece'] . "',
                `menu_four`='" . $droitAccessRole['droit_acces_menu_four'] . "',
                `menu_ges_personnel`='" . $droitAccessRole['droit_acces_menu_personnel'] . "',
                `menu_ges_user`='" . $droitAccessRole['droit_acces_menu_ges_user'] . "',
                `menu_contact`='" . $droitAccessRole['droit_acces_menu_contact'] . "',
                `menu_rapport`='" . $droitAccessRole['droit_acces_menu_rapport'] . "',
                `menu_setting`='" . $droitAccessRole['droit_acces_menu_setting'] . "'
                WHERE droit_menu_role_id='" . $listeDroitMenuRole['droit_menu_role_id'] . "'";

                // On exécute la requête
                $result = mysql_query($query, $link);
            }

            // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
            if (!$result) {
                $message  = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $query;
                die($message);
            }
        }

        // CLIENT
        // Si se sont les droits d'accès du profil client qui sont définis
        if ($key == 'role_client') {

            // var_dump($droitAccessRole);
            // die();

            // On vérifie que l'enregistrement du droit d'accès par role courant exsite déja en BDD
            $querySelDroitMenuRole = "SELECT droit_menu_role_id, role_name FROM tbl_droit_menu_role WHERE role_name = '" . $_POST['client_droit_acces'] . "'";

            // On exécute la requête
            $resultSelDroitMenuRole = mysql_query($querySelDroitMenuRole, $link);

            // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
            if (!$resultSelDroitMenuRole) {
                $message  = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $querySelDroitMenuRole;
                die($message);
            }

            // On récupère le jeu de résultat de la requête
            $listeDroitMenuRole = mysql_fetch_assoc($resultSelDroitMenuRole);

            // var_dump($listeDroitMenuRole);
            // die();

            // Si l'array est vide, alors aucun enregistrement ne correspond à la sélection
            // Dans ce cas, on fait une insertion
            if (empty($listeDroitMenuRole)) {

                // Insertion du nom de la marque dans la table des marques
                $query = "INSERT INTO tbl_droit_menu_role (role_name, menu_client, menu_recep_vehi, menu_vehi, menu_devis,
                menu_facture, menu_stock_piece, menu_four, menu_ges_personnel, menu_ges_user, menu_contact,
                menu_rapport, menu_setting) 
                VALUES('$_POST[client_droit_acces]','$droitAccessRole[droit_acces_menu_client]',
                '$droitAccessRole[droit_acces_menu_recep_vehi]', '$droitAccessRole[droit_acces_menu_vehi]', '$droitAccessRole[droit_acces_menu_devis]',
                '$droitAccessRole[droit_acces_menu_facture]','$droitAccessRole[droit_acces_menu_stock_piece]','$droitAccessRole[droit_acces_menu_four]',
                '$droitAccessRole[droit_acces_menu_personnel]','$droitAccessRole[droit_acces_menu_ges_user]','$droitAccessRole[droit_acces_menu_contact]',
                '$droitAccessRole[droit_acces_menu_rapport]','$droitAccessRole[droit_acces_menu_setting]'
                )";

                // On exécute la requête
                $result = mysql_query($query, $link);
            } else { // Sinon on fait une modification au cas où un enregistrement correspond à la sélection

                $query = "UPDATE tbl_droit_menu_role
				SET `role_name`='" . $_POST['client_droit_acces'] . "',
                `menu_client`='" . $droitAccessRole['droit_acces_menu_client'] . "',
				`menu_recep_vehi`='" . $droitAccessRole['droit_acces_menu_recep_vehi'] . "', 
                `menu_vehi`='" . $droitAccessRole['droit_acces_menu_vehi'] . "',
                `menu_devis`='" . $droitAccessRole['droit_acces_menu_devis'] . "',
                `menu_facture`='" . $droitAccessRole['droit_acces_menu_facture'] . "',
                `menu_stock_piece`='" . $droitAccessRole['droit_acces_menu_stock_piece'] . "',
                `menu_four`='" . $droitAccessRole['droit_acces_menu_four'] . "',
                `menu_ges_personnel`='" . $droitAccessRole['droit_acces_menu_personnel'] . "',
                `menu_ges_user`='" . $droitAccessRole['droit_acces_menu_ges_user'] . "',
                `menu_contact`='" . $droitAccessRole['droit_acces_menu_contact'] . "',
                `menu_rapport`='" . $droitAccessRole['droit_acces_menu_rapport'] . "',
                `menu_setting`='" . $droitAccessRole['droit_acces_menu_setting'] . "'
                WHERE droit_menu_role_id='" . $listeDroitMenuRole['droit_menu_role_id'] . "'";

                // On exécute la requête
                $result = mysql_query($query, $link);
            }

            // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
            if (!$result) {
                $message  = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $query;
                die($message);
            }
        }

        // COMPTABLE
        // Si se sont les droits d'accès du profil comptable qui sont définis
        if ($key == 'role_compta') {

            // var_dump($droitAccessRole);
            // die();

            // On vérifie que l'enregistrement du droit d'accès par role courant exsite déja en BDD
            $querySelDroitMenuRole = "SELECT droit_menu_role_id, role_name FROM tbl_droit_menu_role WHERE role_name = '" . $_POST['compta_droit_acces'] . "'";

            // On exécute la requête
            $resultSelDroitMenuRole = mysql_query($querySelDroitMenuRole, $link);

            // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
            if (!$resultSelDroitMenuRole) {
                $message  = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $querySelDroitMenuRole;
                die($message);
            }

            // On récupère le jeu de résultat de la requête
            $listeDroitMenuRole = mysql_fetch_assoc($resultSelDroitMenuRole);

            // var_dump($listeDroitMenuRole);
            // die();

            // Si l'array est vide, alors aucun enregistrement ne correspond à la sélection
            // Dans ce cas, on fait une insertion
            if (empty($listeDroitMenuRole)) {

                // Insertion du nom de la marque dans la table des marques
                $query = "INSERT INTO tbl_droit_menu_role (role_name, menu_client, menu_recep_vehi, menu_vehi, menu_devis,
                menu_facture, menu_stock_piece, menu_four, menu_ges_personnel, menu_ges_user, menu_contact,
                menu_rapport, menu_setting) 
                VALUES('$_POST[compta_droit_acces]','$droitAccessRole[droit_acces_menu_client]',
                '$droitAccessRole[droit_acces_menu_recep_vehi]', '$droitAccessRole[droit_acces_menu_vehi]', '$droitAccessRole[droit_acces_menu_devis]',
                '$droitAccessRole[droit_acces_menu_facture]','$droitAccessRole[droit_acces_menu_stock_piece]','$droitAccessRole[droit_acces_menu_four]',
                '$droitAccessRole[droit_acces_menu_personnel]','$droitAccessRole[droit_acces_menu_ges_user]','$droitAccessRole[droit_acces_menu_contact]',
                '$droitAccessRole[droit_acces_menu_rapport]','$droitAccessRole[droit_acces_menu_setting]'
                )";

                // On exécute la requête
                $result = mysql_query($query, $link);
            } else { // Sinon on fait une modification au cas où un enregistrement correspond à la sélection

                $query = "UPDATE tbl_droit_menu_role
				SET `role_name`='" . $_POST['compta_droit_acces'] . "',
                `menu_client`='" . $droitAccessRole['droit_acces_menu_client'] . "',
				`menu_recep_vehi`='" . $droitAccessRole['droit_acces_menu_recep_vehi'] . "', 
                `menu_vehi`='" . $droitAccessRole['droit_acces_menu_vehi'] . "',
                `menu_devis`='" . $droitAccessRole['droit_acces_menu_devis'] . "',
                `menu_facture`='" . $droitAccessRole['droit_acces_menu_facture'] . "',
                `menu_stock_piece`='" . $droitAccessRole['droit_acces_menu_stock_piece'] . "',
                `menu_four`='" . $droitAccessRole['droit_acces_menu_four'] . "',
                `menu_ges_personnel`='" . $droitAccessRole['droit_acces_menu_personnel'] . "',
                `menu_ges_user`='" . $droitAccessRole['droit_acces_menu_ges_user'] . "',
                `menu_contact`='" . $droitAccessRole['droit_acces_menu_contact'] . "',
                `menu_rapport`='" . $droitAccessRole['droit_acces_menu_rapport'] . "',
                `menu_setting`='" . $droitAccessRole['droit_acces_menu_setting'] . "'
                WHERE droit_menu_role_id='" . $listeDroitMenuRole['droit_menu_role_id'] . "'";

                // On exécute la requête
                $result = mysql_query($query, $link);
            }

            // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
            if (!$result) {
                $message  = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $query;
                die($message);
            }
        }

        // $listKeys[] = $key;
    }

    // var_dump($listKeys);
    // die();
}

// Faire une redirection vers le formulaire d'attribution des droits
header("Location: " . WEB_URL . "user/addrole.php");
