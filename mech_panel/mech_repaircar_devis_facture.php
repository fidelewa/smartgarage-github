<?php
include('header.php');

// Déclaration et initialisation du compteur de boucle
$i = 0;

$tva = 0.18;

$button_text = "Enregistrer information";

$wms = new wms_core();

// Sélection des fournisseurs offrant les prix les plus bas pour chaque pièce de rechange
// $rows = $wms->getComparPrixPieceRechangeMinByDiagId($link, $_GET['vehi_diag_id']);
$row = $wms->getRepairCarDiagnosticDevisInfoByDiagId($link, $_GET['vehi_diag_id'], $_GET['devis_id']);

// Calcul du montant totla avec la TVA
$montantTva = $row['somme_total_prix_piece_rechange_devis'] * $tva;
$montantTotalTva = $row['somme_total_prix_piece_rechange_devis'] + $montantTva;

// Calcul du montant du avec la TVA
$montantDuTva = $montantTotalTva - $row['montant_paye_piece_rechange_devis'];

// var_dump($rows);
// die();

// Lorsqu'on soumet ou valide le formulaire
if (isset($_POST) && !empty($_POST)) {

    // var_dump($_POST);
    // die();

    // Persister les données de la facture en BDD

    // Linéarisation de l'array des estimations pour le stocker en base de données
    // $facture_data = serialize($_POST['facture_data']);
    $facture_data = json_encode($_POST['facture_data'], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

    // Initialisation de la date de la fature
    $date_facture = date('d/M/Y');

    // Formulation de la requête
    $query = "INSERT INTO tbl_add_facture (date_facture, facture_data, montant_main_oeuvre_facture, montant_total_tva_facture, 
        montant_du_facture, montant_paye_facture, devis_id) 
        VALUES ('$date_facture','$facture_data','$_POST[montant_main_oeuvre_facture]',
        '$_POST[montant_total_tva_facture]','$_POST[montant_du_facture]','$_POST[montant_paye_facture]',
        '$_GET[devis_id]'
        )";

    // Exécution de la requête
    $result = mysql_query($query, $link);

    // S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
    // if (!$result) {
        // Redirection vers la liste des devis
        $url = WEB_URL . 'mech_panel/mech_repaircar_devis_facture_list.php?m=add';
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
        <h1><i class="fa fa-wrench"></i> Formulaire de création de la facture du devis de réparation du véhicule
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

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <table class="table dt-responsive">
                                                    <thead>
                                                        <tr>
                                                            <!-- <th>#</th> -->
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
                                                        $facture_data = array();

                                                        // On délinéarise l'array
                                                        // $devis_data = unserialize($row['devis_data']);
                                                        $devis_data = json_decode($row['devis_data'], true);

                                                        
                                                        foreach ($devis_data as $devis) { ?>
                                                            <tr>
                                                                <!-- <td><?php echo $i; ?></td> -->
                                                                <td><?php echo str_replace('u0027', "'", $devis['designation_piece_rechange_devis']); ?></td>
                                                                <td><?php echo $devis['marque_piece_rechange_devis']; ?></td>
                                                                <td><?php echo $devis['qte_piece_rechange_devis']; ?></td>
                                                                <td><?php echo $devis['prix_piece_rechange_min_devis']; ?></td>
                                                                <td><?php echo $devis['total_prix_piece_rechange_devis']; ?></td>
                                                            </tr>
                                                            <!-- Récupération des données de la facture -->
                                                            <input type="hidden" value="<?php echo str_replace('u0027', "'", $devis['designation_piece_rechange_devis']); ?>" name="facture_data[<?php echo $i; ?>][designation_piece_rechange_facture]" />
                                                            <input type="hidden" value="<?php echo $devis['marque_piece_rechange_devis']; ?>" name="facture_data[<?php echo $i; ?>][marque_piece_rechange_facture]" />
                                                            <input type="hidden" value="<?php echo $devis['qte_piece_rechange_devis']; ?>" name="facture_data[<?php echo $i; ?>][qte_piece_rechange_facture]" />
                                                            <input type="hidden" value="<?php echo $devis['prix_piece_rechange_min_devis']; ?>" name="facture_data[<?php echo $i; ?>][prix_piece_rechange_min_facture]" />
                                                            <input type="hidden" value="<?php echo $devis['total_prix_piece_rechange_devis']; ?>" name="facture_data[<?php echo $i; ?>][total_prix_piece_rechange_facture]" />
                                                            <?php $i++;
                                                        } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" class="text-right">Main d'oeuvre (<?php echo $currency; ?>):</td>
                                                            <td><?php echo $row['main_oeuvre_piece_rechange_devis']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-right">TVA :</td>
                                                            <td><?php echo ($tva * 100) . ' %'; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-right">Total (<?php echo $currency; ?>):</td>
                                                            <td><?php
                                                                echo $montantTotalTva; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-right">Montant dû (<?php echo $currency; ?>):</td>
                                                            <td><?php
                                                                echo $montantDuTva; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-right">Montant payé (<?php echo $currency; ?>):</td>
                                                            <td><?php echo $row['montant_paye_piece_rechange_devis']; ?></td>
                                                        </tr>
                                                    </tfoot>
                                                    <input type="hidden" value="<?php echo $row['main_oeuvre_piece_rechange_devis']; ?>" name="montant_main_oeuvre_facture" />
                                                    <input type="hidden" value="<?php echo $montantTotalTva; ?>" name="montant_total_tva_facture" />
                                                    <input type="hidden" value="<?php echo $montantDuTva; ?>" name="montant_du_facture" />
                                                    <input type="hidden" value="<?php echo $row['montant_paye_piece_rechange_devis']; ?>" name="montant_paye_facture" />
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