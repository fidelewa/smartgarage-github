<?php
include('../header.php');

// Déclaration et initialisation du compteur de boucle
$i = 0;

// Somme des totaux des prix des pièces de rechange
// $somme_total_prix_piece_rechange = 0;

$button_text = "Enregistrer information";

$wms = new wms_core();

// Sélection des fournisseurs offrant les prix les plus bas pour chaque pièce de rechange
$rows = $wms->getComparPrixPieceRechangeMinByDiagId($link, $_GET['vehi_diag_id']);

// Lorsqu'on soumet ou valide le formulaire
if (isset($_POST) && !empty($_POST)) {

    // var_dump($_POST);
    // die();

    // Persister les données du devis en BDD

    // Linéarisation de l'array des données des devis pour le stocker en base de données
    $devis_data = serialize($_POST['devis_data']);

    $date_devis = $wms->datepickerDateToMySqlDate(date('d/m/Y'));

    // Formulation de la requête
    $query = "INSERT INTO tbl_add_devis (date_devis, devis_data, main_oeuvre_piece_rechange_devis, total_ht_gene_piece_rechange_devis, 
        total_tva, total_ttc_gene_piece_rechange_devis, repaircar_diagnostic_id, montant_du_piece_rechange_devis,
        montant_paye_piece_rechange_devis) 
        VALUES ('$date_devis','$devis_data','$_POST[main_oeuvre_piece_rechange_devis]',
        '$_POST[total_ht_gene_piece_rechange_devis]',
        '$_POST[total_tva]',
        '$_POST[total_ttc_gene_piece_rechange_devis]',
        '$_GET[vehi_diag_id]', 
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
        // Lors de l'enregistrement du devis lié au diagnostic d'un véhicule
        // On persiste les données d'historisation du devis lié à un diagnostic donné concernant un véhicule

        $queryInsHistoDevVehi = "INSERT INTO tbl_histo_devis_vehicule (diag_id, devis_id, devis_date, car_id, imma_vehi) 
        SELECT rd.id as diag_id, dev.devis_id, dev.date_devis, cr.car_id, cr.VIN
		FROM tbl_add_devis dev 
		JOIN tbl_repaircar_diagnostic rd ON dev.repaircar_diagnostic_id = rd.id
		JOIN tbl_add_car cr on rd.car_id = cr.car_id 
        WHERE rd.id = '" . $_GET[vehi_diag_id] . "'";

        $resultInsHistoDevVehi = mysql_query($queryInsHistoDevVehi, $link);

        // S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
        if (!$resultInsHistoDevVehi) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $queryInsHistoDevVehi;
            die($message);
        }

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
        <h1> Formulaire de création du devis de réparation du véhicule
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
                                                <table id="labour_table" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Code de la pièce</th>
                                                            <th class="text-center"><b>Pièce de rechange</b></th>
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
                                                        $devis_data = array();

                                                        // On parcours la liste des prix minimum des pièces de rechange par fournisseur
                                                        foreach ($rows as $row) {

                                                            // Calcul du montant total des pièces de rechange
                                                            $total_prix_piece_rechange = $row['qte_piece_rechange'] * $row['prix_piece_rechange_min'];

                                                            ?>

                                                            <!-- Affichage des données du devis -->
                                                            <tr id="estimate-row<?php echo $i; ?>">
                                                                <td>
                                                                    <input name="devis_data[<?php echo $i; ?>][code_piece_rechange_devis]" type="text" value="" class="form-control" />
                                                                </td>
                                                                <td class="text-right">
                                                                    <button data-toggle="tooltip" title="Ajouter une pièce de rechange à partir du stock" type="button" name="devis_data[<?php echo $i; ?>][button]" onClick=loadModal(<?php echo $i; ?>); class="btn btn-info btnsp"><i class="fa fa-plus"></i></button>
                                                                    <input type="hidden" id="parts_id_<?php echo $i; ?>" name="devis_data[<?php echo $i; ?>][stock_parts]" value="" />
                                                                </td>
                                                                <td>
                                                                    <input type="text" value="<?php echo $row['designation_piece_rechange']; ?>" id="parts_desc_<?php echo $i; ?>" name="devis_data[<?php echo $i; ?>][designation_piece_rechange_devis]" class="form-control" />
                                                                </td>
                                                                <!-- <td>
                                                                                            <input type="text" value="<?php echo $row['marque_piece_rechange']; ?>" name="devis_data[<?php echo $i; ?>][marque_piece_rechange_devis]" class="form-control" />
                                                                                        </td> -->
                                                                <td>
                                                                    <input type="text" value="<?php echo $row['qte_piece_rechange']; ?>" id="qty_<?php echo $i; ?>" name="devis_data[<?php echo $i; ?>][qte_piece_rechange_devis]" class="form-control" />
                                                                </td>
                                                                <td>
                                                                    <input id="price_<?php echo $i; ?>" name="devis_data[<?php echo $i; ?>][prix_piece_rechange_min_devis]" type="text" value="<?php echo $row['prix_piece_rechange_min']; ?>" class="form-control eFirePrice" />
                                                                </td>
                                                                <td>
                                                                    <input id="remise_<?php echo $i; ?>" name="devis_data[<?php echo $i; ?>][remise_piece_rechange_devis]" type="text" value="0.00" class="form-control eFireRemise" />
                                                                </td>
                                                                <td>
                                                                    <input id="totalht_<?php echo $i; ?>" name="devis_data[<?php echo $i; ?>][total_prix_piece_rechange_devis_ht]" type="text" value="<?php echo $total_prix_piece_rechange; ?>" class="form-control allownumberonly" />
                                                                </td>
                                                                <td>
                                                                    <input id="totalttc_<?php echo $i; ?>" name="devis_data[<?php echo $i; ?>][total_prix_piece_rechange_devis_ttc]" type="text" value="0.00" class="form-control allownumberonly etotal" />
                                                                </td>
                                                                <td class="text-left"><button type="button" onclick="$('#estimate-row<?php echo $i; ?>').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                                            </tr>

                                                            <!-- Récupération des données du devis -->
                                                            <!-- <input type="hidden" value="<?php echo $row['designation_piece_rechange']; ?>" name="devis_data[<?php echo $i; ?>][designation_piece_rechange_devis]" />
                                                                                                    <input type="hidden" value="<?php echo $row['marque_piece_rechange']; ?>" name="devis_data[<?php echo $i; ?>][marque_piece_rechange_devis]" />
                                                                                                    <input type="hidden" value="<?php echo $row['qte_piece_rechange']; ?>" id="qty_<?php echo $i; ?>" name="devis_data[<?php echo $i; ?>][qte_piece_rechange_devis]" /> -->

                                                            <?php
                                                            // Incrémentation du compteur
                                                            $i++;
                                                            // Concaténation et calcul de la somme des totaux des prix des pièces de rechange
                                                            // $somme_total_prix_piece_rechange = $somme_total_prix_piece_rechange + $total_prix_piece_rechange;
                                                        }

                                                        ?>
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
                                                            <td><input id="total_ht_gene" name="total_ht_gene_piece_rechange_devis" type="text" value="0.00" class="form-control allownumberonly" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7" class="text-right">Total TVA (<?php echo $currency; ?>):</td>
                                                            <td><input id="total_tva" name="total_tva" type="text" value="0.00" class="form-control allownumberonly" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7" class="text-right">Total TTC (<?php echo $currency; ?>):</td>
                                                            <td><input id="total_ttc_gene" name="total_ttc_gene_piece_rechange_devis" type="text" value="0.00" class="form-control allownumberonly" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7" class="text-right">Montant dû (<?php echo $currency; ?>):</td>
                                                            <td>
                                                                <input id="total_due" name="montant_du_piece_rechange_devis" type="text" value="0.00" class="form-control allownumberonly" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7" class="text-right">Montant payé (<?php echo $currency; ?>):</td>
                                                            <td><input id="total_paid" name="montant_paye_piece_rechange_devis" type="text" value="0.00" class="form-control allownumberonly" /></td>
                                                        </tr>

                                                        <!-- <input id="total_due" name="montant_du_piece_rechange_devis" type="hidden" value="0" class="form-control allownumberonly" /> -->
                                                        <!-- <input id="total_paid" name="montant_paye_piece_rechange_devis" type="hidden" value="0" class="form-control allownumberonly" /> -->
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
    <div id="filter_popup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header green_header">
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                    <h3 class="modal-title">Rechercher des pièces</h3>
                </div>
                <div class="modal-body">
                    <div class="box box-info" id="box_model">
                        <div class="box-body">
                            <div class="box-header">
                                <h3 class="box-title"><i class="fa fa-search"></i> Rechercher des pièces</h3>
                            </div>
                            <!-- <div class="form-group col-md-6">
                                    <label for="ddlMake">Marque :</label>
                                    <select class="form-control" onchange="loadYear(this.value);" name="ddlMake" id="ddlMake">
                                        <option value=''>--Sélectionnez Marque--</option>
                                        <?php
                                        $make_list = $wms->get_all_make_list($link);
                                        foreach ($make_list as $make) {
                                            echo "<option value='" . $make['make_id'] . "'>" . $make['make_name'] . "</option>";
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ddl_model">Modèle :</label>
                                    <select class="form-control" onchange="loadPartsData();" name="ddlModel" id="ddl_model">
                                        <option value=''>--Choisir un modèle--</option>
                                    </select>
                                </div> -->
                            <!-- <div class="form-group col-md-4">
                                    <label for="ddl_model">Modèle :</label>
                                    <select class="form-control" onchange="loadYearData(this.value);" name="ddlModel" id="ddl_model">
                                        <option value=''>--Choisir un modèle--</option>
                                    </select>
                                </div> -->
                            <!-- <div class="form-group col-md-4">
                                    <label for="ddlYear">Année :</label>
                                    <select class="form-control" name="ddlYear" onchange="loadPartsData();" id="ddlYear">
                                        <option value=''>--Sélectionnez Année--</option>
                                    </select>
                                </div> -->
                            <div class="form-group col-md-12">
                                <label for="txtPartsName">Saisissez le nom ou le code barre de la pièce :</label>
                                <input class="form-control" type="text" name="txtPartsName" id="txtPartsName" />
                            </div>
                            <div class="form-group col-md-12">
                                <div align="center" class="page_loader"><img src="<?php echo WEB_URL; ?>/img/ajax-loader.gif" /></div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-center"><b>Image</b></td>
                                                <td class="text-center"><b>Code</b></td>
                                                <td class="text-center"><b>Désignation</b></td>
                                                <td class="text-center"><b>Prix base HT</b></td>
                                                <!-- <td class="text-center"><b>Garantie</b></td> -->
                                                <td class="text-center"><b>Quantité/stock</b></td>
                                            </tr>
                                        </thead>
                                        <tbody id="laod_parts_data">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <input type="hidden" id="estimate_row" value="0" />
    <script>
        var row = <?php echo $i; ?>;

        function addEstimate() {
            html = '<tr id="estimate-row' + row + '">';
            html += '  <td class="text-right"><input id="codepiece_' + row + '" type="text" name="devis_data[' + row + '][code_piece_rechange_devis]" class="form-control"></td>';
            html += '  <td class="text-right"><button data-toggle="tooltip" title="Ajouter une pièce de rechange à partir du stock" type="button" name="estimate_data[' + row + '][button]" onClick=loadModal(' + row + '); class="btn btn-info btnsp"><i class="fa fa-plus"></i></button><input type="hidden" id="parts_id_' + row + '" name="estimate_data[' + row + '][stock_parts]" value="0" /></td>';
            html += '  <td class="text-right"><input id="parts_desc_' + row + '" type="text" name="devis_data[' + row + '][designation_piece_rechange_devis]" class="form-control"></td>';
            // html += '  <td class="text-right"><input type="text" id="marque_' + row + '" name="devis_data[' + row + '][marque_piece_rechange_devis]" value="" class="form-control" /></td>';
            html += '  <td class="text-right"><input id="qty_' + row + '" type="text" name="devis_data[' + row + '][qte_piece_rechange_devis]" value="0" class="form-control eFire allownumberonly" /></td>';
            html += '  <td class="text-right"><input type="text" id="price_' + row + '" name="devis_data[' + row + '][prix_piece_rechange_min_devis]" value="0.00" class="form-control eFirePrice" /></td>';
            html += '  <td class="text-right"><input type="text" id="remise_' + row + '" name="devis_data[' + row + '][remise_piece_rechange_devis]" value="0.00" class="form-control eFireRemise allownumberonly" /></td>';
            html += '  <td class="text-right"><input type="text" id="totalht_' + row + '" name="devis_data[' + row + '][total_prix_piece_rechange_devis_ht]" value="0.00" class="form-control allownumberonly" /></td>';
            html += '  <td class="text-right"><input type="text" id="totalttc_' + row + '" name="devis_data[' + row + '][total_prix_piece_rechange_devis_ttc]" value="0.00" class="form-control allownumberonly etotal" /></td>';
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

            row++;
            // reloadQtyRow();
            // numberAllow();
        }

        function addDataToEstimate(obj, parts_id, price, qty, code_piece) {
            if (parseInt(qty) > 0) {
                var row = $("#estimate_row").val();
                var parts_name = $(obj).find(".parts_name").html();
                $("#parts_desc_" + row).val(parts_name);
                $("#price_" + row).val(price);
                // $("#qty_" + row).val('1');
                $("#qty_" + row).val(qty);
                $("#total_" + row).val(price);
                $("#parts_id_" + row).val(parts_id);
                $("#codepiece_" + row).val(code_piece);
                totalEstCost();
                $("#filter_popup").modal("hide")
            } else {
                alert("Stock Empty so you cannot add parts");
            }
        }

        function loadModal(row) {
            $("#estimate_row").val(row);
            $("#filter_popup").modal("show")
        }

        // Au chargement du DOM, on appelle la fonction qui nous intéresse
        $(document).ready(function() {

            $(".eFirePrice").keyup(function() {
                // Cette fonction récupère l'id de l'élément qui possède la classe eFirePrice
                console.log('fgkldfgkl');
                totalHtCalculate(this.id);
            });

            $(".eFireRemise").keyup(function() {
                // Cette fonction récupère l'id de l'élément qui possède la classe eFireRemise
                totalRemiseCalculate(this.id);
            });

            $("#labour").keyup(function() {
                totalEstCost();
            });
        });
    </script>

</body>

</html>

<?php include('../footer.php'); ?>