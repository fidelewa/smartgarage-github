<?php include('../header.php') ?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
$hdnid = "0";
// if (isset($_GET['cid']) && isset($_GET['pjname'])) {
//     $wms->deleteRepairCar($link, $_GET['id']);
//     $delinfo = 'block';
//     $msg = "La pièce jointe a été supprimée avec succès";
// }

if (isset($_GET['m']) && $_GET['m'] == 'up_photo_car_piece_change') {
    $addinfo = 'block';
    $msg = "Photo des pièces de rechange modifiée avec succès";
}

if (isset($_GET['m']) && $_GET['m'] == 'add_photo_car_piece_change') {
    $addinfo = 'block';
    $msg = "Photo des pièces de rechnage ajoutée avec succès";
}

$row = $wms->getPhotoCarPieceChangeByCar($link, $_GET['car_id']);

// var_dump($row);
// die();

?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1> <i class="fa fa-list"></i> Liste des photos des pièces changées du véhicule
        <?php
        if (isset($row) && !empty($row)) {
            echo "<b>" . $row['car_name'] . ' ' . $row['model_name'] . ' ' . $row['VIN'] . "</b>";
        }
        ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Liste des photos des pièces changées</li>
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
                <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/carlist.php" data-original-title="Retour"><i class="fa fa-reply"></i></a>
            </div> -->
            <div class="box box-success">
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table sakotable table-bordered table-striped dt-responsive">
                        <thead>
                            <tr>
                                <?php

                                // Déclaration d'un array (liste) d'image vide
                                $img_list = array(
                                    '1' => null,
                                    '2' => null,
                                    '3' => null,
                                    '4' => null,
                                    '5' => null,
                                    '6' => null,
                                    '7' => null,
                                    '8' => null,
                                    '9' => null,
                                    '10' => null,
                                    '11' => null,
                                    '12' => null
                                );

                                if (isset($row['img_1_url']) && !empty($row['img_1_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $img_list['1'] = $row['img_1_url'];
                                }
                                if (isset($row['img_2_url']) && !empty($row['img_2_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $img_list['2'] = $row['img_2_url'];
                                }
                                if (isset($row['img_3_url']) && !empty($row['img_3_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $img_list['3'] = $row['img_3_url'];
                                }
                                if (isset($row['img_4_url']) && !empty($row['img_4_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $img_list['4'] = $row['img_4_url'];
                                }
                                if (isset($row['img_5_url']) && !empty($row['img_5_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $img_list['5'] = $row['img_5_url'];
                                }
                                if (isset($row['img_6_url']) && !empty($row['img_6_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $img_list['6'] = $row['img_6_url'];
                                }
                                if (isset($row['img_7_url']) && !empty($row['img_7_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $img_list['7'] = $row['img_7_url'];
                                }
                                if (isset($row['img_8_url']) && !empty($row['img_8_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $img_list['8'] = $row['img_8_url'];
                                }
                                if (isset($row['img_9_url']) && !empty($row['img_9_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $img_list['9'] = $row['img_9_url'];
                                }
                                if (isset($row['img_10_url']) && !empty($row['img_10_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $img_list['10'] = $row['img_10_url'];
                                }
                                if (isset($row['img_11_url']) && !empty($row['img_11_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $img_list['11'] = $row['img_11_url'];
                                }
                                if (isset($row['img_12_url']) && !empty($row['img_12_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $img_list['12'] = $row['img_12_url'];
                                }
                                ?>
                                <th>N° photo</th>
                                <th>Visualisation</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            if (!empty($img_list)) {

                                foreach ($img_list as $key => $pj_name) {

                                    // Adresse de la pièce jointe sur le serveur

                                    // $pj_path = WEB_URL . 'img/upload/car/' . $pj_name;
                                    $pj_path = ROOT_PATH . '/img/upload/car/' . $pj_name;

                                    // Si la pièce jointe existe à l'emplacement spécifié et que son nom est défini
                                    // On affiche la liste des pièces jointes en faisant un lien pour les consulter
                                    if (file_exists($pj_path) && $pj_name != '') { ?>
                                        <tr>
                                            <td>
                                                <?php echo $key ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo WEB_URL ?>img/upload/car/<?php echo $pj_name ?>"><img class="form-control" src="<?php echo WEB_URL ?>img/upload/car/<?php echo $pj_name ?>" style="height:125px;width:125px;" id="output" /></a>
                                            </td>
                                        </tr>
                                    <?php }
                                }
                            }
                            ?>


                            <?php
                            mysql_close($link); ?>
                        </tbody>
                    </table>
                </div>

                <form method="POST" enctype="multipart/form-data" action="photo_car_piece_change_process.php">

                    <fieldset>

                        <div class="row">

                            <div class="col-sm-12">

                                <legend>Ajouter les photos des pièces changées du véhicule</legend>

                                <div class="col-md-1">
                                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="img_1_car_pc_work" />
                                    </span>
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="img_2_car_pc_work" />
                                    </span>
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="img_3_car_pc_work" />
                                    </span>
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="img_4_car_pc_work" />
                                    </span>
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="img_5_car_pc_work" />
                                    </span>
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="img_6_car_pc_work" />
                                    </span>
                                </div>

                                <div class="col-md-1">
                                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="img_7_car_pc_work" />
                                    </span>
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="img_8_car_pc_work" />
                                    </span>
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="img_9_car_pc_work" />
                                    </span>
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="img_10_car_pc_work" />
                                    </span>
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="img_11_car_pc_work" />
                                    </span>
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="img_12_car_pc_work" />
                                    </span>
                                </div>
                            </div>
                            <input type="hidden" value="<?php echo $_GET['car_id']; ?>" name="car_id" />
                            <input type="hidden" value="<?php echo $_GET['car_recep_id']; ?>" name="car_recep_id" />
                            <input type="hidden" value="<?php echo $hdnid; ?>" name="photo_car_piece_change_id" />

                        </div>
                    </fieldset>
                    <div class="pull-right" style="margin-top:1%;">
                        <button type="submit" class="btn btn-success btnsp"><i class="fa fa-save fa-2x"></i><br />
                            <?php echo "valider l'ajout des images" ?></button>&emsp;
                        <a class="btn btn-warning btnsp" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/repaircar_reception_list.php" data-original-title="Retour"><i class="fa fa-reply  fa-2x"></i><br />
                            Retour</a>
                    </div>
                </form>

                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <script type="text/javascript">
        function deletePj(custId, pjName) {
            var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer cette photo ?");
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