<?php include('header.php') ?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
    $wms->deleteRepairCar($link, $_GET['id']);
    $delinfo = 'block';
    $msg = "Suppression du bon de commande réussi";
}
if (isset($_GET['m']) && $_GET['m'] == 'add') {
    $addinfo = 'block';
    $msg = "Ajout du bon de commande réussi";
}
if (isset($_GET['m']) && $_GET['m'] == 'up') {
    $addinfo = 'block';
    $msg = "Modification du bon de commande réussi";
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1>Liste de mes bons de commande</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Liste de mes bons de commande</li>
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
                    <h3 class="box-title"><i class="fa fa-list"></i> Liste de mes bons de commande</h3>
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
                                <!-- <th>Statut du devis</th> -->
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $wms->getAllRepairCarDevisBcmdeListByCustId($link, $_SESSION['objCust']['user_id']);

                            // var_dump($result);
                            // die();

                            foreach ($result as $row) {
                                // $image = WEB_URL . 'img/no_image.jpg';
                                // $image_customer = WEB_URL . 'img/no_image.jpg';

                                // if (file_exists(ROOT_PATH . '/img/upload/' . $row['image_vehi']) && $row['image_vehi'] != '') {
                                //     $image = WEB_URL . 'img/upload/' . $row['image_vehi']; //car image
                                // }
                                // if (file_exists(ROOT_PATH . '/img/upload/' . $row['customer_image']) && $row['customer_image'] != '') {
                                //     $image_customer = WEB_URL . 'img/upload/' . $row['customer_image']; //customer iamge
                                // }

                                ?>
                                <tr>
                                    <td><span class="label label-success"><?php echo $row['repair_car_id']; ?></span></td>
                                    <td><?php echo $row['num_matricule']; ?></td>
                                    <td><?php echo $row['c_name']; ?></td>
                                    <td><?php echo $row['add_date_recep_vehi']; ?></td>
                                    <td><?php echo $row['add_date_assurance']; ?></td>
                                    <td><?php echo $row['add_date_visitetech']; ?></td>
                                    <!-- <td><?php
                                        if ($row['confirm_devis'] == null) {
                                            echo "<span class='label label-default'>En attente de confirmation</span> <br/>";
                                        } else if ($row['confirm_devis'] == 1) {
                                            echo "<span class='label label-success'>Confirmé</span> <br/>";
                                        } else if ($row['confirm_devis'] == 0) {
                                            echo "<span class='label label-alert'>Annulé</span> <br/>";
                                        }
                                        ?></td> -->
                                    <!-- <td>
                                        <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>cust_panel/cust_repaircar_diagnostic_devis_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>&devis_id=<?php echo $row['devis_id']; ?>" data-original-title="Consulter la devis de réparation du véhicule"><i class="fa fa-file-text-o"></i></a>
                                    </td> -->
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
    <?php include('footer.php'); ?>