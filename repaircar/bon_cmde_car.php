<?php
include('../header.php');

// Déclaration et initialisation du compteur de boucle
$row = 0;
$bcmd_manage_data = array();
$button_text = "Enregistrer les informations";
$boncmde_num = "";
$boncmde_date_creation = "";
$boncmde_date_livraison = "";

// $rows = $wms->getComparPrixPieceRechangeMinByDiagId($link, $_GET['vehi_diag_id']);

if (isset($_POST) && !empty($_POST)) {

    // var_dump($_POST);
    // die();

    // Persister les données du devis en BDD

    // Linéarisation de l'array des données des commandes pour le stocker en base de données
    $bcmd_manage_data_json = json_encode($_POST['bcmd_manage_data'], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

    // On persiste les données en BDD
    $wms->saveUpdateBonCmdeInfo($link, $_POST, $bcmd_manage_data_json);
    if ((int) $_POST['boncmde_id'] > 0) {
        $url = WEB_URL . 'bon_cmde/boncmdeList.php?m=up';
        header("Location: $url");
    } else {
        // $url = WEB_URL . 'bon_cmde/boncmdeList.php?m=add';
        // Redirection vers la liste des bons de commandes du véhicule concerné
        $url = WEB_URL . 'repaircar/liste_bcmde_vehicule.php?car_id=' . $_POST['car_id'];
        header("Location: $url");
    }
    exit();
}

if (isset($_GET['boncmde_id']) && $_GET['boncmde_id'] != '') {
    $rec = $wms->getBonCmdeById($link, $_GET['boncmde_id']);

    if (!empty($rec)) {
        $sup_id = $rec['supplier_id'];
        $boncmde_num = $rec['boncmde_num'];
        $boncmde_date_creation = date_format(date_create($rec['boncmde_date_creation']), 'd/m/Y');
        $boncmde_date_livraison = date_format(date_create($rec['boncmde_date_livraison']), 'd/m/Y');
        var_dump($rec);
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bon de commande</title>
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
        <h1> Véhicules - liste des véhicules des clients - création d'un bon de commande</h1>
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
                            <?php if (!empty($rec)) { ?>
                                <a class="btn btn-warning" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/liste_bcmde_vehicule.php?car_id=<?php echo $rec['car_id']; ?>" data-original-title="Retour"><i class="fa fa-reply"></i></a>
                            <?php } else { ?>
                                <a class="btn btn-warning" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/liste_bcmde_vehicule.php?car_id=<?php echo $_GET['car_id']; ?>" data-original-title="Retour"><i class="fa fa-reply"></i></a>
                            <?php } ?>
                            <div class="box box-success">
                                <div class="box-header" align="left">
                                    <h3 class="box-title"><i class="fa fa-plus"></i> Formulaire de création d'un bon de commande</h3>
                                </div>
                                <div class="box-body">

                                    <div class="row" style="margin-bottom:50px;">
                                        <div class="col-md-6 col-md-offset-6">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="num_bcmd" class="col-md-6 col-form-label">N° bon de commande :</label>
                                                    <div class="col-md-6">
                                                        <input type="text" id="num_bcmd" name="num_bcmd" value="<?php echo $boncmde_num; ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="date_bcmd" class="col-md-6 col-form-label">Date :</label>
                                                    <div class="col-md-6">
                                                        <input type="text" id="date_bcmd" name="date_bcmd" value="<?php echo $boncmde_date_creation; ?>" class="datepicker form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="date_bcmd" class="col-md-6 col-form-label">Fournisseur :</label>
                                                    <div class="col-md-6">
                                                        <select class="form-control" name="four" id="four">
                                                            <option value=''>--Sélectionnez un fournisseur--</option>
                                                            <?php
                                                            $result = $wms->getAllSuppliers($link);
                                                            foreach ($result as $ligne) {
                                                                if ($sup_id > 0 && $sup_id == $ligne['supplier_id']) {
                                                                    echo "<option selected value='" . $ligne['supplier_id'] . "'>" . $ligne['s_name'] . "</option>";
                                                                } else {
                                                                    echo "<option value='" . $ligne['supplier_id'] . "'>" . $ligne['s_name'] . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="date_livraison_bcmd" class="col-md-6 col-form-label">Date de livraison :</label>
                                                    <div class="col-md-6">
                                                        <input type="text" id="date_livraison_bcmd" name="date_livraison_bcmd" value="<?php echo $boncmde_date_livraison; ?>" class="datepicker form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <div class="table-responsive">
                                                <table id="labour_table" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align:center">Code/désignation</th>
                                                            <th style="text-align:center">Quantité</th>
                                                            <th style="text-align:center">Observation</th>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php

                                                        // Déclaration et initialisation du array de la liste des données du devis
                                                        // $boncmde_data = array();

                                                        if (!empty($rec)) {

                                                            $boncmde_data_json = json_decode($rec['boncmde_data'], true);
                                                            foreach ($boncmde_data_json as $row_boncmde_data) {

                                                                ?>

                                                                <tr id="supplier-data-row<?php echo $row; ?>">
                                                                    <td class="text-right"><input id="code_desi_<?php echo $row; ?>" type="text" value="<?php echo str_replace('u0027', "'", $row_boncmde_data['designation']); ?>" name="bcmd_manage_data[<?php echo $row; ?>][designation]" class="form-control" /></td>
                                                                    <td class="text-right"><input id="qte_<?php echo $row; ?>" type="number" value="<?php echo $row_boncmde_data['qte']; ?>" name="bcmd_manage_data[<?php echo $row; ?>][qte]" class="form-control" /></td>
                                                                    <td class="text-right"><input id="obs_<?php echo $row; ?>" type="text" value="<?php echo str_replace('u0027', "'", $row_boncmde_data['obs']); ?>" name="bcmd_manage_data[<?php echo $row; ?>][obs]" class="form-control" /></td>
                                                                    <td class="text-left"><button type="button" onclick="$('#supplier-data-row<?php echo $row; ?>').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                                                </tr>
                                                                <?php $row++;
                                                            }?>

                                                            <input type="hidden" name="boncmde_id" value="<?php echo $rec['boncmde_id']; ?>" />
                                                    <?php } ?>
                                                        

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3"></td>
                                                            <td class="text-left"><button type="button" onclick="addEstimate();" data-toggle="tooltip" title="Ajouter une ligne" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
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

    <input type="hidden" id="estimate_row" value="0" />

    <script>
        var row = <?php echo $row; ?> ;
        var boncmde_id = <?php if(isset($_GET['boncmde_id']) && $_GET['boncmde_id'] != '') {echo $_GET['boncmde_id'];} else {echo 0;} ?> ;
        var car_id = <?php if (isset($_GET['car_id']) && $_GET['car_id'] != '') {echo $_GET['car_id'];} else {echo 0;}?> ;

        function addEstimate() {
            html = '<tr id="supplier-data-row' + row + '">';
            html += '  <td class="text-right"><input id="code_desi' + row + '" type="text" name="bcmd_manage_data[' + row + '][designation]" value="" class="form-control"></td>';
            html += '  <td class="text-right"><input id="qte_' + row + '" type="number" name="bcmd_manage_data[' + row + '][qte]" value="" class="form-control"></td>';
            html += '  <td class="text-right"><input id="obs_' + row + '" type="text" name="bcmd_manage_data[' + row + '][obs]" value="" class="form-control" /></td>';
            html += '  <td class="text-left"><button type="button" onclick="$(\'#supplier-data-row' + row + '\').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';
            html += ' <input type="hidden" name="boncmde_id" value="' + boncmde_id + '" />'
            html += ' <input type="hidden" name="car_id" value="' + car_id + '" />'
            $('#labour_table tbody').append(html);
            row++;
        }
    </script>

</body>

</html>
<?php
include('../footer.php'); ?>