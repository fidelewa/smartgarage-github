<?php
include_once('../header.php');
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
  $wms->deleteCustomer($link, $_GET['id']);
  $delinfo = 'block';
}
if (isset($_GET['m']) && $_GET['m'] == 'add') {
  $addinfo = 'block';
  $msg = "Véhicule mis en attente de reception et de scannage";
}
// if (isset($_GET['m']) && $_GET['m'] == 'up') {
//   $addinfo = 'block';
//   $msg = "Informations client mises à jour avec succès";
// }
?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1> <i class="fa fa-list"></i> Liste des véhicules à réceptionner et à scanner </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Liste des véhicules à réceptionner et à scanner</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Full Width boxes (Stat box) -->
    <div class="row">
        <div class="col-xs-12">
            <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-ban"></i> Suppression!</h4>
                <?php echo $msg; ?>
            </div>
            <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-check"></i> Succès!</h4>
                <?php echo $msg; ?>
            </div>
            <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>user/adduser.php" data-original-title="Ajouter un utilisateur"><i class="fa fa-plus"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a> </div>
            <div class="box box-success">
                <!-- <div class="box-header">
                    <h3 class="box-title">Liste des véhicules à scanner</h3>
                </div> -->
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table sakotable table-bordered table-striped dt-responsive">
                        <thead>
                            <tr>
                                <th>Immatriculation</th>
                                <th>Marque</th>
                                <th>Modèle</th>
                                <th>Scanner mécanique</th>
                                <th>Scanner électrique</th>
                                <th>Frais de scanner</th>
                                <th>Statut scanner</th>
                                <th>Statut reception</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $results = $wms->getCarScanning($link);
                            foreach ($results as $row) {
                                // $image = WEB_URL . 'img/no_image.jpg';
                                // if(file_exists(ROOT_PATH . '/img/upload/' . $row['usr_image']) && $row['usr_image'] != ''){
                                // 	$image = WEB_URL . 'img/upload/' . $row['usr_image'];
                                // }
                                ?>
                                <tr>
                                    <td><?php echo $row['imma_vehi_client']; ?></td>
                                    <td><?php echo $row['marque_vehi_client']; ?></td>
                                    <td><?php echo $row['model_vehi_client']; ?></td>
                                    <td><?php echo $row['scanner_mecanique']; ?></td>
                                    <td><?php echo $row['scanner_electrique']; ?></td>
                                    <td><?php echo $row['frais_scanner']; ?></td>
                                    <td><?php
                                        if ($row['statut_scannage'] == null) {
                                            echo "<span class='label label-default'>En attente de scan</span> <br/>";
                                        } else if ($row['statut_scannage'] == 1) {
                                            echo "<span class='label label-success'>Scan effectué</span> <br/>";
                                        }
                                        ?></td>
                                    <td><?php
                                        if ($row['statut_reception'] == null) {
                                            echo "<span class='label label-default'>En attente de reception</span> <br/>";
                                        } else if ($row['statut_reception'] == 1) {
                                            echo "<span class='label label-success'>Reception effectuée</span> <br/>";
                                        }
                                        ?></td>
                                    <td>
                                    <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>servcli_panel/recu_paiement_scanner.php?vehicule_scanning_id=<?php echo $row['id']; ?>" data-original-title="Afficher le reçu de paiement du scanner"><i class="fa fa-file-text-o"></i></a>
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
        function deleteSupplier(Id) {
            var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?");
            if (iAnswer) {
                window.location = '<?php echo WEB_URL; ?>user/userlist.php?id=' + Id;
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