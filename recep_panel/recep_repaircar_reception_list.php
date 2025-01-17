<?php include('../header.php') ?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
    $wms->deleteRepairCar($link, $_GET['id']);
    $delinfo = 'block';
    $msg = "La voiture a été supprimée de la liste des véhicules réceptionnés";
}
if (isset($_GET['m']) && $_GET['m'] == 'add') {
    $addinfo = 'block';
    $msg = "La voiture a été ajoutée à la liste des véhicules réceptionnés";
}
if (isset($_GET['m']) && $_GET['m'] == 'etat_vehi_sortie') {
    $addinfo = 'block';
    $msg = "L'état du véhicule à la sortie à été défini avec succès !";
}
if (isset($_GET['m']) && $_GET['m'] == 'up') {
    $addinfo = 'block';
    $msg = "La voiture receptionnée a été modifiée";
}
if (isset($_GET['m']) && $_GET['m'] == 'attribution') {

    if (isset($_GET['car_id']) && isset($_GET['mecanicien_id'])) {

        $addinfo = 'block';
        // $msg = "La fiche de réception du véhicule d'identifiant " . $_GET['car_id'] . " à été attribuée au mécanicien d'identifiant " . $_GET['mecanicien_id'];
        $msg = "La fiche de réception du véhicule " . $_GET['marque'] . ' ' . $_GET['modele'] . ' ' . $_GET['imma']. " à été attribuée au mécanicien " . $_GET['mech_name'];
    }
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1><i class="fa fa-list"></i> Liste de toutes les voitures réceptionnées par <?php echo '<b>'.$_SESSION['objRecep']['name'].'</b>'; ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Liste des voitures réceptionnées</li>
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
            <div align="right" style="margin-bottom:1%;"><a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>recep_panel/recep_repaircar_reception.php" data-original-title="Créer un nouveau formulaire de réception de véhicule"><i class="fa fa-plus"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>recep_panel/recep_dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a></div>
            <div class="box box-success">
                <!-- <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-list"></i> Liste des voitures réceptionnées</h3>
                </div> -->
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

                            $result = $wms->getAllRecepRepairCarListByRecepId($link, $_SESSION['objRecep']['user_id']);

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
                                    <!-- <td><span class="label label-success"><?php echo $row['repair_car_id']; ?></span></td> -->
                                    <td><span class="label label-success"><?php echo $row['car_id']; ?></span></td>
                                    <td><?php echo $row['num_matricule']; ?></td>
                                    <td><?php echo $row['c_name']; ?></td>
                                    <td><?php echo $row['add_date_recep_vehi']; ?></td>
                                    <td><?php echo $row['add_date_assurance']; ?></td>
                                    <td><?php echo $row['add_date_visitetech']; ?></td>
                                    <!-- <td><?php echo $row['m_name']; ?></td> -->
                                    <td>

                                        <!-- <a class="btn btn-info" style="background-color:purple;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/repaircar_diagnostic.php?add_car_id=<?php echo $row['add_car_id']; ?>&car_id=<?php echo $row['car_id']; ?>" data-original-title="Créer le formulaire de diagnostic du véhicule"><i class="fa fa-plus"></i></a> -->
                                        <!-- <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc.php?car_id=<?php echo $row['car_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Fiche de reception du véhicule"><i class="fa fa-file-text-o"></i></a> -->
                                        <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc_gene.php?car_id=<?php echo $row['car_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Fiche de reception du véhicule"><i class="fa fa-file-text-o"></i></a>
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
                $("#me").hide(8000);
                $("#you").hide(8000);
            }, 8000);
        });
    </script>
    <?php include('../footer.php'); ?>