<?php
include('../header.php');

// Déclaration et initialisation du compteur de boucle
$i = 0;

$button_text = "Modifier le devis";

$wms = new wms_core();

$row = $wms->getRepairCarSimuDevis($link, $_GET['devis_id']);

// var_dump($row);
// die();

// Lorsqu'on soumet ou valide le formulaire
if (isset($_POST) && !empty($_POST)) {

    // var_dump($_POST);
    // die();

    // Linéarisation de l'array des estimations pour le stocker en base de données
    // $devis_data_2 = serialize($_POST['devis_data_2']);
    $devis_data_2 = json_encode($_POST['devis_data_2'], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

    // Initialisation de la date de la fature
    // $date_facture = date('d/m/Y');
    // $date_devis = $wms->datepickerDateToMySqlDate($_POST['date_devis']);

    // var_dump($_POST);
    // die();

    // Formulation de la requête
    $query = "UPDATE tbl_add_devis_simulation 
        SET date_devis='" . $_POST['date_devis'] . "', devis_data='" . $devis_data_2 . "',
        main_oeuvre_piece_rechange_devis='" . $_POST['main_oeuvre_piece_rechange_devis'] . "', total_ht_gene_piece_rechange_devis='" . $_POST['total_ht_gene_piece_rechange_devis'] . "',
        total_tva='" . $_POST['total_tva'] . "',total_ttc_gene_piece_rechange_devis='" . $_POST['total_ttc_gene_piece_rechange_devis'] . "',
        montant_du_piece_rechange_devis='" . $_POST['montant_du_piece_rechange_devis'] . "',
        montant_paye_piece_rechange_devis='" . $_POST['montant_paye_piece_rechange_devis'] . "'
        WHERE devis_id='" . $_GET['devis_id'] . "'";

    // echo $query;
    // die();

    // Exécution de la requête
    $result = mysql_query($query, $link);

    // S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    } else {
        // Redirection vers la liste des devis
        $url = WEB_URL . 'estimate/repaircar_simu_devis_list.php?m=up';
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
        <h1>Formulaire de modification du devis de réparation d'un véhicule
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
                                                        <th class="text-center"><b>Pièce de rechange</b></th>
                                                        <th>Désignation</th>
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
                                                    $devis_data_2 = array();

                                                    // On délinéarise l'array
                                                    // $devis_data = unserialize($row['devis_data']);
                                                    $devis_data = json_decode($row['devis_data'], true);

                                                    // var_dump($devis_data);
                                                    // die();

                                                    foreach ($devis_data as $devis) { ?>
                                                        <tr id="estimate-row<?php echo $i; ?>">
                                                            <td><input type="text" id="codepiece_<?php echo $i; ?>" value="<?php echo $devis['code_piece']; ?>" name="devis_data_2[<?php echo $i; ?>][code_piece]" class="form-control" /></td>
                                                            <td class="text-right">
                                                                <button data-toggle="tooltip" title="Ajouter une pièce de rechange à partir du stock" type="button" name="devis_data_2[<?php echo $i; ?>][button]" onClick=loadModal(<?php echo $i; ?>); class="btn btn-info btnsp"><i class="fa fa-plus"></i></button>
                                                                <input type="hidden" id="parts_id_<?php echo $i; ?>" name="devis_data_2[<?php echo $i; ?>][stock_parts]" value="<?php echo $devis->stock_parts; ?>" />
                                                            </td>
                                                            <td><input type="text" id="designation_<?php echo $i; ?>" value="<?php echo str_replace('u0027', "'", $devis['designation']); ?>" name="devis_data_2[<?php echo $i; ?>][designation]" class="form-control" /></td>
                                                            <td><input type="text" id="qty_<?php echo $i; ?>" value="<?php echo $devis['quantity']; ?>" name="devis_data_2[<?php echo $i; ?>][quantity]" class="form-control eFire allownumberonly" /></td>
                                                            <td><input type="text" id="price_<?php echo $i; ?>" value="<?php echo $devis['price']; ?>" name="devis_data_2[<?php echo $i; ?>][price]" class="form-control eFirePrice" /></td>
                                                            <td><input type="text" id="totalht_<?php echo $i; ?>" value="<?php echo $devis['total_prix_piece_rechange_devis_ht']; ?>" name="devis_data_2[<?php echo $i; ?>][total_prix_piece_rechange_devis_ht]" class="form-control allownumberonly" /></td>
                                                            <td><input type="text" id="totalttc_<?php echo $i; ?>" value="<?php echo $devis['total_prix_piece_rechange_devis_ttc']; ?>" name="devis_data_2[<?php echo $i; ?>][total_prix_piece_rechange_devis_ttc]" class="form-control allownumberonly etotal" /></td>
                                                            <td class="text-left"><button type="button" onclick="$('#estimate-row<?php echo $i; ?>').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                                        </tr>
                                                        <!-- Récupération des données du devis -->
                                                        <!-- <input type="hidden" value="<?php echo $devis['stock_parts']; ?>" name="devis_data_2[<?php echo $i; ?>][piece_rechange_id]" /> -->
                                                        
                                                        <?php $i++;
                                                    } 
                                                    ?>

                                                <input type="hidden" value="<?php echo $row['date_devis']; ?>" name="date_devis" />
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="7"></td>
                                                        <td class="text-left"><button type="button" onclick="addEstimate();" data-toggle="tooltip" title="Ajouter une estimation" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Main d'oeuvre (<?php echo $currency; ?>):</td>
                                                        <td><input id="labour" type="text" value="<?php echo $row['main_oeuvre_piece_rechange_devis']; ?>" name="main_oeuvre_piece_rechange_devis" class="form-control allownumberonly" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Total HT:</td>
                                                        <td><input id="total_ht_gene" type="text" value="<?php echo $row['total_ht_gene_piece_rechange_devis']; ?>" name="total_ht_gene_piece_rechange_devis" class="form-control" /></td>
                                                    </tr>
                                                    <!-- <tr>
                                                        <td colspan="6" class="text-right">Remise (%):</td>
                                                        <td><input required id="devis_remise" name="devis_remise" type="text" value="<?php echo $row['devis_remise']; ?>" class="form-control allownumberonly eFireRemise" /></td>
                                                    </tr> -->
                                                    <tr>
                                                        <td colspan="6" class="text-right">Total TVA (<?php echo $currency; ?>):</td>
                                                        <td><input id="total_tva" type="text" value="<?php echo $row['total_tva']; ?>" name="total_tva" class="form-control" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Total TTC (<?php echo $currency; ?>):</td>
                                                        <td><input id="total_ttc_gene" type="text" value="<?php echo $row['total_ttc_gene_piece_rechange_devis']; ?>" name="total_ttc_gene_piece_rechange_devis" class="form-control" /></td>
                                                    </tr>
                                                    <input id="total_due" name="montant_du_piece_rechange_devis" type="hidden" value="<?php echo $row['montant_du_piece_rechange_devis']; ?>" readonly class="form-control allownumberonly" />
                                                    <input id="total_paid" name="montant_paye_piece_rechange_devis" type="hidden" value="<?php echo $row['montant_paye_piece_rechange_devis']; ?>" readonly class="form-control allownumberonly" />
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- <input type="hidden" value="" name="hfDone" id="hfDone" /> -->
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
            html += '  <td class="text-right"><input id="codepiece_' + row + '" type="text" name="devis_data_2[' + row + '][code_piece]" class="form-control"></td>';
            html += '  <td class="text-right"><button data-toggle="tooltip" title="Ajouter une pièce de rechange à partir du stock" type="button" name="devis_data_2[' + row + '][button]" onClick=loadModal(' + row + '); class="btn btn-info btnsp"><i class="fa fa-plus"></i></button><input type="hidden" id="parts_id_' + row + '" name="devis_data_2[' + row + '][stock_parts]" value="0" /></td>';
            html += '  <td class="text-right"><input id="designation_' + row + '" type="text" name="devis_data_2[' + row + '][designation]" class="form-control"></td>';
            html += '  <td class="text-right"><input id="qty_' + row + '" type="text" name="devis_data_2[' + row + '][quantity]" value="0" class="form-control eFire allownumberonly" /></td>';
            html += '  <td class="text-right"><input type="text" id="price_' + row + '" name="devis_data_2[' + row + '][price]" value="0.00" class="form-control eFirePrice" /></td>';
            // html += '  <td class="text-right"><input type="text" id="remise_' + row + '" name="devis_data_2[' + row + '][remise_piece_rechange_devis_2]" value="0.00" class="form-control eFireRemise allownumberonly" /></td>';
            html += '  <td class="text-right"><input type="text" id="totalht_' + row + '" name="devis_data_2[' + row + '][total_prix_piece_rechange_devis_ht]" value="0.00" class="form-control allownumberonly" /></td>';
            html += '  <td class="text-right"><input type="text" id="totalttc_' + row + '" name="devis_data_2[' + row + '][total_prix_piece_rechange_devis_ttc]" value="0.00" class="form-control allownumberonly etotal" /></td>';
            html += '  <td class="text-left"><button type="button" onclick="$(\'#estimate-row' + row + '\').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';
            $('#labour_table tbody').append(html);
            row++;

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

        function verif_pwd() {
            devis_pwd = $("#devis_pwd").val();

            $.ajax({
                url: '../ajax/getstate.php',
                type: 'POST',
                data: 'devis_pwd=' + devis_pwd + '&token=getdevis_pwd',
                dataType: 'html',
                success: function(data) {

                    if(data != "") {
                        console.log(data)
                        $("#mdp_valid_msg").html(data);
                        $("#form_devis").prop('disabled', false);
                    } else {
                        console.log(data)
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
                $("#filter_popup").modal("hide")
            } else {
                alert("Stock Empty so you cannot add parts");
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