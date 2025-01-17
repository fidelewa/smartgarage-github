<?php include('../header.php') ?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
    $wms->deleteRepairCar($link, $_GET['id']);
    $delinfo = 'block';
    $msg = "Suppression de la facture réussi";
}
if (isset($_GET['m']) && $_GET['m'] == 'add') {
    $addinfo = 'block';
    $msg = "Ajout de la facture réussi";
}
if (isset($_GET['m']) && $_GET['m'] == 'up') {
    $addinfo = 'block';
    $msg = "Modification de la facture réussi";
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1><i class="fa fa-list"></i> Liste des factures de réparation attribuées à des véhicules</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Liste des factures de réparation attribuées à des véhicules</li>
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
            <!-- <div align="right" style="margin-bottom:1%;"><a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/repaircar_reception.php" data-original-title="Créer un nouveau formulaire de réception de véhicule"><i class="fa fa-plus"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a></div> -->
            <div class="box box-success">
                <div class="box-header">
                    <!-- <h3 class="box-title"><i class="fa fa-list"></i> Voiture de réparation List</h3> -->
                    <h3 class="box-title"><i class="fa fa-list"></i> Liste des factures de réparation attribuées à des véhicules</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table sakotable table-bordered table-striped dt-responsive">
                        <thead>
                            <tr>
                                <th>N° Facture</th>
                                <th>Nom du client</th>
                                <th>Téléphone</th>
                                <th>Immatriculation</th>
                                <th>Marque</th>
                                <th>Modèle</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $wms->getAllRepairCarSimuDevisFactureList($link);

                            // var_dump($result);
                            // die();

                            foreach ($result as $row) {

                                ?>
                                <tr>
                                    <td><span class="label label-success"><?php echo $row['facture_id']; ?></span></td>
                                    <td><?php echo $row['nom_client']; ?></td>
                                    <td><?php echo $row['numero_tel_client']; ?></td>
                                    <td><?php echo $row['imma_vehi_client']; ?></td>
                                    <td><?php echo $row['marque_vehi_client']; ?></td>
                                    <td><?php echo $row['model_vehi_client']; ?></td>
                                    <td>
                                    <!-- <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_devis_facture_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&devis_id=<?php echo $row['devis_id']; ?>" data-original-title="Consulter la facture"><i class="fa fa-file-text-o"></i></a> -->
                                    <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>estimate/repaircar_simu_devis_facture_doc.php?devis_id=<?php echo $row['devis_id']; ?>" data-original-title="Consulter la facture"><i class="fa fa-file-text-o"></i></a>    
                                    <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>estimate/repaircar_devis_facture_simu_update.php?facture_id=<?php echo $row['facture_id']; ?>" data-original-title="Editer la facture"><i class="fa fa-edit"></i></a> 
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

        $(document).ready(function() {
            setTimeout(function() {
                $("#me").hide(8000);
                $("#you").hide(8000);
            }, 8000);
        });
    </script>
    <?php include('../footer.php'); ?>