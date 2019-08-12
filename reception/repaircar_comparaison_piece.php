<?php
include('../header.php');

$wms = new wms_core();
$row = $wms->getRepairCarDiagnosticInfoByDiagId($link, $_GET['vehi_diag_id']);

// var_dump($row);
// die();

// Déclaration et initialisation du compteur de boucle
$i = 0;

$button_text = "Enregistrer information";

// Lorsqu'on soumet ou valide le formulaire
if (isset($_POST) && !empty($_POST)) {

    // var_dump($_POST['estimate_data']);

    // die();

    // Insertion de chaque enregistrement de l'array en BDD 
    foreach ($_POST['estimate_data'] as $estimate) {

        // Formulation de la requête
        $query = "INSERT INTO tbl_compar_prix_piece_rechange (designation_piece_rechange, marque_piece_rechange, qte_piece_rechange, prix_piece_rechange, supplier_id, repaircar_diagnostic_id) 
        VALUES ('$estimate[designation_piece_rechange]','$estimate[marque_piece_rechange]',
        '$estimate[qte_piece_rechange]','$estimate[prix_piece_rechange]','$estimate[supplier_id_piece_rechange]',
        '$_GET[vehi_diag_id]'
        )";

        // Exécution de la requête
        $result = mysql_query($query, $link);

        // S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
        if (!$result) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $query;
            die($message);
        } else {
            // Redirection vers la liste des diagnostic des véhicules
            $url = WEB_URL . 'reception/repaircar_diagnostic_list.php?m=add_compar_prix_piece_rechange';
            header("Location: $url");
        }
    }
}

?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">


<body>

    <section class="content-header">
        <h1> Formulaire de comparaison des prix des pièces de rechange par fournisseurs
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
                            <a class="btn btn-warning" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/repaircar_diagnostic_list.php" data-original-title="Retour"><i class="fa fa-reply"></i></a> </div>

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
                                            <table class="table dt-responsive">
                                                <thead>
                                                    <tr>
                                                        <!-- <th scope="col" align="justify">N°</th> -->
                                                        <th style="text-align:center">Désignations</th>
                                                        <th style="text-align:center">Marque</th>
                                                        <th style="text-align:center">Quantités</th>
                                                        <!-- <th style="text-align:center">Prix</th> -->
                                                        <th style="text-align:center">Prix Unitaire</th>
                                                        <th style="text-align:center">Fournisseurs</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    // On délinéarise l'array
                                                    // $estimate_data = unserialize($row['estimate_data']);
                                                    $estimate_data = json_decode($row['estimate_data'], true);

                                                    // On récupère la liste de tous les fournisseurs
                                                    $supplierList = $wms->getAllSuppliers($link);

                                                    // On parcours la liste des fournisseurs
                                                    foreach ($supplierList as $supplier) {

                                                        // Pour chaque fournisseur, on affiche les informations concernant
                                                        // les pièces de rechange
                                                        foreach ($estimate_data as $estimate) { ?>

                                                            <tr>
                                                                <td><?php echo str_replace('u0027', "'", $estimate['designation']); ?></td>
                                                                <td><input type="text" name="estimate_data[<?php echo $i; ?>][marque_piece_rechange]" class="form-control" placeholder="Renseigner la marque de la pièce proposé par ce fournisseur" /></td>
                                                                <td><?php echo $estimate['quantity']; ?></td>
                                                                <td><input required type="text" name="estimate_data[<?php echo $i; ?>][prix_piece_rechange]" class="form-control" placeholder="Renseigner le prix proposé par ce fournisseur" /></td>
                                                                <td><?php echo $supplier['s_name']; ?></td>
                                                            </tr>

                                                            <input type="hidden" value="<?php echo $estimate['designation']; ?>" name="estimate_data[<?php echo $i; ?>][designation_piece_rechange]" />
                                                            <input type="hidden" value="<?php echo $estimate['quantity']; ?>" name="estimate_data[<?php echo $i; ?>][qte_piece_rechange]" />
                                                            <input type="hidden" value="<?php echo $supplier['supplier_id']; ?>" name="estimate_data[<?php echo $i; ?>][supplier_id_piece_rechange]" />
                                                            <?php $i++;
                                                        }
                                                    } ?>
                                                </tbody>
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