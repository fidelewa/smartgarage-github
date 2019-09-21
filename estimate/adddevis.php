<?php
include('../header.php');

// Déclaration et initialisation du compteur de boucle
$row = 0;
$estimate_data = array();
$hdnid = "0";
$model_post_token = 0;

// Somme des totaux des prix des pièces de rechange
// $somme_total_prix_piece_rechange = 0;

$button_text = "Enregistrer le devis";
// $form_url = WEB_URL . "estimate/adddevis_traitement.php";

// var_dump($_SESSION);

// Lorsqu'on soumet ou valide le formulaire
if (isset($_POST) && !empty($_POST)) {

    // var_dump($_POST);
    // die();

    // Persister les données du devis en BDD

    // Linéarisation de l'array des données des devis pour le stocker en base de données
    // $devis_data = serialize($_POST['estimate_data']);
    $devis_data = json_encode($_POST['estimate_data'], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

    $date_devis = date_format(date_create('now', new \DateTimeZone('Africa/Abidjan')), 'Y-m-d H:i:s');

    // Formulation de la requête
    $query = "INSERT INTO tbl_add_devis_simulation (date_devis, devis_data, main_oeuvre_piece_rechange_devis, total_ht_gene_piece_rechange_devis, 
        total_tva, total_ttc_gene_piece_rechange_devis, montant_du_piece_rechange_devis, montant_paye_piece_rechange_devis,
        devis_remise, net_payer) 
        VALUES ('$date_devis','$devis_data','$_POST[main_oeuvre_piece_rechange_devis]',
        '$_POST[total_ht_gene_piece_rechange_devis]',
        '$_POST[total_tva]',
        '$_POST[total_ttc_gene_piece_rechange_devis]', 
        '$_POST[montant_du_piece_rechange_devis]',
        '$_POST[montant_paye_piece_rechange_devis]',
        '$_POST[devis_remise]',
        '$_POST[net_payer]'
        )";

    // Exécution de la requête
    $result = mysql_query($query, $link);

    // S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }

    // S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
    // if ($result) {
        // Redirection vers la liste des devis
        $url = WEB_URL . 'estimate/repaircar_simu_devis_list.php?m=add';
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
        <h1> Devis - créer un devis de réparation
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
                                                    <?php foreach ($estimate_data as $estimate) { ?>
                                                        <tr id="estimate-row<?php echo $row; ?>">
                                                            <td class="text-right"><input id="codepiece_<?php echo $row; ?>" type="text" value="" name="estimate_data[<?php echo $row; ?>][code_piece]" class="form-control" /></td>
                                                            <td class="text-right">
                                                                <button data-toggle="tooltip" title="Ajouter une pièce de rechange à partir du stock" type="button" name="estimate_data[<?php echo $row; ?>][button]" onClick=loadModal(<?php echo $row; ?>); class="btn btn-info btnsp"><i class="fa fa-plus"></i></button>
                                                                <input type="hidden" id="parts_id_<?php echo $row; ?>" name="estimate_data[<?php echo $row; ?>][stock_parts]" value="<?php echo $estimate->stock_parts; ?>" />
                                                            </td>
                                                            <td class="text-right"><input id="parts_desc_<?php echo $row; ?>" type="text" value="" name="estimate_data[<?php echo $row; ?>][designation]" class="form-control" /></td>
                                                            <!-- <td class="text-right"><input id="marque_<?php echo $row; ?>" type="text" value="" name="estimate_data[<?php echo $row; ?>][marque]" class="form-control" /></td> -->
                                                            <td class="text-right"><input id="qty_<?php echo $row; ?>" type="text" name="estimate_data[<?php echo $row; ?>][quantity]" value="0" class="form-control eFireQty allownumberonly" /></td>
                                                            <td class="text-right"><input id="price_<?php echo $row; ?>" name="estimate_data[<?php echo $row; ?>][prix_piece_rechange_min_devis]" type="text" value="0.00" class="form-control eFirePrice" /></td>
                                                            <!-- <td class="text-right"><input required id="remise_<?php echo $row; ?>" name="estimate_data[<?php echo $row; ?>][remise_piece_rechange_devis]" type="text" value="" class="form-control eFireRemise" /></td> -->
                                                            <td class="text-right"><input id="totalht_<?php echo $row; ?>" name="estimate_data[<?php echo $row; ?>][total_prix_piece_rechange_devis_ht]" type="text" value="0.00" readonly class="form-control allownumberonly" /></td>
                                                            <td class="text-right"><input id="totalttc_<?php echo $row; ?>" name="estimate_data[<?php echo $row; ?>][total_prix_piece_rechange_devis_ttc]" type="text" value="0.00" readonly class="form-control allownumberonly etotal" /></td>
                                                            <td class="text-left"><button type="button" onclick="$('#estimate-row<?php echo $row; ?>').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                                        </tr>
                                                        <?php $row++;
                                                    } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="7"></td>
                                                        <td class="text-left"><button type="button" onclick="addEstimate();" data-toggle="tooltip" title="Ajouter une estimation" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Main d'oeuvre (<?php echo $currency; ?>):</td>
                                                        <td><input required id="labour" name="main_oeuvre_piece_rechange_devis" type="text" class="form-control allownumberonly" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Total HT:</td>
                                                        <td><input id="total_ht_gene" name="total_ht_gene_piece_rechange_devis" type="text" value="0.00" readonly class="form-control allownumberonly" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Remise (%):</td>
                                                        <!-- <td><input id="total_ht_gene" name="total_ht_gene_piece_rechange_devis" type="text" value="0.00" readonly class="form-control allownumberonly" /></td> -->
                                                        <td><input required id="devis_remise" name="devis_remise" type="text" value="" class="form-control allownumberonly eFireRemise" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Net à payer HT:</td>
                                                        <td><input required id="net_payer" name="net_payer" type="text" value="" class="form-control allownumberonly" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Total TVA (<?php echo $currency; ?>):</td>
                                                        <td><input id="total_tva" name="total_tva" type="text" value="0.00" readonly class="form-control allownumberonly" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="text-right">Total TTC (<?php echo $currency; ?>):</td>
                                                        <td><input id="total_ttc_gene" name="total_ttc_gene_piece_rechange_devis" type="text" value="0.00" readonly class="form-control allownumberonly" /></td>
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
        var row = <?php echo $row; ?>;

        function addEstimate() {
            html = '<tr id="estimate-row' + row + '">';
            html += '  <td class="text-right"><input id="codepiece_' + row + '" type="text" name="estimate_data[' + row + '][code_piece]" class="form-control"></td>';
            html += '  <td class="text-right"><button data-toggle="tooltip" title="Ajouter une pièce de rechange à partir du stock" type="button" name="estimate_data[' + row + '][button]" onClick=loadModal(' + row + '); class="btn btn-info btnsp"><i class="fa fa-plus"></i></button><input type="hidden" id="parts_id_' + row + '" name="estimate_data[' + row + '][stock_parts]" value="0" /></td>';
            html += '  <td class="text-right"><input id="parts_desc_' + row + '" type="text" name="estimate_data[' + row + '][designation]" class="form-control parts_list"></td>';
            html += '  <td class="text-right"><input id="qty_' + row + '" type="text" name="estimate_data[' + row + '][quantity]" value="0" class="form-control eFireQty allownumberonly" /></td>';
            html += '  <td class="text-right"><input type="text" id="price_' + row + '" name="estimate_data[' + row + '][price]" value="0.00" class="form-control eFirePrice allownumberonly" /></td>';
            html += '  <td class="text-right"><input type="text" id="totalht_' + row + '" name="estimate_data[' + row + '][total_prix_piece_rechange_devis_ht]" value="0.00" class="form-control allownumberonly" /></td>';
            html += '  <td class="text-right"><input type="text" id="totalttc_' + row + '" name="estimate_data[' + row + '][total_prix_piece_rechange_devis_ttc]" value="0.00" class="form-control allownumberonly etotal" /></td>';
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

        function verif_pwd() {
            devis_pwd = $("#devis_pwd").val();
            msg_invalid = "<div class='alert alert-warning alert-dismissable' style='display:block'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'><i class='fa fa-close'></i></button><h4> mot de passe invalide </h4></div>";

            $.ajax({
                url: '../ajax/getstate.php',
                type: 'POST',
                data: 'devis_pwd=' + devis_pwd + '&token=getdevis_pwd',
                dataType: 'html',
                success: function(data) {

                    if(data != "") {
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