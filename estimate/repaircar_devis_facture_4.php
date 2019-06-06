<?php
include('../header.php');

// Déclaration et initialisation du compteur de boucle
$i = 0;

// Somme des totaux des prix des pièces de rechange
// $somme_total_prix_piece_rechange = 0;

$button_text = "Enregistrer information";

$wms = new wms_core();

// Sélection des fournisseurs offrant les prix les plus bas pour chaque pièce de rechange
// $rows = $wms->getComparPrixPieceRechangeMinByDiagId($link, $_GET['vehi_diag_id']);
$row = $wms->getRepairCarDiagnosticDevisInfoByDiagId($link, $_GET['vehi_diag_id'], $_GET['devis_id']);

// Lorsqu'on soumet ou valide le formulaire
if (isset($_POST) && !empty($_POST)) {

    // var_dump($_POST);
    // die();

    // Linéarisation de l'array des estimations pour le stocker en base de données
    $facture_data = serialize($_POST['facture_data']);

    // Initialisation de la date de la fature
    $date_facture = date('d/m/Y');

    // Formulation de la requête
    $query = "INSERT INTO tbl_add_facture (date_facture, facture_data, montant_main_oeuvre_facture, total_ht_gene_piece_rechange_facture,
        total_tva_facture, total_ttc_gene_piece_rechange_facture, montant_du_piece_rechange_facture, 
        montant_paye_piece_rechange_facture, devis_id) 
        VALUES ('$date_facture','$facture_data','$_POST[montant_main_oeuvre_facture]','$_POST[total_ht_gene_piece_rechange_facture]',
        '$_POST[total_tva_facture]','$_POST[total_ttc_gene_piece_rechange_facture]','$_POST[montant_du_piece_rechange_facture]',
        '$_POST[montant_paye_piece_rechange_facture]','$_GET[devis_id]'
        )";

    // Exécution de la requête
    $result = mysql_query($query, $link);

    // S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    } else {
        // Redirection vers la liste des devis
        $url = WEB_URL . 'estimate/repaircar_devis_facture_list.php?m=add';
        header("Location: $url");
    }
}

?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> -->

<body>

    <section class="content-header">
        <h1><i class="fa fa-wrench"></i> Formulaire de création de la facture de réparation d'un véhicule
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <table class="table dt-responsive">
                                                <thead>
                                                    <tr>
                                                        <th>Code</th>
                                                        <th>Désignation</th>
                                                        <th>Marque</th>
                                                        <th>Quantité</th>
                                                        <th>Tarif HT</th>
                                                        <th>Remise</th>
                                                        <th>Total HT</th>
                                                        <th>Total TTC</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    // Déclaration et initialisation du array de la liste des données du devis
                                                    $facture_data = array();

                                                    // On délinéarise l'array
                                                    $devis_data = unserialize($row['devis_data']);

                                                    foreach ($devis_data as $devis) { ?>
                                                        <tr>
                                                            <td><?php echo $devis['code_piece_rechange_devis']; ?></td>
                                                            <td><?php echo $devis['designation_piece_rechange_devis']; ?></td>
                                                            <td><?php echo $devis['marque_piece_rechange_devis']; ?></td>
                                                            <td><?php echo $devis['qte_piece_rechange_devis']; ?></td>
                                                            <td><?php echo $devis['prix_piece_rechange_min_devis']; ?></td>
                                                            <td><?php echo $devis['remise_piece_rechange_devis']; ?></td>
                                                            <td><?php echo $devis['total_prix_piece_rechange_devis_ht']; ?></td>
                                                            <td><?php echo $devis['total_prix_piece_rechange_devis_ttc']; ?></td>
                                                        </tr>
                                                        <!-- Récupération des données de la facture -->
                                                        <input type="hidden" value="<?php echo $devis['code_piece_rechange_devis']; ?>" name="facture_data[<?php echo $i; ?>][code_piece_rechange_facture]" />
                                                        <input type="hidden" value="<?php echo $devis['designation_piece_rechange_devis']; ?>" name="facture_data[<?php echo $i; ?>][designation_piece_rechange_facture]" />
                                                        <input type="hidden" value="<?php echo $devis['marque_piece_rechange_devis']; ?>" name="facture_data[<?php echo $i; ?>][marque_piece_rechange_facture]" />
                                                        <input type="hidden" value="<?php echo $devis['qte_piece_rechange_devis']; ?>" name="facture_data[<?php echo $i; ?>][qte_piece_rechange_facture]" />
                                                        <input type="hidden" value="<?php echo $devis['prix_piece_rechange_min_devis']; ?>" name="facture_data[<?php echo $i; ?>][prix_piece_rechange_min_facture]" />
                                                        <input type="hidden" value="<?php echo $devis['remise_piece_rechange_devis']; ?>" name="facture_data[<?php echo $i; ?>][remise_piece_rechange_facture]" />
                                                        <input type="hidden" value="<?php echo $devis['total_prix_piece_rechange_devis_ht']; ?>" name="facture_data[<?php echo $i; ?>][total_prix_piece_rechange_facture_ht]" />
                                                        <input type="hidden" value="<?php echo $devis['total_prix_piece_rechange_devis_ttc']; ?>" name="facture_data[<?php echo $i; ?>][total_prix_piece_rechange_facture_ttc]" />
                                                        <?php $i++;
                                                    } ?>
                                                    <tr>
                                                        <td colspan="7" class="text-right">Montant main d'oeuvre (<?php echo $currency; ?>):</td>
                                                        <td><?php echo $row['main_oeuvre_piece_rechange_devis']; ?></td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="7" class="text-right">Total HT:</td>
                                                        <td><?php echo $row['total_ht_gene_piece_rechange_devis']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7" class="text-right">Total TVA (<?php echo $currency; ?>):</td>
                                                        <td><?php echo $row['total_tva']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7" class="text-right">Total TTC (<?php echo $currency; ?>):</td>
                                                        <td><?php echo $row['total_ttc_gene_piece_rechange_devis']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7" class="text-right">Montant dû (<?php echo $currency; ?>):</td>
                                                        <td><?php echo $row['montant_du_piece_rechange_devis']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7" class="text-right">Montant payé (<?php echo $currency; ?>):</td>
                                                        <td><?php echo $row['montant_paye_piece_rechange_devis']; ?></td>
                                                    </tr>
                                                </tfoot>
                                                <input type="hidden" value="<?php echo $row['main_oeuvre_piece_rechange_devis']; ?>" name="montant_main_oeuvre_facture" />
                                                <input type="hidden" value="<?php echo $row['total_ht_gene_piece_rechange_devis']; ?>" name="total_ht_gene_piece_rechange_facture" />
                                                <input type="hidden" value="<?php echo $row['total_tva']; ?>" name="total_tva_facture" />
                                                <input type="hidden" value="<?php echo $row['total_ttc_gene_piece_rechange_devis']; ?>" name="total_ttc_gene_piece_rechange_facture" />
                                                <input type="hidden" value="<?php echo $row['montant_du_piece_rechange_devis']; ?>" name="montant_du_piece_rechange_facture" />
                                                <input type="hidden" value="<?php echo $row['montant_paye_piece_rechange_devis']; ?>" name="montant_paye_piece_rechange_facture" />
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

</body>

</html>

<?php include('../footer.php'); ?>