<?php
include('../header.php');

// Déclaration et initialisation du compteur de boucle
$row = 0;
$supplier_manage_data = array();
$hdnid = "0";
$model_post_token = 0;
$button_text = "Enregistrer les informations";

if (isset($_POST) && !empty($_POST)) {

    // var_dump($_POST);
    // die();

    // Persister les données du devis en BDD

    // Linéarisation de l'array des données des devis pour le stocker en base de données
    // $supplier_manage_data = json_encode($_POST['supplier_manage_data'], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

    foreach ($_POST['supplier_manage_data'] as $supplier_compta_data) {

        $supplier_compta_data['date'] = $wms->datepickerDateToMySqlDate($supplier_compta_data['date']);

        $supplier_compta_data['debit'] = (float)$supplier_compta_data['debit'];
        $supplier_compta_data['credit'] = (float)$supplier_compta_data['credit'];
        $supplier_compta_data['balance'] = (float)$supplier_compta_data['balance'];

        $supplier_compta_data['supplier_id'] = (int)$supplier_compta_data['supplier_id'];

        // var_dump($supplier_compta_data['supplier_id']);
        // die();
        
        $rslt = $wms->getInfoComptaByRef($link, $supplier_compta_data['reference']);

        if(empty($rslt) && $supplier_compta_data['date'] != '0000-00-00'){

            // Formulation de la requête
        $query = "INSERT INTO tbl_ges_four_compta (ges_four_compta_date, tbl_ges_four_compta_ref, ges_four_compta_lib, debit, credit, solde, supplier_id, hdid) 
        VALUES (
        '$supplier_compta_data[date]',
        '$supplier_compta_data[reference]',
        '$supplier_compta_data[libelle]', 
        '$supplier_compta_data[debit]',
        '$supplier_compta_data[credit]',
        '$supplier_compta_data[balance]',
        '$supplier_compta_data[supplier_id]',
        '$supplier_compta_data[hdid]')";
    
            // Exécution de la requête
            $result = mysql_query($query, $link);
    
            // S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
            // if (!$result) {
            //     $message  = 'Invalid query: ' . mysql_error() . "\n";
            //     $message .= 'Whole query: ' . $query;
            //     die($message);
            // }

        }
    }

    // Redirection vers la liste des devis
    $url = WEB_URL . 'supplier/supplierManage.php?m=add';
    header("Location: $url");
}

// Création du numéro du bon de commande généré automatiquement
$hdid = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des flux financiers gérés par les fournisseurs</title>
    <style>
        /* Echaffaudage #2 */
        /* [class*="col-"] {
            border: 1px dotted rgb(0, 0, 0);
            border-radius: 1px;
        } */
    </style>
</head>

<body>

    <section class="content-header">
        <h1> Fournisseurs - Fiche de gestion des fournisseurs</h1>
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
                            <!-- <button type="button" onclick="javascript:window.print();" class="btn btn-danger btnsp"><i class="fa fa-print" data-original-title="imprimer"></i></button> -->
                            <button class="btn btn-success" type="submit" data-toggle="tooltip" href="javascript:;" data-original-title="<?php echo $button_text; ?>"><i class="fa fa-save"></i></button>
                            <a class="btn btn-warning" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>supplier/supplierManage.php" data-original-title="Retour"><i class="fa fa-reply"></i></a>

                            <div class="box box-success">

                                <div class="box-body">

                                    <?php

                                    // On récupère les données comptables correspondant à un fournisseur spécifique 
                                    $supplier_compta_data = $wms->getInfoComptaBySupplierId($link, $_GET['supplier_id']);

                                    // var_dump($supplier_compta_data);
                                

                                    // S'il n'y a aucune donnée comptable correspondant à ce fournisseur spécifique
                                    if (empty($supplier_compta_data)) {

                                        // On récupère les bons de commande associé au fournisseur spécifié
                                        $supplier_manage_data = $wms->getSupplierInfoBySupplierIdAndBcmd($link, $_GET['supplier_id']);

                                        // var_dump($supplier_manage_data);

                                        if (!empty($supplier_manage_data) && count($supplier_manage_data) > 0) {
                                            ?>

                                            <div class="col-md-4 col-md-onset-8">
                                                <p style="text-align:left;font-size:11pt;font-weight:bold;">NOM DU FOURNISSEUR &nbsp;: <?php echo $supplier_manage_data[0]['s_name'] ?></p>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <div class="table-responsive">
                                                    <table id="labour_table" class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align:center"><?php echo strtoupper("Dates"); ?></th>
                                                                <th style="text-align:center"><?php echo strtoupper("Reference"); ?></th>
                                                                <th style="text-align:center"><?php echo strtoupper("Libelle"); ?></th>
                                                                <th style="text-align:center"><?php echo strtoupper("Debit"); ?></th>
                                                                <th style="text-align:center"><?php echo strtoupper("Credit"); ?></th>
                                                                <th style="text-align:center"><?php echo strtoupper("Balance"); ?></th>
                                                                <th>&nbsp;</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($supplier_manage_data as $supplier_data) { ?>
                                                                <tr id="supplier-data-row<?php echo $row; ?>">
                                                                    <td class="text-right"><input id="date_<?php echo $row; ?>" type="text" value="<?php echo date_format(date_create($row['boncmde_date_creation']), 'd/m/Y'); ?>" name="supplier_manage_data[<?php echo $row; ?>][date]" class="form-control datepicker" /></td>
                                                                    <td class="text-right"><input id="reference_<?php echo $row; ?>" type="text" value="<?php echo $supplier_data['boncmde_num']; ?>" name="supplier_manage_data[<?php echo $row; ?>][reference]" class="form-control" /></td>
                                                                    <td class="text-right"><input id="libelle_<?php echo $row; ?>" type="text" name="supplier_manage_data[<?php echo $row; ?>][libelle]" value="<?php echo $supplier_data['boncmde_designation']; ?>" class="form-control" /></td>
                                                                    <td class="text-right"><input id="debit_<?php echo $row; ?>" name="supplier_manage_data[<?php echo $row; ?>][debit]" type="text" value="0.00" class="form-control eFireDebit" /></td>
                                                                    <td class="text-right"><input id="credit_<?php echo $row; ?>" name="supplier_manage_data[<?php echo $row; ?>][credit]" type="text" value="0.00" class="form-control eFireCredit" /></td>
                                                                    <td class="text-right"><input readonly id="balance_<?php echo $row; ?>" name="supplier_manage_data[<?php echo $row; ?>][balance]" type="text" value="0.00" class="form-control" /></td>
                                                                    <td class="text-left"><button type="button" onclick="$('#supplier-data-row<?php echo $row; ?>').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                                                </tr>
                                                                <input type="hidden" name="supplier_manage_data[<?php echo $row; ?>][supplier_id]" value="<?php echo $_GET['supplier_id']; ?>" />
                                                                <input type="hidden" name="supplier_manage_data[<?php echo $row; ?>][bon_cmde_type]" value="<?php echo $supplier_data['bon_cmde_type']; ?>" />
                                                                <input type="hidden" name="supplier_manage_data[<?php echo $row; ?>][hdid]" value="<?php echo $hdid; ?>" />
                                                                <?php $row++;
                                                            } ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="6"></td>
                                                                <td class="text-left"><button type="button" onclick="addEstimate();" data-toggle="tooltip" title="Ajouter une ligne" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                                            </tr>

                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>

                                        <?php }
                                } else { // S'il y'a des données comptables correspondant à ce fournisseur spécifique 

                                    // var_dump($supplier_compta_data);
                                    ?>

                                        <div class="col-md-4 col-md-onset-8">
                                            <p style="text-align:left;font-size:11pt;font-weight:bold;">NOM DU FOURNISSEUR &nbsp;: <?php echo $supplier_compta_data[0]['s_name'] ?></p>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <div class="table-responsive">
                                                <table id="labour_table" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align:center"><?php echo strtoupper("Dates"); ?></th>
                                                            <th style="text-align:center"><?php echo strtoupper("Reference"); ?></th>
                                                            <th style="text-align:center"><?php echo strtoupper("Libelle"); ?></th>
                                                            <th style="text-align:center"><?php echo strtoupper("Debit"); ?></th>
                                                            <th style="text-align:center"><?php echo strtoupper("Credit"); ?></th>
                                                            <th style="text-align:center"><?php echo strtoupper("Balance"); ?></th>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($supplier_compta_data as $supplier_data) { 
                                                            ?>

                                                            <tr id="supplier-data-row<?php echo $row; ?>">
                                                                <td class="text-right"><input id="date_<?php echo $row; ?>" type="text" value="<?php echo date_format(date_create($supplier_data['ges_four_compta_date']), 'd/m/Y'); ?>" name="supplier_manage_data[<?php echo $row; ?>][date]" class="form-control datepicker" /></td>
                                                                <td class="text-right"><input id="reference_<?php echo $row; ?>" type="text" value="<?php echo $supplier_data['tbl_ges_four_compta_ref']; ?>" name="supplier_manage_data[<?php echo $row; ?>][reference]" class="form-control" /></td>
                                                                <td class="text-right"><input id="libelle_<?php echo $row; ?>" type="text" name="supplier_manage_data[<?php echo $row; ?>][libelle]" value="<?php echo $supplier_data['ges_four_compta_lib']; ?>" class="form-control" /></td>
                                                                <td class="text-right"><input id="debit_<?php echo $row; ?>" name="supplier_manage_data[<?php echo $row; ?>][debit]" type="text" value="<?php echo $supplier_data['debit']; ?>" class="form-control eFireDebit" /></td>
                                                                <td class="text-right"><input id="credit_<?php echo $row; ?>" name="supplier_manage_data[<?php echo $row; ?>][credit]" type="text" value="<?php echo $supplier_data['credit']; ?>" class="form-control eFireCredit" /></td>
                                                                <td class="text-right"><input readonly id="balance_<?php echo $row; ?>" name="supplier_manage_data[<?php echo $row; ?>][balance]" type="text" value="<?php echo $supplier_data['solde']; ?>" class="form-control" /></td>
                                                                <td class="text-left"><button type="button" onclick="$('#supplier-data-row<?php echo $row; ?>').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                                            </tr>
                                                            <input type="hidden" name="supplier_manage_data[<?php echo $row; ?>][supplier_id]" value="<?php echo $_GET['supplier_id']; ?>" />
                                                            <input type="hidden" name="supplier_manage_data[<?php echo $row; ?>][bon_cmde_type]" value="<?php echo $supplier_data['bon_cmde_type']; ?>" />
                                                            <input type="hidden" name="supplier_manage_data[<?php echo $row; ?>][hdid]" value="<?php echo $hdid; ?>" />
                                                            <?php $row++;
                                                        } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6"></td>
                                                            <td class="text-left"><button type="button" onclick="addEstimate();" data-toggle="tooltip" title="Ajouter une ligne" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                                        </tr>

                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>

                                    <?php } ?>
                                </div>

                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
            </section>
        </form>
    </div>

    <input type="hidden" id="estimate_row" value="" />

    <script>
        var row = <?php echo $row; ?>;
        var sid = <?php echo $_GET['supplier_id']; ?>;
        var hdid = <?php echo $hdid; ?>;

        // Somme des soldes
        var somBalance = 0;

        function addEstimate() {
            html = '<tr id="supplier-data-row' + row + '">';
            html += '  <td class="text-right"><input id="date_' + row + '" type="text" name="supplier_manage_data[' + row + '][date]" value="" class="form-control datepicker"></td>';
            html += '  <td class="text-right"><input id="reference_' + row + '" type="text" name="supplier_manage_data[' + row + '][reference]" value="" class="form-control"></td>';
            html += '  <td class="text-right"><input id="libelle_' + row + '" type="text" name="supplier_manage_data[' + row + '][libelle]" value="" class="form-control" /></td>';
            html += '  <td class="text-right"><input type="text" id="debit_' + row + '" name="supplier_manage_data[' + row + '][debit]" value="0.00" class="form-control eFireDebit" /></td>';
            html += '  <td class="text-right"><input type="text" id="credit_' + row + '" name="supplier_manage_data[' + row + '][credit]" value="0.00" class="form-control eFireCredit" /></td>';
            html += '  <td class="text-right"><input readonly type="text" id="balance_' + row + '" name="supplier_manage_data[' + row + '][balance]" value="0.00" class="form-control" /></td>';
            html += '  <td class="text-left"><button type="button" onclick="$(\'#supplier-data-row' + row + '\').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';
            html += ' <input type="hidden" name="supplier_manage_data[' + row + '][supplier_id]" value="'+sid+'" />';
            html += ' <input type="hidden" name="supplier_manage_data[' + row + '][hdid]" value="'+hdid+'" />';
            $('#labour_table tbody').append(html);
            row++;

            $(".eFireDebit").change(function() {
                // Cette fonction récupère l'id de l'élément qui possède la classe eFireDebit
                // console.log("eFireDebit");
                balanceCalculate(this.id);
            });

            $(".eFireCredit").change(function() {
                // Cette fonction récupère l'id de l'élément qui possède la classe eFireCredit
                // console.log("eFireCredit");
                balanceCalculate(this.id);
            });
        }

        function balanceCalculate(id) {

            // Déclaration et initialisation des variables
            var montDebit = 0;
            var montCredit = 0;
            var montBalance = 0;

            var row_id = id.split('_')[1];

            // On récupère la valeur du montant du debit
            if ($("#debit_" + row_id).val() != '') {
                montDebit = $("#debit_" + row_id).val();
            }

            // On récupère la valeur du montant du crédit
            if ($("#credit_" + row_id).val() != '') {
                montCredit = $("#credit_" + row_id).val();
            }

            // Calcul de la balance
            if (montCredit != 0) {
                montBalance = parseFloat(montBalance) - parseFloat(montCredit);
            }

            if (montDebit != 0) {
                montBalance = parseFloat(montBalance) + parseFloat(montDebit);
            }

            // Calcul des la sommes des soldes
            somBalance = somBalance + montBalance;

            console.log(somBalance);

            $("#balance_" + row_id).val(somBalance);

        }

        // Au chargement du DOM
        $(document).ready(function() {

            $(".eFireDebit").change(function() {
                // Cette fonction récupère l'id de l'élément qui possède la classe eFireDebit
                balanceCalculate(this.id);
            });

            $(".eFireCredit").change(function() {
                // Cette fonction récupère l'id de l'élément qui possède la classe eFireCredit
                balanceCalculate(this.id);
            });
        });
    </script>

</body>

</html>
<?php
include('../footer.php'); ?>