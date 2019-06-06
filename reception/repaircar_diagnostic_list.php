<?php include('../header.php') ?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
    $wms->deleteRepairCar($link, $_GET['id']);
    $delinfo = 'block';
    $msg = "Suppression des informations du diagnostic du véhicule réussi";
}
if (isset($_GET['m']) && $_GET['m'] == 'add') {
    $addinfo = 'block';
    $msg = "Ajout des informations du diagnostic du véhicule réussi";
}
if (isset($_GET['m']) && $_GET['m'] == 'add_compar_prix_piece_rechange') {
    $addinfo = 'block';
    $msg = "Comparatif des prix des pièces de rechange par fournisseurs ajouté avec succès";
}
if (isset($_GET['m']) && $_GET['m'] == 'up') {
    $addinfo = 'block';
    $msg = "Modification des informations du diagnostic du véhicule réussi";
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1><i class="fa fa-wrench"></i> Liste des diagnostics des véhicules réceptionnés</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Liste des diagnostics des véhicules réceptionnés</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Full Width boxes (Stat box) -->
    <div class="row">
        <div class="col-xs-12">
            <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i>
                </button>
                <h4><i class="icon fa fa-ban"></i> Deleted!</h4>
                <?php echo $msg; ?>
            </div>
            <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i>
                </button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?php echo $msg; ?>
            </div>
            <div align="right" style="margin-bottom:1%;"><a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/repaircar_reception.php" data-original-title="Créer un nouveau formulaire de réception de véhicule"><i class="fa fa-plus"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a></div>
            <div class="box box-success">
                <div class="box-header">
                    <!-- <h3 class="box-title"><i class="fa fa-list"></i> Voiture de réparation List</h3> -->
                    <h3 class="box-title"><i class="fa fa-list"></i> Liste des diagnostics des véhicules réceptionnés</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table sakotable table-bordered table-striped dt-responsive">
                        <thead>
                            <tr>
                                <th>ID Reparation</th>
                                <th>Immatriculation</th>
                                <th>Client</th>
                                <th>Date reception</th>
                                <th>Date exp. assur</th>
                                <th>Date exp. vis. tech.</th>
                                <!-- <th>Attribué à</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $wms->getAllRepairCarDiagnosticList($link);

                            // var_dump($result);

                            // die();

                            foreach ($result as $row) {

                                ?>
                                <tr>
                                    <td><span class="label label-success"><?php echo $row['repair_car_id']; ?></span></td>
                                    <td><?php echo $row['num_matricule']; ?></td>
                                    <td><?php echo $row['c_name']; ?></td>
                                    <td><?php echo $row['add_date_recep_vehi']; ?></td>
                                    <td><?php echo $row['add_date_assurance']; ?></td>
                                    <td><?php echo $row['add_date_visitetech']; ?></td>
                                    <!-- <td><?php echo $row['m_name']; ?></td> -->
                                    <td>

                                        <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_piecechange_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Consulter la fiche des pièces de rechange requis"><i class="fa fa-file-text-o"></i></a>
                                        <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_diagnostic_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>" data-original-title="Consulter la fiche de diagnostic du véhicule"><i class="fa fa-file-text-o"></i></a>
                                        <?php

                                        // On récupère l'id du diagnostic du véhicule réceptionné à faire réparer 
                                        $rows = $wms->getComparPrixPieceRechangeInfoByDiagId($link, $row['vehi_diag_id']);

                                        // S'il y a des enregistrements correspondant à cet id existant déja en BDD
                                        // On affiche l'icone de la fiche
                                        if (!empty($rows)) { ?>
                                            <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/compar_prix_piece_rechange_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>" data-original-title="Consulter la fiche de comparaison des prix des pièces de rechange par fournisseur"><i class="fa fa-file-text-o"></i></a>
                                            <!-- <a class="btn btn-info" style="background-color:orange;color:#ffffff;" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>estimate/devis_prix_piece_rechange.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>" data-original-title="Créer un devis"><i class="fa fa-plus"></i></a> -->
                                        <?php } else { ?>

                                            <a class="btn btn-info" style="background-color:purple;color:#ffffff;" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/repaircar_comparaison_piece.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>" data-original-title="Créer un formulaire de comparaison des prix des pièces de rechange par fournisseur"><i class="fa fa-plus"></i></a>

                                        <?php }

                                    // On vérifie qu'un devis confirmé par un bon de commande correspond au diagnostic courant
                                    // $rows = $wms->getComparPrixPieceRechangeInfoByDiagId($link, $row['vehi_diag_id']);
                                    $ligne = $wms->getDevisInfoByDiagId($link, $row['vehi_diag_id']);

                                    if (!empty($ligne)) {
                                        // if ($ligne['statut_reparation'] == 'Terminer') { 
                                        ?>
                                            <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_diagnostic_devis_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&devis_id=<?php echo $ligne['devis_id']; ?>" data-original-title="Consulter le devis de réparation du véhicule"><i class="fa fa-file-text-o"></i></a>

                                        <?php //}
                                    } else { ?>

                                            <a class="btn btn-info" style="background-color:orange;color:#ffffff;" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>estimate/devis_prix_piece_rechange.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>" data-original-title="Créer un devis"><i class="fa fa-plus"></i></a>

                                        <?php }

                                    $record = $wms->getFactureInfoByDiagId($link, $row['vehi_diag_id']);

                                    if (!empty($record)) {
                                        // if ($ligne['statut_reparation'] == 'Terminer') { 
                                        ?>
                                            <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_devis_facture_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&devis_id=<?php echo $ligne['devis_id']; ?>" data-original-title="Consulter la facture de réparation du véhicule"><i class="fa fa-file-text-o"></i></a>

                                        <?php //}
                                    } else { ?>

                                            <a class="btn btn-info" style="background-color:gray;color:#ffffff;" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>estimate/repaircar_devis_facture.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&devis_id=<?php echo $ligne['devis_id']; ?>" data-original-title="Créer une facture"><i class="fa fa-plus"></i></a>

                                        <?php }

                                    ?>

                                    </td>
                                </tr>
                            <?php }
                        mysql_close($link); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <script type="text/javascript">
        function deleteCustomer(Id) {
            var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer cette voiture ?");
            if (iAnswer) {
                window.location = '<?php echo WEB_URL; ?>repaircar/carlist.php?id=' + Id;
            }
        }

        $(document).ready(function() {
            setTimeout(function() {
                $("#me").hide(300);
                $("#you").hide(200000);
            }, 200000);
        });
    </script>
    <?php include('../footer.php'); ?>