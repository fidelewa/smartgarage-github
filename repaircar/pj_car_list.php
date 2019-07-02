<?php include('../header.php') ?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
// if (isset($_GET['cid']) && isset($_GET['pjname'])) {
//     $wms->deleteRepairCar($link, $_GET['id']);
//     $delinfo = 'block';
//     $msg = "La pièce jointe a été supprimée avec succès";
// }

$row = $wms->getAllPjByCar($link, $_GET['car_id']);

// var_dump($row);
// die();

?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1> <i class="fa fa-list"></i> Liste des pièces jointes au véhicule
        <?php
        if (isset($row) && !empty($row)) {
            echo $row['car_name']. ' '. $row['model_name']. ' '. $row['VIN'];
        }
        ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Liste des pièces jointes au véhicule</li>
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
                <?php echo $msg; ?>
            </div>
            <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?php echo $msg; ?>
            </div>
            <!-- <div align="right" style="margin-bottom:1%;">
                <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/addcar.php" data-original-title="Add Voiture de réparation"><i class="fa fa-plus"></i></a>
                <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a> 
            </div> -->
            <div class="box box-success">
                <!-- <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-list"></i>
                        Liste des pièces jointes appartenant au client
                        <?php
                        if (isset($row) && !empty($row)) {
                            echo $row['c_name'];
                        }
                        ?></h3>
                </div> -->
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table sakotable table-bordered table-striped dt-responsive">
                        <thead>
                            <tr>
                                <?php

                                // Déclaration d'un array (liste) de pièces jointes vide
                                $pj_list = array();

                                if (isset($row['pj1_url']) && !empty($row['pj1_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj1_url'];
                                }
                                if (isset($row['pj2_url']) && !empty($row['pj2_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj2_url'];
                                }
                                if (isset($row['pj3_url']) && !empty($row['pj3_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj3_url'];
                                }
                                if (isset($row['pj4_url']) && !empty($row['pj4_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj4_url'];
                                }
                                if (isset($row['pj5_url']) && !empty($row['pj5_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj5_url'];
                                }
                                if (isset($row['pj6_url']) && !empty($row['pj6_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj6_url'];
                                }
                                if (isset($row['pj7_url']) && !empty($row['pj7_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj7_url'];
                                }
                                if (isset($row['pj8_url']) && !empty($row['pj8_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj8_url'];
                                }
                                if (isset($row['pj9_url']) && !empty($row['pj9_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj9_url'];
                                }
                                if (isset($row['pj10_url']) && !empty($row['pj10_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj10_url'];
                                }
                                if (isset($row['pj11_url']) && !empty($row['pj11_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj11_url'];
                                }
                                if (isset($row['pj12_url']) && !empty($row['pj12_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj12_url'];
                                }
                                ?>
                                <th>Nom des pièces jointes</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            if (!empty($pj_list)) {

                                foreach ($pj_list as $pj_name) {

                                    // Adresse de la pièce jointe sur le serveur

                                    // $pj_path = WEB_URL . 'img/upload/car/' . $pj_name;
                                    $pj_path = ROOT_PATH . '/img/upload/car/' . $pj_name;

                                    // Si la pièce jointe existe à l'emplacement spécifié et que son nom est défini
                                    // On affiche la liste des pièces jointes en faisant un lien pour les consulter
                                    if (file_exists($pj_path) && $pj_name != '') { ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo WEB_URL ?>img/upload/car/<?php echo $pj_name ?>"><?php echo $pj_name ?></a>
                                            </td>
                                            <!-- <td>
                                                <a class="btn btn-danger" data-toggle="tooltip" onClick="deletePj(<?php echo $row['customer_id'] ?>, <?php echo $pj_name ?>);" href="javascript:;" data-original-title="Supprimer"><i class="fa fa-trash-o"></i></a>
                                            </td> -->
                                        </tr>
                                    <?php }
                                }
                            } else {
                                echo "<p>Ce véhicule n'a aucune pièces jointes</p>";
                            }
                            ?>


                            <?php
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
        function deletePj(custId, pjName) {
            var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer cette pièce jointe ?");
            if (iAnswer) {
                window.location = '<?php echo WEB_URL; ?>customer/pj_client_list.php?cid=' + custId + 'pjname=' + pjName;
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