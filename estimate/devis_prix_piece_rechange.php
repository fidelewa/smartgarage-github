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

    // var_dump($_POST['devis_data']);
    // die();

    // Persister les données du devis en BDD

    // Linéarisation de l'array des données des devis pour le stocker en base de données
    // $devis_data = serialize($_POST['devis_data']);
    $devis_data = json_encode($_POST['devis_data'], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

    $date_devis = $wms->datepickerDateToMySqlDate(date('d/m/Y'));

    // Formulation de la requête

    $query = "INSERT INTO tbl_add_devis (date_devis, devis_data, main_oeuvre_piece_rechange_devis, total_ht_gene_piece_rechange_devis, 
    total_tva, total_ttc_gene_piece_rechange_devis, repaircar_diagnostic_id, montant_du_piece_rechange_devis,
    montant_paye_piece_rechange_devis, devis_remise) 
    VALUES ('$date_devis','$devis_data','$_POST[main_oeuvre_piece_rechange_devis]',
    '$_POST[total_ht_gene_piece_rechange_devis]',
    '$_POST[total_tva]',
    '$_POST[total_ttc_gene_piece_rechange_devis]',
    '$_GET[vehi_diag_id]', 
    '$_POST[montant_du_piece_rechange_devis]',
    '$_POST[montant_paye_piece_rechange_devis]',
    '$_POST[devis_remise]'
    )";

    // Exécution de la requête
    $result = mysql_query($query, $link);

    // S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }

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

?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> -->

<body>

    <section class="content-header">
        <h1> Formulaire de création du devis après diagnostic
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Réception de véhicules</a></li>
            <li><a href="<?php echo WEB_URL ?>reception/repaircar_diagnostic_list.php"> Liste des diagnostics des véhicules réceptionnés</a></li>
            <li class="active">Création de devis</li>
        </ol>
    </section>

    <div class="container">
        <!-- Main content -->
        <form method="post" enctype="multipart/form-data" id="mainForm" name="mainForm" role="form">
            <section class="content">
                <!-- Full Width boxes (Stat box) -->
                <div class="row">
                    <div class="col-md-12">

                        <div id="mdp_valid_msg"></div>

                        <div align="right" style="margin-bottom:1%;">
                            <!-- <a class="btn btn-success" style="background-color:#0029CE;color:#ffffff;" data-toggle="modal" data-target="#devis_vehicule_modal" title="Attribuer le devis à un véhicule"><i class="fa fa-plus"></i></a> -->
                            <button id="form_devis" class="btn btn-success" type="submit" data-toggle="tooltip" href="javascript:;" data-original-title="<?php echo $button_text; ?>"><i class="fa fa-save"></i></button> &nbsp;
                            <!-- <a class="btn btn-warning" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>customer/customerlist.php" data-original-title="Back"><i class="fa fa-reply"></i></a> </div> -->

                            <div class="box box-success">

                                <div class="box-body">
                                    <div class="form-group col-md-12">
                                        <div class="table-responsive">
                                            <table id="labour_table" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Code de la pièce</th>
                                                        <th class="text-center"><b>Pièce de rechange</b></th>
                                                        <th>Désignations</th>
                                                        <th>Quantité</th>
                                                        <th>Tarif HT</th>
                                                        <th>Total HT</th>
                                                        <th>Total TTC</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    // Déclaration et initialisation du array de la liste des données du devis
                                                    $devis_data = array();

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
                                                            <td>
                                                                <input type="text" value="<?php echo $row['qte_piece_rechange']; ?>" id="qty_<?php echo $i; ?>" name="devis_data[<?php echo $i; ?>][qte_piece_rechange_devis]" class="form-control eFireQty" />
                                                            </td>
                                                            <td>
                                                                <input id="price_<?php echo $i; ?>" name="devis_data[<?php echo $i; ?>][prix_piece_rechange_min_devis]" type="text" value="<?php echo $row['prix_piece_rechange_min']; ?>" class="form-control eFirePrice" />
                                                            </td>
                                                            <!-- <td>
                                                                                <input id="remise_<?php echo $i; ?>" name="devis_data[<?php echo $i; ?>][remise_piece_rechange_devis]" type="text" value="" class="form-control eFireRemise" required />
                                                                            </td> -->
                                                            <td>
                                                                <input id="totalht_<?php echo $i; ?>" name="devis_data[<?php echo $i; ?>][total_prix_piece_rechange_devis_ht]" type="text" value="<?php echo $total_prix_piece_rechange; ?>" class="form-control allownumberonly" />
                                                            </td>
                                                            <td>
                                                                <input id="totalttc_<?php echo $i; ?>" name="devis_data[<?php echo $i; ?>][total_prix_piece_rechange_devis_ttc]" type="text" value="<?php echo $total_prix_piece_rechange; ?>" class="form-control allownumberonly etotal" />
                                                            </td>
                                                            <td class="text-left"><button type="button" onclick="$('#estimate-row<?php echo $i; ?>').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                                        </tr>

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
                                                        <td colspan="7"></td>
                                                        <td class="text-left"><button type="button" onclick="addEstimate();" data-toggle="tooltip" title="Ajouter une estimation" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Main d'oeuvre (<?php echo $currency; ?>):</td>
                                                        <td><input id="labour" name="main_oeuvre_piece_rechange_devis" type="text" class="form-control allownumberonly" required /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Total HT:</td>
                                                        <td><input id="total_ht_gene" name="total_ht_gene_piece_rechange_devis" type="text" value="0.00" class="form-control allownumberonly" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Remise (%):</td>
                                                        <!-- <td><input id="total_ht_gene" name="total_ht_gene_piece_rechange_devis" type="text" value="0.00" readonly class="form-control allownumberonly" /></td> -->
                                                        <td><input required id="devis_remise" name="devis_remise" type="text" value="" class="form-control allownumberonly eFireRemise" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Total TVA (<?php echo $currency; ?>):</td>
                                                        <td><input id="total_tva" name="total_tva" type="text" value="0.00" class="form-control allownumberonly" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Total TTC (<?php echo $currency; ?>):</td>
                                                        <td><input id="total_ttc_gene" name="total_ttc_gene_piece_rechange_devis" type="text" value="0.00" class="form-control allownumberonly" /></td>
                                                    </tr>
                                                    <tr id="devis_pwd_box">
                                                        <!-- <td colspan="6" class="text-right">Mot de passe:</td>
                                                        <td><input id="devis_pwd" name="devis_pwd" type="text" value="" class="form-control" /></td> -->
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
            html += '  <td class="text-right"><button data-toggle="tooltip" title="Ajouter une pièce de rechange à partir du stock" type="button" name="devis_data[' + row + '][button]" onClick=loadModal(' + row + '); class="btn btn-info btnsp"><i class="fa fa-plus"></i></button><input type="hidden" id="parts_id_' + row + '" name="devis_data[' + row + '][stock_parts]" value="0" /></td>';
            html += '  <td class="text-right"><input id="parts_desc_' + row + '" type="text" name="devis_data[' + row + '][designation_piece_rechange_devis]" class="form-control"></td>';
            html += '  <td class="text-right"><input id="qty_' + row + '" type="text" name="devis_data[' + row + '][qte_piece_rechange_devis]" value="0" class="form-control eFireQty allownumberonly" /></td>';
            html += '  <td class="text-right"><input type="text" id="price_' + row + '" name="devis_data[' + row + '][prix_piece_rechange_min_devis]" value="0.00" class="form-control eFirePrice" /></td>';
            html += '  <td class="text-right"><input type="text" id="totalht_' + row + '" name="devis_data[' + row + '][total_prix_piece_rechange_devis_ht]" value="0.00" class="form-control allownumberonly" /></td>';
            html += '  <td class="text-right"><input type="text" id="totalttc_' + row + '" name="devis_data[' + row + '][total_prix_piece_rechange_devis_ttc]" value="0.00" class="form-control allownumberonly etotal" /></td>';
            html += '  <td class="text-left"><button type="button" onclick="$(\'#estimate-row' + row + '\').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';
            $('#labour_table tbody').append(html);
            row++;
            // reloadQtyRow();
            // numberAllow();

            $(".eFireQty").keyup(function() {
                // Cette fonction récupère l'id de l'élément qui possède la classe eFirePrice
                totalHtCalculate(this.id);
            });

            $(".eFirePrice").keyup(function() {
                // Cette fonction récupère l'id de l'élément qui possède la classe eFirePrice
                totalHtCalculate(this.id);
            });

            $(".eFireRemise").change(function() {
                // Cette fonction récupère l'id de l'élément qui possède la classe eFireRemise
                // console.log('remise')
                totalRemiseCalculate();
                // totalEstCost();

                // On récupère la valeur du taux de la remise en (%)
                if ($("#devis_remise").val() != '') {
                    taux_remise_percent = $("#devis_remise").val();

                    if (taux_remise_percent > 10) {

                        html = "<td colspan='6' class='text-right'>Mot de passe:</td><td><input id='devis_pwd' name='devis_pwd' type='password' value='' class='form-control' /> <button class='btn btn-success' type='button' onclick='verif_pwd();' data-original-title='vérifier la validité du mot de passe'><i class='fa fa-check'></i></button></td>"

                        $("#devis_pwd_box").html(html);

                        if ($("#devis_pwd").val() == '') {
                            alert("Le mot de passe est obligatoire !!!");
                            $("#devis_pwd").prop('required', true);
                            $("#devis_pwd").focus();
                            $("#form_devis").prop('disabled', true);
                        }

                    }
                }
            });

            $("#labour").keyup(function() {
                // totalEstCost();
                CalculTotalHTGene()
            });
        }

        $(".eFireQty").keyup(function() {
            // Cette fonction récupère l'id de l'élément qui possède la classe eFirePrice
            totalHtCalculate(this.id);
        });

        $(".eFirePrice").keyup(function() {
            // Cette fonction récupère l'id de l'élément qui possède la classe eFirePrice
            totalHtCalculate(this.id);
        });

        $(".eFireRemise").change(function() {
            // Cette fonction récupère l'id de l'élément qui possède la classe eFireRemise
            // console.log('remise')
            totalRemiseCalculate();
            // totalEstCost();

            // On récupère la valeur du taux de la remise en (%)
            if ($("#devis_remise").val() != '') {
                taux_remise_percent = $("#devis_remise").val();

                if (taux_remise_percent > 10) {

                    html = "<td colspan='6' class='text-right'>Mot de passe:</td><td><input id='devis_pwd' name='devis_pwd' type='password' value='' class='form-control' /> <button class='btn btn-success' type='button' onclick='verif_pwd();' data-original-title='vérifier la validité du mot de passe'><i class='fa fa-check'></i></button></td>"

                    $("#devis_pwd_box").html(html);

                    if ($("#devis_pwd").val() == '') {
                        alert("Le mot de passe est obligatoire !!!");
                        $("#devis_pwd").prop('required', true);
                        $("#devis_pwd").focus();
                        $("#form_devis").prop('disabled', true);
                    }

                }
            }
        });

        $("#labour").keyup(function() {
            // totalEstCost();
            CalculTotalHTGene()
        });

        function verif_pwd() {
            devis_pwd = $("#devis_pwd").val();
            msg_invalid = "<div class='alert alert-warning alert-dismissable' style='display:block'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'><i class='fa fa-close'></i></button><h4> mot de passe invalide </h4></div>";

            $.ajax({
                url: '../ajax/getstate.php',
                type: 'POST',
                data: 'devis_pwd=' + devis_pwd + '&token=getdevis_pwd',
                dataType: 'html',
                success: function(data) {

                    if (data != "") {
                        // console.log(data)
                        $("#mdp_valid_msg").html(data);
                        $("#form_devis").prop('disabled', false);
                    } else {
                        // console.log(msg_invalid)
                        $("#mdp_valid_msg").html(msg_invalid);
                        $("#form_devis").prop('disabled', true);
                    }

                },
                error: function() {
                    alert("Error");
                }
            });
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
                totalHtCalculate($("#price_" + row).attr('id'));
                $("#filter_popup").modal("hide")
            } else {
                alert("Le stock de la pièce est vide");
            }
        }

        function loadModal(row) {
            $("#estimate_row").val(row);
            $("#filter_popup").modal("show")
        }
    </script>

</body>

</html>

<?php include('../footer.php'); ?>