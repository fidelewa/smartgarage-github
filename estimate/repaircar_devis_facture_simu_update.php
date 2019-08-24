<?php
include('../header.php');

// Déclaration et initialisation du compteur de boucle
$i = 0;

// Somme des totaux des prix des pièces de rechange
// $somme_total_prix_piece_rechange = 0;

$button_text = "Modifier la facture";

$wms = new wms_core();

// Sélection des fournisseurs offrant les prix les plus bas pour chaque pièce de rechange
// $rows = $wms->getComparPrixPieceRechangeMinByDiagId($link, $_GET['vehi_diag_id']);
// $row = $wms->getRepairCarDiagnosticDevisInfoByDiagId($link, $_GET['devis_id']);
// $row = $wms->getRepairCarSimuDevis($link, $_GET['devis_simu_id']);

$row = $wms->getRepairCarSimuFacture($link, $_GET['facture_id']);

// var_dump($row);
// die();

// Lorsqu'on soumet ou valide le formulaire
if (isset($_POST) && !empty($_POST)) {

    // var_dump($_POST);
    // die();

    foreach ($_POST['facture_data'] as $fac_data) { // Pour chaque pièce de rechange inscrites dans la facture

        // var_dump($fac_data);
        // die();

        // On met à jour la quantité de la pièce de rechange en question dans le stock
        // A la validation du formulaire de facture
        // $row = $wms->updateQtyPartsStock($link, $fac_data);
        $row = $wms->updateQtyPieceStock($link, $fac_data);
    }

    // Linéarisation de l'array des estimations pour le stocker en base de données
    // $facture_data = serialize($_POST['facture_data']);
    $facture_data = json_encode($_POST['facture_data'], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

    // Initialisation de la date de la fature
    // $date_facture = date('d/m/Y');
    // $date_facture = $wms->datepickerDateToMySqlDate($_POST['date_facture']);

    // var_dump($_POST);
    // die();

    // Formulation de la requête
    $query = "UPDATE tbl_add_facture_simulation 
        SET date_facture='" . $_POST['date_facture'] . "', facture_data='" . $facture_data . "',
        montant_main_oeuvre_facture='" . $_POST['montant_main_oeuvre_facture'] . "', total_ht_gene_piece_rechange_facture='" . $_POST['total_ht_gene_piece_rechange_facture'] . "',
        total_tva_facture='" . $_POST['total_tva_facture'] . "',total_ttc_gene_piece_rechange_facture='" . $_POST['total_ttc_gene_piece_rechange_facture'] . "',
        montant_du_piece_rechange_facture='" . $_POST['montant_du_piece_rechange_facture'] . "',
        montant_paye_piece_rechange_facture='" . $_POST['hfDone'] . "'
        WHERE facture_id='" . $_GET['facture_id'] . "'";


    // echo $query;
    // die();

    // Exécution de la requête
    $result = mysql_query($query, $link);

    // S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
    // if ($result) {
    // Redirection vers la liste des devis
    $url = WEB_URL . 'estimate/repaircar_simu_devis_facture_list.php?m=up';
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
        <h1>Formulaire de création de la facture de réparation d'un véhicule
        </h1>
        <!-- <ol class="breadcrumb">
            <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo WEB_URL ?>repaircar/carlist.php"> véhicule à faire réparer</a></li>
            <li class="active">Ajout de véhicule à faire réparer</li>
        </ol> -->
    </section>

    <div class="container">
        <!-- Main content -->
        <form method="post" enctype="multipart/form-data" id="mainForm" name="mainForm" role="form">
            <section class="content">
                <!-- Full Width boxes (Stat box) -->
                <div class="row">
                    <div class="col-md-12">

                        <div align="right" style="margin-bottom:1%;">
                            <!-- <a class="btn btn-success" style="background-color:#0029CE;color:#ffffff;" data-toggle="modal" data-target="#devis_vehicule_modal" title="Attribuer le devis à un véhicule"><i class="fa fa-plus"></i></a> -->
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
                                                        <!-- <th>Marque</th> -->
                                                        <th>Quantité</th>
                                                        <th>Tarif HT</th>
                                                        <th>Taux Remise</th>
                                                        <th>Total HT</th>
                                                        <th>Total TTC</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    // Déclaration et initialisation du array de la liste des données du devis
                                                    $facture_data = array();

                                                    // On délinéarise l'array
                                                    // $devis_data = unserialize($row['devis_data']);
                                                    $devis_data = json_decode($row['devis_data'], true);

                                                    // var_dump($devis_data);
                                                    // die();

                                                    foreach ($devis_data as $devis) { ?>
                                                    <tr id="estimate-row<?php echo $i; ?>">
                                                        <td><input type="text" id="codepiece_<?php echo $i; ?>" value="<?php echo $devis['code_piece']; ?>" name="facture_data[<?php echo $i; ?>][code_piece_rechange_facture]" class="form-control" /></td>
                                                        <td><input type="text" id="designation_<?php echo $i; ?>" value="<?php echo str_replace('u0027', "'", $devis['designation']); ?>" name="facture_data[<?php echo $i; ?>][designation_piece_rechange_facture]" class="form-control" /></td>
                                                        <!-- <td><input type="text" value="<?php echo $devis['marque']; ?>" name="facture_data[<?php echo $i; ?>][marque_piece_rechange_facture]" class="form-control" /></td> -->
                                                        <td><input type="text" id="qty_<?php echo $i; ?>" value="<?php echo $devis['quantity']; ?>" name="facture_data[<?php echo $i; ?>][qte_piece_rechange_facture]" class="form-control eFire allownumberonly" /></td>
                                                        <td><input type="text" id="price_<?php echo $i; ?>" value="<?php echo $devis['price']; ?>" name="facture_data[<?php echo $i; ?>][prix_piece_rechange_min_facture]" class="form-control eFirePrice" /></td>
                                                        <td><input type="text" id="remise_<?php echo $i; ?>" value="<?php echo $devis['remise_piece_rechange_devis']; ?>" name="facture_data[<?php echo $i; ?>][remise_piece_rechange_facture]" class="form-control eFireRemise allownumberonly" /></td>
                                                        <td><input type="text" id="totalht_<?php echo $i; ?>" value="<?php echo $devis['total_prix_piece_rechange_devis_ht']; ?>" name="facture_data[<?php echo $i; ?>][total_prix_piece_rechange_facture_ht]" class="form-control allownumberonly" /></td>
                                                        <td><input type="text" id="totalttc_<?php echo $i; ?>" value="<?php echo $devis['total_prix_piece_rechange_devis_ttc']; ?>" name="facture_data[<?php echo $i; ?>][total_prix_piece_rechange_facture_ttc]" class="form-control allownumberonly etotal" /></td>
                                                        <td class="text-left"><button type="button" onclick="$('#estimate-row<?php echo $i; ?>').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                                    </tr>
                                                    <!-- Récupération des données de la facture -->
                                                    <input type="hidden" value="<?php echo $devis['stock_parts']; ?>" name="facture_data[<?php echo $i; ?>][piece_rechange_id]" />
                                                    <?php $i++;
                                                    } ?>
                                                    <input type="hidden" value="<?php echo $row['date_facture']; ?>" name="date_facture" />
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="7"></td>
                                                        <td class="text-left"><button type="button" onclick="addEstimate();" data-toggle="tooltip" title="Ajouter une estimation" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Main d'oeuvre (<?php echo $currency; ?>):</td>
                                                        <td><input id="labour" type="text" value="<?php echo $row['montant_main_oeuvre_facture']; ?>" name="montant_main_oeuvre_facture" class="form-control allownumberonly" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Total HT:</td>
                                                        <td><input id="total_ht_gene" type="text" value="<?php echo $row['total_ht_gene_piece_rechange_facture']; ?>" name="total_ht_gene_piece_rechange_facture" class="form-control" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Total TVA (<?php echo $currency; ?>):</td>
                                                        <td><input id="total_tva" type="text" value="<?php echo $row['total_tva_facture']; ?>" name="total_tva_facture" class="form-control" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Total TTC (<?php echo $currency; ?>):</td>
                                                        <td><input id="total_ttc_gene" type="text" value="<?php echo $row['total_ttc_gene_piece_rechange_facture']; ?>" name="total_ttc_gene_piece_rechange_facture" class="form-control" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Montant dû (<?php echo $currency; ?>):</td>
                                                        <td><input id="total_due" type="text" value="<?php echo $row['montant_du_piece_rechange_facture']; ?>" name="montant_du_piece_rechange_facture" class="form-control" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Montant payé (<?php echo $currency; ?>):</td>
                                                        <td><input id="total_paid" type="text" value="<?php echo $row['montant_paye_piece_rechange_facture']; ?>" name="montant_paye_piece_rechange_facture" class="form-control" /></td>
                                                    </tr>

                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="" name="hfDone" id="hfDone" />
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
            </section>
        </form>
    </div>

    <script>
        var row = <?php echo $i; ?>;

        function addEstimate() {
            html = '<tr id="estimate-row' + row + '">';
            html += '  <td class="text-right"><input id="codepiece_' + row + '" type="text" name="facture_data[' + row + '][code_piece_rechange_facture]" class="form-control"></td>';
            html += '  <td class="text-right"><input id="designation_' + row + '" type="text" name="facture_data[' + row + '][designation_piece_rechange_facture]" class="form-control"></td>';
            // html += '  <td class="text-right"><input type="text" id="marque_' + row + '" name="facture_data[' + row + '][marque_piece_rechange_facture]" value="" class="form-control" /></td>';
            html += '  <td class="text-right"><input id="qty_' + row + '" type="text" name="facture_data[' + row + '][qte_piece_rechange_facture]" value="0" class="form-control eFire allownumberonly" /></td>';
            html += '  <td class="text-right"><input type="text" id="price_' + row + '" name="facture_data[' + row + '][prix_piece_rechange_min_facture]" value="0.00" class="form-control eFirePrice" /></td>';
            html += '  <td class="text-right"><input type="text" id="remise_' + row + '" name="facture_data[' + row + '][remise_piece_rechange_facture]" value="0.00" class="form-control eFireRemise allownumberonly" /></td>';
            html += '  <td class="text-right"><input type="text" id="totalht_' + row + '" name="facture_data[' + row + '][total_prix_piece_rechange_facture_ht]" value="0.00" class="form-control allownumberonly" /></td>';
            html += '  <td class="text-right"><input type="text" id="totalttc_' + row + '" name="facture_data[' + row + '][total_prix_piece_rechange_facture_ttc]" value="0.00" class="form-control allownumberonly etotal" /></td>';
            html += '  <td class="text-left"><button type="button" onclick="$(\'#estimate-row' + row + '\').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';
            $('#labour_table tbody').append(html);

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

            $("#total_paid").keyup(function() {

                calculateTotalPaid();
            });

            row++;
            // reloadQtyRow();
            // numberAllow();
        }

        function calculateTotalPaid(payment_done, payment_due, old_payment_done) {

            // console.log(payment_done);
            // console.log(payment_due);

            payment_due = parseFloat(payment_due) - parseFloat(payment_done);

            // console.log(payment_due);

            payment_due = parseFloat(payment_due).toFixed(2);

            payment_done = parseFloat(old_payment_done) + parseFloat(payment_done);

            console.log('Montant payé total :' + payment_done);

            $("#total_due").val(payment_due);
            $("#hfDue").val(payment_due);
            $("#hfDone").val(payment_done);

        }

        // Au chargement du DOM, on appelle la fonction qui nous intéresse
        $(document).ready(function() {

            // On récupère les valeurs courantes du total du et du total payé
            var payment_done = $("#total_paid").val();
            var payment_due = $("#total_due").val();
            var old_payment_done = "<?php echo $row['montant_paye_piece_rechange_facture']; ?>";

            console.log('Ancien paiement du :' + old_payment_done);
            console.log('Ancien montant payé :' + payment_done);
            console.log('Montant due :' + payment_due);
            // console.log(payment_done);

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

            $("#total_paid").change(function() {
                // On récupère la nouvelle valeur du montant total payé
                payment_done = parseFloat($("#total_paid").val());
                console.log('Nouveau montant payé :' + payment_done);
                // payment_due = $("#total_due").val();
                calculateTotalPaid(payment_done, payment_due, old_payment_done);
            });
        });
    </script>

</body>

</html>

<?php include('../footer.php'); ?>