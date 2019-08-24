<?php
include('header.php');

// Déclaration et initialisation du compteur de boucle
$i = 0;

// Somme des totaux des prix des pièces de rechange
$somme_total_prix_piece_rechange = 0;

$button_text = "Enregistrer information";

$wms = new wms_core();

// Sélection des fournisseurs offrant les prix les plus bas pour chaque pièce de rechange
$rows = $wms->getComparPrixPieceRechangeMinByDiagId($link, $_GET['vehi_diag_id']);

// Lorsqu'on soumet ou valide le formulaire
if (isset($_POST) && !empty($_POST)) {

    // Calcul de la somme total avec la main d'oeuvre
    $_POST['somme_total_prix_piece_rechange_devis'] = $_POST['somme_total_prix_piece_rechange_devis'] + $_POST['main_oeuvre_piece_rechange_devis'];

    // Calcul du montant du avec la main d'oeuvre
    $_POST['montant_du_piece_rechange_devis'] = $_POST['somme_total_prix_piece_rechange_devis'] - $_POST['montant_paye_piece_rechange_devis'];

    // var_dump($_POST);
    // die();

    // Persister les données du devis en BDD

    // Linéarisation de l'array des estimations pour le stocker en base de données
    // $devis_data = serialize($_POST['devis_data']);
    $devis_data = json_encode($_POST['devis_data'], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

    // Récupération de l'identifiant du mécanicien courant depuis la session
    $mech_id = $_SESSION['objMech']['user_id'];

    // Formulation de la requête d'insertion
    $query = "INSERT INTO tbl_add_devis (devis_data, main_oeuvre_piece_rechange_devis, somme_total_prix_piece_rechange_devis, 
        montant_du_piece_rechange_devis, montant_paye_piece_rechange_devis, repaircar_diagnostic_id, mech_id) 
        VALUES ('$devis_data','$_POST[main_oeuvre_piece_rechange_devis]',
        '$_POST[somme_total_prix_piece_rechange_devis]','$_POST[montant_du_piece_rechange_devis]','$_POST[montant_paye_piece_rechange_devis]',
        '$_GET[vehi_diag_id]','$mech_id'
        )";

    // Exécution de la requête
    $result = mysql_query($query, $link);

    // S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
    // if ($result) {
    // Redirection vers la liste des devis
    $url = WEB_URL . 'mech_panel/mech_repaircar_diagnostic_devis_list.php?m=add';
    header("Location: $url");
    // }
}

?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> -->

<body>

    <section class="content-header">
        <h1><i class="fa fa-wrench"></i> Formulaire du devis des coûts de réparation du véhicule
        </h1>
        <!-- <ol class="breadcrumb">
            <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo WEB_URL ?>repaircar/carlist.php"> véhicule à faire réparer</a></li>
            <li class="active">Ajout de véhicule à faire réparer</li>
        </ol> -->
    </section>

    <div class="container">
        <!-- Main content -->
        <form method="post" enctype="multipart/form-data">
            <section class="content">
                <!-- Full Width boxes (Stat box) -->
                <div class="row">
                    <div class="col-md-12">

                        <div align="right" style="margin-bottom:1%;">
                            <button class="btn btn-success" type="submit" data-toggle="tooltip" href="javascript:;" data-original-title="<?php echo $button_text; ?>"><i class="fa fa-save"></i></button> &nbsp;
                            <!-- <a class="btn btn-warning" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>customer/customerlist.php" data-original-title="Back"><i class="fa fa-reply"></i></a> </div> -->

                            <div class="box box-success">
                                <!-- <div class="box-header">
                                <h3 class="box-title"><i class="fa fa-plus"></i> Formulaire client</h3>
                            </div> -->
                                <div class="box-body">

                                    <!-- <div class="form-group">
                                    <label for="type_client"><span style="color:red;">*</span> Type de client :</label>
                                    <select class='form-control' id="type_client" name="type_client">
                                        <option value="<?php echo $c_type_client; ?>">--Sélectionner le type du client--</option>
                                        <option value="Société">Société</option>
                                        <option value="Particulier">Particulier</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                                </div> -->

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <table class="table dt-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th>Désignations</th>
                                                            <th>Marque</th>
                                                            <th>Quantité</th>
                                                            <th>Prix Unitaire</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php

                                                        // Déclaration et initialisation du array de la liste des données du devis
                                                        $devis_data = array();

                                                        // On parcours la liste des prix minimum des pièces de rechange par fournisseur
                                                        foreach ($rows as $row) {

                                                            // Calcul du montant total des pièces de rechange
                                                            $total_prix_piece_rechange = $row['qte_piece_rechange'] * $row['prix_piece_rechange_min'];

                                                            ?>

                                                        <!-- Affichage des données du devis -->
                                                        <tr>
                                                            <td><?php echo $row['designation_piece_rechange']; ?></td>
                                                            <td><?php echo $row['marque_piece_rechange']; ?></td>
                                                            <td><?php echo $row['qte_piece_rechange']; ?></td>
                                                            <td><?php echo $row['prix_piece_rechange_min']; ?></td>
                                                            <td>
                                                                <input id="total_prix_piece_rechange" name="total_prix_piece_rechange" type="text" value=<?php echo $total_prix_piece_rechange; ?> readonly class="form-control allownumberonly" />
                                                            </td>
                                                        </tr>

                                                        <!-- Récupération des données du devis -->
                                                        <input type="hidden" value="<?php echo $row['designation_piece_rechange']; ?>" name="devis_data[<?php echo $i; ?>][designation_piece_rechange_devis]" />
                                                        <input type="hidden" value="<?php echo $row['marque_piece_rechange']; ?>" name="devis_data[<?php echo $i; ?>][marque_piece_rechange_devis]" />
                                                        <input type="hidden" value="<?php echo $row['qte_piece_rechange']; ?>" id="qty_<?php echo $i; ?>" name="devis_data[<?php echo $i; ?>][qte_piece_rechange_devis]" />
                                                        <input type="hidden" value="<?php echo $row['prix_piece_rechange_min']; ?>" id="price_<?php echo $i; ?>" name="devis_data[<?php echo $i; ?>][prix_piece_rechange_min_devis]" />
                                                        <input type="hidden" value="<?php echo $total_prix_piece_rechange; ?>" id="tot_<?php echo $i; ?>" name="devis_data[<?php echo $i; ?>][total_prix_piece_rechange_devis]" />
                                                        <?php
                                                            // Incrémentation du compteur
                                                            $i++;
                                                            // Concaténation et calcul de la somme des totaux des prix des pièces de rechange
                                                            $somme_total_prix_piece_rechange = $somme_total_prix_piece_rechange + $total_prix_piece_rechange;
                                                        }

                                                        ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" class="text-right">Montant main d'oeuvre (<?php echo $currency; ?>):</td>
                                                            <td><input id="labour" name="main_oeuvre_piece_rechange_devis" type="text" class="form-control allownumberonly eFire" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-right">Montant total (sans la main d'oeuvre):</td>
                                                            <td><input id="somme_total_prix_piece_rechange" name="somme_total_prix_piece_rechange_devis" type="text" value="<?php echo $somme_total_prix_piece_rechange; ?>" readonly class="form-control allownumberonly etotal" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-right">Montant dû (<?php echo $currency; ?>):</td>
                                                            <td><input id="total_due" name="montant_du_piece_rechange_devis" type="text" value="0" readonly class="form-control allownumberonly" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-right">Montant payé (<?php echo $currency; ?>):</td>
                                                            <td><input id="total_paid" name="montant_paye_piece_rechange_devis" type="text" value="0" readonly class="form-control allownumberonly" /></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
            </section>
        </form>
    </div>

    <script>
        // Au chargement du DOM, on appelle la fonction qui nous intéresse
        $(document).ready(function() {
            reloadQtyRow();
        });
    </script>

</body>

</html>

<?php include('footer.php'); ?>