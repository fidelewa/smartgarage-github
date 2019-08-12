<?php
include_once('../header.php');
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
    $wms->deleteBonCmdeInfo($link, $_GET['id']);
    $delinfo = 'block';
}
//	add success
if (isset($_SESSION['token']) && $_SESSION['token'] == 'add') {
    $addinfo = 'block';
    $msg = "Informations du devis ajouté avec succès";
    unset($_SESSION['token']);
}
//	update success
if (isset($_SESSION['token']) && $_SESSION['token'] == 'up') {
    $addinfo = 'block';
    $msg = "Informations du devis modifiées avec succès";
    unset($_SESSION['token']);
}
if (isset($_GET['bcmde_id']) && $_GET['bcmde_id'] != '' && $_GET['bcmde_id'] > 0) {
    // $wms->deleteRepairCar($link, $_GET['id']);
    $wms->deleteBcmde($link, $_GET['bcmde_id']);
    $delinfo = 'block';
    $msg = "Informations du devis supprimées avec succès";
}
// if (isset($_GET['m']) && $_GET['m'] == 'add') {
//   $_SESSION['token'] = 'add';
//   $url = WEB_URL . 'bon_cmde/boncmdeList.php';
//   header("Location: $url");
// }
// if (isset($_GET['m']) && $_GET['m'] == 'up') {
//   $_SESSION['token'] = 'up';
//   $url = WEB_URL . 'bon_cmde/boncmdeList.php';
//   header("Location: $url");
// }

$result = $wms->getAllDevisDataByCarId($link, $_GET['car_id']);

// var_dump($result);
?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1><i class="fa fa-list"></i> Liste des devis du véhicule <?php
                                                                if (isset($result) && !empty($result)) {
                                                                    echo "<b>" . $result[0]['car_name'] . ' ' . $result[0]['model_name'] . ' ' . $result[0]['VIN']. "</b>";
                                                                }
                                                                ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Liste des devis crées pour ce véhicule</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Full Width boxes (Stat box) -->
    <div class="row">
        <div class="col-xs-12">
            <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-ban"></i> Deleted!</h4>
                Suppression des informations du devis réussi.
            </div>
            <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?php echo $msg; ?>
            </div>
            <div align="right" style="margin-bottom:1%;">
                <!-- <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>bon_cmde/addBonCmde.php" data-original-title="Ajouter un devis"><i class="fa fa-plus"></i></a> -->
                <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/carlist.php" data-original-title="Retour"><i class="fa fa-reply"></i></a>
            </div>
            <div class="box box-success">
                <!-- <div class="box-header">
          <h3 class="box-title">Liste des devis crées</h3>
        </div> -->
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table sakotable table-bordered table-striped dt-responsive">
                        <thead>
                            <tr>
                                <th>N° du devis</th>
                                <!-- <th>Identifiant du devis</th> -->
                                <th>Immatriculation</th>
                                <!-- <th>Client</th> -->
                                <th>Date du devis</th>
                                <th>Date exp. assur</th>
                                <th>Date exp. vis. tech.</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
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
                                    <td><span class="label label-success"><?php echo $row['devis_id']; ?></span></td>
                                    <td><?php echo $row['VIN']; ?></td>
                                    <!-- <td><?php echo $row['c_name']; ?></td> -->
                                    <td><?php echo date_format(date_create($row['date_devis']), 'd/m/Y'); ?></td>
                                    <td><?php echo $row['add_date_assurance']; ?></td>
                                    <td><?php echo $row['add_date_visitetech']; ?></td>
                                    <td>
                                        <a class="btn btn-success" style="background-color:#CF7B00;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/liste_facture_vehicule.php?devis_id=<?php echo $row['devis_id']; ?>" data-original-title="Afficher la liste des factures du véhicule"><i class="fa fa-list"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
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
        function deleteSupplier(bcmde_id, car_id) {
            var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer ce devis ?");
            if (iAnswer) {
                window.location = '<?php echo WEB_URL; ?>repaircar/liste_bcmde_vehicule.php?car_id=' + car_id + '&bcmde_id=' + bcmde_id;
            }
        }

        $(document).ready(function() {
            setTimeout(function() {
                $("#me").hide(300);
                $("#you").hide(300);
            }, 3000);
        });
    </script>
    <?php include('../footer.php'); ?>