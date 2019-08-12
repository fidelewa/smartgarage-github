<?php
include('../header.php');

// Déclaration et initialisation du compteur de boucle
$row = 0;
$depense_car_data = array();
$button_text = "Enregistrer les informations";
// $boncmde_num = "";
$boncmde_date_creation = "";
$boncmde_date_livraison = "";


// On récupère la liste de tous les bons de commande
$listBcmde = $wms->getAllBonCmde($link);

// var_dump($listBcmde);

// S'il y a au moin un enregistrement dans la table des bons de commande
if (!empty($listBcmde) && count($listBcmde) > 0) {

    // On parcours la liste des bons de commande
    foreach ($listBcmde as $bcmde) {
        // var_dump($bcmde);

        // On récupère l'identifiant du dernier bon de commande enregistré
        // Puis on sort de la boucle
        $bcmde_num = $bcmde['boncmde_num'];
    }

    // On ajoute 1 à ce numéro de bon de commande pour avoir le numéro du bon de commande suivant
    $nextNumBcmde = (int) $bcmde_num;
    $boncmde_num = $nextNumBcmde + 1;
    // var_dump($boncmde_num);

} else {

    $boncmde_num = "000100";
}


if (isset($_POST) && !empty($_POST)) {

    // var_dump($_POST);
    // die();

    // Persister les données du devis en BDD

    // Linéarisation de l'array des données des commandes pour le stocker en base de données
    $depense_car_data_json = json_encode($_POST['depense_car_data'], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

    // On persiste les données en BDD
    $wms->saveUpdateBonCmdeInfo($link, $_POST, $depense_car_data_json);

    if ((int) $_POST['boncmde_id'] > 0) {

        $url = WEB_URL . 'repaircar/liste_bcmde_vehicule.php?car_id=' . $_POST['car_id'] . '&m=up';
        header("Location: $url");
    } else {

        // Redirection vers la liste des bons de commandes du véhicule concerné
        $url = WEB_URL . 'repaircar/liste_bcmde_vehicule.php?car_id=' . $_POST['car_id'] . '&m=add';
        header("Location: $url");
    }
    exit();
}

if (isset($_GET['boncmde_id']) && $_GET['boncmde_id'] != '') {
    $rec = $wms->getBonCmdeById($link, $_GET['boncmde_id']);

    // var_dump($rec);

    if (!empty($rec)) {
        $sup_id = $rec['supplier_id'];
        $boncmde_num = $rec['boncmde_num'];
        $boncmde_date_creation = date_format(date_create($rec['boncmde_date_creation']), 'd/m/Y');
        $boncmde_date_livraison = date_format(date_create($rec['boncmde_date_livraison']), 'd/m/Y');
        // var_dump($rec);
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajout d'une dépense</title>
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
        <h1> Véhicules - liste des véhicules des clients - ajout des dépenses d'un véhicule</h1>
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
                            <a class="btn btn-warning" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/carlist.php" data-original-title="Retour"><i class="fa fa-reply"></i></a>
                            <div class="box box-success">
                                <div class="box-header" align="left">
                                    <h3 class="box-title"> Formulaire d'enregistrement des dépenses du véhicule</h3>
                                </div>
                                <div class="box-body">

                                    <!-- <div class="row" style="margin-bottom:50px;">
                                        <div class="col-md-6 col-md-offset-6">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label for="num_bcmd" class="col-md-6 col-form-label">N° bon de commande :</label>
                                                    <div class="col-md-6">
                                                        <input type="text" id="num_bcmd" name="num_bcmd" value="<?php echo str_pad($boncmde_num, 6, "000", STR_PAD_LEFT); ?>" class="form-control">
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
                                    </div> -->

                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <div class="table-responsive">
                                                <table id="labour_table" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <!-- <th style="text-align:center">N°dépense</th> -->
                                                            <th style="text-align:center">Article</th>
                                                            <th style="text-align:center">Quantité</th>
                                                            <th style="text-align:center" width="200px">Coût d'achat</th>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php

                                                        // Déclaration et initialisation du array de la liste des données du devis
                                                        // $boncmde_data = array();

                                                        if (!empty($rec)) {

                                                            $depense_car_data_json = json_decode($rec['boncmde_data'], true);
                                                            foreach ($depense_car_data_json as $row_depense_car_data) {

                                                                ?>

                                                                <tr id="supplier-data-row<?php echo $row; ?>">
                                                                    <!-- <td class="text-right"><input id="num_depense_<?php echo $row; ?>" type="text" value="<?php echo $row_depense_car_data['numero']; ?>" name="depense_car_data[<?php echo $row; ?>][numero]" class="form-control" /></td> -->
                                                                    <td class="text-right"><input id="desi_article_<?php echo $row; ?>" type="text" value="<?php echo str_replace('u0027', "'", $row_depense_car_data['designation']); ?>" name="depense_car_data[<?php echo $row; ?>][designation]" class="form-control" /></td>
                                                                    <td class="text-right"><input id="qte_<?php echo $row; ?>" type="number" value="<?php echo $row_depense_car_data['qte']; ?>" name="depense_car_data[<?php echo $row; ?>][qte]" class="form-control" /></td>
                                                                    <td class="text-right"><input id="montant_<?php echo $row; ?>" type="number" value="<?php echo $row_depense_car_data['montant']; ?>" name="depense_car_data[<?php echo $row; ?>][montant]" class="form-control etotal" /></td>
                                                                    <td class="text-left"><button type="button" onclick="$('#supplier-data-row<?php echo $row; ?>').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                                                </tr>
                                                                <?php $row++;
                                                            } ?>

                                                            <input type="hidden" name="boncmde_id" value="<?php echo $rec['boncmde_id']; ?>" />
                                                            <input type="hidden" name="car_id" value="<?php echo $rec['car_id']; ?>" />
                                                        <?php } ?>


                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3"></td>
                                                            <td class="text-left"><button type="button" onclick="addEstimate();" data-toggle="tooltip" title="Ajouter une dépense" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="text-right">Total des dépenses:</td>
                                                            <td><input id="total_depense" type="text" value="" name="total_depense" class="form-control" /></td>
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
        var row = <?php echo $row; ?>;

        function addEstimate() {
            html = '<tr id="supplier-data-row' + row + '">';
            html += '  <td class="text-right"><input id="desi_article_' + row + '" type="text" name="depense_car_data[' + row + '][designation]" value="" class="form-control"></td>';
            html += '  <td class="text-right"><input id="qte_' + row + '" type="number" name="depense_car_data[' + row + '][qte]" value="" class="form-control" /></td>';
            html += '  <td class="text-right"><input id="montant_' + row + '" type="number" name="depense_car_data[' + row + '][montant]" value="" class="form-control etotal" /></td>';
            html += '  <td class="text-left"><button type="button" onclick="$(\'#supplier-data-row' + row + '\').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';
            $('#labour_table tbody').append(html);
            row++;

            $(".etotal").keyup(function() {
                // Cette fonction récupère l'id de l'élément qui possède la classe eFirePrice
                totalDepenseCalculate(this.id);
            });
        }
    </script>

</body>

</html>
<?php
include('../footer.php'); ?>