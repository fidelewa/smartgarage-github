<?php
include('../header.php');

// Déclaration et initialisation du compteur de boucle
$row = 0;
$estimate_data = array();

// Somme des totaux des prix des pièces de rechange
// $somme_total_prix_piece_rechange = 0;

$button_text = "Enregistrer information";

// Lorsqu'on soumet ou valide le formulaire
if (isset($_POST) && !empty($_POST)) {

    // var_dump($_POST);
    // die();

    // Persister les données du devis en BDD

    // Linéarisation de l'array des données des devis pour le stocker en base de données
    $devis_data = serialize($_POST['estimate_data']);

    $date_devis = date('d/m/Y');

    // Formulation de la requête
    $query = "INSERT INTO tbl_add_devis_simulation (date_devis, devis_data, main_oeuvre_piece_rechange_devis, total_ht_gene_piece_rechange_devis, 
        total_tva, total_ttc_gene_piece_rechange_devis, montant_du_piece_rechange_devis,
        montant_paye_piece_rechange_devis) 
        VALUES ('$date_devis','$devis_data','$_POST[main_oeuvre_piece_rechange_devis]',
        '$_POST[total_ht_gene_piece_rechange_devis]',
        '$_POST[total_tva]',
        '$_POST[total_ttc_gene_piece_rechange_devis]', 
        '$_POST[montant_du_piece_rechange_devis]',
        '$_POST[montant_paye_piece_rechange_devis]'
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
        $url = WEB_URL . 'estimate/repaircar_diagnostic_devis_list.php?m=add';
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
        <h1><i class="fa fa-wrench"></i> Formulaire de création du devis de réparation du véhicule (simulation)
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

                                <div class="box-body">
                                    <div class="form-group col-md-12">
                                        <div class="table-responsive">
                                            <table id="labour_table" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Code de la pièce</th>
                                                        <th>Désignations</th>
                                                        <th>Marque</th>
                                                        <th>Quantité</th>
                                                        <th>Tarif HT</th>
                                                        <th>Taux Remise</th>
                                                        <th>Total HT</th>
                                                        <th>Total TTC</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($estimate_data as $estimate) { ?>
                                                        <tr id="estimate-row<?php echo $row; ?>">
                                                            <td class="text-right"><input id="codepiece_<?php echo $row; ?>" type="text" value="" name="estimate_data[<?php echo $row; ?>][code_piece]" class="form-control" /></td>
                                                            <td class="text-right"><input id="designation_<?php echo $row; ?>" type="text" value="" name="estimate_data[<?php echo $row; ?>][designation]" class="form-control" /></td>
                                                            <td class="text-right"><input id="marque_<?php echo $row; ?>" type="text" value="" name="estimate_data[<?php echo $row; ?>][marque]" class="form-control" /></td>
                                                            <td class="text-right"><input id="qty_<?php echo $row; ?>" type="text" name="estimate_data[<?php echo $row; ?>][quantity]" value="0" class="form-control eFire allownumberonly" /></td>
                                                            <td class="text-right"><input id="price_<?php echo $row; ?>" name="estimate_data[<?php echo $row; ?>][prix_piece_rechange_min_devis]" type="text" value="0.00" class="form-control eFirePrice" /></td>
                                                            <td class="text-right"><input id="remise_<?php echo $row; ?>" name="estimate_data[<?php echo $row; ?>][remise_piece_rechange_devis]" type="text" value="0.00" class="form-control eFireRemise" /></td>
                                                            <td class="text-right"><input id="totalht_<?php echo $row; ?>" name="estimate_data[<?php echo $row; ?>][total_prix_piece_rechange_devis_ht]" type="text" value="0.00" readonly class="form-control allownumberonly" /></td>
                                                            <td class="text-right"><input id="totalttc_<?php echo $row; ?>" name="estimate_data[<?php echo $row; ?>][total_prix_piece_rechange_devis_ttc]" type="text" value="0.00" readonly class="form-control allownumberonly etotal" /></td>
                                                            <td class="text-left"><button type="button" onclick="$('#estimate-row<?php echo $row; ?>').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                                        </tr>
                                                        <?php $row++;
                                                    } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="8"></td>
                                                        <td class="text-left"><button type="button" onclick="addEstimate();" data-toggle="tooltip" title="Ajouter une estimation" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7" class="text-right">Main d'oeuvre (<?php echo $currency; ?>):</td>
                                                        <td><input id="labour" name="main_oeuvre_piece_rechange_devis" type="text" class="form-control allownumberonly" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7" class="text-right">Total HT:</td>
                                                        <td><input id="total_ht_gene" name="total_ht_gene_piece_rechange_devis" type="text" value="0.00" readonly class="form-control allownumberonly" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7" class="text-right">Total TVA (<?php echo $currency; ?>):</td>
                                                        <td><input id="total_tva" name="total_tva" type="text" value="0.00" readonly class="form-control allownumberonly" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7" class="text-right">Total TTC (<?php echo $currency; ?>):</td>
                                                        <td><input id="total_ttc_gene" name="total_ttc_gene_piece_rechange_devis" type="text" value="0.00" readonly class="form-control allownumberonly" /></td>
                                                    </tr>

                                                    <input id="total_due" name="montant_du_piece_rechange_devis" type="hidden" value="0" readonly class="form-control allownumberonly" />
                                                    <input id="total_paid" name="montant_paye_piece_rechange_devis" type="hidden" value="0" readonly class="form-control allownumberonly" />
                                                </tfoot>
                                            </table>
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
        var row = <?php echo $row; ?>;

        function addEstimate() {
            html = '<tr id="estimate-row' + row + '">';
            html += '  <td class="text-right"><input id="codepiece_' + row + '" type="text" name="estimate_data[' + row + '][code_piece]" class="form-control"></td>';
            html += '  <td class="text-right"><input id="designation_' + row + '" type="text" name="estimate_data[' + row + '][designation]" class="form-control"></td>';
            html += '  <td class="text-right"><input type="text" id="marque_' + row + '" name="estimate_data[' + row + '][marque]" value="" class="form-control" /></td>';
            html += '  <td class="text-right"><input id="qty_' + row + '" type="text" name="estimate_data[' + row + '][quantity]" value="0" class="form-control eFire allownumberonly" /></td>';
            html += '  <td class="text-right"><input type="text" id="price_' + row + '" name="estimate_data[' + row + '][price]" value="0.00" class="form-control eFirePrice allownumberonly" /></td>';
            html += '  <td class="text-right"><input type="text" id="remise_' + row + '" name="estimate_data[' + row + '][remise_piece_rechange_devis]" value="0.00" class="form-control eFireRemise allownumberonly" /></td>';
            html += '  <td class="text-right"><input type="text" id="totalht_' + row + '" name="estimate_data[' + row + '][total_prix_piece_rechange_devis_ht]" value="0.00" class="form-control allownumberonly" /></td>';
            html += '  <td class="text-right"><input type="text" id="totalttc_' + row + '" name="estimate_data[' + row + '][total_prix_piece_rechange_devis_ttc]" value="0.00" class="form-control allownumberonly etotal" /></td>';
            html += '  <td class="text-left"><button type="button" onclick="$(\'#estimate-row' + row + '\').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';
            $('#labour_table tbody').append(html);
            row++;
            // reloadQtyRow();
            // numberAllow();

            $(".eFirePrice").keyup(function() {
                // Cette fonction récupère l'id de l'élément qui possède la classe eFirePrice
                totalHtCalculate(this.id);
            });

            $(".eFireRemise").keyup(function() {
                // Cette fonction récupère l'id de l'élément qui possède la classe eFireRemise
                totalRemiseCalculate(this.id);
            });

            $("#labour").keyup(function() {
                totalEstCost();
            });
        }

    </script>

</body>

</html>

<?php include('../footer.php'); ?>